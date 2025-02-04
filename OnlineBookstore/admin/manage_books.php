<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 1) {
    header('Location: ../login.php');
    exit();
}

// Add Book
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $price = $_POST['price'];
    
    $stmt = $conn->prepare("INSERT INTO books (title, author, price) VALUES (?, ?, ?)");
    $stmt->execute([$title, $author, $price]);
}

// Delete Book
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
}

// Fetch Books
$stmt = $conn->query("SELECT * FROM books");
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Manage Books</h2>
        <form method="POST" class="mb-4">
            <input type="text" name="title" class="form-control mb-2" placeholder="Book Title" required>
            <input type="text" name="author" class="form-control mb-2" placeholder="Author" required>
            <input type="number" step="0.01" name="price" class="form-control mb-2" placeholder="Price" required>
            <button type="submit" name="add_book" class="btn btn-primary">Add Book</button>
        </form>

        <table class="table">
            <thead><tr><th>Title</th><th>Author</th><th>Price</th><th>Action</th></tr></thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book['title']; ?></td>
                    <td><?= $book['author']; ?></td>
                    <td>$<?= $book['price']; ?></td>
                    <td>
                        <a href="?delete=<?= $book['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
