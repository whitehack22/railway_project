<?php
// Include database connection
include('includes/db.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Query the database for the admin with the given username
    $sql = "SELECT * FROM admins WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Fetch the user data
        $admin = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $admin['password'])) {
            // Start a session and store admin information
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            
            // Redirect to admin panel
            header("Location: admin_panel.php");
            exit();
        } else {
            echo "<script>alert('Invalid password');</script>";
        }
    } else {
        echo "<script>alert('No admin found with that username');</script>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/admin_login.css">
    <script src="js/admin_validation.js"></script>
</head>
<body>

<div class="container">
    <h2>Admin Login</h2>
    <form method="POST" action="admin_login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        
        <button type="submit">Login</button>
    </form>

    <!-- Link to Registration Page -->
    <p>Don't have an account? <a href="admin_register.php">Click here to register</a></p>
    
</div>

</body>
</html>
