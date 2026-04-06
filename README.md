# 🚀 Portfolio Management System

A production-ready, full-stack portfolio management system with a dynamic admin CMS and a beautiful public-facing portfolio website.

![License](https://img.shields.io/badge/license-MIT-blue)
![Node](https://img.shields.io/badge/node-20+-green)
![Next.js](https://img.shields.io/badge/next.js-14-black)

## ✨ Features

### Admin Panel
- 🔐 JWT authentication with refresh tokens & account lockout
- 📊 Analytics dashboard with charts and activity logs
- 📁 Full CRUD: Projects, Skills, Experience, Certifications, Blog
- 🖼️ Image upload with validation
- 🔍 SEO management per content item
- 👥 Role-based access control (Admin / Editor / Viewer)

### Public Portfolio
- ⚡ Server-side rendered (Next.js ISR) for perfect SEO
- 📱 Mobile-first responsive design
- 🌙 Dark / Light mode toggle
- 🎨 Smooth animations (Framer Motion)
- 🔍 Projects filterable by category and tech stack
- 📈 Skills visualization with animated progress bars
- 📅 Experience timeline
- 📧 Contact form with rate limiting
- 📝 Blog with markdown support

## 🏗️ Tech Stack

| Layer    | Technology           |
|----------|----------------------|
| Frontend | Next.js 14, React 18 |
| Styling  | Tailwind CSS 3       |
| State    | Zustand + React Query|
| Backend  | Node.js, Express.js  |
| Database | MongoDB 7 + Mongoose |
| Cache    | Redis 7              |
| Auth     | JWT + Refresh Tokens |
| Deploy   | Docker + Nginx       |
| CI/CD    | GitHub Actions       |

## 🚀 Quick Start

```bash
# 1. Clone
git clone https://github.com/your-username/portfolio.git
cd portfolio

# 2. Install all deps
npm run install:all

# 3. Configure environment
cp backend/.env.example  backend/.env
cp frontend/.env.local.example frontend/.env.local
# Edit both files with your config

# 4. Seed database
npm run seed

# 5. Start development
npm run dev
```

**URLs:**
- Portfolio:   http://localhost:3000
- Admin Panel: http://localhost:3000/admin
- API:         http://localhost:5000/api
- Health:      http://localhost:5000/api/health

**Default admin credentials:**
```
Email:    admin@portfolio.dev
Password: Admin@123!
```

## 🐳 Docker

```bash
# Copy and configure environment
cp backend/.env.example .env

# Start all services
docker compose up -d --build

# Seed database (first time)
docker compose exec backend node src/utils/seed.js
```

## 📁 Project Structure

```
portfolio/
├── backend/                # Express.js API
│   ├── src/
│   │   ├── config/         # DB, logger, email config
│   │   ├── controllers/    # Route handlers
│   │   ├── middleware/     # Auth, rate limiting, upload
│   │   ├── models/         # Mongoose schemas
│   │   ├── routes/         # Express routers
│   │   ├── services/       # Business logic (future)
│   │   ├── utils/          # Helpers, seed, pagination
│   │   ├── validators/     # Input validation rules
│   │   └── server.js       # App entry point
│   └── tests/
│       ├── unit/
│       └── integration/
├── frontend/               # Next.js 14 App
│   └── src/
│       ├── app/            # App Router pages
│       │   ├── admin/      # Admin CMS pages
│       │   └── page.tsx    # Public portfolio (SSR)
│       ├── components/
│       │   ├── admin/      # Admin-specific components
│       │   ├── public/     # Portfolio sections
│       │   ├── shared/     # Navbar, Footer
│       │   └── ui/         # Reusable primitives
│       ├── hooks/          # React Query hooks
│       ├── lib/            # Axios client
│       ├── store/          # Zustand stores
│       └── types/          # TypeScript types
├── docker/                 # Dockerfiles + Nginx config
├── docs/                   # Architecture, API, Deploy guides
└── .github/workflows/      # CI/CD pipeline
```

## 📖 Documentation

- [API Reference](docs/API.md)
- [Architecture](docs/ARCHITECTURE.md)
- [Deployment Guide](docs/DEPLOYMENT.md)

## 🧪 Testing

```bash
cd backend
npm test              # All tests
npm run test:unit     # Unit tests only
npm run test:coverage # With coverage report
```

## 🔒 Security

- ✅ Password hashing: bcrypt (cost factor 12)
- ✅ JWT with short-lived access tokens (15m)
- ✅ httpOnly cookies for refresh tokens
- ✅ Input sanitization: XSS + NoSQL injection
- ✅ Rate limiting: API (100/15min), Auth (10/15min), Contact (5/hr)
- ✅ Secure headers: Helmet.js
- ✅ CORS with whitelist
- ✅ Account lockout after 5 failed logins
- ✅ Parameterized DB queries via Mongoose

## 📄 License

MIT — see [LICENSE](LICENSE) for details.
