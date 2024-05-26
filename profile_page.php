<?php 
session_start();
require 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit;
}

// Retrieve user ID from the session
$user_id = $_SESSION['id'];

// Retrieve user name from the session
$user_name = $_SESSION['name'];
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Title Here</title>
    <?php include 'dependencies.php'; ?>
    <?php require 'header.php'; ?> 
    <style>
                html,body {
            background: #efefef;
            font-family: "Arial";
        }

        .container {
            max-width: 1250px;
            margin: 30px auto 30px;
            padding: 0 !important;
            width: 90%;
            background-color: #fff;
            box-shadow: 0 3px 6px rgba(0,0,0,0.10), 0 3px 6px rgba(0,0,0,0.10);
            position: relative;
        }
        
        .update_profile {
            position: absolute;
            top: -110vh;
            width: 100%;
            height: 100%;
            background-color: rgba(128,128,128,0.8); 
            z-index:4;
            visibility: hidden;
            transition: 0.5s ease-in-out;
        }
        
        
        .update_profile_content {
            background-color: #FBF4DE;
        }
        .update_profile_content .preview div:first-child {
            width: calc( 100% - 40px );
            padding: 20px;
            height: 360px;
        }
        
        header {
            padding top: 25px;
            background: #eee;
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-color: red;
            height: 350px;
            position: relative;
        }

        @media (max-width:800px) {
            header {
                height: 150px;
            } 
        }

        main {
            padding: 20px 20px 0px 20px;
        }

        .left {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            transition: 0.3s;
        }

        .photo {
            width: 200px;
            height: 200px;
            margin-top: -120px;
            border-radius: 100px;
            border: 4px solid #fff;
        }
        
        @keyframes profile {
            0% {
                position: absolute;
                width: 200px;
                height: 200px;
                margin-top: -120px;
                border-radius: 100px;
            }
            100% {
                width: 300px;
                height:500px;
                margin-top: -120px;
                border-radius: 100px;
            }
        }
        .active {
            width: 20px;
            height: 20px;
            border-radius: 20px;
            position: absolute;
            right: calc(50% - 70px);
            top: 75px;
            background-color: #FFC107;
            border: 3px solid #fff;
        }

        @media (max-width:990px) {
            .active {
                right: calc(50% - 60px);
                top: 50px;
            } 
        }

        .name {
            margin-top: 20px;
            font-family: "Open Sans";
            font-weight: 600;
            font-size: 18pt;
            color: #777;
        }

        .info {
            margin-top: -5px;
            margin-bottom: 5px;
            font-family: 'Montserrat', sans-serif;
            font-size: 11pt;
            color: #aaa;
        }

        .stats {
            margin-top: 25px;
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #ededed;
            font-family: 'Montserrat', sans-serif;
        }


        .number-stat {
            padding: 0px;
            font-size: 14pt;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
            color: #aaa;
        }

        .desc-stat {
            margin-top: -10px;
            font-size: 20px;
            color: #bbb;
            text-align: center;
        }
        .like:hover {
            color:#F9BE4F;
        }
        .desc {
            text-align: center;
            margin-top: 25px;
            margin: 25px 40px;
            color: #999;
            font-size: 11pt;
            font-family: "Open Sans";
            
            padding-bottom: 25px;
            border-bottom: 1px solid #ededed;
            position: relative;
        }

        

        .right {
            padding: 0 25px 0 25px !important;
            overflow-y: auto;
            
        }

        .nav {
            display: inline-flex;
        }

        .nav li {
            margin: 40px 30px 0 10px;
            cursor: pointer;
            font-size: 13pt;
            text-transform: uppercase;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            color: #F9BE4F;
            border-bottom: 2px solid #F9BE4F;
        }

      

        .follow {
            position: absolute;
            right: 8%;
            top: 35px;
            font-size: 11pt;
            background-color: #F9BE4F;
            color: #fff;
            padding: 8px 15px;
            cursor: pointer;
            transition: all .4s;
            font-family: 'Montserrat', sans-serif;
            font-weight: 400;
            display: none;
        }

        .follow:hover {
            box-shadow: 0 0 15px rgba(0,0,0,0.2), 0 0 15px rgba(0,0,0,0.2);
        }

        @media (max-width:990px) {
            .nav {
                display: none;
            }

            .follow {
                width: 50%;
                margin-left: 25%;
                display: block;
                position: unset;
                text-align: center;
                display: block;

            }
        }
        .gallery  {
            margin-top: 35px;
        }

        .gallery div {
            margin-bottom: 30px;
        }

        .gallery img {
            box-shadow: 0 3px 6px rgba(0,0,0,0.10), 0 3px 6px rgba(0,0,0,0.10);
            width: auto; 
            height: auto;
            cursor: pointer;
            width: 100%;
        }
        
        .edit {
            position: absolute;
            background-color: #F9BE4F;
            border: 2px solid rgba(237, 235, 235,1);
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 3px 6px rgba(0,0,0,0.10), 0 3px 6px rgba(0,0,0,0.10);
            color: white;
        }
        
        header .edit {
            right: 10px;  
            bottom: 10px;
            font-size: 25px;
            padding: 5px;
        }
        .photo-left .edit {
            right: calc(50% - 90px);
            top: 20px;
            padding: 3px;
           
        }
        .edit:hover {
            box-shadow: 3px 3px 3px rgba(0,0,0,0);
        }
        .desc .edit {
            right: 2px;
            bottom: 2px;
            box-shadow: none;
            font-size:  15px;
            padding: 4px;
        }
        .desc .edit:hover {
            box-shadow: 0 3px 6px rgba(0,0,0,0.10), 0 3px 6px rgba(0,0,0,0.10);
        }
        .progress {
            display: none;
            padding: 2px;
            background: rgba(0, 0, 0, 0.25);
            border-radius: 6px;
            -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.25), 0 1px rgba(255, 255, 255, 0.08);
            height: 20px;
            width:90%;
            margin-left: 5%;
        }

        .progress-bar {
            height: 16px;
            border-radius: 4px;
            background-image: -webkit-linear-gradient(top, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05));
            background-image: -moz-linear-gradient(top, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05));
            background-image: -o-linear-gradient(top, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05));
            background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.05));
            -webkit-transition: 0.4s linear;
            -moz-transition: 0.4s linear;
            -o-transition: 0.4s linear;
            transition: 0.4s linear;
            -webkit-transition-property: width, background-color;
            -moz-transition-property: width, background-color;
            -o-transition-property: width, background-color;
            transition-property: width, background-color;
            -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, 0.25), inset 0 1px rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 1px 1px rgba(0, 0, 0, 0.25), inset 0 1px rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
       
        .delete_button_wrapper {
            position: absolute;
            width: calc(100% - 30px);
            padding-right: 15px;
            padding-left: 15px;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            top:0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .3s;
            opacity: 0;
        }
        .delete_button_wrapper button {
            background-color: black;
            padding: 5px 10px;
            color: white;
            border: none;
        }
        .delete_button_wrapper:hover {
            opacity: 1;
        }
        form {
            padding: 20px;
        }
        label {
            padding-top: 10px;
        }
        form input[type=text],form input[type=email],form input[type=tel],form input[type=password] {
            width: 100%;
            padding: 8px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .form input[type=submit] {
            background-color: #F9BE4F;
            padding: 5px 10px;
            color: white;
            border: none;
            margin-top: 10px;
        }

        .message {
            color:#ddd;
            background-color:#FFC107;
            padding:10px;
            text-align:center;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .success {
            color:#ddd;
            background-color:#4CAF50;
            padding:10px;
            text-align:center;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .info_message {
            color: #ddd;
            background-color: #2196F3;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .error {
            color:#ddd;
            background-color:#f44336;
            padding:10px;
            text-align:center;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        
        #edit_prof_pic {
            visibility: hidden;
            width: 0;
            height: 0;
        }
        #edit_cover {
            visibility: hidden;
            width: 0;
            height: 0;
        }
        
        .preview {
            position: relative;
        }
        .preview img {
            width: 100%;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        
        .preview div:first-child {
            position: absolute;
            width: 0;
            height: 0;
            bottom: 0;
            right: 0;
            border-bottom: 0;
        }
        
        .preview div {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgba(0,0,0,0.5);
            color: #fff;
            padding: 5px 10px;
            border-bottom-right-radius: 4px;
            border-top-left-radius: 4px;
            display: none;
        }
        
        .preview:hover div {
            display: block;
        }
        
        .preview:hover div:first-child {
            display: block;
        }
        #edit_prof_pic {
            visibility: hidden;
            width: 0;
            height: 0;
        }
        #edit_cover {
            visibility: hidden;
            width: 0;
            height: 0;
        }
        
        .preview {
            position: relative;
        }
        .preview img {
            width: 100%;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        
        .preview div:first-child {
            position: absolute;
            width: 0;
            height: 0;
            bottom: 0;
            right: 0;
            border-bottom: 0;
        }
        
        .preview div {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgba(0,0,0,0.5);
            color: #fff;
            padding: 5px 10px;
            border-bottom-right-radius: 4px;
            border-top-left-radius: 4px;
            display: none;
        }
        
        .preview:hover div {
            display: block;
        }
        
        .preview:hover div:first-child {
            display: block;
        }
        #edit_prof_pic {
            visibility: hidden;
            width: 0;
            height: 0;
        }
        #edit_cover {
            visibility: hidden;
            width: 0;
            height: 0;
        }
        
        .preview {
            position: relative;
        }
        .preview img {
            width: 100%;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        
        .preview div:first-child {
            position: absolute;
            width: 0;
            height: 0;
            bottom: 0;
            right: 0;
            border-bottom: 0;
        }
        
        .preview div {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgba(0,0,0,0.5);
            color: #fff;
            padding: 5px 10px;
            border-bottom-right-radius: 4px;
            border-top-left-radius: 4px;
            display: none;
        }
        
        .preview:hover div {
            display: block;
        }
        
        .preview:hover div:first-child {
            display: block;
        }
        #edit_prof_pic {
            visibility: hidden;
            width: 0;
            height: 0;
        }
        #edit_cover {
            visibility: hidden;
            width: 0;
            height: 0;
        }
        
        .preview {
            position: relative;
        }
        .preview img {
            width: 100%;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
        }
        
        .preview div:first-child {
            position: absolute;
            width: 0;
            height: 0;
            bottom: 0;
            right: 0;
            border-bottom: 0;
        }
        
        .preview div {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background-color: rgba(0,0,0,0.5);
            color: #fff;
            padding: 5px 10px;
            border-bottom-right-radius: 4px;
            border-top-left-radius: 4px;
            display: none;
        }
        
        .preview:hover div {
            display: block;
        }
        
        .preview:hover div:first-child {
            display: block;
        }
        
.confirm_button {
    background-color: green;
    padding: 5px 10px;
    color: white;
    border: none;
}

.delete_button {
    background-color: red;
    padding: 5px 10px;
    color: white;
    border: none;
}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".nav li").click(function(){
                $(this).addClass('active').siblings().removeClass('active');
            })
        });

        function displayEditField() {
            var form = document.getElementById("update_details_form");
            if (form.style.display === "none") {
                form.style.display = "block";
                document.querySelector(".follow").textContent = 'Hide Edit Fields';
            } else {
                form.style.display = "none";
                document.querySelector(".follow").textContent = 'Edit Info.';
            }
        }

        document.getElementById("update_details_form").addEventListener("submit", function(event) {
            event.preventDefault();
            var form = event.target;
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", form.action);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert("Details Updated Successfully");
                    location.reload();
                } else {
                    alert("Error: " + xhr.responseText);
                }
            };
            xhr.send(formData);
        });

        document.getElementById("update_password").addEventListener("submit", function(event) {
            event.preventDefault();
            var form = event.target;
            var formData = new FormData(form);
            if (formData.get("newpass") !== formData.get("confpass")) {
                alert("Passwords do not match");
                return;
            }
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_password.php");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert("Password Changed Successfully");
                    form.reset();
                } else {
                    alert("Error: " + xhr.responseText);
                }
            };
            xhr.send(formData);
        });

        function confirmAdopt(adId, event) {
            event.preventDefault();
            if (confirm("Are you sure you want to confirm adoption?")) {
                // Perform action to confirm adoption
            }
        }

        function deleteAd(adId) {
            if (confirm("Are you sure you want to delete this ad?")) {
                // Perform action to delete ad
            }
        }

        function confirmAdopt(adId) {
            var parentDiv = event.target.closest('.col-md-4');
            var imageUrl = parentDiv.querySelector('img').src;

            var data = {
                adId: adId,
                imageUrl: imageUrl
                // Add more data fields as needed
            };

            $.ajax({
                type: "POST",
                url: "adoption_success.php",
                data: data,
                success: function(response) {
                    // Handle success response
                    console.log("Adoption success: ", response);
                    alert("Adoption completed successfully");
                    // Optionally, you can reload the page or perform other actions
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error("Error: ", error);
                    alert("Error confirming adoption: " + error);
                }
            });
        }
    </script>
</head>
<body>
<?php
$query = "SELECT * FROM users where id='".$_SESSION['id']."'";
$result = mysqli_query($conn, $query) or die($query . " " . mysqli_error($conn));
while($rows=mysqli_fetch_array($result)) {
?>
<div class="container">
    <div class="update_profile">
        <!-- Update profile content here -->
    </div>
    <header style="background-image: url('img/2022 Pet Product Packaging Trends.jpg');">
        <a href="index.php" class="home-button">Home</a>
        <span class="material-icons edit" onclick="update_profile_img()" title="Change profile image">create</span>
    </header>
    <main>
        <div class="row">
            <div class="left col-lg-4">
                <!-- Left column content -->
                <div class="photo-left">
                    <img class="photo" src="<?php echo $rows['profile_img_url'] ?>">
                    <span class="material-icons edit" onclick="update_profile_img()" title="Change profile image">create</span>
                </div>
                <h4 class="name"><?php echo $rows['name'] ?></h4>
                <form id="update_details_form" class="form" action="update_user_details.php">
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name" value="<?php echo $rows['name'] ?>"><br>
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" value="<?php echo $rows['email'] ?>" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"><br>
                    <label for="contact">Contact:</label><br>
                    <input type="tel" id="contact" name="contact" value="<?php echo $rows['contact'] ?>" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" oninvalid="this.setCustomValidity('Enter valid format eg. 9876543210')" oninput="this.setCustomValidity('')"><br>
                    <label for="city">City:</label><br>
                    <input type="text" id="city" name="city" value="<?php echo $rows['city'] ?>"><br>
                    <label for="address">Address:</label><br>
                    <input type="text" id="address" name="address" value="<?php echo $rows['address'] ?>"><br>

                    <input type="submit" value="Update">
                </form>

                <form id="update_password" class="form">
                    <label for="oldpass">Old Password:</label><br>
                    <input type="password" id="oldpass" name="oldpass" value="" pattern=".{6,}" required=""><br>
                    <label for="newpass">New Password:</label><br>
                    <input type="password" id="newpass" name="newpass" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="this.setCustomValidity('Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters')" oninput="this.setCustomValidity('')"  required><br>
                    <label for="confpass">Confirm New Password:</label><br>
                    <input type="password" id="confpass" name="confpass" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" oninvalid="this.setCustomValidity('Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters')" oninput="this.setCustomValidity('')"  required><br>
                    <input type="submit" value="Change Password">
                </form>
            </div>
            <div class="right col-lg-8">
                <ul class="nav">
                    
                </ul>
                <span class="follow" onclick="displayEditField()">Edit Info.</span>
                <div class="row gallery">
<?php
$query = "SELECT confirmed_ad_info.ad_id, confirmed_ad_info.name as uploader_name, confirmed_ad_info.pet_name, confirmed_ad_info.pet_category, confirmed_ad_info.breed, confirmed_ad_info.color, confirmed_ad_info.gender, confirmed_ad_info.age, confirmed_ad_info.age_type, confirmed_ad_info.size, confirmed_ad_info.vaccinated, confirmed_ad_info.neutured, confirmed_ad_info.weight, confirmed_ad_info.city_village, confirmed_ad_info.district, confirmed_ad_info.state, confirmed_ad_info.description, confirmed_ad_info.about_pet, confirmed_ad_info.adoption_rules, confirmed_ad_info.available, confirmed_ad_info.image_url
          FROM confirmed_ad_info
          INNER JOIN users ON confirmed_ad_info.name = users.name
          WHERE users.id = '$user_id'";


$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ad_id = $row['ad_id'];
        $uploader_name = $row['uploader_name'];
        $pet_name = $row['pet_name'] === 'unknown' ? "Unknown" : $row['pet_name'];
        $pet_category = $row['pet_category'];
        $breed = $row['breed'] === '-1' ? "Unknown" : $row['breed'];
        $color = $row['color'] ? $row['color'] : "Unknown";
        $gender = $row['gender'] === '-1' ? "Male" : ($row['gender'] === '1' ? "Female" : "Unknown");
        $age = $row['age'] === '0' ? "Unknown" : $row['age'];
        $age_type = $row['age_type'];
        $size = $row['size'] === '0' ? "Unknown" : ($row['size'] === '1' ? "Small" : ($row['size'] === '2' ? "Medium" : "Large"));
        $vaccinated = $row['vaccinated'] === '1' ? "Yes" : "No";
        $neutured = $row['neutured'] === '1' ? "Yes" : "No";
        $weight = $row['weight'] === '-1' ? "Unknown" : $row['weight'];
        $city_village = $row['city_village'];
        $district = $row['district'];
        $state = $row['state'];
        $description = $row['description'] ? $row['description'] : "No description available";
        $about_pet = $row['about_pet'] ? $row['about_pet'] : "No information available";
        $adoption_rules = $row['adoption_rules'] ? $row['adoption_rules'] : "No information available";
        $available = $row['available'] === '1' ? "Available" : "Not Available";
        $image_url = $row['image_url'];
?>
        <div class="col-sm-6 col-md-4 col-lg-3 column">
            <div class="card">
                <img src="uploads/<?php echo $row['image_url']; ?>" class="img-responsive" alt="Pet Image">
                <div class="name_favorite_align">
                    <h6 class="" style="font-size: 18px;"><?php echo $uploader_name; ?></h6>
                    <div>
                        <p style="color: #ed2ccb; padding-right: 8px; font-size: 22px;text-align: center; margin: 0;"><?php echo $pet_name; ?></p>
                    </div>
                </div>
<div class="pet_info">
    <p style="font-size: 15px;">Breed: <?php echo $breed; ?></p>
    <p style="font-size: 15px;">Age: <?php echo $age; ?></p>
    <p style="font-size: 15px;">Gender: <?php echo $gender; ?></p>
    <button class="confirm_button" onclick="confirmAdopt('<?php echo $ad_id; ?>', event)">Confirm Adopt</button>

</div>


                
            </div>
        </div>
<?php
    }
} else {
    echo "No posts found.";
}
?>


                </div>
            </div>
        </div>
    </main>

</div>
<?php } ?>
<script>
    function displayEditField() {
        var form = document.getElementById("update_details_form");
        if (form.style.display === "none") {
            form.style.display = "block";
            document.querySelector(".follow").textContent = 'Hide Edit Fields';
        } else {
            form.style.display = "none";
            document.querySelector(".follow").textContent = 'Edit Info.';
        }
    }

    document.getElementById("update_details_form").addEventListener("submit", function(event) {
        event.preventDefault();
        var form = event.target;
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", form.action);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Details Updated Successfully");
                location.reload();
            } else {
                alert("Error: " + xhr.responseText);
            }
        };
        xhr.send(formData);
    });

    document.getElementById("update_password").addEventListener("submit", function(event) {
        event.preventDefault();
        var form = event.target;
        var formData = new FormData(form);
        if (formData.get("newpass") !== formData.get("confpass")) {
            alert("Passwords do not match");
            return;
        }
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "update_password.php");
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Password Changed Successfully");
                form.reset();
            } else {
                alert("Error: " + xhr.responseText);
            }
        };
        xhr.send(formData);
    });



    function update_profile_img() {
        // Function to update profile image
    }
function confirmAdopt(adId, event) {
    event.preventDefault();
    if (confirm("Are you sure you want to confirm adoption?")) {
        // Perform action to confirm adoption
    }
}
// Function to confirm adoption
function confirmAdopt(adId, event) {
    event.preventDefault();
    console.log("Confirming adoption for ad ID:", adId); // Log to console for debugging
    if (confirm("Are you sure you want to confirm adoption?")) {
        // Perform action to confirm adoption
        $.ajax({
            type: "POST",
            url: "adoption_success.php",
            data: { adId: adId },
            success: function(response) {
                // Handle success response
                console.log("Adoption success response: ", response);
                if (response.includes("Adoption confirmed successfully")) {
                    alert("Adoption completed successfully");
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert("Error confirming adoption: " + response);
                }
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error("Error: ", error);
                alert("Error confirming adoption: " + error);
            }
        });
    }
}

</script>
</body>
</html>
