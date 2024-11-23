<?php
session_start();


if (empty($_SESSION['pnr']) || empty($_POST['payment_method'])) {
    echo "<script type='text/javascript'>
            alert('Invalid payment process.');
            window.location.href='book_ticket.php';
          </script>";
    exit();
}

$pnr = $_SESSION['pnr'];
$payment_method = $_POST['payment_method'];

$conn = mysqli_connect("localhost", "root", "", "nairobi_commuters");
if (!$conn) {  
    die("<script type='text/javascript'>
            alert('Database connection failed');
            window.location.href='payment.php';
         </script>");
}

if (isset($_POST['pay'])) {
    

   
    $update_payment_stmt = $conn->prepare("UPDATE passengers SET payment_status = 'Paid' WHERE PNR = ?");
    $update_payment_stmt->bind_param("s", $pnr);
    
    if ($update_payment_stmt->execute()) {
        echo "<script type='text/javascript'>
                alert('Payment successful! Your ticket is booked.');
                window.location.href='ticket_details.php?pnr=" . urlencode($pnr) . "';
              </script>";
        exit();
    } else {
        echo "<script type='text/javascript'>
                alert('Payment failed. Please try again.');
                window.location.href='payment.php';
              </script>";
    }
    $update_payment_stmt->close();
}
?>
