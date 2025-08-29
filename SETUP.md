# CityGuard Setup Guide

## Requirements

- PHP 7.4+ (with mysqli, PDO, mbstring, openssl, fileinfo, gd)
- Composer (for vendor autoloading)
- MySQL 5.7+/MariaDB
- Web server: Apache (recommended), Nginx, or Laragon
- Node.js/npm: Not required (no package.json found)

## Installation Steps

1. **Clone the repository**
   ```sh
git clone <repo-url> citiguard
cd citiguard
```

2. **Install PHP dependencies**
   ```sh
composer install
```

3. **Configure Environment**
   - Copy `config/config.sample.php` to `config/config.php` and edit values, or use `.env.example` if you add dotenv support.
   - Set DB credentials, base URL, and any secrets.

4. **Database Setup**
   - Create a new MySQL database (e.g., `citiguard`).
   - Import schema and seed data:
     ```sh
     mysql -u <user> -p citiguard < uploads/db_backup_2025-08-16_01-31-31.sql
     ```
   - Grant user permissions:
     ```sql
     GRANT ALL PRIVILEGES ON citiguard.* TO '<user>'@'localhost' IDENTIFIED BY '<password>';
     FLUSH PRIVILEGES;
     ```

5. **Web Server Configuration**
   - Set document root to the project folder (e.g., `c:/laragon/www/citiguard`).
   - For Apache, ensure `.htaccess` is enabled (if present).
   - For Laragon, add a new site pointing to this folder.

6. **File Permissions**
   - Ensure `uploads/` is writable by the web server.

7. **Access the App**
   - User: http://localhost/citiguard/
   - Admin: http://localhost/citiguard/admin/

## Troubleshooting
- Check `config/db.php` for DB connection errors.
- Enable PHP error reporting for debugging.
- Review `README.md` for additional info.
