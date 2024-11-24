<?php
session_start();
include("header.php");

if (!isset($_GET['pnr'])) {
    echo "<script type='text/javascript'>
            alert('No ticket found.');
            window.location.href='book_ticket.php';
          </script>";
    exit();
}

$pnr = $_GET['pnr'];

// Database connection
$conn = mysqli_connect("localhost", "root", "", "nairobi_commuters");
if (!$conn) {  
    die("<script type='text/javascript'>
            alert('Database connection failed');
            window.location.href='book_ticket.php';
         </script>");
}

// Query to fetch ticket details, including information from the `tickets` table
$stmt = $conn->prepare("
    SELECT 
        p.PNR, 
        p.email, 
        p.seat_number, 
        p.payment_status, 
        t.t_name, 
        t.route,
        tk.t_status,
        tk.t_fare
    FROM passengers p
    JOIN trains t ON p.t_no = t.t_no
    JOIN tickets tk ON p.PNR = tk.PNR
    WHERE p.PNR = ?
");
$stmt->bind_param("s", $pnr);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    // Data successfully fetched
} else {
    echo "<script type='text/javascript'>
            alert('Ticket not found.');
            window.location.href='book_ticket.php';
          </script>";
    exit();
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ticket Details</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background: url('img/bg7.webp') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
        }
        #ticket {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 15px;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 2rem;
        }
        p {
            font-size: 1.2rem;
            margin: 10px 0;
        }
        .details {
            text-align: left;
            margin: 20px auto;
            width: 80%;
        }
    </style>
</head>
<body>
    <div id="ticket">
        <h1>Your Ticket</h1>
        <div class="details">
            <p><strong>PNR:</strong> <?php echo htmlspecialchars($row['PNR']); ?></p>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
            <p><strong>Train:</strong> <?php echo htmlspecialchars($row['t_name']); ?></p>
            <p><strong>Route:</strong> <?php echo htmlspecialchars($row['route']); ?></p>
            <p><strong>Seat Number:</strong> <?php echo htmlspecialchars($row['seat_number']); ?></p>
            <p><strong>Payment Status:</strong> <?php echo htmlspecialchars($row['payment_status']); ?></p>
            <p><strong>Ticket Status:</strong> <?php echo htmlspecialchars($row['t_status']); ?></p>
            <p><strong>Fare:</strong> Ksh <?php echo htmlspecialchars($row['t_fare']); ?></p>
        </div>
        <p>Thank you for booking with Nairobi Commuters Railways!</p>
    </div>
</body>
</html>
