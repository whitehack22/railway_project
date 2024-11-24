<?php
session_start();
include('includes/db.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Get today's date in the format 'Y-m-d' to query by date
$today = date('Y-m-d');

// Get the number of passengers who booked tickets today
$queryPassengers = "SELECT COUNT(*) as passenger_count FROM passengers WHERE DATE(registered_at) = '$today'";
$resultPassengers = $conn->query($queryPassengers);
$passengersCount = $resultPassengers->fetch_assoc()['passenger_count'];

// Get the number of tickets generated today
$queryTickets = "SELECT COUNT(*) as ticket_count FROM tickets WHERE DATE(booking_date) = '$today'";
$resultTickets = $conn->query($queryTickets);
$ticketsCount = $resultTickets->fetch_assoc()['ticket_count'];

// Get the busiest train based on the number of available seats
$queryBusiestTrain = "SELECT train_name, COUNT(*) as booked_seats
                      FROM seats
                      WHERE is_available = 0  -- Only booked seats
                      GROUP BY train_name
                      ORDER BY booked_seats DESC
                      LIMIT 1";
$resultBusiestTrain = $conn->query($queryBusiestTrain);
$busiestTrain = $resultBusiestTrain->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="css/admin_panel.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_panel.php">Dashboard</a>
        <a href="passenger_details.php">Passenger Details</a>
        <a href="station_details.php">Station Details</a>
        <a href="train_details.php">Train Details</a>
        <a href="reports.php" class="active">Reports</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Daily Reports</h2>

        <!-- Report 1: Number of Passengers Booked Today -->
        <div class="report-section">
            <h3>Number of Passengers Registered Today</h3>
            <p>Total Passengers: <span class="count"><?php echo $passengersCount; ?></span></p>
        </div>

        <!-- Report 2: Number of Tickets Generated Today -->
        <div class="report-section">
            <h3>Number of Tickets Generated Today</h3>
            <p>Total Tickets: <span class="count"><?php echo $ticketsCount; ?></span></p>
        </div>

        <!-- Report 3: Busiest Train (Most Booked Seats) -->
        <div class="report-section">
            <h3>Busiest Train Today</h3>
            <?php if ($busiestTrain): ?>
                <p><strong>Train Name:</strong> <?php echo $busiestTrain['train_name']; ?></p>
                <p><strong>Booked Seats:</strong> <?php echo $busiestTrain['booked_seats']; ?></p>
            <?php else: ?>
                <p>No train bookings for today.</p>
            <?php endif; ?>
        </div>

        <!-- Graphical Reports -->
        <div class="chart-container">
            <!-- Bar Chart: Number of Passengers and Tickets -->
            <canvas id="passengerTicketChart"></canvas>
        </div>

        <div class="chart-container">
            <!-- Pie Chart: Busiest Train -->
            <canvas id="busiestTrainChart"></canvas>
        </div>
    </div>
</div>

<script>
// Bar Chart for Passengers and Tickets
const ctx1 = document.getElementById('passengerTicketChart').getContext('2d');
const passengerTicketChart = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Passengers', 'Tickets'],
        datasets: [{
            label: 'Count for Today',
            data: [<?php echo $passengersCount; ?>, <?php echo $ticketsCount; ?>],
            backgroundColor: ['#4CAF50', '#FF9800'],
            borderColor: ['#4CAF50', '#FF9800'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Pie Chart for Busiest Train
const ctx2 = document.getElementById('busiestTrainChart').getContext('2d');
const busiestTrainChart = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['Busiest Train', 'Other Trains'],
        datasets: [{
            label: 'Busiest Train Today',
            data: [<?php echo $busiestTrain ? $busiestTrain['booked_seats'] : 0; ?>, <?php echo $busiestTrain ? 0 : 1; ?>],
            backgroundColor: ['#FF5722', '#9E9E9E'],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});
</script>

</body>
