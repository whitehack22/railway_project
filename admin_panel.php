<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('includes/db.php'); // Database connection

// Fetch data for the dashboard
// Count total bookings
$totalBookingsQuery = "SELECT COUNT(*) AS total_bookings FROM bookings";
$totalBookingsResult = $conn->query($totalBookingsQuery);
$totalBookings = $totalBookingsResult->fetch_assoc()['total_bookings'];

// Count active trains
$activeTrainsQuery = "SELECT COUNT(*) AS active_trains FROM trains WHERE status='active'";
$activeTrainsResult = $conn->query($activeTrainsQuery);
$activeTrains = $activeTrainsResult->fetch_assoc()['active_trains'];

// Fetch upcoming bookings
$upcomingBookingsQuery = "SELECT * FROM bookings WHERE travel_date > NOW() ORDER BY travel_date ASC LIMIT 5";
$upcomingBookingsResult = $conn->query($upcomingBookingsQuery);

// Fetch user activity (last 5 registered users)
$userActivityQuery = "SELECT username, created_at FROM users ORDER BY created_at DESC LIMIT 5";
$userActivityResult = $conn->query($userActivityQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_panel.css">
</head>
<body>

<div class="container">
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
    <p>You are now logged in as an admin.</p>

    <div class="dashboard">
        <div class="stat">
            <h3>Total Bookings</h3>
            <p><?php echo $totalBookings; ?></p>
        </div>

        <div class="stat">
            <h3>Active Trains</h3>
            <p><?php echo $activeTrains; ?></p>
        </div>

        <div class="stat">
            <h3>Upcoming Bookings</h3>
            <ul>
                <?php while ($booking = $upcomingBookingsResult->fetch_assoc()) { ?>
                    <li>
                        <?php echo $booking['user_name'] . " - " . $booking['travel_date']; ?>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="stat">
            <h3>Recent User Activity</h3>
            <ul>
                <?php while ($user = $userActivityResult->fetch_assoc()) { ?>
                    <li>
                        <?php echo $user['username'] . " - " . $user['created_at']; ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <a href="logout.php">Logout</a>
</div>

</body>
</html>
