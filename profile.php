<?php
session_start();
include("header.php"); 

// Check if the user is logged in
if (!isset($_SESSION['user_info'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Database connection
$conn = mysqli_connect("localhost", "root", "", "nairobi_commuters");
if (!$conn) {  
    die('Could not connect: ' . mysqli_connect_error());
}

// Get user email from session
$email = $_SESSION['user_info'];

// Fetch user data from the database
$sql = "SELECT * FROM passengers WHERE email = '$email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

// If user not found, redirect to login page
if (!$user) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url(img/bg7.webp) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            margin-bottom: 20px;
        }
        td {
            padding: 10px;
        }
        .button {
            background-color: #00bfff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none; /* Remove underline */
            margin-bottom: 15px; /* Add space between buttons vertically */
        }
        .button:hover {
            background-color: darkorange;
            text-decoration: none; /* Remove underline */
        }
        .danger {
            background-color: red;
            text-decoration: none; /* Remove underline */
        }
        .danger:hover {
            background-color: darkred;
            text-decoration: none; /* Remove underline */
        }
        .profile-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Profile</h2>
        <table>
            <tr>
                <td><strong>First Name:</strong></td>
                <td><?php echo $user['p_fname']; ?></td>
            </tr>
            <tr>
                <td><strong>Last Name:</strong></td>
                <td><?php echo $user['p_lname']; ?></td>
            </tr>
            <tr>
                <td><strong>Age:</strong></td>
                <td><?php echo $user['p_age']; ?></td>
            </tr>
            <tr>
                <td><strong>Contact:</strong></td>
                <td><?php echo $user['p_contact']; ?></td>
            </tr>
            <tr>
                <td><strong>Gender:</strong></td>
                <td><?php echo $user['p_gender']; ?></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td><?php echo $user['email']; ?></td>
            </tr>
            <tr>
                <td><strong>Role:</strong></td>
                <td><?php echo $user['role']; ?></td>
            </tr>
        </table>
        
        <div class="profile-btn">
            <!-- Change password link -->
            <a href="changepw.php" class="button">Change Password</a>
        </div>

        <div class="profile-btn">
            <!-- Deactivate account link -->
            <a href="deact.php?email=<?php echo $email; ?>" class="button danger">Deactivate Account</a>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
