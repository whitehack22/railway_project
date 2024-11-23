<?php
session_start();
include("header.php"); // Include header

// Include database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'nairobi_commuters';

// Create connection using mysqli
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['changepw'])) {
    $email = $_POST['email'];
    $opw = $_POST['opw'];
    $npw = $_POST['npw'];

    // Sanitize user inputs
    $email = $conn->real_escape_string($email);
    $opw = $conn->real_escape_string($opw);
    $npw = $conn->real_escape_string($npw);

    // Check if the email exists in the database
    $sql = "SELECT * FROM passengers WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists
        $row = $result->fetch_assoc();
        $dbpassword = $row['password'];

        // Verify the current password using password_verify() function
        if (password_verify($opw, $dbpassword)) {
            // Hash the new password
            $hashed_new_password = password_hash($npw, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_sql = "UPDATE passengers SET password = '$hashed_new_password' WHERE email = '$email'";
            if ($conn->query($update_sql) === TRUE) {
                echo "<script type='text/javascript'>alert('Password changed successfully');</script>";
            } else {
                echo "<script type='text/javascript'>alert('Error updating password');</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('Incorrect current password');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('User does not exist');</script>";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/main.css">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500' rel='stylesheet' type='text/css'>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery-1.8.2.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/main.js"></script>
    <style type="text/css">
        a:link, a:visited, a:hover, a:active { color: #ffffff; }
    </style>
</head>
<body>

<form id="login-form" class="login-form" name="form1" method="post" action="changepw.php">
    <div id="form-content">
        <div class="welcome">
            <p>Would you like to change your password for the Nairobi Railways Commuters System?</p>
            <p>Email ID: <input type="text" name="email" required><br/></p>
            <p>Current password: <input type="password" name="opw" required><br/></p>
            <p>New password: <input type="password" name="npw" required><br/></p>
            <center><input type="submit" name="changepw" value="Change password"></center>
        </div>    
    </div>
</form>

</body>
</html>

