@php
    $routeName = request()->route() ? request()->route()->getName() : '';
    $pageTitle = trim($__env->yieldContent('pageTitle'));
    $pageEyebrow = auth()->check() && auth()->user()->role === 'admin' ? 'Admin console' : 'User console';

    if ($pageTitle === '') {
        $titles = [
            'admin.dashboard' => 'Dashboard',
            'admin.users.index' => 'Users',
            'admin.users.create' => 'Create User',
            'admin.users.edit' => 'Edit User',
            'admin.account-numbers.index' => 'Account Numbers',
            'admin.account-numbers.create' => 'New Account Number',
            'admin.account-numbers.edit' => 'Edit Account Number',
            'admin.announcements.index' => 'Announcements',
            'admin.announcements.create' => 'New Announcement',
            'admin.announcements.edit' => 'Edit Announcement',
            'admin.activity-logs.index' => 'Activity Logs',
            'admin.settings.index' => 'Settings',
            'admin.settings.update' => 'Settings',
            'admin.reports.transactions' => 'Transactions Report',
            'admin.transactions.show' => 'Transaction Details',
            'admin.reports.invoices' => 'Invoices Report',
            'admin.invoices.show' => 'Invoice Details',
            'admin.reports.users' => 'Users Report',
            'admin.reports.accounts' => 'Accounts Report',
            'profile.update' => 'My Profile',
            'user.dashboard' => 'Dashboard',
            'user.transactions.index' => 'Transactions',
            'user.transactions.create' => 'Create Transaction',
            'user.transactions.edit' => 'Edit Transaction',
            'user.transactions.show' => 'Transaction Details',
            'user.invoices.index' => 'Invoices',
            'user.invoices.create' => 'Create Invoice',
            'user.invoices.edit' => 'Edit Invoice',
            'user.invoices.show' => 'Invoice Details',
            'user.reports.transactions' => 'Transaction Report',
            'user.reports.invoices' => 'Invoice Report',
            'profile' => 'My Profile',
        ];

        $pageTitle = $titles[$routeName] ?? ucwords(str_replace(['admin.', 'user.', '.', '-'], ['', '', ' ', ' '], $routeName ?: 'Dashboard'));
    }
@endphp

<div class="app-overlay hidden"></div>
<nav class="app-header">
    <div class="topbar-left">
        <button id="mobile-menu-button" class="icon-button mobile-menu-button" type="button" aria-label="Open navigation">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
        <div>
            <p class="page-eyebrow">{{ $pageEyebrow }}</p>
            <h1>{{ $pageTitle }}</h1>
        </div>
    </div>

    <div class="topbar-actions">
        <div class="topbar-date">
            <i class="far fa-calendar" aria-hidden="true"></i>
            <span>{{ now()->format('M d, Y') }}</span>
        </div>

        <button id="theme-toggle" class="icon-button theme-toggle" type="button" aria-label="Switch theme">
            <i class="fas fa-moon" aria-hidden="true"></i>
        </button>

        <a href="{{ route('profile') }}" class="topbar-profile">
            <span class="avatar small">{{ strtoupper(substr(auth()->user()->name ?? 'G', 0, 1)) }}</span>
            <span class="profile-copy">
                <strong>{{ auth()->user()->name ?? 'Guest' }}</strong>
                <small>{{ auth()->user()->email ?? '' }}</small>
            </span>
        </a>

        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</nav>
