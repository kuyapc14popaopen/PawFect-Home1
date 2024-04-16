<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ad_id'])) {
        $ad_id = $_POST['ad_id'];

        // Delete from ad_info table
        $deleteAdInfo = "DELETE FROM ad_info WHERE ad_id = '$ad_id'";
        if (mysqli_query($connection, $deleteAdInfo)) {
            // Delete from ad_images table
            $deleteAdImages = "DELETE FROM ad_images WHERE ad_id = '$ad_id'";
            if (mysqli_query($connection, $deleteAdImages)) {
                echo "Post with Ad ID " . $ad_id . " deleted successfully.";
            } else {
                echo "Error deleting post from ad_images table: " . mysqli_error($connection);
            }
        } else {
            echo "Error deleting post from ad_info table: " . mysqli_error($connection);
        }
    } else {
        echo "Invalid request. Missing Ad ID.";
    }
} else {
    echo "Invalid request method.";
}

mysqli_close($connection);
?>
