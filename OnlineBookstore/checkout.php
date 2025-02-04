<?php
session_start();
include 'db.php'; // Include the database connection file

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch cart items
$stmt = $conn->prepare("
    SELECT cart.id AS cart_id, books.id AS book_id, books.title, books.price 
    FROM cart 
    JOIN books ON cart.book_id = books.id 
    WHERE cart.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total price
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'];
}

// Simulate checkout process
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insert order into the database
    foreach ($cart_items as $item) {
        $stmt = $conn->prepare("INSERT INTO orders (user_id, book_id, quantity, total_price) VALUES (?, ?, 1, ?)");
        $stmt->execute([$_SESSION['user_id'], $item['book_id'], $item['price']]);
    }

    // Clear the cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);

    $success = "Order placed successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
        <h1>Checkout</h1>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php else: ?>
            <h3>Total Price: $<?php echo $total_price; ?></h3>
            <form method="POST" action="checkout.php">
                <button type="submit" class="btn btn-success">Place Order</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
