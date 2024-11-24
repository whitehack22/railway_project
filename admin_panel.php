<?php 
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('includes/db.php'); // Database connection

// Fetch data for the dashboard
// Count total tickets
$totalTicketsQuery = "SELECT COUNT(*) AS total_tickets FROM tickets";
$totalTicketsResult = $conn->query($totalTicketsQuery);
$totalTickets = $totalTicketsResult->fetch_assoc()['total_tickets'];

// Count active trains
$activeTrainsQuery = "SELECT COUNT(*) AS active_trains FROM trains WHERE t_status = 'On time'";
$activeTrainsResult = $conn->query($activeTrainsQuery);
$activeTrains = $activeTrainsResult->fetch_assoc()['active_trains'];

// Fetch upcoming passenger bookings (Join passengers and tickets for better insights)
$upcomingTicketsQuery = "
    SELECT p.p_fname, p.p_lname, p.email, t.PNR, t.t_status 
    FROM passengers p
    JOIN tickets t ON p.PNR = t.PNR
    WHERE t.t_status = 'Waiting'
    ORDER BY t.PNR ASC 
    LIMIT 5";
$upcomingTicketsResult = $conn->query($upcomingTicketsQuery);

// Fetch user activity (last 5 registered users)
$userActivityQuery = "SELECT p_fname, p_lname, email, role FROM passengers ORDER BY p_id DESC LIMIT 5";
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

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="passenger_details.php">Passenger Details</a>
    <a href="train_details.php">Train Details</a>
    <a href="station_details.php">Station Details</a>
    <a href="reports.php">Reports</a>
    <a href="admin_profile.php">Profile</a>
    <a href="logout.php" class="logout">Logout</a>
</div>

<div class="content">
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <p>You are now logged in as an admin.</p>

    <div class="dashboard">
        <div class="stat">
            <h3>Total Tickets</h3>
            <p><?php echo $totalTickets; ?></p>
        </div>

        <div class="stat">
            <h3>Active Trains</h3>
            <p><?php echo $activeTrains; ?></p>
        </div>

        <div class="stat">
            <h3>Upcoming Tickets</h3>
            <ul>
                <?php while ($ticket = $upcomingTicketsResult->fetch_assoc()) { ?>
                    <li>
                        <?php 
                            echo $ticket['p_fname'] . " " . $ticket['p_lname'] . 
                            " (" . $ticket['email'] . ") - PNR: " . $ticket['PNR'] . 
                            " - Status: " . $ticket['t_status']; 
                        ?>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="stat">
            <h3>Recent User Activity</h3>
            <ul>
                <?php while ($user = $userActivityResult->fetch_assoc()) { ?>
                    <li>
                        <?php echo $user['p_fname'] . " " . $user['p_lname'] . " - " . $user['email']; ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
