# AMS — Attendance Management System

A PHP + MySQL + CSS + JavaScript attendance portal inspired by the uploaded UI references. It includes separate experiences for **Admin**, **Teacher**, and **Student**.

## Included

- Sign in + registration
- Demo two-factor/OTP screen (code: `123456`)
- Admin dashboard, user management, attendance review, reports
- Teacher dashboard, record attendance, view attendance, profile
- Student dashboard, **My Profile**, **My Attendance**
- MySQL database schema + demo records
- Responsive layout with mobile sidebar
- Prepared SQL statements and password hashing

## Requirements

- PHP 8.1+ with PDO MySQL enabled
- MySQL 8+ or MariaDB
- Apache/XAMPP/WAMP/Laragon

## XAMPP setup

1. Copy the `ams` folder into `C:/xampp/htdocs/ams`.
2. Start **Apache** and **MySQL** in XAMPP.
3. Open phpMyAdmin and import `setup.sql`.
4. If your MySQL password is not blank, edit `config/config.php` and change `DB_PASS`.
5. Open `http://localhost/ams/`.

## Demo accounts

- Admin: `admin@ams.local` / `admin123`
- Teacher: `teacher@ams.local` / `teacher123`
- Student: `student@ams.local` / `student123`
- OTP for all demo logins: `123456`

## Project structure

```text
ams/
├── admin/
├── teacher/
├── student/
├── assets/css/style.css
├── assets/js/app.js
├── config/
├── includes/
├── index.php
├── login.php
├── register.php
├── verify.php
├── logout.php
└── setup.sql
```

## Important

This is a school-project starter. For production use, add CSRF protection, real email/SMS OTP delivery, stronger permission rules, audit logs, rate limiting, and environment-based secrets.
