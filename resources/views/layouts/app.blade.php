<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name','bKash TMS') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        (function () {
            try {
                var savedTheme = localStorage.getItem('bkash-theme');
                var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.setAttribute('data-theme', savedTheme || (prefersDark ? 'dark' : 'light'));
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="wrapper {{ View::hasSection('hideSidebar') ? 'auth-wrapper' : '' }}">
    @includeWhen(!View::hasSection('hideSidebar'), 'partials.sidebar')
    <div class="app-main">
        @includeWhen(!View::hasSection('hideSidebar'), 'partials.topbar')
        <main class="content-wrapper {{ View::hasSection('hideSidebar') ? 'auth-content' : '' }}">
            <div class="page-container">
                @unless(View::hasSection('hideSidebar'))
                    @include('partials.flash')
                @endunless
                @yield('content')
            </div>
        </main>

        @unless(View::hasSection('hideSidebar'))
        <footer class="app-footer">
            <div class="page-container footer-inner">
                <span>&copy; {{ date('Y') }} bKash Transaction Management System. 
                    <a href="https://brimetech.com" target="_blank" class="text-blue-500 hover:underline">Developed by BrimeTech</a>    
                </span>
                <span>Built for fast transaction management.</span>
            </div>
        </footer>
        @endunless
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
