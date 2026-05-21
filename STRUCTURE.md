# bKash Transaction Management System - Project Structure

Laravel 8 application for managing bKash users, account numbers, transactions, invoices, announcements, activity logs, reports, and application settings.

The app uses Blade views, custom CSS in `resources/css/app.css`, compiled/public CSS in `public/css/app.css`, JavaScript in `resources/js/app.js`, and Chart.js from CDN for dashboard charts.

## Top-Level Layout

- `app/` - application code
- `bootstrap/` - Laravel bootstrap files
- `config/` - Laravel configuration
- `database/` - migrations, seeders, and `database.sql`
- `public/` - web root, compiled CSS/JS, uploads, front controller
- `resources/` - Blade views, source CSS, source JS, language files
- `routes/` - web/API route definitions
- `storage/` - framework cache, logs, uploaded runtime files
- `tests/` - Laravel test directory
- `vendor/` - Composer dependencies
- `webpack.mix.js` - Laravel Mix asset build configuration

## Controllers

### Auth

- `app/Http/Controllers/AuthController.php`
  - login/logout
  - forgot password
  - reset password

### Admin

- `app/Http/Controllers/Admin/DashboardController.php`
  - admin dashboard totals
  - total transaction trend bar chart
  - daily transaction trend grouped bar chart by transaction type
  - recent transactions and account summaries

- `app/Http/Controllers/Admin/UserController.php`
  - admin user CRUD

- `app/Http/Controllers/Admin/AccountNumberController.php`
  - bKash account number CRUD

- `app/Http/Controllers/Admin/AnnouncementController.php`
  - announcement CRUD

- `app/Http/Controllers/Admin/ActivityLogController.php`
  - searchable activity logs by date, user, and action

- `app/Http/Controllers/Admin/ReportController.php`
  - reports index
  - all-user transaction report
  - all-user invoice report
  - users report with quick links to transactions, invoices, and logs
  - accounts report
  - admin read-only transaction detail
  - admin read-only invoice detail

- `app/Http/Controllers/Admin/SettingController.php`
  - application settings
  - currency settings
  - payment provider settings
  - invoice settings
  - logo/favicon upload
  - cache clear action

### User

- `app/Http/Controllers/User/DashboardController.php`
  - user dashboard totals
  - transaction trend grouped bar chart by type
  - recent transactions
  - profile edit
  - user transaction and invoice reports

- `app/Http/Controllers/User/TransactionController.php`
  - transaction CRUD
  - modern transaction list, form, and receipt/detail UI
  - activity logging for create/update/delete

- `app/Http/Controllers/User/InvoiceController.php`
  - invoice CRUD
  - modern invoice show UI
  - professional print/PDF invoice layout
  - invoice settings integration
  - activity logging for create/update/delete

## Middleware

- `app/Http/Middleware/RoleMiddleware.php`
  - protects admin-only and user-only route groups

## Models

- `app/Models/User.php`
  - relationships: `transactions()`, `invoices()`

- `app/Models/Transaction.php`
  - user-owned transaction records

- `app/Models/Invoice.php`
  - user-owned invoice records

- `app/Models/AccountNumber.php`
  - managed bKash account numbers

- `app/Models/Announcement.php`
  - admin announcements shown to users

- `app/Models/ActivityLog.php`
  - audit log entries

- `app/Models/ApplicationSetting.php`
  - key/value application settings with defaults

## Database

### Migrations

- `2014_10_12_000000_create_users_table.php`
- `2014_10_12_100000_create_password_resets_table.php`
- `2019_08_19_000000_create_failed_jobs_table.php`
- `2019_12_14_000001_create_personal_access_tokens_table.php`
- `2026_01_01_000001_create_account_numbers_table.php`
- `2026_01_01_000002_create_transactions_table.php`
- `2026_01_01_000003_create_invoices_table.php`
- `2026_01_01_000004_create_announcements_table.php`
- `2026_01_01_000005_create_activity_logs_table.php`
- `2026_01_01_000006_create_application_settings_table.php`

### SQL Import

- `database.sql`
  - MySQL/MariaDB schema
  - default admin seed
  - example account numbers
  - application settings table and defaults

## Views

### Layouts and Partials

- `resources/views/layouts/app.blade.php`
  - main authenticated/app layout
  - theme initialization
  - sidebar/topbar/footer includes

- `resources/views/partials/sidebar.blade.php`
  - admin and user navigation
  - admin links for settings, reports, activity logs, invoices, transactions, users, accounts, announcements

- `resources/views/partials/topbar.blade.php`
  - page titles
  - theme toggle
  - profile and logout controls

- `resources/views/partials/flash.blade.php`
  - success/error messages

### Auth

- `resources/views/auth/login.blade.php`
- `resources/views/auth/forgot-password.blade.php`
- `resources/views/auth/reset-password.blade.php`

### Admin Views

- `resources/views/admin/dashboard.blade.php`
  - totals
  - daily/total transaction charts
  - recent transactions
  - top receiving accounts

- `resources/views/admin/users/`
  - `index.blade.php`
  - `create.blade.php`
  - `edit.blade.php`

- `resources/views/admin/account_numbers/`
  - `index.blade.php`
  - `create.blade.php`
  - `edit.blade.php`

- `resources/views/admin/announcements/`
  - `index.blade.php`
  - `create.blade.php`
  - `edit.blade.php`

- `resources/views/admin/activity_logs/index.blade.php`

- `resources/views/admin/settings/index.blade.php`
  - general, currency, payment provider, and invoice settings tabs
  - follows app light/dark theme variables

- `resources/views/admin/reports/`
  - `index.blade.php`
  - `transactions.blade.php`
  - `invoices.blade.php`
  - `users.blade.php`
  - `accounts.blade.php`

- `resources/views/admin/transactions/show.blade.php`
  - read-only admin transaction detail

- `resources/views/admin/invoices/show.blade.php`
  - read-only admin invoice detail

### User Views

- `resources/views/user/dashboard.blade.php`
  - user totals
  - grouped transaction trend chart by type
  - recent transactions

- `resources/views/user/profile.blade.php`

- `resources/views/user/transactions/`
  - `index.blade.php` - modern transaction summary/list UI
  - `create.blade.php` - smart transaction form
  - `edit.blade.php` - smart transaction edit form
  - `show.blade.php` - receipt-style transaction detail and print layout

- `resources/views/user/invoices/`
  - `index.blade.php`
  - `create.blade.php`
  - `edit.blade.php`
  - `show.blade.php` - modern invoice view and professional print layout

- `resources/views/user/reports/`
  - `transactions.blade.php`
  - `invoices.blade.php`

## Assets

- `resources/css/app.css`
  - source app stylesheet
  - light/dark theme variables
  - layout, sidebar, topbar, cards, tables, settings, invoices, transactions, print styles

- `public/css/app.css`
  - compiled/copied public stylesheet served by the app

- `resources/js/app.js`
  - sidebar mobile behavior
  - sidebar search
  - theme toggle

- `public/js/app.js`
  - compiled public JavaScript

## Routes

Routes are defined in `routes/web.php`.

### Public/Auth

- `/`
- `/login`
- `/forgot-password`
- `/reset-password/{token}`
- `/logout`

### Shared Authenticated

- `/profile`

### User Routes

Prefix: `/user`

- `/dashboard`
- `/transactions`
- `/transactions/create`
- `/transactions/{transaction}`
- `/transactions/{transaction}/edit`
- `/invoices`
- `/invoices/create`
- `/invoices/{invoice}`
- `/invoices/{invoice}/edit`
- `/reports/transactions`
- `/reports/invoices`

### Admin Routes

Prefix: `/admin`

- `/dashboard`
- `/users`
- `/account-numbers`
- `/announcements`
- `/activity-logs`
- `/settings`
- `/settings/clear-cache`
- `/reports`
- `/reports/transactions`
- `/reports/invoices`
- `/reports/users`
- `/reports/accounts`
- `/transactions/{id}`
- `/invoices/{id}`

## Roles and Access

- Admin users can manage users, account numbers, announcements, settings, and view all reports, transactions, invoices, and activity logs.
- User accounts can manage only their own transactions and invoices.
- Admin transaction/invoice detail pages are read-only and use admin routes.
- User transaction/invoice edit and delete actions remain user-owned.

## Deployment Notes

- Designed for Laravel 8 and PHP 7.3+.
- Configure database credentials in `.env`.
- Run migrations with `php artisan migrate`.
- If using `database.sql`, import it into MySQL/MariaDB and then update `.env`.
- Public web root should point to `public/`.
- If CSS/JS changes are made through Laravel Mix, run the asset build; otherwise keep `resources/css/app.css` and `public/css/app.css` in sync.
