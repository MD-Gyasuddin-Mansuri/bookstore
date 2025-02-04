# Online Bookstore Management System

## 📌 Project Overview

The **Online Bookstore Management System** is a web-based application designed for managing books, users, and orders. It allows users to browse books, add them to a cart, and place orders. Admins can manage books, users, and orders from the admin panel.

## 🚀 Features

### 🔹 User Features

- **User Authentication**: Register, login, and manage profiles.
- **Book Browsing**: View available books with details (title, author, price, image).
- **Shopping Cart**: Add and remove books from the cart.
- **Order Management**: Users can place and view their orders.

### 🔹 Admin Panel Features

- **Book Management**: Add, update, and delete books.
- **User Management**: View and manage registered users.
- **Order Management**: Track and manage customer orders.

## 🏗️ Project Structure

```
/bookstore
  ├── admin/                 # Admin Panel
  │     ├── index.php        # Admin dashboard
  │     ├── manage_books.php # Manage books
  │     ├── manage_users.php # Manage users
  │     ├── manage_orders.php# Manage orders
  ├── images/                # Book images
  ├── includes/              # Helper functions & database connection
  ├── css/                   # Stylesheets
  ├── js/                    # JavaScript files
  ├── db.php                 # Database connection
  ├── index.php              # Homepage (Book Listing)
  ├── login.php              # User login
  ├── register.php           # User registration
  ├── profile.php            # User profile
  ├── cart.php               # Shopping cart
  ├── order.php              # Order processing
  ├── logout.php             # User logout
```

## 🛠️ Installation & Setup

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/MD-Gyasuddin-Mansuri/bookstore.git
cd bookstore
```

### 2️⃣ Set Up the Database

1. Import the `database.sql` file into MySQL.
2. Ensure `db.php` contains the correct database credentials:

```php
$host = 'localhost';
$dbname = 'bookstore';
$username = 'root';
$password = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
```

### 3️⃣ Start the Server

If using **XAMPP**, move the project to `htdocs/` and start Apache & MySQL.

If using PHP’s built-in server:

```bash
php -S localhost:8000
```

Then visit `http://localhost:8000` in your browser.

## 📦 Usage Guide

- **Visit the homepage (****`index.php`****)** to browse books.
- **Login/Register (****`login.php`****, ****`register.php`****)** to access features.
- **Manage cart (****`cart.php`****)** to add/remove books.
- **Place orders (****`order.php`****)** after finalizing the cart.
- **Admin panel (****`admin/index.php`****)** for managing the bookstore.

## 📷 Adding Book Images

- Upload book images to the `images/` folder.
- Ensure the `books` table in the database has an `image` column.
- Store image paths like `images/bookname.jpg` in the database.
- Modify `index.php` to display images:

```php
<img src="<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
```

## 🔒 Security Considerations

- **Password Hashing**: Ensure passwords are hashed using `password_hash()`.
- **SQL Injection Prevention**: Use prepared statements for database queries.
- **Session Management**: Use `session_start()` and validate user sessions.

## ✨ Future Enhancements

- Implement **payment gateway integration**.
- Add **book search & filtering**.
- Enhance **UI design** with better responsiveness.

## 📜 License

This project is licensed under the **MIT License**.

## 💬 Support

For issues or suggestions, open an issue on the repository or contact me.

