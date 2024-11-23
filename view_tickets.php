<?php
session_start();
if (!isset($_SESSION['user_info']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "nairobi_commuters");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$tickets = $conn->query("SELECT * FROM bookings");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Tickets</title>
</head>
<body>
    <h1>Manage Tickets</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Train ID</th>
            <th>Status</th>
            <th>Booking Date</th>
        </tr>
        <?php while ($row = $tickets->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['user_id'] ?></td>
                <td><?= $row['train_id'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['booking_date'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
