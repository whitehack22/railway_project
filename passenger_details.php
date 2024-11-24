<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('includes/db.php'); // Include database connection

// Delete a passenger
if (isset($_POST['delete_passenger'])) {
    $p_id = $_POST['p_id'];
    $deletePassengerQuery = $conn->prepare("DELETE FROM passengers WHERE p_id = ?");
    $deletePassengerQuery->bind_param("i", $p_id);
    $deletePassengerQuery->execute();
    $deletePassengerQuery->close();

    echo "<script>alert('Passenger removed successfully.'); window.location.href='passenger_details.php';</script>";
    exit();
}

// Cancel a ticket
if (isset($_POST['cancel_ticket'])) {
    $pnr = $_POST['pnr'];
    $cancelTicketQuery = $conn->prepare("DELETE FROM tickets WHERE PNR = ?");
    $cancelTicketQuery->bind_param("s", $pnr);
    $cancelTicketQuery->execute();
    $cancelTicketQuery->close();

    echo "<script>alert('Ticket canceled successfully.'); window.location.href='passenger_details.php';</script>";
    exit();
}

// Confirm Payment
if (isset($_POST['confirm_payment'])) {
    $pnr = $_POST['pnr'];
    
    // Update payment status and ticket status
    $confirmPaymentQuery = $conn->prepare("UPDATE passengers p JOIN tickets t ON p.PNR = t.PNR SET p.payment_status = 'Confirmed', t.t_status = 'Ticket Acquired' WHERE p.PNR = ?");
    $confirmPaymentQuery->bind_param("s", $pnr);
    $confirmPaymentQuery->execute();
    $confirmPaymentQuery->close();

    echo "<script>alert('Payment confirmed and ticket status updated to Ticket Acquired.'); window.location.href='passenger_details.php';</script>";
    exit();
}

// Fetch passenger details
$passengerQuery = "
    SELECT 
        p.p_id, p.p_fname, p.p_lname, p.p_age, p.p_contact, p.p_gender, p.email, p.t_no, p.PNR, p.payment_status, p.seat_number,
        t.t_status
    FROM 
        passengers p
    LEFT JOIN 
        tickets t ON p.PNR = t.PNR
";
$passengerResult = $conn->query($passengerQuery);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Details</title>
    <link rel="stylesheet" href="css/admin_panel.css">
  
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_panel.php">Dashboard</a>
        <a href="passenger_details.php" class="active">Passenger Details</a>
        <a href="train_details.php">Train Details</a>
        <a href="station_details.php">Station Details</a>
        <a href="reports.php">Reports</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <h1>Passenger Details</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Train Number</th>
                    <th>PNR</th>
                    <th>Payment Status</th>
                    <th>Seat Number</th>
                    <th>Ticket Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $passengerResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['p_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['p_fname'] . ' ' . $row['p_lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['p_age']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['t_no'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['PNR'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['payment_status']); ?></td>
                        <td><?php echo htmlspecialchars($row['seat_number'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($row['t_status'] ?? 'No Ticket'); ?></td>
                        <td>
                            <!-- Remove Passenger -->
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="p_id" value="<?php echo $row['p_id']; ?>">
                                <button type="submit" name="delete_passenger" class="button danger">Remove</button>
                            </form>
                            <!-- Cancel Ticket -->
                            <?php if (!empty($row['PNR'])) { ?>
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="pnr" value="<?php echo $row['PNR']; ?>">
                                    <button type="submit" name="cancel_ticket" class="button warning">Cancel Ticket</button>
                                </form>
                            <?php } ?>
                            <!-- Confirm Payment -->
                            <?php if ($row['payment_status'] == 'Pending') { ?>
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="pnr" value="<?php echo $row['PNR']; ?>">
                                    <button type="submit" name="confirm_payment" class="button success">Confirm Payment</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
