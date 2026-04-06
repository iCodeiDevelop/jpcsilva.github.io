# API Documentation — Portfolio Management System

## Base URL
```
Development: http://localhost:5000/api
Production:  https://api.yourdomain.com/api
```

## Authentication
All admin routes require JWT Bearer token:
```http
Authorization: Bearer <access_token>
```

Access tokens expire in **15 minutes**. Use `/api/auth/refresh` with an `httpOnly` refresh cookie to get new tokens automatically.

---

## Endpoints

### 🔐 Auth
| Method | Endpoint                     | Auth | Description                    |
|--------|------------------------------|------|--------------------------------|
| POST   | `/auth/login`                | ❌   | Login — returns tokens         |
| POST   | `/auth/register`             | ❌   | Register editor account        |
| POST   | `/auth/logout`               | ✅   | Logout — invalidates tokens    |
| POST   | `/auth/refresh`              | ❌   | Refresh access token via cookie|
| GET    | `/auth/me`                   | ✅   | Get current user profile       |
| PATCH  | `/auth/me`                   | ✅   | Update name / avatar           |
| POST   | `/auth/change-password`      | ✅   | Change password                |

**Login Request:**
```json
POST /api/auth/login
{ "email": "admin@portfolio.dev", "password": "Admin@123!" }
```
**Login Response:**
```json
{
  "status": "success",
  "data": {
    "user": { "_id": "...", "name": "Alex", "email": "...", "role": "admin" },
    "accessToken": "eyJhbGci...",
    "expiresIn": "15m"
  }
}
```

---

### 👤 Profile (public)
| Method | Endpoint       | Auth  | Description      |
|--------|----------------|-------|------------------|
| GET    | `/profile`     | ❌    | Get profile data |
| PUT    | `/admin/profile` | ✅ admin | Create/update profile |

---

### 📁 Projects
| Method | Endpoint                          | Auth       | Description           |
|--------|-----------------------------------|------------|-----------------------|
| GET    | `/projects`                       | ❌ (public) | List published projects |
| GET    | `/projects/:id`                   | ❌          | Get project by ID/slug |
| POST   | `/admin/projects`                 | ✅ admin/editor | Create project     |
| PATCH  | `/admin/projects/:id`             | ✅          | Update project        |
| DELETE | `/admin/projects/:id`             | ✅ admin    | Delete project        |
| PATCH  | `/admin/projects/:id/status`      | ✅          | Publish / archive     |
| POST   | `/admin/projects/:id/images`      | ✅          | Upload images         |

**Query Params for GET /projects:**
- `?status=published` — filter by status
- `?category=web` — filter by category
- `?featured=true` — featured only
- `?tech=React` — filter by tech stack
- `?search=ecommerce` — full-text search
- `?page=1&limit=10` — pagination
- `?sort=-createdAt` — sorting

---

### 🔧 Skills
| Method | Endpoint              | Auth | Description     |
|--------|-----------------------|------|-----------------|
| GET    | `/skills`             | ❌   | Get all skills  |
| GET    | `/skills/:id`         | ❌   | Get skill by ID |
| POST   | `/admin/skills`       | ✅   | Create skill    |
| PATCH  | `/admin/skills/:id`   | ✅   | Update skill    |
| DELETE | `/admin/skills/:id`   | ✅ admin | Delete skill |
| PATCH  | `/admin/skills/order` | ✅   | Bulk reorder    |

---

### 💼 Experience
| Method | Endpoint                   | Auth | Description        |
|--------|----------------------------|------|--------------------|
| GET    | `/experiences`             | ❌   | List experiences   |
| POST   | `/admin/experiences`       | ✅   | Create experience  |
| PATCH  | `/admin/experiences/:id`   | ✅   | Update experience  |
| DELETE | `/admin/experiences/:id`   | ✅   | Delete experience  |

---

### 📰 Blog
| Method | Endpoint              | Auth | Description         |
|--------|-----------------------|------|---------------------|
| GET    | `/blogs`              | ❌   | List published posts|
| GET    | `/blogs/tags`         | ❌   | Get all tags        |
| GET    | `/blogs/:id`          | ❌   | Get post by ID/slug |
| POST   | `/admin/blogs`        | ✅   | Create post         |
| PATCH  | `/admin/blogs/:id`    | ✅   | Update post         |
| DELETE | `/admin/blogs/:id`    | ✅ admin | Delete post     |

---

### 📧 Contact
| Method | Endpoint    | Auth | Description              |
|--------|-------------|------|--------------------------|
| POST   | `/contact`  | ❌   | Submit contact form (rate limited: 5/hr) |

**Request:**
```json
{
  "name":    "John Doe",
  "email":   "john@example.com",
  "subject": "Project Inquiry",
  "message": "I'd like to discuss a potential project..."
}
```

---

### 📊 Analytics (Admin)
| Method | Endpoint          | Auth       | Description              |
|--------|-------------------|------------|--------------------------|
| GET    | `/admin/analytics`| ✅ admin   | Dashboard stats & charts |

---

## Error Responses
```json
{
  "status": "fail",
  "message": "Detailed error message here"
}
```

HTTP Status Codes:
- `200` Success
- `201` Created
- `204` No Content (deleted)
- `400` Bad Request / Validation Error
- `401` Unauthorized
- `403` Forbidden
- `404` Not Found
- `409` Conflict (duplicate)
- `429` Rate Limited
- `500` Internal Server Error
