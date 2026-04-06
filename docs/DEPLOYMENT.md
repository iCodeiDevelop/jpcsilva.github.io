# Deployment Guide — Portfolio Management System

## Prerequisites
- Docker & Docker Compose
- Node.js 20+
- MongoDB 7.0+
- Redis 7.0+
- A registered domain name
- SSL certificate (Let's Encrypt recommended)

---

## 1. Local Development

### Quick Start
```bash
# Clone the repository
git clone https://github.com/your-username/portfolio.git
cd portfolio

# Install all dependencies
npm run install:all

# Configure environment
cp backend/.env.example backend/.env
cp frontend/.env.local.example frontend/.env.local
# Edit both files with your values

# Seed database with sample data
npm run seed

# Start development servers (runs both concurrently)
npm run dev
```

Frontend:  http://localhost:3000
Backend:   http://localhost:5000
API Docs:  http://localhost:5000/api/health

Admin login: admin@portfolio.dev / Admin@123!

---

## 2. Docker Deployment

### Step 1 — Configure Environment
```bash
cp backend/.env.example .env
# Edit .env with production values — especially:
#   JWT_SECRET        (min 32 random chars)
#   JWT_REFRESH_SECRET(min 32 random chars)
#   SMTP_HOST, SMTP_USER, SMTP_PASS
#   ADMIN_EMAIL, ADMIN_PASSWORD
#   CLIENT_URL = https://yourdomain.com
```

### Step 2 — SSL Certificates
```bash
mkdir -p docker/certs
# Option A: Let's Encrypt
certbot certonly --standalone -d yourdomain.com
cp /etc/letsencrypt/live/yourdomain.com/fullchain.pem docker/certs/
cp /etc/letsencrypt/live/yourdomain.com/privkey.pem   docker/certs/

# Option B: Self-signed (dev only)
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout docker/certs/privkey.pem \
  -out    docker/certs/fullchain.pem
```

### Step 3 — Deploy
```bash
# Build and start all services
docker compose up -d --build

# Seed the database (first time only)
docker compose exec backend node src/utils/seed.js

# Check health
docker compose ps
curl https://yourdomain.com/api/health
```

### Step 4 — Verify
```bash
docker compose logs backend  -f
docker compose logs frontend -f
```

---

## 3. Cloud Deployment

### Frontend → Vercel
```bash
cd frontend
npx vercel --prod
# Set environment variables in Vercel dashboard:
#   NEXT_PUBLIC_API_URL = https://api.yourdomain.com
```

### Backend → Railway / Render
1. Connect GitHub repo to Railway/Render
2. Set root directory to `backend/`
3. Set build command: `npm install`
4. Set start command: `node src/server.js`
5. Configure all environment variables from `.env.example`
6. Provision MongoDB Atlas and Redis (Upstash)

### Database → MongoDB Atlas
```bash
# Connection string format:
MONGODB_URI=mongodb+srv://<user>:<pass>@cluster0.xxxxx.mongodb.net/portfolio_db?retryWrites=true&w=majority
```

---

## 4. CI/CD Setup (GitHub Actions)

Add these secrets to GitHub Settings → Secrets:

| Secret                    | Description                        |
|---------------------------|------------------------------------|
| `JWT_SECRET`              | Production JWT secret              |
| `JWT_REFRESH_SECRET`      | Production JWT refresh secret      |
| `NEXT_PUBLIC_API_URL`     | Backend API URL                    |
| `DEPLOY_HOST`             | Production server IP               |
| `DEPLOY_USER`             | SSH username                       |
| `DEPLOY_KEY`              | SSH private key (RSA)              |

Pipeline runs:
- On every push to `main`: test → build → deploy
- On every PR to `main`: test only (no deploy)

---

## 5. Post-Deployment Checklist

- [ ] Admin login works: `/admin/login`
- [ ] Portfolio visible at `/`
- [ ] Contact form sends emails
- [ ] File uploads work
- [ ] HTTPS redirects from HTTP
- [ ] MongoDB backups configured
- [ ] Error monitoring (Sentry) configured
- [ ] Analytics (GA4) configured

---

## 6. Maintenance

### Backup Database
```bash
docker exec portfolio_mongo mongodump \
  --uri="mongodb://admin:secret@localhost:27017/portfolio_db?authSource=admin" \
  --out=/backups/$(date +%Y%m%d)
```

### Update Application
```bash
git pull origin main
docker compose pull
docker compose up -d --no-deps backend frontend
docker system prune -f
```

### View Logs
```bash
docker compose logs backend  --tail=100 -f
docker compose logs frontend --tail=100 -f
```
