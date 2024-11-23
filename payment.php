<?php
session_start();


if (empty($_SESSION['pnr'])) {
    echo "<script type='text/javascript'>
            alert('No booking found. Please book a ticket first.');
            window.location.href='book_ticket.php';
          </script>";
    exit();
}

$pnr = $_SESSION['pnr'];

?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background: url('img/bg7.webp') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
        }
        #payment {
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        select, input[type="radio"] {
            margin: 15px 0;
            padding: 10px;
            width: 90%;
            font-size: 1rem;
            border-radius: 5px;
            border: none;
        }
        #pay {
            padding: 10px 25px;
            background: #28a745;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        #pay:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div id="payment">
        <h1>Payment</h1>
        <p>Your PNR: <strong><?php echo htmlspecialchars($pnr); ?></strong></p>
        <form method="post" action="process_payment.php">
            <label for="payment_method">Choose Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option selected disabled>-- Select Payment Method --</option>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="mobile_money">Mobile Money</option>
            </select>
            <button type="submit" name="pay" id="pay">Pay Now</button>
        </form>
    </div>
</body>
</html>
