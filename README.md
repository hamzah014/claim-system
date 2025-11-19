# Claim System Project Setup Guide

This guide explains how to install, run, and maintain the Laravel project locally and in production.

---

## Requirements

* PHP 8.2
* Git
* Laravel CLI (optional)

---

## 1. Clone the Project

```bash
git clone https://github.com/hamzah014/claim-system.git
cd claim-system
```

---

## 2. Install PHP Dependencies

```bash
composer install
```

---

## 3. Environment Setup

Copy the example environment file:

```bash
cp .env.example .env
```

Generate an application key:

```bash
php artisan key:generate
```

Update `.env` with your database credentials:

```
DB_DATABASE=your_db
DB_USERNAME=root
DB_PASSWORD=secret
```

---

## 4. Migrate & Seed Database (If Needed)

```bash
php artisan migrate
php artisan db:seed   # optional
```

---

## 5. Run the Local Development Server

```bash
php artisan serve
```

Visit the project at: `http://localhost:8000`

---

## 11. Project Structure

```
app/          # Application code
bootstrap/    # Framework bootstrap files
config/       # Configuration files
database/     # Migrations and seeds
public/       # Public web root
resources/    # Views, CSS, JS
routes/       # Routes
storage/      # Logs, cache
tests/        # Automated tests
```

---

## License

This project is licensed under your preferred license.
