<?php
session_start();
require 'connection.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$currentUserId = $_SESSION['id'];

// Fetch notifications for the current user
function fetchNotifications($currentUserId)
{
    global $conn;
    $stmt = $conn->prepare("
        SELECT n.*, u.name as requester_name 
        FROM notifications n
        JOIN users u ON n.requester_id = u.id
        WHERE uploader_id = ? OR requester_id = ?
    ");
    $stmt->bind_param("ii", $currentUserId, $currentUserId);
    $stmt->execute();
    $result = $stmt->get_result();

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    $stmt->close();

    return $notifications;
}

// Handle confirm and reject actions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['notification_id'])) {
    $action = $_POST['action'];
    $notificationId = $_POST['notification_id'];

    // Update notification status based on action
    $stmt = $conn->prepare("UPDATE notifications SET status = ? WHERE id = ?");
    $stmt->bind_param("ii", $action, $notificationId);
    $stmt->execute();
    $stmt->close();

    // Get requester name for notification message
    $stmt = $conn->prepare("SELECT u.name FROM notifications n JOIN users u ON n.requester_id = u.id WHERE n.id = ?");
    $stmt->bind_param("i", $notificationId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $requesterName = $row['name'];
        if ($action == 1) {
            echo "You successfully confirmed the adoption request of $requesterName.";
        } else {
            echo "You successfully rejected the adoption request of $requesterName.";
        }
    }
    exit;
}

$notifications = fetchNotifications($currentUserId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .notification {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            margin-bottom: 10px;
        }

        .notification:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .action-buttons {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Notifications</h1>
        <?php if (count($notifications) > 0): ?>
            <?php foreach ($notifications as $notification): ?>
                <div class="notification">
                    <p><strong>Ad ID:</strong> <?= htmlspecialchars($notification['ad_id']) ?></p>
                    <p><strong>Requester Name:</strong> <?= htmlspecialchars($notification['requester_name']) ?></p>
                    <p><strong>Message:</strong> <?= htmlspecialchars($notification['message']) ?></p>
                    <p><strong>Status:</strong> <?= $notification['status'] ? 'Read' : 'Unread' ?></p>
                    <?php if ($notification['uploader_id'] == $currentUserId && !$notification['status']): ?>
                        <div class="action-buttons">
                            <form action="" method="post">
                                <input type="hidden" name="action" value="1"> <!-- Confirm action -->
                                <input type="hidden" name="notification_id" value="<?= $notification['id'] ?>">
                                <button type="submit">Confirm</button>
                            </form>
                            <form action="" method="post">
                                <input type="hidden" name="action" value="2"> <!-- Reject action -->
                                <input type="hidden" name="notification_id" value="<?= $notification['id'] ?>">
                                <button type="submit">Reject</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No notifications found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
