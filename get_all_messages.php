<?php
require 'connection.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo "You must be logged in to view messages.";
    return;
}

$current_user_id = $_SESSION['id'];

$stmt = $conn->prepare("
    SELECT m.id, m.sender_id, m.receiver_id, m.message, m.timestamp, 
           u1.name as sender_name, u2.name as receiver_name
    FROM messages m
    JOIN users u1 ON m.sender_id = u1.id
    JOIN users u2 ON m.receiver_id = u2.id
    WHERE m.sender_id = ? OR m.receiver_id = ?
    ORDER BY m.timestamp ASC
");
$stmt->bind_param("ii", $current_user_id, $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);

$stmt->close();
?>
