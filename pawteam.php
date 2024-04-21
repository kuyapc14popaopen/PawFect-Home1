<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="pawfecthome.net/pawteam.html" content="width=device-width, initial-scale=1.0">
    <title>Team Section</title>
    <style>
        /* Google Font */
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');

        * {
            margin: 0;
            padding: 20;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100vh;
            background-color: #4c3812;
        }

        .main-container {
            background: #dcdada;
            border-radius: 15px;
            margin: 1rem;
            padding: 20px;
            box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.4);
        }

        h2 {
            text-align: center;
        }

        hr {
            width: 10rem;
            margin: 10px auto;
        }

        .members {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .team-member {
            margin: 8px;
            transition: all .3s ease;
            cursor: pointer;
        }

        .team-member:hover {
            transform: scale(1.1);
        }

        img {
            width: 120px; /* Adjust the width as desired */
            height: 120px; /* Adjust the height as desired */
            border-radius: 100%;
            margin: 12px;
        }

        h4,
        p {
            text-align: center;
            font-size: 12px;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <h2>PawFect Team</h2>
        <hr>
        <div class="members">
            <div class="team-member">
                <img src="Jm.jpg">
                <h4>John Michael Ordonio</h4>
                <p>Web Developer</p>
            </div>
            <div class="team-member">
                <img src="Carl.jpg">
                <h4>Carl Jefferson Rallos</h4>
                <p>Web Developer</p>
            </div>
            <div class="team-member">
                <img src="Frank.jpg">
                <h4>Francess Molina</h4>
                <p>Web Developer</p>
            </div>
            <div class="team-member">
                <img src="Houston.jpg">
                <h4>Houston Sarmiento</h4>
                <p>Web Developer</p>
            </div>
            <div class="team-member">
                <img src="Zcy.jpg">
                <h4>Zcyrene Pujeda</h4>
                <p>Web Developer</p>
            </div>
            <div class="team-member">
                <img src="Jay-m.jpg">
                <h4>Jay-m Sarsua</h4>
                <p>Web Developer</p>
            </div>
        </div>
    </div>
    <!-- Our Team Page design using HTML CSS by raju_webdev -->
</body>
</html>