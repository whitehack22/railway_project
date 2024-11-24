<?php
session_start();

// Validate session and post variables
if (empty($_SESSION['pnr']) || empty($_POST['payment_method'])) {
    echo "<script type='text/javascript'>
            alert('Invalid payment process.');
            window.location.href='book_ticket.php';
          </script>";
    exit();
}

// Assign variables
$pnr = $_SESSION['pnr'];
$payment_method = $_POST['payment_method'];
$p_id = $_SESSION['p_id'] ?? null;  // Ensure this is set when the user logs in

// Check if p_id is valid
if (empty($p_id)) {
    echo "<script type='text/javascript'>
            alert('Invalid user session. Please log in again.');
            window.location.href='login.php';
          </script>";
    exit();
}

try {
    // Enable exceptions for mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Connect to the database
    $conn = new mysqli("localhost", "root", "", "nairobi_commuters");

    // Begin transaction
    $conn->begin_transaction();

    // 1. Check if ticket already exists
    $check_ticket_stmt = $conn->prepare("SELECT PNR FROM tickets WHERE PNR = ?");
    $check_ticket_stmt->bind_param("s", $pnr);  // Bind PNR as a string
    $check_ticket_stmt->execute();
    $check_ticket_stmt->store_result();

    if ($check_ticket_stmt->num_rows > 0) {
        // If the ticket already exists, no need to insert again, just update the status.
        echo "<script type='text/javascript'>
                alert('Payment already processed for this ticket.');
                window.location.href='ticket_details.php?pnr=" . urlencode($pnr) . "';
              </script>";
        exit();
    }
    $check_ticket_stmt->close();

    // 2. Update payment status in the passengers table
    $update_payment_stmt = $conn->prepare("UPDATE passengers SET payment_status = 'Completed' WHERE PNR = ?");
    $update_payment_stmt->bind_param("s", $pnr);  // Bind PNR as a string
    $update_payment_stmt->execute();

    // 3. Fetch ticket fare for the passenger
    $ticket_fare_query = $conn->prepare("SELECT t_fare FROM tickets WHERE PNR = ? LIMIT 1");
    $ticket_fare_query->bind_param("s", $pnr);  // Bind PNR as a string
    $ticket_fare_query->execute();
    $ticket_fare_query->store_result();

    if ($ticket_fare_query->num_rows == 0) {
        throw new Exception("Ticket not found for the provided PNR");
    }

    $ticket_fare_query->bind_result($t_fare);
    $ticket_fare_query->fetch();

    // 4. Insert ticket information into the tickets table (if not already done)
    $insert_ticket_stmt = $conn->prepare("INSERT INTO tickets (PNR, t_status, t_fare, p_id, booking_date) VALUES (?, 'Paid', ?, ?, NOW())");
    $insert_ticket_stmt->bind_param("sii", $pnr, $t_fare, $p_id);  // Bind PNR as a string and other fields as appropriate
    $insert_ticket_stmt->execute();

    // Commit the transaction if everything goes well
    $conn->commit();

    // Close the prepared statements
    $update_payment_stmt->close();
    $ticket_fare_query->close();
    $insert_ticket_stmt->close();
    $conn->close();

    // Redirect to ticket details page with success message
    echo "<script type='text/javascript'>
            alert('Payment successful! Your ticket is booked.');
            window.location.href='ticket_details.php?pnr=" . urlencode($pnr) . "';
          </script>";
    exit();
} catch (Exception $e) {
    // Roll back the transaction in case of any error
    if (isset($conn)) {
        $conn->rollback();
    }

    // Display error message
    echo "<script type='text/javascript'>
            alert('Payment failed: " . htmlspecialchars($e->getMessage(), ENT_QUOTES) . "');
            window.location.href='payment.php';
          </script>";

    // Ensure resources are properly closed
    if (isset($update_payment_stmt)) $update_payment_stmt->close();
    if (isset($ticket_fare_query)) $ticket_fare_query->close();
    if (isset($insert_ticket_stmt)) $insert_ticket_stmt->close();
    if (isset($conn)) $conn->close();
}
?>

