<?php
session_start(); // Start the session
include 'connection.php'; // Include your database connection file

// Fetch data from ad_info table based on user_id from session
$query = "SELECT * FROM ad_info WHERE user_id=" . $_SESSION['id'];
$result = mysqli_query($conn, $query) or die($query . " " . mysqli_error($conn));

// Check if any ads are available for the user
$isAdsAvailable = false;

// Loop through each row of ad_info table
while ($ad_rows = mysqli_fetch_array($result)) {
    $isAdsAvailable = true;
    $ad_id = $ad_rows['ad_id'];

    // Fetch image URL from ad_images table for the corresponding ad_id
    $query_image = "SELECT image_url FROM ad_images WHERE ad_id='$ad_id' LIMIT 1";
    $result_image = mysqli_query($conn, $query_image) or die($query_image . " " . mysqli_error($conn));

    // Fetch other details from ad_info table
    $name = mysqli_real_escape_string($conn, $ad_rows['name']);
    $pet_name = mysqli_real_escape_string($conn, $ad_rows['pet_name']);
    $pet_category = mysqli_real_escape_string($conn, $ad_rows['pet_category']);
    $breed = mysqli_real_escape_string($conn, $ad_rows['breed']);
    $color = mysqli_real_escape_string($conn, $ad_rows['color']);
    $gender = mysqli_real_escape_string($conn, $ad_rows['gender']);
    $age = mysqli_real_escape_string($conn, $ad_rows['age']);
    $age_type = mysqli_real_escape_string($conn, $ad_rows['age_type']);
    $size = mysqli_real_escape_string($conn, $ad_rows['size']);
    $vaccinated = mysqli_real_escape_string($conn, $ad_rows['vaccinated']);
    $neutured = mysqli_real_escape_string($conn, $ad_rows['neutured']);
    $weight = mysqli_real_escape_string($conn, $ad_rows['weight']);
    $city_village = mysqli_real_escape_string($conn, $ad_rows['city_village']);
    $district = mysqli_real_escape_string($conn, $ad_rows['district']);
    $state = mysqli_real_escape_string($conn, $ad_rows['state']);
    $description = mysqli_real_escape_string($conn, $ad_rows['description']);
    $about_pet = mysqli_real_escape_string($conn, $ad_rows['about_pet']);
    $adoption_rules = mysqli_real_escape_string($conn, $ad_rows['adoption_rules']);

    // If there's an image available for the ad, insert data into adoption_success table
    if ($url = mysqli_fetch_array($result_image)) {
        $image_url = mysqli_real_escape_string($conn, $url['image_url']);
        
        // Insert data into adoption_success table
        $insert_query = "INSERT INTO adoption_success (ad_id, user_id, name, pet_name, pet_category, breed, color, gender, age, age_type, size, vaccinated, neutured, weight, city_village, district, state, description, about_pet, adoption_rules, available, image_url) VALUES ('$ad_id', '{$_SESSION['id']}', '$name', '$pet_name', '$pet_category', '$breed', '$color', '$gender', '$age', '$age_type', '$size', '$vaccinated', '$neutured', '$weight', '$city_village', '$district', '$state', '$description', '$about_pet', '$adoption_rules', NULL, '$image_url')";
        
        // Execute the insert query
        mysqli_query($conn, $insert_query) or die(mysqli_error($conn));
    }
}

// If no ads were available, you can handle the situation accordingly
if (!$isAdsAvailable) {
    echo "No ads available for the user.";
}

// Close the database connection
mysqli_close($conn);
?>
