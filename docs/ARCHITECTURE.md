# System Architecture — Portfolio Management System

## Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                          INTERNET                               │
└──────────────────────────┬──────────────────────────────────────┘
                           │ HTTPS
                    ┌──────▼──────┐
                    │   Nginx     │  Reverse Proxy + SSL Termination
                    │  (Port 80/  │  Rate limiting, Security headers
                    │   443)      │  Static file caching
                    └──────┬──────┘
            ┌──────────────┼──────────────┐
            │              │              │
     ┌──────▼──────┐ ┌─────▼──────┐ ┌───▼─────────┐
     │  Next.js 14  │ │ Express.js │ │  /uploads/  │
     │  Frontend    │ │  Backend   │ │  Static     │
     │  (Port 3000) │ │  (Port 5000│ │  Files      │
     └──────┬──────┘ └─────┬──────┘ └─────────────┘
            │              │
            │         ┌────┴─────────────┐
            │         │                  │
     ┌──────▼──────┐  │  ┌────────────┐  │
     │  SSR Pages  │  │  │  MongoDB   │  │
     │  (Next.js   │  │  │  (Port     │  │
     │  ISR/SSR)   │  │  │  27017)    │  │
     └─────────────┘  │  └────────────┘  │
                      │  ┌────────────┐  │
                      │  │   Redis    │  │
                      │  │  (Port     │  │
                      │  │   6379)    │  │
                      │  └────────────┘  │
                      └─────────────────┘
```

## Layer Breakdown

### 1. Client Layer (Next.js 14 — App Router)
- **SSR/ISR**: Public portfolio pages use server-side rendering with incremental static regeneration (60s) for optimal SEO
- **Client-side**: Admin dashboard uses client-side rendering with React Query for real-time data
- **Theming**: next-themes for dark/light mode
- **State**: Zustand for auth state + React Query for server state

### 2. API Layer (Express.js)
- **Architecture**: MVC + Service Layer pattern
- **Authentication**: JWT (access: 15min) + Refresh tokens (7 days) via httpOnly cookies
- **Validation**: express-validator on all inputs
- **Security**: helmet, CORS, rate limiting, mongo-sanitize, XSS protection
- **Logging**: Winston structured logging + Morgan HTTP logs
- **File Handling**: Multer with MIME type validation

### 3. Data Layer
- **Primary DB**: MongoDB with Mongoose ODM
  - TTL indexes on analytics (90 days) and activity logs (180 days)
  - Compound indexes for common query patterns
- **Cache**: Redis for session data and rate limiting
- **Files**: Local disk (uploads/) — swappable to S3 via Flysystem-style abstraction

## Key Design Decisions

| Decision | Choice | Reason |
|----------|--------|--------|
| Frontend framework | Next.js 14 | SSR for SEO, App Router for layouts |
| State management | Zustand + React Query | Minimal boilerplate, great DX |
| CSS | Tailwind CSS | Utility-first, consistent design system |
| Backend framework | Express.js | Mature, flexible, huge ecosystem |
| Database | MongoDB | Schema flexibility, great for content |
| Auth | JWT + Refresh | Stateless, scalable, secure httpOnly cookies |
| Images | next/image | Built-in optimization, WebP conversion |
| Animations | Framer Motion | Declarative, performant |

## Security Architecture

```
Request → Rate Limiter → CORS Check → Helmet Headers
        → Input Sanitization (XSS / NoSQL injection)
        → JWT Validation → Role Check (RBAC)
        → Controller → Service → Database
        → Response (sanitized)
```

## RBAC Roles

| Role   | Projects | Skills | Blog | Profile | Analytics | Users |
|--------|----------|--------|------|---------|-----------|-------|
| Admin  | CRUD     | CRUD   | CRUD | CRUD    | Read      | CRUD  |
| Editor | CRUD*    | CRUD   | CRUD | -       | -         | -     |
| Viewer | Read     | Read   | Read | -       | -         | -     |

*Editors cannot delete

## Scalability Notes

1. **Horizontal scaling**: Backend is stateless (JWT auth, Redis sessions) → can run multiple instances behind load balancer
2. **Database**: MongoDB replica set + read replicas for heavy report queries
3. **CDN**: Static assets + images can be served via CloudFront/Cloudflare
4. **Caching**: Redis caching layer for frequently-read data (profile, skills)
5. **Queue**: Long-running tasks (report generation, bulk emails) → Bull queue on Redis
