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
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal content */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 5px;
        position: relative;
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
    .card .adopt_btn
    {
        height: 40px;
        text-align: center;
        margin-bottom: 7px; /* Add margin-bottom */
    }

    .card .adopt_btn button
    {
        background-color: rgb(249, 190, 79);
        text-decoration: none;
        padding: 5px 10px;
        color:whitesmoke;
        font-size: 17px;
        border-radius: 355px 45px 225px 75px/15px 225px 15px 255px;
        transition: 1s;
    }

    .card .adopt_btn button:hover
    {
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
          WHERE confirmed_ad_info.pet_category IS NOT NULL AND confirmed_ad_info.pet_category = 'cat'";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $ad_id = $row['ad_id'];
        $name = $row['name'];
        $pet_name = $row['pet_name'] === 'unknown' ? "Unknown" : $row['pet_name'];
        $pet_category = $row['pet_category'];
        $breed = $row['breed'] === '-1' ? "Unknown" : $row['breed'];
        $color = $row['color'] ? $row['color'] : "Unknown";
        $gender = $row['gender'] === '0' ? "Male" : ($row['gender'] === '1' ? "Female" : "Unknown");
$age = ($row['age'] === '0' || $row['age'] === '-1') ? "Unknown" : $row['age'];
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
                    <h6 class=""><?php echo $name; ?></h6>
                    <div>
                        <p style="color: #ed2ccb; padding-right: 8px; font-size: 30px;text-align: center; margin: 0;"><?php echo $pet_name; ?></p>
                        <span class="material-icons favorites noselect"  onclick="favorite_toggle(this)">favorite_border</span>
                    </div>
                </div>
                <div class="pet_info">
                    <p>Breed: <?php echo $breed; ?></p>
                    <p>Age: <?php echo $age; ?></p>
                    <p>Gender: <?php echo $gender; ?></p>
                </div>

                <!-- Add Adopt button here -->
                <div class="adopt_btn">
                    <button onclick="adoptPet(<?php echo $ad_id; ?>)">Adopt</button>
                </div>
                <!-- End of Adopt button -->

                <div class="more_info_btn"><a href="#" onclick="showMoreInfo('<?php echo $name; ?>', '<?php echo $pet_name; ?>', '<?php echo $pet_category; ?>', '<?php echo $breed; ?>', '<?php echo $color; ?>', '<?php echo $gender; ?>', '<?php echo $age; ?>', '<?php echo $age_type; ?>', '<?php echo $size; ?>', '<?php echo $vaccinated; ?>', '<?php echo $neutured; ?>', '<?php echo $weight; ?>', '<?php echo $city_village; ?>', '<?php echo $district; ?>', '<?php echo $state; ?>', '<?php echo $description; ?>', '<?php echo $about_pet; ?>', '<?php echo $adoption_rules; ?>', '<?php echo $available; ?>')">More info</a></div>
            </div>
        </div>
<?php
    }
} else {
    echo "No ads found.";
}
?>

<?php include 'post-ad-part-1.php';?>

<!-- Popup to display more info -->
<div id="popup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <div id="popupContent">
            <!-- Content will be filled dynamically -->
        </div>
    </div>
</div>

<script>
    // Function to show the popup with more info
    function showMoreInfo(ad_id, pet_name, pet_category, breed, color, gender, age, age_type, size, vaccinated, neutured, weight, city_village, district, state, description, about_pet, adoption_rules, available) {
        var popupContent = `
            <h2>${pet_name}</h2>
            <p>Category: ${pet_category}</p>
            <p>Breed: ${breed}</p>
            <p>Color: ${color}</p>
            <p>Gender: ${gender}</p>
            <p>Age: ${age} ${age_type}</p>
            <p>Size: ${size}</p>
            <p>Vaccinated: ${vaccinated}</p>
            <p>Neutered/Spayed: ${neutured}</p>
            <p>Weight: ${weight}</p>
            <p>Location: ${city_village}, ${district}, ${state}</p>
            <p>Description: ${description}</p>
            <p>About Pet: ${about_pet}</p>
            <p>Adoption Rules: ${adoption_rules}</p>
            <p>Status: ${available}</p>
        `;
        document.getElementById("popupContent").innerHTML = popupContent;
        document.getElementById("popup").style.display = "block";
    }

    // Function to close the popup
    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }

    // Function to handle pet adoption
    function adoptPet(ad_id) {
        // You can perform actions here, such as marking the pet as adopted
        // For now, let's just log the ID to the console
        console.log("Adopting pet with ID: " + ad_id);
    }

    $(document).ready(function() {
        fetchAds(); // Call this function when the page loads
    });

    var start = 0;
    var processing = false;

    function fetchAds() {
        const formData = new FormData();
        formData.append('start', start);
        $.ajax({
            url: 'retriveAds.php',
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
                start += 12; // Assuming 12 items are fetched each time
                if (data != "") {
                    $('.display_ads').append(data);
                    processing = false;
                } else {
                    $('.display_ads').append('<p class="col-lg-12 column" style="width:100%;text-align:center;font-size:20px;color:#F9575C">Nothing more to load</p>');
                }
            },
            error(data) {
                console.log(data);
            }
        });
    }

    $(document).scroll(function(e) {
        if (processing) return;
        var scrollAmount = $(window).scrollTop();
        var documentHeight = $(document).height();
        var scrollPercent = (scrollAmount / documentHeight) * 100;

        if (scrollPercent > 50) {
            processing = true;
            fetchAds();
        }
    });

</script>
</body>
</html>
