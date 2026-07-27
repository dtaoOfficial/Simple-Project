# Deployment Guide (No Docker) — Simple-Project

Step-by-step for deploying this Laravel + React + Inertia + MySQL project to a live server. No Docker — plain PHP-FPM + Nginx + MySQL, same style as your other projects (git clone → configure → Nginx → subdomain → SSL).

---

## 1. Server Requirements (install these first)

| Tool | Notes |
|---|---|
| PHP 8.3 or 8.4 | with extensions: `mbstring`, `pdo_mysql`, `openssl`, `xml`, `ctype`, `bcmath`, `fileinfo` |
| Composer | PHP package manager |
| Node.js + npm | only needed to run the frontend build |
| MySQL 8 | database |
| Nginx | web server |
| Certbot | for free SSL certificates |

---

## 2. Clone the Project

```bash
cd /var/www
git clone https://github.com/dtaoOfficial/Simple-Project.git
cd Simple-Project
```

## 3. Install Dependencies

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

📝 `--no-dev` skips dev-only tools (testing, debug bars) — never needed and some are a security risk in production.

## 4. Set Up `.env`

`.env` is never in git (it holds secrets). Create it manually on the server:

```bash
cp .env.example .env
```

Edit `.env` with production values:

```
APP_NAME="Simple Project"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yoursubdomain.yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simple_project
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

⚠️ `APP_DEBUG=false` is critical — leaving it `true` in production leaks internal error details (file paths, queries) to anyone who visits a broken page.

## 5. Generate App Key + Run Migrations

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
```

📝 `--force` skips the "are you sure?" prompt that Laravel shows in production by default.

## 6. Set Folder Permissions

The web server user (usually `www-data`) needs write access to two folders:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

📝 Without this, you'll get "Permission denied" errors the first time Laravel tries to write a log file or cache file.

## 7. Cache Everything for Performance

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

⚠️ If you change `.env` later, run `php artisan config:clear` first, then re-cache — otherwise Laravel keeps using the OLD cached config.

## 8. Nginx Config

**Most common Laravel mistake:** the document root must point to the `public/` subfolder — NOT the project root.

Create `/etc/nginx/sites-available/simple-project`:

```nginx
server {
    listen 80;
    server_name yoursubdomain.yourdomain.com;
    root /var/www/Simple-Project/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

📝 Adjust the PHP-FPM socket path (`php8.4-fpm.sock`) to match your installed PHP version.

Enable the site:

```bash
sudo ln -s /etc/nginx/sites-available/simple-project /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 9. Test Before Going Live

Visit `http://your-server-ip` (or a temporary `server_name _;` block) to confirm the site loads before pointing a real domain at it.

## 10. Point Subdomain + Enable SSL

1. Add a DNS A record: `yoursubdomain.yourdomain.com` → your server's IP
2. Update the Nginx `server_name` to match (already done above)
3. Run Certbot:

```bash
sudo certbot --nginx -d yoursubdomain.yourdomain.com
```

Certbot auto-edits the Nginx config to add HTTPS + redirects HTTP → HTTPS.

## 11. Final Check

Visit `https://yoursubdomain.yourdomain.com` — should load over SSL with the padlock, admin panel at `/admin` should work too.

---

## Redeploying Later (after code changes)

```bash
cd /var/www/Simple-Project
git pull
composer install --no-dev --optimize-autoloader
npm install && npm run build
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

## Common Gotchas Checklist

- [ ] Document root is `public/`, not the project root
- [ ] `.env` has `APP_DEBUG=false` in production
- [ ] `storage/` and `bootstrap/cache/` are writable by the web server user
- [ ] Re-run `config:cache` after every `.env` change
- [ ] `.env` is never committed to git (check `.gitignore`)
