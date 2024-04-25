<?php
session_start();
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id']; // User ID from AJAX request

    // Get data from the POST request
    $ad_id = $_POST['ad_id'];
    $image_url = $_POST['image_url'];
    $name = $_POST['name'];
    $pet_name = $_POST['pet_name'];
    $pet_category = $_POST['pet_category'];
    $breed = $_POST['breed'];
    $color = $_POST['color'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $age_type = $_POST['age_type'];
    $size = $_POST['size'];
    $vaccinated = $_POST['vaccinated'];
    $neutured = $_POST['neutured'];
    $weight = $_POST['weight'];

    // Insert into confirmed_ad_info table
    $insert_info_query = "INSERT INTO confirmed_ad_info 
        (ad_id, name, user_id, image_url, pet_name, pet_category, breed, color, gender, age, age_type, size, vaccinated, neutured, weight)
        VALUES ('$ad_id', '$name', '$user_id', '$image_url', '$pet_name', '$pet_category', '$breed', '$color', '$gender', '$age', '$age_type', '$size', '$vaccinated', '$neutured', '$weight')";

    if (mysqli_query($connection, $insert_info_query)) {
        // Delete the ad from ad_info table
        $delete_ad_query = "DELETE FROM ad_info WHERE ad_id = '$ad_id'";
        if (mysqli_query($connection, $delete_ad_query)) {
            $response = array("success" => true, "message" => "Ad confirmed and data inserted successfully.");
        } else {
            $response = array("success" => false, "message" => "Error deleting ad: " . mysqli_error($connection));
        }
    } else {
        $response = array("success" => false, "message" => "Error inserting image data: " . mysqli_error($connection));
    }

    echo json_encode($response);
} else {
    // If not a POST request or user ID not provided
    $response = array("success" => false, "message" => "Invalid request or user not logged in.");
    echo json_encode($response);
}
?>
