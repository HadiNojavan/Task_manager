# Task Manager API Documentation

## Base URL

```
http://localhost:8082
```

## Authentication

The API uses Bearer Token Authentication.

After a successful login, the API returns an authentication token. For protected endpoints, send the token in the request header:

```
Authorization: Bearer {token}
```

---

## Authentication Endpoints

### Register

Create a new user.

- **Request:** `POST /api/register`
- **Access:** Guest

**Body**
```json
{
    "username": "hadi",
    "password": "123456"
}
```

---

### Login

Login to the system.

- **Request:** `POST /api/login`
- **Access:** Guest

**Body**
```json
{
    "username": "hadi",
    "password": "123456"
}
```

**Response**
```json
{
    "message": "Login successful",
    "token": "your-token",
    "role": "user",
    "username": "hadi"
}
```

---

### Logout

Logout the authenticated user and invalidate the token.

- **Request:** `POST /api/logout`
- **Access:** Authenticated User

**Headers**
```
Authorization: Bearer {token}
```

---

## Task Endpoints

### Get Tasks

Get tasks available to the authenticated user. An admin can see all tasks; a normal user can only see their assigned tasks.

- **Request:** `GET /api/tasks`
- **Access:** Authenticated User

**Headers**
```
Authorization: Bearer {token}
```

---

### Get My Tasks

Get tasks assigned to the authenticated user.

- **Request:** `GET /api/my-tasks`
- **Access:** Authenticated User

**Headers**
```
Authorization: Bearer {token}
```

---

### Get Task By ID

Get one task by its ID.

- **Request:** `GET /api/tasks/{id}`
- **Access:** Authenticated User
- **Example:** `GET /api/tasks/5`

**Headers**
```
Authorization: Bearer {token}
```

---

### Create Task

Create a new task.

- **Request:** `POST /api/tasks`
- **Access:** Authenticated User

**Headers**
```
Authorization: Bearer {token}
```

**Body**
```json
{
    "title": "Learn PHP",
    "description": "Practice MVC",
    "due_date": "2026-09-10",
    "priority": "high",
    "status": "pending"
}
```

---

### Update Task

Update an existing task.

- **Request:** `PATCH /api/tasks/{id}`
- **Access:** Authenticated User
- **Example:** `PATCH /api/tasks/5`

**Headers**
```
Authorization: Bearer {token}
```

**Body**
```json
{
    "title": "Learn PHP and MVC",
    "description": "Practice MVC architecture",
    "due_date": "2026-09-15",
    "priority": "medium",
    "status": "in_progress"
}
```

---

### Delete Task

Soft delete a task.

- **Request:** `DELETE /api/tasks/{id}`
- **Access:** Authenticated User
- **Example:** `DELETE /api/tasks/5`

**Headers**
```
Authorization: Bearer {token}
```

---

## Admin Endpoints

### Get All Users

Get information about all users.

- **Request:** `GET /api/users`
- **Access:** Admin Only

**Headers**
```
Authorization: Bearer {admin-token}
```

---

### Add Admin

Create a new admin user.

- **Request:** `POST /api/add_admin`
- **Access:** Admin Only

**Headers**
```
Authorization: Bearer {admin-token}
```

**Body**
```json
{
    "username": "new_admin",
    "password": "123456"
}
```

---

### Assign Task

Assign one task to multiple users.

- **Request:** `POST /api/tasks/{id}/assign`
- **Access:** Admin Only
- **Example:** `POST /api/tasks/5/assign`

**Headers**
```
Authorization: Bearer {admin-token}
```

**Body**
```json
{
    "user_ids": [1, 2, 3]
}
```

---

### Get Deleted Tasks

Get tasks that were soft deleted.

- **Request:** `GET /api/tasks/deleted`
- **Access:** Admin Only

**Headers**
```
Authorization: Bearer {admin-token}
```

---

### Restore Task

Restore a soft-deleted task.

- **Request:** `PATCH /api/tasks/{id}/restore`
- **Access:** Admin Only
- **Example:** `PATCH /api/tasks/5/restore`

**Headers**
```
Authorization: Bearer {admin-token}
```
this endpoint can used only by admin to filter result 
### Query Parameters

The `GET /api/tasks` endpoint supports filtering and searching tasks.

Available parameters:

- `status` `pending`, `in_progress`, `completed` 
- `priority` `low`, `medium`, `high`
- `search` to search in title 

### Examples

Filter by status:

```text
GET /api/tasks?status=completed
```
