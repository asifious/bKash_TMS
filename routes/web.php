<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AccountNumberController as AdminAccountNumberController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\InvoiceController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserDashboard::class, 'profile'])->name('profile');
    Route::patch('/profile', [UserDashboard::class, 'updateProfile'])->name('profile.update');

    Route::prefix('user')->middleware(['role:user'])->group(function () {
        Route::get('/dashboard', [UserDashboard::class, 'index'])->name('user.dashboard');
        Route::resource('transactions', TransactionController::class, ['as' => 'user']);
        Route::resource('invoices', InvoiceController::class, ['as' => 'user']);
        Route::get('/reports/transactions', [UserDashboard::class, 'transactionsReport'])->name('user.reports.transactions');
        Route::get('/reports/invoices', [UserDashboard::class, 'invoicesReport'])->name('user.reports.invoices');
    });

    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        Route::resource('users', AdminUserController::class, ['as' => 'admin'])->except(['show']);
        Route::resource('account-numbers', AdminAccountNumberController::class, ['as' => 'admin'])->parameters(['account-numbers' => 'id'])->except(['show']);
        Route::resource('announcements', AdminAnnouncementController::class, ['as' => 'admin'])->parameters(['announcements' => 'id'])->except(['show']);
        Route::get('/activity-logs', [AdminActivityLogController::class, 'index'])->name('admin.activity-logs.index');
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::put('/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');
        Route::post('/settings/clear-cache', [AdminSettingController::class, 'clearCache'])->name('admin.settings.clear-cache');
        Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/reports/transactions', [AdminReportController::class, 'transactions'])->name('admin.reports.transactions');
        Route::get('/transactions/{id}', [AdminReportController::class, 'transactionShow'])->name('admin.transactions.show');
        Route::get('/reports/invoices', [AdminReportController::class, 'invoices'])->name('admin.reports.invoices');
        Route::get('/invoices/{id}', [AdminReportController::class, 'invoiceShow'])->name('admin.invoices.show');
        Route::get('/reports/users', [AdminReportController::class, 'users'])->name('admin.reports.users');
        Route::get('/reports/accounts', [AdminReportController::class, 'accounts'])->name('admin.reports.accounts');
    });
});
