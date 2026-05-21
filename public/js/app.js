document.addEventListener('DOMContentLoaded', function () {
	const menuButton = document.getElementById('mobile-menu-button');
	const sidebar = document.querySelector('.app-sidebar');
	const overlay = document.querySelector('.app-overlay');
	const sidebarSearch = document.getElementById('sidebar-search');
	const themeToggle = document.getElementById('theme-toggle');

	function setTheme(theme) {
		const normalizedTheme = theme === 'dark' ? 'dark' : 'light';
		const root = document.documentElement;

		root.setAttribute('data-theme', normalizedTheme);

		if (themeToggle) {
			const icon = themeToggle.querySelector('i');
			const isDark = normalizedTheme === 'dark';
			themeToggle.setAttribute('aria-label', isDark ? 'Switch to light theme' : 'Switch to dark theme');
			themeToggle.setAttribute('title', isDark ? 'Switch to light theme' : 'Switch to dark theme');

			if (icon) {
				icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
			}
		}
	}

	if (menuButton && sidebar && overlay) {
		menuButton.addEventListener('click', function () {
			sidebar.classList.toggle('open');
			overlay.classList.toggle('hidden');
		});

		overlay.addEventListener('click', function () {
			sidebar.classList.remove('open');
			overlay.classList.add('hidden');
		});

		sidebar.querySelectorAll('.nav-link').forEach(function (link) {
			link.addEventListener('click', function () {
				sidebar.classList.remove('open');
				overlay.classList.add('hidden');
			});
		});
	}

	if (sidebarSearch && sidebar) {
		sidebarSearch.addEventListener('input', function () {
			const query = sidebarSearch.value.trim().toLowerCase();

			sidebar.querySelectorAll('.nav-group').forEach(function (group) {
				let visibleCount = 0;

				group.querySelectorAll('.nav-link').forEach(function (link) {
					const isVisible = link.textContent.toLowerCase().includes(query);
					link.style.display = isVisible ? 'flex' : 'none';
					visibleCount += isVisible ? 1 : 0;
				});

				group.style.display = visibleCount ? 'block' : 'none';
			});
		});
	}

	if (themeToggle) {
		setTheme(document.documentElement.getAttribute('data-theme') || 'light');

		themeToggle.addEventListener('click', function () {
			const nextTheme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
			localStorage.setItem('bkash-theme', nextTheme);
			setTheme(nextTheme);
		});
	}
});
