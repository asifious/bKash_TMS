# bKash Transaction Management System

A Laravel 8 web application for managing bKash-style transactions, invoices, users, account numbers, reports, announcements, settings, and activity logs.

This project is built for small teams, agents, or merchants who need a simple admin/user dashboard for recording money movement, tracking invoices, and reviewing user activity.

> This is an independent transaction management system. It is not an official bKash product unless deployed and maintained by an authorized owner.

## Features

- Role-based admin and user dashboards
- User transaction CRUD
- Smart transaction UI with cash in, send money, and received money types
- Receipt-style transaction detail page with print support
- User invoice CRUD
- Modern invoice detail screen with professional print/PDF layout
- Admin can view all users, transactions, invoices, reports, and activity logs
- Admin read-only transaction and invoice detail pages
- Account number management
- Announcement management
- Application settings with tabs for general, currency, payment provider, and invoice settings
- Light/dark theme toggle
- Dashboard charts using Chart.js
  - user grouped transaction trend
  - admin total transaction trend
  - admin daily transaction trend by type
- Shared-hosting friendly Laravel deployment

## Tech Stack

- PHP `^7.3|^8.0`
- Laravel `^8.75`
- MySQL or MariaDB
- Blade templates
- Custom CSS
- Laravel Mix
- Chart.js CDN
- Font Awesome CDN
- Tailwind CDN

## Requirements

- PHP 7.3 or newer
- Composer
- MySQL or MariaDB
- Node.js and npm, only if rebuilding frontend assets
- PHP extensions commonly required by Laravel:
  - BCMath
  - Ctype
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML

## Installation

Clone the repository:

```bash
git clone <your-repository-url>
cd <project-folder>
```

Install PHP dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the app key:

```bash
php artisan key:generate
```

Update `.env` with your database credentials:

```env
APP_NAME="bKash TMS"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bkash
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seed the default admin user:

```bash
php artisan migrate --seed
```

Start the local server:

```bash
php artisan serve
```

Visit:

```text
http://127.0.0.1:8000
```

## Default Login

If you run the included database seeder:

```text
Username: admin
Password: admin123
```

Change the default password immediately after first login.

## Frontend Assets

The app currently serves compiled assets from:

- `public/css/app.css`
- `public/js/app.js`

Source files live in:

- `resources/css/app.css`
- `resources/js/app.js`

If you change source assets and want to rebuild with Laravel Mix:

```bash
npm install
npm run dev
```

For production:

```bash
npm run prod
```

If you are not using the build step, keep `resources/css/app.css` and `public/css/app.css` in sync manually.

## Database Import Option

For shared hosting or phpMyAdmin workflows, `database.sql` is included.

You can either:

- run Laravel migrations with `php artisan migrate --seed`, or
- import `database.sql` into MySQL/MariaDB.

If importing `database.sql`, review the seeded admin password before deploying publicly.

## Main User Workflows

User accounts can:

- view their dashboard
- create, edit, view, and delete their own transactions
- create, edit, view, and delete their own invoices
- print transaction receipts
- print professional invoices
- view transaction and invoice reports
- update profile and password

## Main Admin Workflows

Admin accounts can:

- manage users
- manage account numbers
- manage announcements
- manage application settings
- view all transactions
- view all invoices
- view all activity logs
- filter reports by user and date
- inspect read-only transaction and invoice details
- update general, currency, payment provider, and invoice settings
- clear application cache from the settings page

## Project Structure

Important paths:

```text
app/
  Http/Controllers/
    Admin/
    User/
  Models/

database/
  migrations/
  seeders/
  database.sql

resources/
  css/app.css
  js/app.js
  views/
    admin/
    auth/
    layouts/
    partials/
    user/

public/
  css/app.css
  js/app.js

routes/
  web.php
```

For a more detailed map, see `STRUCTURE.md`.

## Useful Commands

Clear caches:

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

Cache for production:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Run migrations:

```bash
php artisan migrate
```

Rollback last migration batch:

```bash
php artisan migrate:rollback
```

List routes:

```bash
php artisan route:list
```

## Shared Hosting Deployment

See `README_DEPLOY.md` for cPanel/shared-hosting deployment notes.

Short version:

- point the web root to `public/`
- configure `.env`
- import the database or run migrations
- make `storage/` and `bootstrap/cache/` writable
- set `APP_DEBUG=false` in production
- change the default admin password

## Security Notes

- Do not commit `.env`.
- Do not use the default admin password in production.
- Set `APP_DEBUG=false` on live servers.
- Use HTTPS in production.
- Keep Composer dependencies updated.
- Restrict database user privileges where possible.
- Review uploaded logo/favicon files before enabling public uploads on shared hosting.

## GitHub Checklist

Before publishing this repository:

- confirm `.env` is not committed
- add production screenshots if desired
- add a `LICENSE` file if the project should be open source
- update this README with the final repository URL
- change default branding/settings if this is for a client

## License

No standalone `LICENSE` file is currently included. Add one before publishing if you want others to use, modify, or redistribute this project.
