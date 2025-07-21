# Student Management System

A simple PHP + MySQL student management system with authentication for students and faculty.

## Features

- User authentication (login/signup)
- Faculty dashboard to manage students
- Student dashboard for profile access
- Role-based access (student / faculty)

## Requirements

- PHP 8+
- MySQL (phpMyAdmin via XAMPP)
- Composer (optional)

---

## Setup using XAMPP

1. Clone or download the project:
```
git clone https://github.com/Humble2021/student_system.git
```
2. Move it to htdocs:

```
mv student_system /opt/lampp/htdocs/  # for Linux
```
3. Import the database:
```
Open phpMyAdmin (http://localhost/phpmyadmin)
```
```
Create database student_system
```
```
Import student_system.sql
```
4. Access the system:

```
http://localhost/student_system
```
5. Setup using PHP Built-in Server
Navigate to the project directory:

```
cd student_system
```
6. Start the server:

```
php -S localhost:8000
```
7. Open in browser:

```
http://localhost:8000
```
8. Default Roles
Student and Faculty are defined during signup

```Faculty can view all students

📁 Project Structure


student_system/
│
├── assets/               # CSS & JS
├── authentication/       # Login, Signup, Logout
├── dashboard/
│   ├── student/
│   └── faculty/
├── layout/               # Header, Footer
├── middleware/           # Auth, Role Check
├── conn.php
├── index.php
└── student_system.sql

```

## Author
Developed by [@Humble2021](https://github.com/Humble2021)