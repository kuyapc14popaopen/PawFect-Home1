<?php
session_start();
require("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function upload($connection)
    {
        $name = basename($_FILES['photo']['name']);
        $fileNameNew = rand(222, 999) . time() . "." . $name;
        $path = 'uploads/' . $fileNameNew;

        if (file_exists($path)) {
            upload($connection);
        } elseif ($_FILES["photo"]["size"] > 10000000) {
            echo 2;
            unset($_POST);
            return;
        } elseif (!empty($name)) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $path)) {
                $query = "INSERT INTO ad_images(ad_id,image_url) VALUES('" . $_SESSION['ad_id'] . "','" . $fileNameNew . "')";
                if (!mysqli_query($connection, $query)) {
                    echo 'Database insert Unsuccessful: ' . mysqli_error($connection);
                } else {
                    // Redirect to pending_posts.php after successful upload
                    header("Location: pending_posts.php");
                    exit();
                }
            } else {
                echo 0;
                unset($_POST);
                return;
            }
        }
    }

    function getValue($choice)
    {
        switch ($choice) {
            case "Unknown":
                return -1;
            case "No":
                return 0;
            case "Yes":
                return 1;
            case '-1':
                return -1;
            case "Small":
                return 0;
            case "Medium":
                return 1;
            case "Large":
                return 2;
            default:
                return 2;
        }
    }

    function upload_details($connection)
    {
        $pet_name = filter_var($_POST['pet_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pet_category = filter_var($_POST['pet_category'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $breed = filter_var($_POST['breed'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $gender = (filter_var($_POST['gender'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) == "Male") ? 0 : 1;
        $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
        $age_type = filter_var($_POST['age_type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $size = getValue(filter_var($_POST['size'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $vaccinated = getValue(filter_var($_POST['vaccinated'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $neutured = getValue(filter_var($_POST['neutured'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $weight = filter_var($_POST['weight'], FILTER_SANITIZE_NUMBER_INT);
        $city_village = filter_var($_POST['city_village'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $district = filter_var($_POST['district'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $state = filter_var($_POST['state'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $about_pet = filter_var($_POST['about_pet'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $adoption_rules = filter_var($_POST['adoption_rules'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $ad_id = rand(100000000, 999999999) . time();
        $user_id = $_SESSION['id'];
        $_SESSION['ad_id'] = $ad_id;

        $query = "INSERT INTO ad_info(ad_id,user_id,pet_name,pet_category,breed,gender,age,age_type,size,vaccinated,neutured,weight,city_village,district,state,description,about_pet,adoption_rules)" .
            " VALUES('" . $ad_id . "','" . $user_id . "','" . $pet_name . "','" . $pet_category . "','" . $breed . "'," . $gender . "," . $age . ",'" . $age_type . "'," . $size . "," . $vaccinated . "," . $neutured . "," . $weight . ",'" . $city_village . "','" . $district . "','" . $state . "','" . $description . "','" . $about_pet . "','" . $adoption_rules . "')";

        $result = mysqli_query($connection, $query) or die($query . " " . mysqli_error($connection));
    }

    if (isset($_POST['pet_name'])) {
        upload_details($connection);
    }
    upload($connection);
}

mysqli_close($connection);
?>
