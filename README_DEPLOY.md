Deployment Instructions for shared hosting / cPanel (Laravel 8 + PHP 7.3)

1. Requirements
- PHP 7.3 with extensions: openssl, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath
- MySQL or MariaDB
- Ability to create a MySQL database and import SQL (via phpMyAdmin)

2. Prepare files
- Upload the project files into a folder inside `public_html` or a subfolder. For shared hosting without SSH, put Laravel's `public` contents into `public_html` and the rest of the Laravel project one level above `public_html` if possible.

3. Database
- Create a database and a database user in cPanel.
- Import `database.sql` via phpMyAdmin. BEFORE importing, replace the placeholder bcrypt password in `database.sql` for the admin user. To generate a bcrypt hash you can run locally: `php -r "echo password_hash('admin123', PASSWORD_BCRYPT);"` and paste the result into the SQL file.

4. Environment
- Upload a `.env` file with DB credentials and `APP_KEY`. If you cannot run `php artisan key:generate`, you can generate a 32-character random key and prefix with `base64:` after encoding; however recommended to generate locally.

5. Permissions
- Ensure `storage/` and `bootstrap/cache` are writable by the web server.

6. URL and index
- If you placed project one level above `public_html`, set the DocumentRoot to project/public or move files accordingly. If you can't change DocumentRoot, copy `public/index.php` and `public/.htaccess` into `public_html` and adjust `index.php` paths to autoload `../vendor/autoload.php` and `../bootstrap/app.php`.

7. Cron and Queues
- For queued jobs or scheduled tasks, use cPanel cron to call `php /path/to/artisan schedule:run` every minute if available.

8. Notes
- Because many shared hosts disable `exec` or `proc_open`, avoid packages requiring such features. For PDF generation, prefer browser print CSS or client-side html2pdf.js for reliability.

9. Post-deploy
- Use admin panel to create real users or update admin password if needed.


