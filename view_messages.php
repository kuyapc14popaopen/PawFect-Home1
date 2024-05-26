<?php
session_start();
require 'connection.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

// Function to fetch unique chat users for the logged-in user
function fetchChatUsers($currentUserId)
{
    global $conn;
    $stmt = $conn->prepare("
        SELECT DISTINCT u.id, u.name 
        FROM users u
        JOIN messages m ON (u.id = m.sender_id OR u.id = m.receiver_id)
        WHERE (m.sender_id = ? OR m.receiver_id = ?) AND u.id != ?
    ");
    $stmt->bind_param("iii", $currentUserId, $currentUserId, $currentUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    $stmt->close();

    return $users;
}

$currentUserId = $_SESSION['id'];
$chatUsers = fetchChatUsers($currentUserId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Messages</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .user-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .user-list li {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .user-list a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
        }
        .user-list a:hover {
            background-color: #f0f0f0;
            border-radius: 4px;
        }
        .user-icon {
            background-color: #007bff;
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Messages</h1>
        </div>
        <ul class="user-list">
            <?php foreach ($chatUsers as $user): ?>
                <li>
                    <a href="chat_conversation.php?user_id=<?= $user['id'] ?>&user_name=<?= urlencode($user['name']) ?>">
                        <div class="user-icon"><?= strtoupper(substr($user['name'], 0, 1)) ?></div>
                        <?= htmlspecialchars($user['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
