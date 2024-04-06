<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="styles.css">

    <title>AdminHub</title>

</head>
<body>


    <!-- SIDEBAR -->
    <section id="sidebar">


        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Pawfect Home</span>
        </a>

        <ul class="side-menu top">
            <li class="active" data-content="dashboard">
                <a href="#">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>

            <li data-content="chart">
                <a href="#">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Chart</span>
                </a>
            </li>
            <li class="active" data-content="manage-users">
                <a href="#">
                    <i class='bx bxs-group'></i>
                    <span class="text">Manage Users</span>
                </a>
            </li>

            <li data-content="manage-pets">
                <a href="#">
                    <i class='bx bxs-group'></i>
                    <span class="text">Manage Pets</span>
                </a>
            </li>

            <li data-content="adoption-requests">
                <a href="#">
                    <i class='bx bxs-group'></i>
                    <span class="text">Adoption Requests</span>
                </a>
            </li>
        </ul>

        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>

            <form action="#">

            </form>
            <a href="#" class="profile">
                <img src="img/icon.jpg">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->

        <main>
            <section id="dashboard" class="content-section">
                <div class="box-container">
                    <div class="box-item">
                        <h3>Box 1</h3>
                        <p>This is Box 1 content.</p>
                    </div>
                    <div class="box-item">
                        <h3>Box 2</h3>
                        <p>This is Box 2 content.</p>
                    </div>
                    <div class="box-item">
                        <h3>Box 3</h3>
                        <p>This is Box 3 content.</p>
                    </div>
                    <div class="box-item">
                        <h3>Box 4</h3>
                        <p>This is Box 4 content.</p>
                    </div>
                    <div class="box-item">
                        <h3>Box 5</h3>
                        <p>This is Box 5 content.</p>
                    </div>
                    <div class="box-item">
                        <h3>Box 6</h3>
                        <p>This is Box 6 content.</p>
                    </div>
                </div>
            </section>
            <section id="chart" class="content-section" style="display: none;">
                <h2>Chart Content</h2>
                <p>This is the content for the Chart.</p>
            </section>
            <section id="manage-users" class="content-section" style="display: block;">
                <h2>Manage Users</h2>
                <div class="user-info">
                    <p><strong>Name:</strong> <?php echo $user['email']; ?></p>
                    <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                    <p><strong>Address:</strong> <?php echo $user['address']; ?></p>
                    <!-- Display other user information as needed -->
                </div>
            </section>
            <section id="manage-pets" class="content-section" style="display: none;">
                <h2>Manage Pets Content</h2>
                <p>This is the content for managing pets.</p>
            </section>
            <section id="adoption-requests" class="content-section" style="display: none;">
<div class="adoption-container">
   
</div>
            </section>
        </main>
        <!-- MAIN -->
    </section>

    <script src="script.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sideMenuItems = document.querySelectorAll(".side-menu li");

            sideMenuItems.forEach(function (item) {
                item.addEventListener("click", function (event) {
                    // Prevent default link behavior
                    event.preventDefault();

                    // Get the data-content attribute value
                    const contentId = item.getAttribute("data-content");

                    // Hide all content sections
                    const contentSections = document.querySelectorAll(".content-section");
                    contentSections.forEach(function (section) {
                        section.style.display = "none";
                    });

                    // Show the selected content section
                    const selectedContent = document.getElementById(contentId);
                    if (selectedContent) {
                        selectedContent.style.display = "block";
                    }

                    // Optionally, you can add logic to handle active state for the clicked item
                    // For example, remove 'active' class from all items and add it to the clicked item
                    sideMenuItems.forEach(function (menuItem) {
                        menuItem.classList.remove("active");
                    });
                    item.classList.add("active");
                });
            });
        });

        function goBack() {
            window.history.back();
        }


    </script>
</body>
</html>
