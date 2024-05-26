<?php
require 'connection.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to send a message.']);
    return;
}

if (!isset($_POST['receiver_name']) || !isset($_POST['message']) || empty($_POST['receiver_name']) || empty($_POST['message']) || !isset($_POST['ad_id'])) {
    echo json_encode(['success' => false, 'message' => 'Receiver name, message, and ad ID are required.']);
    return;
}

$sender_id = $_SESSION['id'];
$message = $_POST['message'];
$receiver_name = $_POST['receiver_name'];
$ad_id = $_POST['ad_id'];

// Retrieve receiver's user ID based on the provided name
$stmt = $conn->prepare("SELECT id FROM users WHERE name = ?");
$stmt->bind_param("s", $receiver_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Receiver not found.']);
    return;
}

$row = $result->fetch_assoc();
$receiver_id = $row['id'];

$stmt->close();

// Insert message into the database
$stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message, ad_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $sender_id, $receiver_id, $message, $ad_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to send message.']);
}

$stmt->close();
?>
