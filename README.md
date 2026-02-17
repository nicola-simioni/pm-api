# PM API

A RESTful Project Management API built with Laravel, MySQL and Docker.

---

## Project Overview

PM API is a backend application designed to manage:

- Organizations  
- Projects  
- Tasks  
- Task assignments to users  

The application follows RESTful principles and uses a relational database with proper foreign key constraints.  
This project is fully containerized using Docker.

---

## Tech Stack

- PHP 8.3  
- Laravel  
- MySQL 8  
- Nginx  
- Docker & Docker Compose  

---

## Data Model

**Relationships**

- **Organization** → has many **Projects**  
- **Project** → belongs to **Organization**  
- **Project** → has many **Tasks**  
- **Task** → belongs to **Project**  
- **Task** → can be assigned to multiple **Users** (many-to-many)  

Relational integrity is enforced via foreign keys and pivot tables.

---

## Local Development Setup

**1. Clone repository**

git clone git@github.com:nicola-simioni/pm-api.git  
cd pm-api

**2. Start Docker containers**

docker compose up -d --build

**3. Run migrations**

docker compose exec app php artisan migrate

The API will be available at:

http://localhost:8000

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

**Create an organization**

curl -X POST http://localhost:8000/api/organizations \
  -H "Content-Type: application/json" \
  -d '{"name":"Acme Corp"}'

**Assign users to a task**

curl -X POST http://localhost:8000/api/tasks/1/assign-users \
  -H "Content-Type: application/json" \
  -d '{"user_ids":[1,2]}'

---

## Author

Nicola Simioni
