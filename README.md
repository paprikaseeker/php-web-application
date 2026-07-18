# Sea Of Black Brewery Website

## Overview

This project is a PHP-based brewery website for Sea Of Black. It combines a polished front-end experience with backend features such as authentication, reviews, contact handling, password reset, and an admin workflow.

It is a strong portfolio project because it demonstrates both visual design and practical server-side development with PHP, PostgreSQL, sessions, forms, and database interaction.

## What is included

### Main pages
- [index.php](index.php) — homepage with branding, hero content, and navigation
- [story.php](story.php) — brewery story page
- [beers.php](beers.php) — beer/product listing page
- [shop.php](shop.php) — shop-style page for showcasing items
- [contact.php](contact.php) — contact page with a working form
- [reviews.php](reviews.php) — review submission and display page
- [login.php](login.php) — login form
- [register.php](register.php) — registration form
- [restorepass.php](restorepass.php) — password reset flow
- [account.php](account.php) — user account area
- [admin.php](admin.php) — admin dashboard

### Backend logic
- [inc/config.php](inc/config.php) — database and mail configuration
- [inc/databaselogin.php](inc/databaselogin.php) — core database and authentication logic
- [inc/auth_helper.php](inc/auth_helper.php) — login/session helper functions
- [inc/security.php](inc/security.php) — CSRF and security helpers
- [inc/handle_auth.php](inc/handle_auth.php) — authentication endpoint
- [inc/contact_handler.php](inc/contact_handler.php) — contact form handler
- [inc/submit_review.php](inc/submit_review.php) — review submission handler
- [inc/admin_actions.php](inc/admin_actions.php) — admin review and beer management actions

### Frontend assets
- [css](css) — page-specific stylesheets
- [cssbootstrap](cssbootstrap) — Bootstrap CSS assets
- [js](js) — JavaScript for login, logout, registration, reviews, and UI interactions
- [images](images) — site visuals, product images, and review images

### Database
- [database/database_schema.sql](database/database_schema.sql) — PostgreSQL schema and sample data

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
- Role-based admin access via the users table

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
├── css/
├── cssbootstrap/
├── js/
├── images/
├── database/
└── vendor/
```

## Setup

1. Make sure PHP and PostgreSQL are installed and running.
2. Create a PostgreSQL database.
3. Import the SQL from [database/database_schema.sql](database/database_schema.sql).
4. Update the values in [inc/config.php](inc/config.php) with your local database and mail settings.
5. Start a local PHP server and open the project in your browser.
6. To access the admin area, create a user account and set that user’s role to `admin` in the database.

## GitHub and portfolio notes

- This repository is intended for portfolio use and demonstration of practical PHP web development.
- Keep local secrets out of the repository. Use a local [.env](.env) file and do not commit it.
- The project is ready to showcase as a full-featured PHP web app with real database-driven behavior.
- If you want to make it even stronger for portfolio purposes, adding screenshots, a short demo video, and a feature summary would help.

## Summary

This repository is a full-featured PHP website demo that includes:
- public pages
- user accounts
- form handling
- database-driven content
- admin moderation
- security-focused backend logic

It is a strong project to showcase if you want to demonstrate practical web development skills.
