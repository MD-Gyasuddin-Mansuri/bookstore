<?php
session_start();
include '../db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ Check if user is an admin using `is_admin`
if ($user['is_admin'] != 1) {
    header('Location: ../index.php'); // Redirect non-admins to homepage
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Panel</a>
            <div class="navbar-nav">
                <a class="nav-link" href="manage_books.php">Manage Books</a>
                <a class="nav-link" href="manage_users.php">Manage Users</a>
                <a class="nav-link" href="manage_orders.php">Manage Orders</a>
                <a class="nav-link text-danger" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Admin Dashboard</h2>
        <p>Welcome, Admin!</p>
    </div>
</body>
</html>
