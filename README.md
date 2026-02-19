# PM API

![Laravel](https://img.shields.io/badge/Laravel-12-orange)
![PHP](https://img.shields.io/badge/PHP-8.3-blue)
![License](https://img.shields.io/badge/License-MIT-green)

A RESTful Project Management API built with Laravel 12, MySQL and Docker.

---

## Project Overview

PM API is a backend application designed to manage:

- Organizations  
- Projects  
- Tasks  
- Task assignments to users  
- Role-based access control (RBAC)

The API follows RESTful principles and uses a relational database with proper foreign key constraints.

Authentication is handled via **Laravel Sanctum**.  
Authorization is implemented using **middleware-based role control**.

The project is fully containerized using Docker for reproducibility.

---

## Tech Stack

- PHP 8.3  
- Laravel 12  
- Laravel Sanctum (API Authentication)  
- MySQL 8  
- Nginx  
- Docker & Docker Compose  

---

## Data Model

### Relationships

- **Organization** → has many **Projects**  
- **Project** → belongs to **Organization**  
- **Project** → has many **Tasks**  
- **Task** → belongs to **Project**  
- **Task** → can be assigned to multiple **Users** (many-to-many)  
- **User** → can belong to multiple **Organizations** (many-to-many with role)

### Pivot Tables

- `organization_user`  
  - `user_id`  
  - `organization_id`  
  - `role` (admin | member)  

- `task_user`  
  - `user_id`  
  - `task_id`  

Relational integrity is enforced via foreign keys and pivot tables.

---

## Local Development Setup

### 1. Clone repository

```bash
git clone git@github.com:nicola-simioni/pm-api.git
cd pm-api
```

### 2. Start Docker containers

```bash
docker compose up -d --build
```

### 3. Install dependencies

```bash
docker compose exec app composer install
```

### 4. Copy environment file

```bash
cp .env.example .env
```

### 5. Generate application key

```bash
docker compose exec app php artisan key:generate
```

### 6. Run migrations

```bash
docker compose exec app php artisan migrate
```

The API will be available at:

```
http://localhost:8000
```

---

## Authentication

This API uses **Laravel Sanctum** for token-based authentication.

Protected routes require:

```
Authorization: Bearer YOUR_TOKEN
```

Example: generate a token (development only)

```bash
docker compose exec app php artisan tinker
```

```php
$user = App\Models\User::first();
$user->createToken('api-token')->plainTextToken;
```

Use the printed token in your requests.

---

## Authorization (RBAC)

Role-based access control is implemented via middleware.  
Only users with the proper role can access certain endpoints.

Example:

```php
->middleware(['auth:sanctum', 'role:admin'])
```

Roles are stored in the pivot table `organization_user`:

- `admin` → full access in the organization  
- `member` → restricted access  

---

## API Endpoints

### Organizations

| Method | Endpoint |
|--------|----------|
| GET    | /api/organizations |
| POST   | /api/organizations |
| GET    | /api/organizations/{id} |
| PUT    | /api/organizations/{id} |
| DELETE | /api/organizations/{id} |

### Projects

| Method | Endpoint |
|--------|----------|
| GET    | /api/projects |
| POST   | /api/projects |
| GET    | /api/projects/{id} |
| PUT    | /api/projects/{id} |
| DELETE | /api/projects/{id} |

### Tasks

| Method | Endpoint |
|--------|----------|
| GET    | /api/tasks |
| POST   | /api/tasks |
| GET    | /api/tasks/{id} |
| PUT    | /api/tasks/{id} |
| DELETE | /api/tasks/{id} |
| POST   | /api/tasks/{id}/assign-users |

---

## Example Requests

### Create an organization

```bash
curl -X POST http://localhost:8000/api/organizations \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"name":"Acme Corp"}'
```

### Assign users to a task (admin only)

```bash
curl -X POST http://localhost:8000/api/tasks/1/assign-users \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"user_ids":[1,2]}'
```

### Example unauthorized response

```json
{
  "message": "Forbidden: insufficient role"
}
```

---

## Architecture Highlights

- Clean separation of authentication and authorization  
- Middleware-based role control  
- Pivot-based RBAC design  
- RESTful resource controllers  
- Dockerized environment for reproducibility  

---

## Author

Nicola Simioni
