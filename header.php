<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nairobi Commuters Railways</title>
    <link rel="stylesheet" href="s1.css" type="text/css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #ce1616; 
            padding: 10px 20px;
        }

        .wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .menu ul li {
            margin: 0 15px;
            position: relative;
        }

        .menu ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
        }

        #dropdown {
            position: relative;
            display: inline-block;
            color: white;
            font-size: 18px;
            cursor: pointer;
        }

        #Logout {
            display: none;
            position: absolute;
            top: 30px;
            right: 0;
            background-color: white;
            color: black;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            text-align: center;
            z-index: 10;
        }

        #Logout a {
            text-decoration: none;
            color: black;
            font-size: 16px;
        }

        #Logout a:hover {
            text-decoration: underline;
        }

       
        @media (max-width: 768px) {
            .menu ul {
                flex-direction: column;
                text-align: center;
            }

            .menu ul li {
                margin: 10px 0;
            }
        }
    </style>
   <script src="jquery.js"></script>
<script>
    $(document).ready(function () {
        $("#dropdown").hover(
            function () {
                $("#Logout").stop(true, true).slideDown("slow");
            },
            function () {
                $("#Logout").stop(true, true).slideUp("slow");
            }
        );
    });
</script>

</head>
<body>
    <div class="container">
        <div class="wrapper">
            <div class="menu">
                <ul id="navmenu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="pnrstatus.php">PNR Status</a></li>
                    <li><a href="bookticket.php">Book a Ticket</a></li>
                    
                    <li><a href="admin_login.php">Admin</a></li>

                    <!-- Admin link (visible only for logged-in admins) -->
                    <?php if (isset($_SESSION['admin_logged_in'])): ?>
                        <li><a href="admin_dashboard.php">Admin Panel</a></li>
                    <?php endif; ?>

                    <!-- User-specific logic -->
                    <li>
                        <?php  
                        if (isset($_SESSION['user_info'])) {
                            echo '<div id="dropdown">' . $_SESSION['user_info'] . 
                                 '<div id="Logout">
                                     <a href="profile.php">Profile</a><br>
                                     <a href="logout.php">Logout</a>
                                 </div></div>';
                        } elseif (isset($_SESSION['admin_logged_in'])) {
                            echo '<div id="dropdown">Admin 
                                  <div id="Logout"><a href="logout.php">Logout</a></div></div>';
                        } else {
                            echo '<a href="register.php">Login/Register</a>';
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
