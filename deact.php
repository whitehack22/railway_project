<?php
session_start();
include("header.php"); // Include header
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deactivate Account</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="js/jquery-1.8.2.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/main.js"></script>
    <style type="text/css">
        a:link, a:visited, a:hover, a:active {
            color: #ffffff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <form id="login-form" class="login-form" name="form1" method="post" action="">
        <div id="form-content">
            <div class="welcome">
                <p>Are you sure you wish to deactivate your account?</p>
                <label>Email ID:</label> <input type="email" name="email" required><br/>
                <label>Password:</label> <input type="password" name="password" required><br/><br/>
                <center><input type="submit" name="submit" value="Deactivate Account"></center>
            </div>
        </div>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Sanitize inputs
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = htmlspecialchars($password);

        // Database connection
        $conn = new mysqli("localhost", "root", "", "nairobi_commuters");  // Ensure this is the correct DB name

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute query to check email and password
        $stmt = $conn->prepare("SELECT email, password FROM passengers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($dbemail, $dbpassword);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $dbpassword)) {
                // Prepare and execute query to deactivate the account
                $deleteStmt = $conn->prepare("DELETE FROM passengers WHERE email = ?");
                $deleteStmt->bind_param("s", $dbemail);

                if ($deleteStmt->execute()) {
                    echo "<script>alert('Account successfully deactivated.'); window.location.href = 'index.php';</script>"; // Redirect to homepage
                } else {
                    echo "<script>alert('Failed to deactivate account. Please try again later.');</script>";
                }
                $deleteStmt->close();
            } else {
                echo "<script>alert('Incorrect password.');</script>";
            }
        } else {
            echo "<script>alert('User does not exist.');</script>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
