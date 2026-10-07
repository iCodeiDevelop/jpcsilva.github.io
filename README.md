# jpcsilva.com — John Paul Silva Portfolio

Personal portfolio website for **John Paul C. Silva** — IT Consultant, Systems Analyst, and Educator based in Davao City, Philippines.

**Live site:** https://jpcsilva.com  
**Admin panel:** https://jpcsilva.com/admin

---

## Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 11, PHP 8.2+ |
| Frontend | Blade, Tailwind CSS (CDN), Alpine.js |
| Database | MySQL 8+ |
| Icons | Lucide Icons |
| Hosting | Shared hosting or VPS |

---

## Quick Start (Local)

```bash
# 1. Clone and enter project
git clone https://github.com/jpcsilva/portfolio.git
cd portfolio

# 2. Install PHP dependencies
composer install

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Configure database in .env, then:
php artisan migrate
php artisan db:seed
php artisan storage:link

# 5. Start local server
php artisan serve
```

**Visit:** http://localhost:8000  
**Admin:** http://localhost:8000/admin  
**Login:** admin@jpcsilva.com / Admin@2024!  
*(Change your password immediately after first login)*

---

## Deployment (Shared Hosting — Hostinger/Namecheap)

See **DEPLOYMENT.md** for full step-by-step guide.

**Quick summary:**
1. Purchase hosting + domain `jpcsilva.com`
2. Point document root to `/public`
3. Upload files via File Manager or Git
4. Run `composer install --no-dev` via SSH
5. Set up `.env` with production values
6. Run `php artisan migrate --seed --force`
7. Run `php artisan storage:link`

---

## Admin Panel

Go to `/admin` to manage all content without touching code:

- **Projects** — Add/edit/delete with tech stack, links, screenshots
- **Skills** — Categorised skills with proficiency levels
- **Experience** — Timeline entries with highlights
- **Certifications** — PRC, ITIL v4, TESDA NC II, etc.
- **Blog** — Write articles (Markdown supported)
- **Messages** — View contact form submissions
- **Settings** — Edit hero text, bio, social links, SEO

---

## Services Showcased

1. IT Consulting
2. Systems Analysis & Design
3. Technical Writing
4. IT Training & Facilitation
5. IT Project Management

---

## Project Structure

```
app/
  Http/
    Controllers/
      Public/     ← HomeController, ProjectController, BlogController, ContactController
      Admin/      ← Dashboard, Project, Skill, Experience, Cert, Blog, Message, Settings
    Middleware/
  Models/         ← Project, Skill, Experience, Certification, Blog, Message, Setting, User

database/
  migrations/     ← 8 migrations
  seeders/        ← Pre-filled with your real content

resources/
  views/
    layouts/      ← app.blade.php, nav.blade.php, footer.blade.php, admin.blade.php
    public/       ← home.blade.php (single page), project-detail, blog-*
    admin/        ← dashboard + CRUD views for each entity

routes/web.php    ← All public + admin routes
```

---

## After Launch — Content To Fill In

These are left blank intentionally — update via **Admin → Settings**:

- [ ] Upload your professional photo → Settings → Profile Photo
- [ ] Add your Resume PDF → Settings → Resume URL
- [ ] Update GitHub URL → `https://github.com/[your-username]`
- [ ] Update LinkedIn URL → `https://linkedin.com/in/[your-profile]`
- [ ] Add Google Analytics ID (optional)
- [ ] Add project screenshots (Admin → Projects → Edit → Upload)
- [ ] Add your credential IDs/URLs to certifications

---

## Security Notes

- Change default admin password immediately after first login
- Set `APP_DEBUG=false` in production `.env`
- Use a Google App Password (not your Gmail password) for SMTP
- Rate limiting is enabled: 5 contact submissions/hour per IP

---

## License

Personal use. Not for redistribution.
