# Makorokocho Hotel Website

A full hotel management web application built with PHP and MySQL.
The system allows customers to book rooms online and administrators to manage bookings, rooms, and customer messages.

## Features

### Customer Side

* View available rooms
* Online room booking
* Contact form
* Responsive design

### Admin Panel

* username: admin
* password: 1234
* Secure admin login
* Manage rooms (Add / Edit / Delete)
* Manage bookings
* View customer messages
* Reports dashboard

## Technologies Used

* PHP (Core PHP)
* MySQL / MariaDB
* HTML5, CSS3, JavaScript
* XAMPP (Local Server)

## Database Setup

1. Open phpMyAdmin
2. Create database:

   ```
   makorokocho_hotel
   ```
3. Import file:

   ```
   database/makorokocho_hotel.sql
   ```

## Installation (Local)

1. Copy project to:

   ```
   C:\xampp\htdocs\
   ```
2. Start Apache and MySQL (XAMPP)
3. Open browser:

   ```
   http://localhost/hotel_website
   ```

## Admin Login

Update credentials from database table:

```
admin_users
```

## Project Structure

```
hotel_website/
│
├── admin/
├── css/
├── image/
├── database/
├── index.html
└── README.md
```

## Author

**Makorokocho Tech**
GitHub: https://github.com/makorokochotech
