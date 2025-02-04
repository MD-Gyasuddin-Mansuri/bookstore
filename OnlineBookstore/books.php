<?php
session_start();
include 'db.php'; // Database connection

// Fetch books from the database
$stmt = $conn->query("SELECT * FROM books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Online Bookstore</a>
            <div class="navbar-nav">
                <a class="nav-link" href="cart.php">Cart</a>
                <a class="nav-link" href="profile.php">Profile</a>
            </div>
        </div>
    </nav>

    <!-- Display Books -->
    <div class="container mt-4">
        <h2>Available Books</h2>
        <div class="row">
            <?php foreach ($books as $book): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="assets/images/<?php echo !empty($book['image']) ? $book['image'] : 'default.jpg'; ?>" 
                             class="card-img-top" alt="<?php echo $book['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $book['title']; ?></h5>
                            <p class="card-text">Author: <?php echo $book['author']; ?></p>
                            <p class="card-text">Price: $<?php echo $book['price']; ?></p>
                            <a href="cart.php?action=add&id=<?php echo $book['id']; ?>" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
