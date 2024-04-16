<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Posts</title>
    <style>
        /* Your CSS styles here */
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 8px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .pet-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-4">Pending Posts</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Pet Name</th>
            <th>Pet Category</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        session_start();
        include 'connection.php';

        // Fetch all data from the ad_info table
        $sql = "SELECT * FROM ad_info";
        $result = mysqli_query($connection, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ad_id'] . "</td>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['pet_name'] . "</td>";
            echo "<td>" . $row['pet_category'] . "</td>";
            echo "<td><button onclick='showModal(\"modal-" . $row['ad_id'] . "\", \"" . $row['pet_name'] . "\", \"" . $row['pet_category'] . "\", \"" . $row['breed'] . "\", \"" . $row['color'] . "\", \"" . $row['gender'] . "\", \"" . $row['age'] . "\", \"" . $row['age_type'] . "\", \"" . $row['size'] . "\", \"" . $row['vaccinated'] . "\", \"" . $row['neutured'] . "\", \"" . $row['weight'] . "\", \"" . $row['city_village'] . "\", \"" . $row['district'] . "\", \"" . $row['state'] . "\", \"" . $row['description'] . "\", \"" . $row['about_pet'] . "\", \"" . $row['adoption_rules'] . "\", \"" . $row['available'] . "\")'>Show Details</button></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Modals -->
    <?php
    mysqli_data_seek($result, 0); // Reset result pointer
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div id='modal-" . $row['ad_id'] . "' class='modal'>";
        echo "<div class='modal-content'>";
        echo "<span class='close' onclick='closeModal(\"modal-" . $row['ad_id'] . "\")'>&times;</span>";
        $ad_id = $row['ad_id'];
        $imageQuery = "SELECT image_url FROM ad_images WHERE ad_id = '$ad_id'";
        $imageResult = mysqli_query($connection, $imageQuery);
        if ($imageRow = mysqli_fetch_assoc($imageResult)) {
            $imageUrl = 'uploads/' . $imageRow['image_url'];
            echo "<img src='$imageUrl' alt='Pet Image' class='pet-image'>";
        }
        echo "<h3>Details for Ad ID: " . $row['ad_id'] . "</h3>";
        echo "<p><strong>Breed:</strong> " . $row['breed'] . "</p>";
        echo "<p><strong>Gender:</strong> " . ($row['gender'] == 0 ? 'Male' : 'Female') . "</p>";
        echo "<p><strong>Age:</strong> " . $row['age'] . " " . $row['age_type'] . "</p>";
        echo "<p><strong>Size:</strong> " . getSizeLabel($row['size']) . "</p>";
        echo "<p><strong>Vaccinated:</strong> " . getYesNoLabel($row['vaccinated']) . "</p>";
        echo "<p><strong>Neutered:</strong> " . getYesNoLabel($row['neutured']) . "</p>";
        echo "<p><strong>Weight:</strong> " . $row['weight'] . "</p>";
        echo "<p><strong>City/Village:</strong> " . $row['city_village'] . "</p>";
        echo "<p><strong>District:</strong> " . $row['district'] . "</p>";
        echo "<p><strong>State:</strong> " . $row['state'] . "</p>";
        echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
        echo "<p><strong>About Pet:</strong> " . $row['about_pet'] . "</p>";
        echo "<p><strong>Adoption Rules:</strong> " . $row['adoption_rules'] . "</p>";

        // Add Confirm and Reject buttons
        echo "<button onclick='confirmAction(\"" . $row['ad_id'] . "\", \"" . $row['pet_name'] . "\", \"" . $row['pet_category'] . "\", \"" . $row['breed'] . "\", \"" . $row['color'] . "\", \"" . $row['gender'] . "\", \"" . $row['age'] . "\", \"" . $row['age_type'] . "\", \"" . $row['size'] . "\", \"" . $row['vaccinated'] . "\", \"" . $row['neutured'] . "\", \"" . $row['weight'] . "\", \"" . $row['city_village'] . "\", \"" . $row['district'] . "\", \"" . $row['state'] . "\", \"" . $row['description'] . "\", \"" . $row['about_pet'] . "\", \"" . $row['adoption_rules'] . "\", \"" . $row['available'] . "\")'>Confirm</button>";
        echo "<button onclick='rejectAction(\"reject-" . $row['ad_id'] . "\")'>Reject</button>";

        echo "</div></div>";
    }

    // Function to get Size label
    function getSizeLabel($size)
    {
        switch ($size) {
            case 0:
                return "Small";
            case 1:
                return "Medium";
            case 2:
                return "Large";
            default:
                return "Unknown";
        }
    }

    // Function to get Yes/No label
    function getYesNoLabel($value)
    {
        return $value == 1 ? "Yes" : "No";
    }
    ?>

    <script>
        function showModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "block";
        }

        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = "none";
                }
            }
        }

        // Function to handle confirm action
        function confirmAction(ad_id, pet_name, pet_category, breed, color, gender, age, age_type, size, vaccinated, neutured, weight, city_village, district, state, description, about_pet, adoption_rules, available) {
            var formData = new FormData();
            formData.append('ad_id', ad_id);
            formData.append('pet_name', pet_name);
            formData.append('pet_category', pet_category);
            formData.append('breed', breed);
            formData.append('color', color);
            formData.append('gender', gender);
            formData.append('age', age);
            formData.append('age_type', age_type);
            formData.append('size', size);
            formData.append('vaccinated', vaccinated);
            formData.append('neutured', neutured);
            formData.append('weight', weight);
            formData.append('city_village', city_village);
            formData.append('district', district);
            formData.append('state', state);
            formData.append('description', description);
            formData.append('about_pet', about_pet);
            formData.append('adoption_rules', adoption_rules);
            formData.append('available', available);

            $.ajax({
                url: 'confirm_action.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response);
                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }

        // Function to handle reject action
        function rejectAction(actionId) {
            // Implement your reject action logic here
            alert("Rejected action for " + actionId);
        }
    </script>
</div>
</body>
</html>
