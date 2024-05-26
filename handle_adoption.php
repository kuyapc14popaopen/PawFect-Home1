<?php
session_start();
require 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit;
}

// Check if ad_id and ad_name are set
if (!isset($_POST['ad_id']) || !isset($_POST['ad_name'])) {
    exit("Adoption parameters not set");
}

// Sanitize input data
$ad_id = mysqli_real_escape_string($conn, $_POST['ad_id']);
$ad_name = mysqli_real_escape_string($conn, $_POST['ad_name']);

// Retrieve the uploader's ID from the users table based on their name
$query = "SELECT id FROM users WHERE name = '$ad_name'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $uploader_id = $row['id'];

    // Get the requester_id from the session
    $requester_id = $_SESSION['id'];

    // Insert notification into the notifications table
    $message = "Adoption request for ad ID: $ad_id";
    $status = 0; // Status 0 indicates the request is pending
    $insert_query = "INSERT INTO notifications (ad_id, uploader_id, requester_id, message, status) 
                     VALUES ('$ad_id', '$uploader_id', '$requester_id', '$message', '$status')";

    if (mysqli_query($conn, $insert_query)) {
        // Request is confirmed, insert a message into the messages table
        $auto_message = "Your adoption request for ad ID: $ad_id has been accepted!";
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp
        $message_insert_query = "INSERT INTO messages (sender_id, receiver_id, message, timestamp) 
                                 SELECT '$uploader_id', '$requester_id', '$auto_message', '$timestamp'
                                 WHERE NOT EXISTS (
                                     SELECT 1 FROM messages
                                     WHERE (sender_id = '$uploader_id' AND receiver_id = '$requester_id')
                                        OR (sender_id = '$requester_id' AND receiver_id = '$uploader_id')
                                 )";
        
        if (mysqli_query($conn, $message_insert_query)) {
            echo json_encode(["success" => true, "message" => "Adoption request sent successfully"]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to send adoption request: " . mysqli_error($conn)]);
        }
    } else {
        // Failed to insert notification
        echo json_encode(["success" => false, "error" => "Failed to insert notification: " . mysqli_error($conn)]);
    }
} else {
    // Uploader not found
    echo json_encode(["success" => false, "error" => "Uploader not found"]);
}
?>
