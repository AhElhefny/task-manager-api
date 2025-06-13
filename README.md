# 🧠 Advanced Task Manager API

A Laravel 12 RESTful API for managing tasks with support for full-text search, prioritization, filtering, sorting, soft deletes, queue-based notifications, and more.

---

## 🚀 Features

### ✅ Basic Features

- **Task Creation**
  - Create tasks with title, description, and due date.
  - Validate that title is required, description is optional, and due date is a valid future date.
  - Status Enum: `Pending`, `In Progress`, `Completed`, `Overdue`.

- **Task Updates**
  - Update task status.
  - Prevent direct transition to `Completed` unless task is already `In Progress`.

- **Task Deletion**
  - Soft delete support to preserve task history.

- **Task Listing**
  - Filter tasks by status and due date range.
  - Sort tasks by: `priority`, `due date`, or `creation date`.

---

### 🧠 Advanced Features

- **Task Notifications**
  - Email notification 24 hours before due date.
  - Artisan command scheduled to run hourly.
  - Powered by Laravel Queues.

- **Task Search**
  - Full-text search on `title` and `description` using MySQL’s `MATCH...AGAINST`.

- **Task Prioritization**
  - Enum-based priority system: `Low`, `Medium`, `High`.
  - Supports sorting by priority.

---

### 🧪 Code Quality

- ✅ Follows **SOLID principles**.
- ✅ Uses **Service Layer**, **Form Requests**, **Custom Resources**, and **Traits**.
- ✅ Organized by feature with clear folder structure.
- ✅ Factory and Seeder support for test data.
- ✅ Unit and Feature tests planned.

---

### 🎁 Bonus Features

- 🔐 Rate Limiting (Optional) to prevent abuse.
- 📦 API Resource Responses for clean output.
- 🧾 API Documentation ready to be extended via Swagger / Laravel OpenAPI.

---

## ⚙️ Setup Instructions

### 1. Clone the repository

```bash
git clone https://github.com/AhElhefny/task-manager-api.git
cd task-manager-api
2. Install dependencies

composer install
cp .env.example .env
php artisan key:generate
3. Configure the .env file
Set your database connection

Configure mail settings for notifications

4. Run migrations and seeders

php artisan migrate --seed
5. (Optional) Set up Scheduler
Add this to your server cron job (to run every minute):


* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
🧪 Running Tests

php artisan test
📄 License
This project is open-sourced under the MIT license.

👨‍💻 Built with ❤️ by AhElhefny

