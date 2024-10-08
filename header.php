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
    var start = 0, processing = false;
    var search_load = false;

    function toggle() {
        var header = document.getElementById("header");
        header.classList.toggle('active');
    }

    function fetchSearchResults() {
        const formData = new FormData();
        formData.append('search', $('.search').val());
        if ($('.search').val().trim() === "") search_load = false;
        formData.append('start', start);

        $.ajax({
            url: 'retriveSearchResults.php',
            method: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                start += 12;
                if (data !== "") {
                    $('.display_ads').append(data);
                    processing = false;
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
        start = 0;
        $('.display_ads').empty();
        fetchSearchResults();
        search_load = true;
    }

    function login() {
        $("#dynamic_content").css("visibility", "visible");
        $("#dynamic_content").load("Login.php");
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


</script>

<header id="header" class="">
    <a href="index.php" class="logo"><span class="material-icons" style="font-size: 40px; margin-right: 8px; rgb(255 255 255);">pets</span><p>PawFect Home</p></a>
    
    <ul onclick="toggle()">
        <li></li>
        <li><a href="javascript:void(0)" id='postAdLink'><span class="glyphicon glyphicon-open"></span> Post Pets </a></li>
        <?php if(isset($_SESSION['email'])) { ?>
            <li><a href="profile_page.php"><span class="glyphicon glyphicon-cog"></span> Profile Settings</a></li>
            <li><a href="completedadoption.php"><span class="glyphicon glyphicon-ok"></span> Adopted Pets</a></li>
            <li><a href="view_messages.php"><span class="glyphicon glyphicon-envelope"></span> Messages</a></li>
            <li><a href="notification.php"><span class="glyphicon glyphicon-bell"></span> Notifications</a></li> <!-- Added notifications link -->
            <li><a href="javascript:logOut();"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
        <?php } else { ?>
            <li><a href="javascript:signUp();"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
            <li><a href="javascript:login();"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        <?php } ?>
    </ul>
    
    <div class="toggle" onclick="toggle()"></div>
</header>


<div id="dynamic_content"></div>

</body>
</html>
