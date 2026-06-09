# EventHub — Events Management Web Application

A full-stack web application for a community organisation to manage and showcase events. It has a **public-facing site** where visitors browse, search, and filter upcoming events in real time, and a **secure admin panel** where staff can log in to add, edit, and delete events.

Built for the **Internet Programming** module at the **University of Northampton**, running in a fully containerised Docker environment.

---

## Features

**Public site**
- Browse all upcoming events, loaded dynamically from a MySQL database.
- Keyword search and category/location filtering that update **instantly via AJAX** — no page reload.
- "Coming Soon" badge automatically highlights events happening within the next 7 days.
- Sidebar showing live event counts per category and location.
- Responsive layout (CSS Grid + media queries), hero section, and a back-to-top button.

**Admin panel**
- Secure login using **PHP sessions** and **bcrypt** password hashing.
- Dashboard with event statistics broken down by category.
- Full event management: add, edit, and delete, with client-side and server-side validation.

## Tech Stack

- **Front end:** HTML5, CSS3, JavaScript (Fetch API)
- **Back end:** PHP 8.1 (Apache)
- **Database:** MySQL 5.7 (PDO)
- **Async:** AJAX + JSON
- **Testing:** PHPUnit
- **Environment:** Docker & Docker Compose (PHP/Apache + MySQL + Adminer)

## Security

- **PDO prepared statements** on every query to prevent SQL injection.
- **`htmlspecialchars`** output escaping to prevent cross-site scripting (XSS).
- **bcrypt** password hashing via PHP's `password_hash` / `password_verify`.
- Session-protected admin pages that redirect unauthenticated users to the login page.

## Architecture

EventHub follows a three-tier architecture. The browser (HTML/CSS/JS) talks to a PHP back end running on Apache, which connects to MySQL via PDO. For search and filtering, JavaScript sends an AJAX request to `get_events.php`, which builds a dynamic prepared-statement query and returns results as JSON; the page then updates without reloading. The whole stack runs in three Docker containers orchestrated with Docker Compose.

## Running the Project

The application runs entirely in Docker.

```bash
# 1. Clone the repository
git clone https://github.com/prstshojaei/eventhub-web-app.git
cd eventhub-web-app

# 2. Start the containers
docker compose up -d
```

The database tables and sample data are created automatically from `sql/init.sql` when the MySQL container first starts.

- **Website:** http://localhost
- **Adminer (database UI):** http://localhost:8080

### Admin login (demo)

```
Username: admin
Password: admin123
```

## Running the Tests

```bash
docker compose exec php phpunit src/Code/tests/EventTest.php
```

Tests cover core application logic including input validation, allowed-category checks, date validation, and XSS-escaping behaviour.

## Project Structure

```
├── src/Code/          # Application code
│   ├── index.php          # Public events page
│   ├── admin.php          # Admin dashboard
│   ├── script.js          # AJAX, validation, UI logic
│   ├── styles.css         # Responsive styling
│   ├── php/               # Back-end endpoints (login, CRUD, get_events)
│   └── tests/             # PHPUnit tests
├── sql/init.sql       # Database schema + sample data
├── assets/            # Images
├── Dockerfile
└── docker-compose.yml
```
