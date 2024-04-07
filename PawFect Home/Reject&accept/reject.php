<?php
if (isset($_POST['reject'])) {
    $postId = $_POST['post_id'];

    // Update post status to "rejected" in the database
    $pdo = new PDO('mysql:host=localhost;dbname=your_database', 'username', 'password');
    $stmt = $pdo->prepare('UPDATE posts SET status = "rejected" WHERE id = :id');
    $stmt->execute(['id' => $postId]);

    // Redirect back to the admin dashboard
    header('Location: dashboard.html');
    exit;
}
?>
