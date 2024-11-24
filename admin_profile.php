<?php 
session_start();
include('includes/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch admin data from the database
$admin_id = $_SESSION['admin_id'];
$query = "SELECT * FROM admins WHERE id = $admin_id";
$result = $conn->query($query);
$admin = $result->fetch_assoc();

// Handle profile update
if (isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    
    // Update the admin's details
    $updateQuery = "UPDATE admins SET username = '$username', email = '$email' WHERE id = $admin_id";
    $conn->query($updateQuery);
    header("Location: admin_profile.php"); // Reload to see changes
}

// Handle password change
if (isset($_POST['change_password'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    
    // Update the admin's password
    $changePasswordQuery = "UPDATE admins SET password = '$new_password' WHERE id = $admin_id";
    $conn->query($changePasswordQuery);
    header("Location: admin_profile.php"); // Reload to apply the new password
}

// Handle account deletion
if (isset($_POST['delete_account'])) {
    // Delete the admin's account from the database
    $deleteQuery = "DELETE FROM admins WHERE id = $admin_id";
    $conn->query($deleteQuery);
    
    // Logout the admin after deletion
    session_unset();
    session_destroy();
    header("Location: admin_login.php"); // Redirect to login page
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="css/admin_panel.css">
</head>
<body>

<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_panel.php">Dashboard</a>
        <a href="passenger_details.php">Passenger Details</a>
        <a href="station_details.php">Station Details</a>
        <a href="train_details.php" class="active">Train Details</a>
        <a href="reports.php">Reports</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Welcome, <?php echo $admin['username']; ?>!</h2>
        
        <h3>Profile Information</h3>
        <p><strong>Username:</strong> <?php echo $admin['username']; ?></p>
        <p><strong>Email:</strong> <?php echo $admin['email']; ?></p>
        <p><strong>Account Created On:</strong> <?php echo $admin['created_at']; ?></p>

        <h3>Edit Profile</h3>
        <form method="POST">
            <input type="text" name="username" value="<?php echo $admin['username']; ?>" required>
            <input type="email" name="email" value="<?php echo $admin['email']; ?>" required>
            <button type="submit" name="update_profile">Update Profile</button>
        </form>

        <h3>Change Password</h3>
        <form method="POST">
            <input type="password" name="new_password" placeholder="New Password" required>
            <button type="submit" name="change_password">Change Password</button>
        </form>

        <h3>Delete Account</h3>
        <p>This will permanently delete your account!</p>
        <form method="POST">
            <button type="submit" name="delete_account" onclick="return confirm('Are you sure you want to delete your account?')">Delete Account</button>
        </form>

    </div>
</div>

</body>
</html>
