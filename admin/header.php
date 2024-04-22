<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>

<script type="text/javascript">
    var start=0, processing=false;
    var search_load=false;
    
    function toggle() {
        var header=document.getElementById("header");
        header.classList.toggle('active');
    }
    
    function fetchSearchResults() {
        const formData = new FormData();
        formData.append('search', $('.search').val());
        if ($('.search').val().trim() === "") search_load=false;
        formData.append('start', start);

        $.ajax({
            url: 'retriveSearchResults.php',
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                start+=12;
                if (data !== "") {
                    $('.display_ads').append(data);
                    processing=false;
                } else {
                    $('.display_ads').append('<p class="col-lg-12 column" style="width:100%;text-align:center;font-size:20px;color:#F9575C">Nothing more to load</p>');
                }
            },
            error: function (data) {
                console.log(data);
            }
        });                
    }
    
    function searchAds() {
        if ($('.display_ads').css('height') === undefined && $('.search').val().trim() !== "") {
            document.location = "displaypets.php?search=" + $('.search').val();
        }
        start=0;
        $('.display_ads').empty();
        fetchSearchResults();
        search_load=true;
    }
    
    function login() {
        $("#dynamic_content").css("visibility", "visible");
        $("#dynamic_content").load("login.php");
    }
    
    function signUp() {
        $("#dynamic_content").css("visibility", "visible");
        $("#dynamic_content").load("signup.php");
    }
    
    function logOut() {
        $("#dynamic_content").css("visibility", "visible");
        $("#dynamic_content").load("logout.php");
    }
    
    function wishlist() {
        $("#dynamic_content").css("visibility", "visible");
        $("#dynamic_content").empty();
        $.ajax({
            url: 'wishlist.php',
            method: 'POST',
            data: '',
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#dynamic_content").append(data);
            },
            error: function (data) {
                console.log(data);
            }
        });     
    }

    function showNotifications() {
        $.ajax({
            url: 'fetchNotifications.php',
            method: 'GET',
            success: function (data) {
                // Display notifications using data received from the server
                alert(data); // Example: Display notifications in an alert
                
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    }
</script>

<header id="header" class="">
    <a href="index.php" class="logo"><span class="material-icons" style="font-size: 40px; margin-right: 8px; rgb(255 255 255);">pets</span><p>PawFect Home</p></a>
    
    <ul onclick="toggle()">
        <li></li>

        <?php if(isset($_SESSION['email'])) { ?>
            <li><a href="javascript:wishlist();"><span class="glyphicon glyphicon-bell"></span> Notifications</a></li>
            <li><a href="dashboard.php  "><span class="glyphicon glyphicon-log-out"></span> Return</a></li>
        <?php } ?>
    </ul>
    
    <div class="toggle" onclick="toggle()"></div>
</header>

<div id="dynamic_content"></div>

</body>
</html>
