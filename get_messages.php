<?php
require 'connection.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo "You must be logged in to view messages.";
    return;
}

if (!isset($_POST['with_user_id']) || empty($_POST['with_user_id'])) {
    echo "User ID to fetch messages with is required.";
    return;
}

$current_user_id = $_SESSION['id'];
$with_user_id = $_POST['with_user_id'];

$stmt = $conn->prepare("
    SELECT m.id, m.sender_id, m.receiver_id, m.message, m.timestamp, 
           u1.name as sender_name, u2.name as receiver_name
    FROM messages m
    JOIN confirmed_ad_info u1 ON m.sender_id = u1.user_id
    JOIN confirmed_ad_info u2 ON m.receiver_id = u2.user_id
    WHERE (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?)
    ORDER BY m.timestamp ASC
");
$stmt->bind_param("iiii", $current_user_id, $with_user_id, $with_user_id, $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);

$stmt->close();
?>
