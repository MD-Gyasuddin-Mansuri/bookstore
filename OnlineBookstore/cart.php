<?php
session_start();
include 'db.php'; // Include the database connection file

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Add item to cart (with quantity support)
if (isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Check if the book is already in the cart
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND book_id = ?");
    $stmt->execute([$user_id, $book_id]);
    $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart_item) {
        // If book is already in cart, increase quantity
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND book_id = ?");
        $stmt->execute([$user_id, $book_id]);
    } else {
        // If book is not in cart, add it with quantity = 1
        $stmt = $conn->prepare("INSERT INTO cart (user_id, book_id, quantity) VALUES (?, ?, 1)");
        $stmt->execute([$user_id, $book_id]);
    }
}

// ✅ Remove item from cart (Ensure cart ID is a number)
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $cart_id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$cart_id, $user_id]);
}

// ✅ Fetch cart items with quantity and total price
$stmt = $conn->prepare("
    SELECT cart.id AS cart_id, books.id AS book_id, books.title, books.price, cart.quantity 
    FROM cart 
    JOIN books ON cart.book_id = books.id 
    WHERE cart.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ✅ Calculate total price
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
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
        <h1>Shopping Cart</h1>
        <?php if (empty($cart_items)): ?>
            <div class="alert alert-info">Your cart is empty.</div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <a href="cart.php?action=remove&id=<?php echo $item['cart_id']; ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Total Price: $<?php echo number_format($total_price, 2); ?></h3>
            <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
        <?php endif; ?>
    </div>
</body>
</html>
