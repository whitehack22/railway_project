<?php
// Include database connection
include('includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!');</script>";
    } else {
        // Check if passwords match
        if ($password !== $confirmPassword) {
            echo "<script>alert('Passwords do not match!');</script>";
        } else {
            // Hash the password before storing it
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert the admin into the database
            $sql = "INSERT INTO admins (username, password, email) VALUES ('$username', '$hashedPassword', '$email')";
            
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Admin registered successfully!');</script>";
            } else {
                echo "<script>alert('Error: " . $conn->error . "');</script>";
            }
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link rel="stylesheet" href="css/admin_login.css">
    <script src="js/admin_validation.js"></script>
</head>
<body>

<div class="container">
    <h2>Admin Register</h2>
    <form id="register-form" method="POST" action="admin_register.php">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password" id="confirm_password" required>
    
    <button type="submit">Register</button>
</form>


      <!-- Link to Login Page -->
      <p>Already have an account? <a href="admin_login.php">Click to Login</a></p>

</div>

</body>
</html>
