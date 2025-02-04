<?php
session_start();
include '../db.php';

$stmt = $conn->query("SELECT * FROM orders");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Orders</h2>
        <table class="table">
            <thead><tr><th>User ID</th><th>Book ID</th><th>Total Price</th><th>Order Date</th></tr></thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['user_id']; ?></td>
                    <td><?= $order['book_id']; ?></td>
                    <td>$<?= $order['total_price']; ?></td>
                    <td><?= $order['order_date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
