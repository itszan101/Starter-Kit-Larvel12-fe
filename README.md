# Laravel Frontend Starter (API-Driven)

This repository contains the **frontend layer** for the Laravel API Starter Kit.

[https://github.com/itszan101/Starter-Kit-Larvel12]

It is a **server-rendered Laravel application (Blade)** that consumes a separate backend API for authentication, authorization, and data management.

The frontend acts purely as a **client**:

* No direct database access
* No business logic duplication
* All auth & permission checks are delegated to the backend API

---

## Key Characteristics

* Laravel Blade-based frontend
* API-driven authentication (Laravel Sanctum backend)
* Session-based token storage
* Role & permission aware UI
* Middleware-based access control

Designed for:

* Admin panels
* Internal dashboards
* Government / enterprise systems

---

## Tech Stack

* PHP >= 8.2
* Laravel
* Blade Template Engine
* Laravel HTTP Client
* Session-based state management

---

## Architecture Overview

```
[ Browser ]
     ↓
[ Laravel Frontend (Blade) ]
     ↓ HTTP API
[ Laravel Backend API ]
     ↓
[ Database ]
```

The frontend never touches the database directly.
All user data, roles, and permissions come from the backend API.

---

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd <frontend-project>
```

Install dependencies:

```bash
composer install
```

Create environment file:

```bash
cp .env.example .env
php artisan key:generate
```

---

## Environment Configuration

Set the backend API URL in `.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

BACKEND_URL=http://127.0.0.1:8000/api
```

> `BACKEND_URL` **must point to the API base path**.

---

## Authentication Flow

1. User submits login form
2. Frontend sends credentials to backend API
3. Backend returns:

   * Access token
   * User data
   * Roles
   * Permissions
4. Frontend stores them in session
5. Subsequent requests are authorized using middleware

Token is attached to API calls using:

```
Authorization: Bearer <token>
```

---

## Route Structure

### Public Routes

* `/login`
* `/register`

Accessible only for **guest users** using `check.token:guest` middleware.

---

### Protected Routes

All routes below require authentication using `check.token:auth`.

#### Dashboard

* `/dashboard`

#### Admin (User) Management

| URL                        | Permission        |
| -------------------------- | ----------------- |
| `/admins`                  | `user.view`       |
| `/admins/create`           | `user.create`     |
| `/admins/{id}/edit`        | `user.update`     |
| `/admins/{id}` (DELETE)    | `user.delete`     |
| `/admins/{id}/assign-role` | `role.assignUser` |

---

#### Role Management

| URL                              | Permission              |
| -------------------------------- | ----------------------- |
| `/roles`                         | `role.view`             |
| POST `/roles`                    | `role.create`           |
| DELETE `/roles/{id}`             | `role.delete`           |
| POST `/roles/update-permissions` | `permission.assignRole` |

---

#### Permission Management

| URL                        | Permission              |
| -------------------------- | ----------------------- |
| `/permissions`             | `permission.view`       |
| POST `/permissions`        | `permission.create`     |
| DELETE `/permissions/{id}` | `permission.delete`     |
| POST `/permissions/assign` | `permission.assignRole` |

---

## Middleware Overview

| Middleware          | Purpose                                          |
| ------------------- | ------------------------------------------------ |
| `check.token:guest` | Prevent logged-in users accessing login/register |
| `check.token:auth`  | Ensure user is authenticated                     |
| `checkPermission:*` | Permission-based access control                  |

Middleware reads **roles & permissions from session**, not database.

---

## Controller Pattern

Controllers act as:

* Form validators
* API proxies
* Session managers

No business logic should live here.

Example responsibilities:

* Validate request
* Forward request to backend API
* Handle API response
* Store or clear session

---

## Session Data Structure

Stored on successful login:

* `api_token`
* `user_role`
* `user_permissions`
* `user_data`

These values are used for:

* Authorization
* UI rendering
* Middleware checks

---

## Important Notes

* Backend **must be running** before frontend
* Permission mismatch will result in blocked routes
* Frontend assumes backend response format is consistent

---

## Contributing

Contributions are welcome.

* Keep controllers thin
* Avoid duplicating backend logic
* Respect separation of concerns

---

## License

This project is open-source and released under the **MIT License**.

Use it as a frontend shell, not as a logic dump.
