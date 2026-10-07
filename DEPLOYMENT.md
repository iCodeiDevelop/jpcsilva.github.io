# Deployment Guide — jpcsilva.com

## Option A: Shared Hosting (Recommended for Start)

Providers: **Hostinger** (₱99–299/mo), **Namecheap**, **DreamHost**

### Requirements
- PHP 8.2+ with extensions: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- MySQL 5.7+
- Composer
- SSH access (recommended)

---

### Step 1 — Purchase Hosting + Domain

1. Go to **Hostinger.ph** → Web Hosting plan (PHP + MySQL)
2. Register `jpcsilva.com` as your domain
3. Point the domain to your hosting nameservers

---

### Step 2 — Prepare Your Files

```bash
# On your local machine:
composer install --no-dev --optimize-autoloader
npm run build   # (not needed — we use CDN Tailwind)

# Copy everything EXCEPT:
# - node_modules/
# - .env  (create fresh on server)
# - /storage/logs/*
```

---

### Step 3 — Upload to Server

**Option A: Git (if your host supports SSH)**
```bash
ssh your-user@your-server
cd ~/domains/jpcsilva.com
git clone https://github.com/jpcsilva/portfolio.git .
```

**Option B: File Manager / FTP**
- Upload all files to the `public_html` folder (or the folder for jpcsilva.com)
- Make sure `/public` contents go to `public_html`
- Everything else (app, config, database, etc.) goes **outside** public_html

---

### Step 4 — Set Document Root (Critical)

In your hosting control panel (cPanel / hPanel):

```
Document Root: /home/your-user/public_html/public
```

Or if your host doesn't allow this, use a `.htaccess` redirect in `public_html`:

```apache
# public_html/.htaccess
RewriteEngine On
RewriteRule ^(.*)$ /public/$1 [L]
```

---

### Step 5 — Create Database

1. In cPanel → MySQL Databases
2. Create database: `jpcsilva_portfolio`
3. Create user with password, assign full privileges

---

### Step 6 — Configure .env

Via SSH or File Manager, create `.env` at project root:

```env
APP_NAME="John Paul Silva | jpcsilva.com"
APP_ENV=production
APP_KEY=    # will be generated
APP_DEBUG=false
APP_URL=https://jpcsilva.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jpcsilva_portfolio
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_gmail@gmail.com
MAIL_PASSWORD=your_google_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@jpcsilva.com"
MAIL_FROM_NAME="John Paul Silva"
PORTFOLIO_CONTACT_EMAIL=hello@jpcsilva.com

ADMIN_EMAIL=admin@jpcsilva.com
ADMIN_PASSWORD=YourStrongPassword@2024!

FILESYSTEM_DISK=public
```

---

### Step 7 — Run Setup Commands (SSH)

```bash
cd ~/domains/jpcsilva.com  # or wherever your files are

# Generate app key
php artisan key:generate

# Run migrations + seed your content
php artisan migrate --seed --force

# Create storage symlink (for file uploads)
php artisan storage:link

# Cache config for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Step 8 — Enable SSL (Free)

In your hosting control panel:
- Enable **Let's Encrypt SSL** for jpcsilva.com
- Force HTTPS redirect (usually a checkbox)

---

### Step 9 — Test Everything

- [ ] https://jpcsilva.com loads your portfolio
- [ ] Dark mode toggle works
- [ ] Contact form sends an email to hello@jpcsilva.com
- [ ] https://jpcsilva.com/admin shows login page
- [ ] Admin login works with your credentials
- [ ] Upload a project thumbnail from admin panel

---

## Option B: VPS (DigitalOcean / Vultr — ₱300–600/mo)

For better performance and full control.

### Quick Setup with Laravel Forge or manual LEMP

```bash
# Ubuntu 22.04 LTS
sudo apt update && sudo apt upgrade -y

# Install PHP 8.2
sudo add-apt-repository ppa:ondrej/php
sudo apt install php8.2 php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-bcmath php8.2-gd

# Install MySQL
sudo apt install mysql-server
sudo mysql_secure_installation

# Install Nginx
sudo apt install nginx

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install your app
cd /var/www
git clone https://github.com/jpcsilva/portfolio.git jpcsilva
cd jpcsilva
composer install --no-dev
cp .env.example .env
php artisan key:generate
# Edit .env with DB credentials
php artisan migrate --seed --force
php artisan storage:link
chown -R www-data:www-data /var/www/jpcsilva/storage
```

**Nginx config** (`/etc/nginx/sites-available/jpcsilva.com`):
```nginx
server {
    listen 80;
    server_name jpcsilva.com www.jpcsilva.com;
    root /var/www/jpcsilva/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht { deny all; }
}
```

```bash
# Enable site + SSL
sudo ln -s /etc/nginx/sites-available/jpcsilva.com /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
sudo certbot --nginx -d jpcsilva.com -d www.jpcsilva.com
```

---

## Email Setup (Gmail → Google App Password)

1. Go to **myaccount.google.com** → Security → 2-Step Verification (enable it)
2. Then: Security → App Passwords → Select "Mail" + "Other (Custom name)"  
3. Type "jpcsilva.com Portfolio" → Generate
4. Copy the 16-character password → put in `.env` as `MAIL_PASSWORD`

---

## After Deployment — Priority Checklist

### Content (Admin Panel)
- [ ] Login at jpcsilva.com/admin → change your password
- [ ] **Settings** → Update GitHub, LinkedIn URLs with your real profiles
- [ ] **Settings** → Upload resume PDF URL (upload to Google Drive → get shareable link)
- [ ] **Projects** → Upload screenshots for each project (≥ 800×500px)
- [ ] **Certifications** → Add credential IDs and verify URLs
- [ ] Add more projects as you complete them

### SEO & Visibility (Week 1)
- [ ] Submit to **Google Search Console** (search.google.com/search-console)
- [ ] Add sitemap: install `spatie/laravel-sitemap` or create manually
- [ ] Update **LinkedIn** profile with portfolio URL
- [ ] Update **GitHub** profile README with portfolio link
- [ ] Update email signature: `Portfolio: jpcsilva.com`

### Freelance Platforms (Week 1–2)
- [ ] **Upwork** — Add portfolio URL in profile, reference your projects
- [ ] **Freelancer.ph** — Local platform for Philippine clients
- [ ] **LinkedIn** — Turn on "Open to Work" (visible only to recruiters)
- [ ] **JobStreet / OnlineJobs.ph** — For Philippine-based opportunities

---

## Maintenance

```bash
# Update app
git pull origin main
composer install --no-dev
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache

# Backup database
mysqldump -u your_user -p jpcsilva_portfolio > backup_$(date +%Y%m%d).sql
```
