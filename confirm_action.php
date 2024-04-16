<?php
// confirm_action.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_id = $_POST['ad_id'];
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
    $city_village = $_POST['city_village'];
    $district = $_POST['district'];
    $state = $_POST['state'];
    $description = $_POST['description'];
    $about_pet = $_POST['about_pet'];
    $adoption_rules = $_POST['adoption_rules'];
    $available = $_POST['available'];

    // Here you can perform any database operations or other tasks with the received data
    // For demonstration purposes, we'll just return a success message
    $response = "Confirmed action for Ad ID: $ad_id, Pet Name: $pet_name";
    echo $response;
} else {
    http_response_code(405); // Method Not Allowed
    echo "Error: Invalid Request";
}
?>
