<?php
session_start();
?>
<html>
<head>
    <title>PawFect Home</title>
    <?php include 'dependencies.php'; ?>
    <script>
        function showLoginPopup() {
            var confirmation = confirm("Please log in first!");
            if (confirmation) {
                // Trigger click event on the Login button
                document.getElementById('glyphicon glyphicon-log-in').click();
            } else {
                // Do nothing if user clicks cancel
                return;
            }
        }
    </script>
</head>
<body>
<?php
require 'header.php';
?> 
<div id="dynamic_content">
    
</div>
  
<div id="bannerImage">
    <div class="container">
        <center>
        <div id="bannerContent">
            <h1>Helping Animals.</h1>
            <h2>Saving Lives.</h2>
            <p>Empower Their Journey: Join Us in Creating Forever Homes for Every Pawprint</p>
            <!-- Added onclick event to the link -->
            <a href="#" class="btn btn-primary" onclick="showLoginPopup()">Click here to see all the cute pets</a>
        </div>
        </center>
    </div>
</div>
<div class="container  ">
    <div class="row">
        <div class="col-xs-4 ">
            <div  class="thumbnail category_card">
                <a href="displaypets.php?search=dog">
                    <img src="img/dogs.jpg" alt="Camera">
                </a>
                <center>
                    <div class="caption">
                        <p id="autoResize">Dogs</p>
                        <p>Choose dog pet.</p>
                    </div>
                </center>
            </div>
        </div>
        <div class="col-xs-4 ">
            <div class="thumbnail category_card">
                <a href="displaypets.php?search=cat">
                    <img src="img/cats.jpg" alt="Cats">
                </a>
                <center>
                    <div class="caption">
                        <p id="autoResize">Cats</p>
                        <p>A family of Meowwwww</p>
                    </div>
                </center>
            </div>
        </div>
        <div class="col-xs-4 ">
            <div class="thumbnail category_card">
                <a href="displaypets.php?search=fish">
                    <img src="img/fishes.jpg" alt="Fishes">
                </a>
                <center>
                    <div class="caption">
                        <p id="autoResize">Fishes</p>
                        <p>Cutes Fishes.</p>
                    </div>
                </center>
            </div>
        </div>
    </div>
    
</div>
<br><br> <br><br><br><br>
<footer class="footer"> 
    <div class="container">
    <center>
    <p> Looking for a pet or finding a new home for a pet. Petmania is here for you</P>
    </center>
    </div>
</footer>

<?php include 'post-ad-part-1.php';?>
</body>
</html>
