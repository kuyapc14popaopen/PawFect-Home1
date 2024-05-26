<?php
session_start();
require 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit;
}

// Retrieve user ID from the session
$user_id = $_SESSION['id'];

// Fetch notifications for the user (requester_id or uploader_id)
$query = "SELECT * FROM notifications WHERE requester_id = '$user_id' OR uploader_id = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // Notifications found, display them
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<p>Message: " . $row['message'] . "</p>";
        echo "<p>Status: " . ($row['status'] == 0 ? "Pending" : "Accepted/Rejected") . "</p>";
        echo "</div>";
    }
} else {
    // No notifications found
    echo "No notifications";
}
?>
