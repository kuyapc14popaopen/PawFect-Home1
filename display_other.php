<?php
session_start();
require 'connection.php';
?>

<html>
<head>
    <title></title>
    <link rel="shortcut icon" href="img/Bulldog.jpeg" />
    <?php include 'dependencies.php'; ?>
    <style>
        /* CSS for the popup */
        /* Popup container */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1000; /* Sit on top */
            left: 50%;
            top: 150px; /* Adjust this value to move the modal lower */
            transform: translate(-50%, 0); /* Center horizontally */
            width: 80%; /* Adjust the width if needed */
            max-width: 600px;
            background-color: rgba(0, 0, 0, 0.4); /* Black with opacity */
        }

        /* Modal content */
        .modal-content {
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 5px;
        }

        /* Close button */
        .close {
            position: absolute;
            right: 10px;
            top: 5px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Adopt Button */
        .card .adopt_btn,
        .adopt_btn {
            text-align: center;
        }

        .card .adopt_btn button,
        .adopt_btn button {
            background-color: rgb(249, 190, 79);
            text-decoration: none;
            padding: 5px 10px;
            color: whitesmoke;
            font-size: 17px;
            border-radius: 355px 45px 225px 75px/15px 225px 15px 255px;
            transition: 1s;
        }

        .card .adopt_btn button:hover,
        .adopt_btn button:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div id="dynamic_content">
</div>

<div class="display_ads">
    <!-- Placeholder for displaying ads -->
</div>

<?php
$query = "SELECT confirmed_ad_info.ad_id, confirmed_ad_info.name, confirmed_ad_info.pet_name, confirmed_ad_info.pet_category, confirmed_ad_info.breed, confirmed_ad_info.color, confirmed_ad_info.gender, confirmed_ad_info.age, confirmed_ad_info.age_type, confirmed_ad_info.size, confirmed_ad_info.vaccinated, confirmed_ad_info.neutured, confirmed_ad_info.weight, confirmed_ad_info.city_village, confirmed_ad_info.district, confirmed_ad_info.state, confirmed_ad_info.description, confirmed_ad_info.about_pet, confirmed_ad_info.adoption_rules, confirmed_ad_info.available, confirmed_ad_info.image_url
          FROM confirmed_ad_info
          LEFT JOIN confirmed_ad_images ON confirmed_ad_info.ad_id = confirmed_ad_images.ad_id
          WHERE confirmed_ad_info.pet_category IS NOT NULL AND confirmed_ad_info.pet_category NOT IN ('dog', 'cat')";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ad_id = $row['ad_id'];
        $name = $row['name'];
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
                    <h6 class="" style="font-size: 20px;"><?php echo $name; ?></h6>
                    <div>
                        <p style="color: #ed2ccb; padding-right: 8px; font-size: 24px;text-align: center; margin: 0;"><?php echo $pet_name; ?></p>
                        <span class="material-icons favorites noselect" onclick="favorite_toggle(this)">favorite_border</span>
                    </div>
                </div>
                <div class="pet_info">
                    <p style="font-size: 18px;">Breed: <?php echo $breed; ?></p>
                    <p style="font-size: 18px;">Age: <?php echo $age; ?></p>
                    <p style="font-size: 18px;">Gender: <?php echo $gender; ?></p>
                </div>

                <!-- Add Adopt button here -->
                <div class="adopt_btn">
                    <button onclick="showMoreInfo(<?php echo $ad_id; ?>, '<?php echo $pet_name; ?>', '<?php echo $pet_category; ?>', '<?php echo $breed; ?>', '<?php echo $color; ?>', '<?php echo $gender; ?>', '<?php echo $age; ?>', '<?php echo $age_type; ?>', '<?php echo $size; ?>', '<?php echo $vaccinated; ?>', '<?php echo $neutured; ?>', '<?php echo $weight; ?>', '<?php echo $city_village; ?>', '<?php echo $district; ?>', '<?php echo $state; ?>', '<?php echo $description; ?>', '<?php echo $about_pet; ?>', '<?php echo $adoption_rules; ?>', '<?php echo $available; ?>')" class="adopt_button_modal">Adopt</button>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Adoption Information</h5>
        </div>
        <div class="modal-body">
            <div id="more_info_content"></div>
            <div class="modal-footer">
                <button type="button" id="adoptButtonInModal" class="btn btn-success">Adopt</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    function showMoreInfo(ad_id, pet_name, pet_category, breed, color, gender, age, age_type, size, vaccinated, neutured, weight, city_village, district, state, description, about_pet, adoption_rules, available) {
        var modalTitle = document.getElementById("modal-title");
        modalTitle.innerHTML = pet_name;

        var moreInfoContent = document.getElementById("more_info_content");
        moreInfoContent.innerHTML = `
            <p>Pet Category: ${pet_category}</p>
            <p>Breed: ${breed}</p>
            <p>Color: ${color}</p>
            <p>Gender: ${gender}</p>
            <p>Age: ${age} ${age_type}</p>
            <p>Size: ${size}</p>
            <p>Vaccinated: ${vaccinated}</p>
            <p>Neutured: ${neutured}</p>
            <p>Weight: ${weight}</p>
            <p>Location: ${city_village}, ${district}, ${state}</p>
            <p>Description: ${description}</p>
            <p>About Pet: ${about_pet}</p>
            <p>Adoption Rules: ${adoption_rules}</p>
            <p>Availability: ${available}</p>
        `;

        // Set the ad_id as data attribute to the adopt button in the modal
        var adoptButton = document.getElementById("adoptButtonInModal");
        adoptButton.setAttribute("data-ad-id", ad_id);

        // Show the modal
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Function to handle adoption button click
    var adoptButton = document.getElementById("adoptButtonInModal");
    adoptButton.onclick = function() {
        var ad_id = this.getAttribute("data-ad-id");
        adoptPet(ad_id);
    }

    // Function to handle adoption process
    function adoptPet(ad_id) {
        // Send the adoption request to the server
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    alert(xhr.responseText); // Display success message
                    modal.style.display = "none"; // Close the modal
                } else {
                    alert("Failed to send adoption request. Please try again."); // Display error message
                }
            }
        };
        xhr.open("POST", "process_adoption.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("ad_id=" + ad_id);
    }
</script>

</body>
</html>
