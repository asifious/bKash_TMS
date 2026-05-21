@php
    $isAdmin = auth()->check() && auth()->user()->role === 'admin';
    $homeRoute = $isAdmin ? route('admin.dashboard') : route('user.dashboard');
    $roleLabel = $isAdmin ? 'Admin' : 'User';

    $adminMenu = [
        'Workspace' => [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'fa-chart-pie'],
            ['label' => 'Users', 'route' => 'admin.users.index', 'active' => 'admin.users.*', 'icon' => 'fa-users'],
            ['label' => 'Account Numbers', 'route' => 'admin.account-numbers.index', 'active' => 'admin.account-numbers.*', 'icon' => 'fa-hashtag'],
            ['label' => 'Announcements', 'route' => 'admin.announcements.index', 'active' => 'admin.announcements.*', 'icon' => 'fa-bullhorn'],
            ['label' => 'Activity Logs', 'route' => 'admin.activity-logs.index', 'active' => 'admin.activity-logs.*', 'icon' => 'fa-clipboard-list'],
            ['label' => 'Settings', 'route' => 'admin.settings.index', 'active' => 'admin.settings.*', 'icon' => 'fa-cog'],
        ],
        'Reports' => [
            ['label' => 'Transactions', 'route' => 'admin.reports.transactions', 'active' => 'admin.*transactions*', 'icon' => 'fa-chart-line'],
            ['label' => 'Invoices', 'route' => 'admin.reports.invoices', 'active' => 'admin.*invoices*', 'icon' => 'fa-file-invoice'],
            ['label' => 'Users Report', 'route' => 'admin.reports.users', 'active' => 'admin.reports.users', 'icon' => 'fa-user-check'],
            ['label' => 'Account Report', 'route' => 'admin.reports.accounts', 'active' => 'admin.reports.accounts', 'icon' => 'fa-wallet'],
        ],
        'Account' => [
            ['label' => 'My Profile', 'route' => 'profile', 'active' => 'profile', 'icon' => 'fa-user-circle'],
        ],
    ];

    $userMenu = [
        'Workspace' => [
            ['label' => 'Dashboard', 'route' => 'user.dashboard', 'active' => 'user.dashboard', 'icon' => 'fa-chart-pie'],
            ['label' => 'Transactions', 'route' => 'user.transactions.index', 'active' => 'user.transactions.index', 'icon' => 'fa-exchange-alt'],
            ['label' => 'Create Transaction', 'route' => 'user.transactions.create', 'active' => 'user.transactions.create', 'icon' => 'fa-plus-circle'],
            ['label' => 'Invoices', 'route' => 'user.invoices.index', 'active' => 'user.invoices.*', 'icon' => 'fa-file-invoice'],
        ],
        'Reports' => [
            ['label' => 'Transaction Report', 'route' => 'user.reports.transactions', 'active' => 'user.reports.transactions', 'icon' => 'fa-chart-line'],
            ['label' => 'Invoice Report', 'route' => 'user.reports.invoices', 'active' => 'user.reports.invoices', 'icon' => 'fa-file-alt'],
        ],
        'Account' => [
            ['label' => 'My Profile', 'route' => 'profile', 'active' => 'profile', 'icon' => 'fa-user-circle'],
        ],
    ];

    $menu = $isAdmin ? $adminMenu : $userMenu;
@endphp

<aside class="app-sidebar">
    <div class="sidebar-brand">
        <a href="{{ $homeRoute }}" class="brand-link" aria-label="bKash TMS home">
            <span class="brand-mark"><img src="{{ asset('images/bkash-logo.webp') }}" alt="bKash Logo" ></span>
            <span>
                <span class="brand-name">bKash TMS</span>
                <span class="brand-caption">{{ $roleLabel }} workspace</span>
            </span>
        </a>
    </div>

    <div class="sidebar-search">
        <i class="fas fa-search" aria-hidden="true"></i>
        <input id="sidebar-search" type="search" placeholder="Search menu">
    </div>

    <nav class="sidebar-nav" aria-label="Primary navigation">
        @foreach($menu as $group => $items)
            <div class="nav-group">
                <p class="nav-group-title">{{ $group }}</p>
                @foreach($items as $item)
                    <a href="{{ route($item['route']) }}" class="nav-link {{ request()->routeIs($item['active']) ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas {{ $item['icon'] }}" aria-hidden="true"></i></span>
                        <span class="nav-text">{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </div>
        @endforeach
    </nav>

    <a href="{{ route('profile') }}" class="sidebar-user">
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}</div>
        <div>
            <p>{{ auth()->user()->name ?? 'Guest' }}</p>
            <span>{{ auth()->user()->email ?? $roleLabel }}</span>
        </div>
    </a>
</aside>
