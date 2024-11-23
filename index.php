<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nairobi Commuters Railways</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
        #logo {
            width: 150px;
            height: 150px;
            display: block;
            margin: 0 auto;
        }

        * {
            color: #red;
        }

        html {
            background: url(img/bg7.webp) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        #main {
            width: 700px;
            margin: 50px auto;
            padding: 20px;
            border-radius: 25px;
            background-color: rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        a {
            color: orange;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            color: orange;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php 
    session_start();
    include("header.php"); 
    ?>
    
    <div id="main">
        <a href="index.php">
            <img src="img/logo_krc.png" alt="Nairobi Commuters Railways Logo" id="logo">
        </a>
        <h1 style="color:white">Nairobi Commuters Railways</h1>
        <h2 style="color:white" >Have a Safe Journey with Us</h2>

        <?php
        if (isset($_SESSION['user_info'])) {
            echo '<h3><a href="bookticket.php">Book Your Ticket Here</a></h3>';
        } else {
            echo '<h3><a href="register.php">Please Register/Login Before Booking</a></h3>';
        }
        ?>
    </div>
    

</body>
</html>


<footer>
        <div class="footer-container">
            <p><strong>&copy; 2024 Nairobi Commuters Railway System. All Rights Reserved.</strong></p>
            <p><strong>Designed by Gordon Amos</strong></p>
            <div class="footer-links">
                <a href="about.php">About Us</a> | 
                <a href="contact.php">Contact</a> | 
                <a href="privacy.php">Privacy Policy</a>
            </div>
        </div>
    </footer>
