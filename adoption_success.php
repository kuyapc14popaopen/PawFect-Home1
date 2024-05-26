<?php
session_start(); // Start the session
include 'connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if adId is passed in the POST request
    if (isset($_POST['adId'])) {
        $ad_id = mysqli_real_escape_string($conn, $_POST['adId']);
        $user_id = $_SESSION['id'];

        // Fetch the user's name from the users table using user_id
        $user_query = "SELECT name FROM users WHERE id='$user_id'";
        $user_result = mysqli_query($conn, $user_query) or die($user_query . " " . mysqli_error($conn));
        
        if (mysqli_num_rows($user_result) > 0) {
            $user_row = mysqli_fetch_assoc($user_result);
            $user_name = mysqli_real_escape_string($conn, $user_row['name']);

            // Debugging: Output the user's name
            echo "User name fetched: $user_name<br>";

            // Fetch data from confirmed_ad_info table based on the user's name
            $query = "SELECT * FROM confirmed_ad_info WHERE name='$user_name' AND ad_id='$ad_id'";
            $result = mysqli_query($conn, $query) or die($query . " " . mysqli_error($conn));

            // Check if any ad is found
            if (mysqli_num_rows($result) > 0) {
                $ad_rows = mysqli_fetch_assoc($result);
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
                $image_url = mysqli_real_escape_string($conn, $ad_rows['image_url']);

                // Check if the data already exists in adoption_success table
                $check_query = "SELECT * FROM adoption_success WHERE ad_id='$ad_id' AND user_id='$user_id'";
                $check_result = mysqli_query($conn, $check_query) or die($check_query . " " . mysqli_error($conn));

                if (mysqli_num_rows($check_result) == 0) {
                    // Insert data into adoption_success table
                    $insert_query = "INSERT INTO adoption_success (ad_id, user_id, name, pet_name, pet_category, breed, color, gender, age, age_type, size, vaccinated, neutured, weight, city_village, district, state, description, about_pet, adoption_rules, available, image_url) VALUES ('$ad_id', '$user_id', '$name', '$pet_name', '$pet_category', '$breed', '$color', '$gender', '$age', '$age_type', '$size', '$vaccinated', '$neutured', '$weight', '$city_village', '$district', '$state', '$description', '$about_pet', '$adoption_rules', NULL, '$image_url')";
                    
                    if (mysqli_query($conn, $insert_query)) {
                        // Delete the record from confirmed_ad_info table
                        $delete_query = "DELETE FROM confirmed_ad_info WHERE ad_id='$ad_id' AND name='$user_name'";
                        if (mysqli_query($conn, $delete_query)) {
                            echo "Adoption confirmed successfully and data removed from confirmed_ad_info";
                        } else {
                            echo "Error deleting from confirmed_ad_info: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error inserting into adoption_success: " . mysqli_error($conn);
                    }
                } else {
                    echo "Adoption already confirmed.";
                }
            } else {
                echo "No ad found with the provided ID and user name.";
            }
        } else {
            echo "No user found with the provided ID.";
        }
    } else {
        echo "No ad ID provided.";
    }
} else {
    echo "Invalid request method.";
}

// Close the database connection
mysqli_close($conn);
?>
