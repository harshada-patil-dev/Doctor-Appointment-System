# Doctor Appointment System (PHP + MySQL)

A college mini-project with three roles: **Admin**, **Doctor**, **Patient**.

## Features
- **Admin**: manage departments and doctors, view all appointments, update status, dashboard counts
- **Doctor**: view own appointments, update status (Pending / Confirmed / Completed / Cancelled)
- **Patient**: register, login, book appointment (department -> doctor -> date/time), cancel appointment

## Tech Stack
HTML, CSS, JavaScript, PHP (PDO), MySQL

## Setup (XAMPP / WAMP)
1. Copy the `doctor_appointment` folder into `C:\xampp\htdocs\`
2. Start **Apache** and **MySQL** in the XAMPP control panel
3. Open http://localhost/phpmyadmin -> **Import** -> choose `database.sql` -> Go
4. If your MySQL has a password, edit `config.php`
5. Open http://localhost/doctor_appointment

## Login Details
| Role    | Email             | Password |
|---------|-------------------|----------|
| Admin   | admin@clinic.com  | admin123 |
| Doctor  | created by admin  | set by admin |
| Patient | register on site  | your choice |

## Demo flow
1. Login as admin -> add a doctor (Doctors page)
2. Logout -> register a patient -> login -> Book Appointment
3. Login as the doctor (or admin) -> update the appointment status
4. Login as patient -> see status, cancel if needed

## Folder Structure
```
doctor_appointment/
|-- config.php            DB connection, session, helper functions
|-- database.sql          Tables + default admin + sample departments
|-- index.php, login.php, register.php, logout.php
|-- admin/                dashboard, departments, doctors, appointments
|-- doctor/               dashboard (own appointments)
|-- patient/              dashboard (list/cancel), book
|-- includes/             header, footer, appointment_table
|-- css/style.css
`-- js/script.js
```

## Security points (good for viva)
- Passwords stored with `password_hash()` / checked with `password_verify()`
- PDO prepared statements prevent SQL injection
- `htmlspecialchars()` (function `e()`) prevents XSS
- Role check (`require_role`) on every protected page
- Double-booking of the same doctor/date/time is blocked
- Patients can only cancel their own appointments; doctors can only update their own
