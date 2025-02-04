<?php
session_start();
include 'db.php'; // Include the database connection file
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bookstore</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Online Bookstore</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h1>Welcome to the Online Bookstore</h1>
        <div class="row">
            <?php
            // Fetch books from the database
            $stmt = $conn->query("SELECT * FROM books");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/' . $row['image'] . '" class="card-img-top" alt="' . $row['title'] . '">
                        <div class="card-body">
                            <h5 class="card-title">' . $row['title'] . '</h5>
                            <p class="card-text">Author: ' . $row['author'] . '</p>
                            <p class="card-text">Price: $' . $row['price'] . '</p>
                            <a href="cart.php?action=add&id=' . $row['id'] . '" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
