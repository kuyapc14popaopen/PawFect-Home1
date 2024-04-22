<?php
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO email_otp (email, otp) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $otp);

    if ($stmt->execute()) {
        $subject = 'OTP Verification';
        $message = 'Your OTP is: ' . $otp;
        $headers = 'From: pawfecthome@pawfecthome.net';

        if(mail($email, $subject, $message, $headers)) {
            echo "OTP sent successfully.";
        } else {
            echo "Failed to send OTP. Error: " . error_get_last()['message'];
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
