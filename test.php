<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>User Data</h2>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>City</th>
            <th>Address</th>
            <th>Profile Image</th>
            <th>Update Timestamp</th>
        </tr>
        <?php
        // Include the connection file
        require 'connection.php';

        // Check if $conn is defined and not null
        if ($conn) {
            // Query to fetch all users
            $sql = "SELECT * FROM users";
            
            // Get the result set from the query
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $row["contact"] . "</td>";
                    echo "<td>" . $row["city"] . "</td>";
                    echo "<td>" . $row["address"] . "</td>";
                    echo "<td><img src='" . $row["profile_img_url"] . "' height='50'></td>";
                    echo "<td>" . $row["update_timestamp"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No users found</td></tr>";
            }

            // Close the result set
            $result->free();
        } else {
            echo "<tr><td colspan='8'>Database connection error</td></tr>";
        }

        // Close connection
        $conn->close();
        ?>
    </table>

</body>
</html>
