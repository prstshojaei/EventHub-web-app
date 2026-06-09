# EventHub — Community Events Portal

**Name:** Parastoo Shojaei Sarcheshmeh  
**Student ID:** 25828319  
**Module:** CSYM019 Internet Programming  

---

## About This Project

EventHub is a community events web application.
It includes a public events listing page with AJAX search and filtering,
and a secure admin panel for managing events.

---

## Technologies

- HTML5 and CSS3 for the front end
- JavaScript for AJAX and form validation
- PHP 7.2 for server-side processing
- MySQL for the database
- Docker to run the local server environment

---

## How to Run It

You need Docker Desktop installed first.
git clone https://github.com/D12AOS/csym019-internet-programming-assignment-prstshojaei.git
cd csym019-internet-programming-assignment-prstshojaei
docker compose up

Then open your browser and go to:

- Public site: http://localhost
- Database viewer: http://localhost:8080
- Admin login: http://localhost/php/login.php

---

## Login Details

**Admin username:** admin  
**Admin password:** admin123

**Database:**  
Server: db  
Username: root  
Password: csym019  
Database: Internet_programming  

---

## File Structure

```
project/
├── docker-compose.yml
├── Dockerfile
├── sql/
│   └── init.sql
├── docs/
│   ├── README.md
│   └── progress.md
├── assets/
│   └── images/
└── src/
    └── Code/
        ├── index.php
        ├── admin.php
        ├── styles.css
        ├── script.js
        └── php/
            ├── db.php
            ├── login.php
            ├── logout.php
            ├── add_event.php
            ├── edit_event.php
            ├── delete_event.php
            └── get_events.php
```

## What I Built

**Public site:**
- Events listing page loaded from MySQL using PHP
- Search box and category/location filters using AJAX and JSON
- Coming Soon badge for events happening within 7 days
- Event counts next to each category and location
- Responsive design for mobile screens

**Admin panel:**
- Login page with PHP session and bcrypt password hashing
- Dashboard showing event counts per category
- Add, edit and delete events
- Form validation on both client and server side

---

## Extra Things I Added

- Location filter in the sidebar
- Event time field
- Coming Soon badge
- Category and location counts
- Admin dashboard with live stats
- Back to top button
