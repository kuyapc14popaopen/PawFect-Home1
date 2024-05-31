<?php
require_once 'vendor/autoload.php'; // Include Google API Client Library

$client = new Google_Client(['client_id' => '351357889779-6ckpggvl265avbi2bgh1kq3ud204e891.apps.googleusercontent.com']);  // Your client ID
$payload = $client->verifyIdToken($_POST['id_token']);

if ($payload) {
    $userid = $payload['sub'];  // User ID from Google
    // Here you can implement your user authentication logic
    // For example, check if user exists in your database, create a new user, etc.
    // For this example, let's assume the user is authenticated
    echo 'user';  // Return 'user' if user is authenticated
} else {
    echo 'Invalid token';  // Return 'Invalid token' if token is invalid
}
?>
