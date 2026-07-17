# Sea Of Black Brewery Website

## Overview

This project is a PHP-based brewery website for Sea Of Black. It combines a modern landing page experience with backend functionality such as authentication, reviews, contact form handling, and an admin workflow.

It is designed as a full-stack-style demo project that shows how front-end pages can connect to a PostgreSQL database and dynamic PHP logic.

## What is inside the project

### Main pages
- `index.php` — homepage with branding, hero content, and navigation
- `story.php` — brewery story page
- `beers.php` — beer/product listing page
- `shop.php` — shop-style page for showcasing items
- `contact.php` — contact page with a working form
- `reviews.php` — review page with rating and review submission UI
- `login.php` — login form
- `register.php` — registration form
- `restorepass.php` — password reset flow
- `account.php` — user account area
- `admin.php` — admin dashboard

### Backend logic
- `inc/config.php` — database and mail configuration
- `inc/databaselogin.php` — main database logic and business logic class
- `inc/auth_helper.php` — login/session helper functions
- `inc/security.php` — CSRF and rate limiting helpers
- `inc/handle_auth.php` — authentication endpoint
- `inc/contact_handler.php` — contact form handler
- `inc/submit_review.php` — review submission handler
- `inc/admin_actions.php` — admin review and beer management actions

### Frontend assets
- `css/` — page-specific stylesheets
- `js/` — JavaScript for login, logout, registration, and reviews
- `images/` — site visuals, product images, and review images

### Database
- `database/database_schema.sql` — PostgreSQL schema and sample data

## Features

- Responsive multi-page website layout
- User registration and login
- Session-based authentication
- Password reset flow
- CSRF protection and login attempt tracking
- Guest and account-based review submissions
- Review moderation through admin actions
- Contact form with database storage and email sending
- PostgreSQL integration with PDO

## Tech stack

- PHP
- PostgreSQL
- PDO
- HTML / CSS / JavaScript
- Bootstrap
- PHPMailer

## Project structure

```text
/
├── index.php
├── story.php
├── beers.php
├── shop.php
├── contact.php
├── reviews.php
├── login.php
├── register.php
├── restorepass.php
├── account.php
├── admin.php
├── inc/
│   ├── config.php
│   ├── databaselogin.php
│   ├── auth_helper.php
│   ├── security.php
│   ├── handle_auth.php
│   ├── contact_handler.php
│   ├── submit_review.php
│   ├── admin_actions.php
│   └── header.php
├── js/
├── css/
├── images/
├── database/
└── vendor/
```

## Setup

1. Make sure PHP and PostgreSQL are installed and running.
2. Create a PostgreSQL database.
3. Import the SQL from `database/database_schema.sql`.
4. Update the values in `inc/config.php` with your local database and mail settings.
5. Start a local PHP server and open the project in your browser.

## Notes for portfolio use

- The project is a good example of a practical PHP web app with real database interaction.
- It shows both front-end design and backend logic.
- The code is suitable for explaining CRUD-style workflows, authentication, form handling, and simple admin tools.
- Before sharing publicly, replace any real credentials and sensitive local configuration values with placeholders.

## Summary

This repository is a full-featured PHP website demo that includes:
- public pages
- user accounts
- form handling
- database-driven content
- admin moderation
- security-focused backend logic

It is a strong project to showcase if you want to demonstrate practical web development skills.