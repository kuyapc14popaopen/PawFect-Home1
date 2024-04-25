<?php
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION['id'])) {
        echo "User is not logged in";
        exit;
    }

    // Establish database connection
    require 'connection.php';

    // Extract data from the POST request
    $adId = $_POST["adId"];
    $userId = $_SESSION["id"]; // Assuming you have a session variable for user ID
    $imageUrl = $_POST["imageUrl"];

    // Prepare the SQL statement
    $sql = "INSERT INTO adoption_success (ad_id, user_id, image_url) VALUES (?, ?, ?)";

    // Initialize a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters to the statement
    $stmt->bind_param("sss", $adId, $userId, $imageUrl);

    // Execute the statement
    if ($stmt->execute()) {
        // Insertion successful
        echo "Adoption record inserted successfully";
    } else {
        // Insertion failed
        echo "Error: " . $conn->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Request method is not POST
    echo "Invalid request method";
}
?>
