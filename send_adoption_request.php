<?php
session_start();
include 'connection.php';

$user_id = $_SESSION['user_id'];
$ad_id = $_POST['ad_id'];
$ad_name = $_POST['ad_name'];

if ($user_id && $ad_id && $ad_name) {
    // Insert into adoption_request table
    $query = "INSERT INTO adoption_request (user_id, pet_id, status) VALUES (?, ?, 0)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $user_id, $ad_id);
    
    if ($stmt->execute()) {
        // Insert notification
        $notification_message = "Adoption request sent for " . $ad_name;
        $query = "INSERT INTO notifications (user_id, message, status) VALUES (?, ?, 'unread')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $user_id, $notification_message);
        $stmt->execute();

        echo json_encode(["message" => "Adoption request sent successfully!"]);
    } else {
        echo json_encode(["message" => "Failed to send adoption request."]);
    }
    $stmt->close();
} else {
    echo json_encode(["message" => "Invalid request."]);
}
$conn->close();
?>
