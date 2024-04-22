<?php
session_start();
require '../connection.php';

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

    if (mysqli_query($conn, $insert_info_query)) {
        $response = array("success" => true, "message" => "Ad confirmed and data inserted successfully.");
    } else {
        $response = array("success" => false, "message" => "Error inserting image data: " . mysqli_error($conn));
    }

    echo json_encode($response);
} else {
    // If not a POST request or user ID not provided
    $response = array("success" => false, "message" => "Invalid request or user not logged in.");
    echo json_encode($response);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reject Pet</title>
</head>
<body>
    <!-- Your HTML content here -->
    <script>
        // Function to handle pet rejection
        function rejectPet(ad_id, user_id, image_url, name, pet_name, pet_category, breed, color, gender, age, age_type, size, vaccinated, neutured, weight) {
            $.ajax({
                url: 'reject.php',
                method: 'POST',
                data: {
                    ad_id: ad_id,
                    user_id: user_id,
                    image_url: image_url,
                    name: name,
                    pet_name: pet_name,
                    pet_category: pet_category,
                    breed: breed,
                    color: color,
                    gender: gender,
                    age: age,
                    age_type: age_type,
                    size: size,
                    vaccinated: vaccinated,
                    neutured: neutured,
                    weight: weight
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        console.log("Pet rejected and data inserted successfully.");
                        // You can perform any additional actions here after rejection
                    } else {
                        console.error("Error rejecting pet: " + result.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error rejecting pet: " + error);
                }
            });
        }
    </script>
</body>
</html>
