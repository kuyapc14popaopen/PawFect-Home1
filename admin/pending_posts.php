<?php
session_start();
require '../connection.php';
?>

<html>
<head>
    <title></title>
    <link rel="shortcut icon" href="../img/Bulldog.jpeg" />
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
$sql = "SELECT ad_images.image_url, users.name, ad_info.pet_name, ad_info.pet_category, ad_info.breed, ad_info.color, ad_info.gender, ad_info.age, ad_info.age_type, ad_info.size, ad_info.vaccinated, ad_info.neutured, ad_info.weight, ad_info.city_village, ad_info.district, ad_info.state, ad_info.description, ad_info.about_pet, ad_info.adoption_rules, ad_info.available, ad_info.ad_id
        FROM ad_images
        INNER JOIN ad_info ON ad_images.ad_id = ad_info.ad_id
        INNER JOIN users ON ad_info.user_id = users.id
        WHERE ad_info.archived = FALSE"; // Add condition to select only non-archived ads

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
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
?>
        <div class="col-sm-6 col-md-4 col-lg-3 column" data-ad-id="<?php echo $row['ad_id']; ?>">
            <div class="card">
                <img src="../uploads/<?php echo $row['image_url']; ?>" class="img-responsive" alt="Pet Image">
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
                <div class="more_info_btn"><a href="#" onclick="showMoreInfo('<?php echo $name; ?>', '<?php echo $pet_name; ?>', '<?php echo $pet_category; ?>', '<?php echo $breed; ?>', '<?php echo $color; ?>', '<?php echo $gender; ?>', '<?php echo $age; ?>', '<?php echo $age_type; ?>', '<?php echo $size; ?>', '<?php echo $vaccinated; ?>', '<?php echo $neutured; ?>', '<?php echo $weight; ?>', '<?php echo $city_village; ?>', '<?php echo $district; ?>', '<?php echo $state; ?>', '<?php echo $description; ?>', '<?php echo $about_pet; ?>', '<?php echo $adoption_rules; ?>', '<?php echo $available; ?>')">More info</a></div>
                
                <!-- Confirm and Reject buttons -->
                <div class="confirm-reject-btns">
                    <button id="confirmBtn" class="btn btn-success" onclick="confirmPet('<?php echo $row['ad_id']; ?>', '<?php echo $row['image_url']; ?>', '<?php echo $name; ?>', '<?php echo $pet_name; ?>', '<?php echo $breed; ?>', '<?php echo $gender; ?>', '<?php echo $pet_category; ?>', '<?php echo $color; ?>', '<?php echo $age; ?>', '<?php echo $age_type; ?>', '<?php echo $size; ?>', '<?php echo $vaccinated; ?>', '<?php echo $neutured; ?>', '<?php echo $weight; ?>')">Confirm</button>

                    <button class="btn btn-secondary" onclick="archivePet(<?php echo $row['ad_id']; ?>)">Archive</button>
                </div>
            </div>
        </div>
<?php
    }
} else {
    echo "No ads found.";
}
?>

<?php include '../post-ad-part-1.php';?>

<!-- Popup to display more info -->
<div id="popup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <div id="popupContent">
            <!-- Content will be filled dynamically -->
        </div>
    </div>
</div>

<!-- Script for confirming and rejecting pets -->
<script>
function archivePet(id) {
  if (confirm("Are you sure you want to archive this pet?")) {
    $.ajax({
      type: "POST",
      url: "archive_pet.php",
      data: { id: id },
      success: function(response) {
        // Refresh the page or update the table as needed
        location.reload();
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  }
}
    function confirmPet(adId, image_url, name, petName, breed, gender, pet_category, color, age, age_type, size, vaccinated, neutured, weight) {
        var confirmationData = {
            ad_id: adId,
            name: name,
            image_url: image_url,
            pet_name: petName,
            pet_category: pet_category,
            breed: breed,
            color: color,
            gender: gender,
            age: age,
            age_type: age_type,
            size: size,
            vaccinated: vaccinated,
            neutured: neutured,
            weight: weight,
            user_id: '<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>' // Include user ID
        };

        $.ajax({
            url: 'confirm_ad.php',
            method: 'POST',
            data: confirmationData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    console.log("Ad confirmed with ID: " + adId);
                    alert("Ad confirmed successfully!");

                    // Remove the card from the DOM
                    var cardToRemove = document.querySelector("[data-ad-id='" + adId + "']");
                    if (cardToRemove) {
                        cardToRemove.parentNode.removeChild(cardToRemove);
                    }

                    // After confirmation, delete the ad from the database
                    $.ajax({
                        url: '../delete_ad.php?ad_id=' + adId, // Send ad_id as GET parameter
                        method: 'GET', // Change method to GET
                        dataType: 'json',
                        success: function (deleteResponse) {
                            if (deleteResponse.success) {
                                console.log("Ad deleted from the database with ID: " + adId);
                            } else {
                                console.error("Error deleting ad from the database:", deleteResponse.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Error deleting ad from the database:", error);
                        }
                    });
                } else {
                    console.error("Error confirming ad:", response.message);
                    alert("Error confirming ad: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error confirming ad:", error);
                alert("Error confirming ad. Please try again.");
            }
        });
    }

    function rejectPet(adId) {
        // Redirect to archive.php with the ad ID as a parameter
        window.location.href = 'archive.php?ad_id=' + adId;
    }

    // Function to show the popup with more info (unchanged)
    function showMoreInfo(name, pet_name, pet_category, breed, color, gender, age, age_type, size, vaccinated, neutured, weight, city_village, district, state, description, about_pet, adoption_rules, available) {
        var popupContent = `
            <h2> ${pet_name}</h2>
            <p>Category: ${pet_category}</p>
            <p>Breed: ${breed}</p>
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
        `;
        document.getElementById("popupContent").innerHTML = popupContent;
        document.getElementById("popup").style.display = "block";
    }

    // Function to close the popup (unchanged)
    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }

</script>


</body>
</html>
