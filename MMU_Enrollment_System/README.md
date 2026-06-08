# MMU Student Enrollment System

A beginner-friendly PHP 8 and MySQL web application for a university Software Engineering Fundamentals project. Students can register, login, update their profile, view courses, enroll in courses, and track enrollment status. Admins can view dashboard totals, manage courses, view students, and approve or reject enrollments.

## Technology Stack

- HTML5, CSS3, Bootstrap 5, JavaScript
- PHP 8
- MySQL
- XAMPP recommended for local setup

## Folder Structure

```text
MMU_Enrollment_System/
├── admin/
├── assets/css/
├── config/
├── student/
├── database.sql
├── enroll_process.php
├── login.php
├── logout.php
├── README.md
└── register.php
```

## XAMPP Installation Steps

1. Install XAMPP from https://www.apachefriends.org/.
2. Start Apache and MySQL from the XAMPP Control Panel.
3. Copy the `MMU_Enrollment_System` folder into your XAMPP `htdocs` folder.
   - Example: `C:\xampp\htdocs\MMU_Enrollment_System`
4. Open phpMyAdmin:
   - `http://localhost/phpmyadmin`
5. Import the database:
   - Click **Import**.
   - Choose `database.sql` from this project folder.
   - Click **Go**.
6. Open the project in your browser:
   - `http://localhost/MMU_Enrollment_System/login.php`

## Database Setup

The SQL file creates the database:

```sql
mmu_enrollment
```

It creates these tables:

- `students`
- `admins`
- `courses`
- `enrollments`

It also inserts one admin account and four sample courses.

## Login Credentials

Admin login:

- URL: `http://localhost/MMU_Enrollment_System/admin/admin_login.php`
- Username: `admin`
- Password: `password`

Student login:

- Register a new student account at `http://localhost/MMU_Enrollment_System/register.php`
- Then login at `http://localhost/MMU_Enrollment_System/login.php`

## Configuration

Database connection settings are in:

```text
config/database.php
```

Default XAMPP settings:

```php
$host = 'localhost';
$database = 'mmu_enrollment';
$username = 'root';
$password = '';
```

If your MySQL user has a password, update `$password`.

## Features

Student:

- Register account
- Login and logout
- View dashboard
- View and update profile
- View courses
- Enroll into courses
- View Pending, Approved, or Rejected enrollment status

Admin:

- Login and logout
- View dashboard totals
- View students
- Add, edit, and delete courses
- Approve or reject enrollments

## Security Notes

- PHP sessions protect student and admin pages.
- Form inputs are checked to prevent empty submissions.
- Database queries use prepared statements.
- Passwords are stored with PHP password hashing.

## Common Troubleshooting

- If the app cannot connect to the database, make sure MySQL is running and `database.sql` has been imported.
- If Bootstrap styling does not appear, check your internet connection because Bootstrap is loaded from CDN.
- If login fails for admin, re-import `database.sql` and use username `admin` with password `password`.
