<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: ../login.php');
    exit();
}

// Delete User
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
}

// Fetch Users
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Users</h2>
        <table class="table">
            <thead><tr><th>Username</th><th>Email</th><th>Action</th></tr></thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['username']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td>
                        <a href="?delete=<?= $user['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
