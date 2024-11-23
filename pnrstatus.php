<?php
session_start();


$conn = mysqli_connect("localhost", "root", "", "nairobi_commuters");
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}


if (isset($_POST['submit'])) {
    $pnr = intval($_POST['pnr']); 

    if (empty($pnr)) {
        echo "<script type='text/javascript'>alert('PNR is required to check status.');</script>";
    } else {
        $stmt = $conn->prepare("SELECT t_status FROM tickets WHERE PNR = ?");
        if (!$stmt) {
            die('SQL prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("i", $pnr); 
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die('Query failed: ' . $stmt->error);
        }

        $row = $result->fetch_assoc();

        if ($row == NULL) {
            echo "<script type='text/javascript'>alert('PNR not found. Please check your PNR.');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Your ticket status is: {$row['t_status']}');</script>";
        }
        $stmt->close();
    }
}


if (isset($_POST['cancel'])) {
    $pnr = intval($_POST['pnr']); 

    if (empty($pnr)) {
        echo "<script type='text/javascript'>alert('PNR is required to cancel a ticket.');</script>";
    } else {
        $stmt = $conn->prepare("DELETE FROM tickets WHERE PNR = ?");
        if (!$stmt) {
            die('SQL prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("i", $pnr); 
        if ($stmt->execute()) {
            echo "<script type='text/javascript'>alert('Your ticket has been successfully cancelled.');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Ticket cancellation failed. Please try again.');</script>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nairobi Commuters PNR Status</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #pnr {
            font-size: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            width: 500px;
            margin: auto;
            border-radius: 25px;
            border: 2px;
            position: absolute;
            left: 0;
            right: 0;
            padding: 20px;
            margin-top: 130px;
        }
        html {
            background: url(img/bg7.webp) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        .button {
            background-color: #00bfff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button:hover {
            background-color: orange;
        }
    </style>
</head>
<body>
    <?php include("header.php"); ?>

    <center>
        <div id="pnr">
            <strong style="color: white;">Check your Nairobi Commuters Railway PNR status:</strong><br/><br/>

            
            <form method="post" action="pnrstatus.php">
                <div id="pnrtext">
                    <input type="text" name="pnr" size="30" maxlength="10" placeholder="Enter PNR here" required>
                </div>
                <br/>
                <input type="submit" name="submit" value="Check Status" class="button"><br/><br/>

                <?php if (isset($_SESSION['user_info'])): ?>
                    <input type="submit" name="cancel" value="Cancel Ticket" class="button">
                <?php else: ?>
                    <a href="register.php" style="color: white;">Login/Register</a>
                <?php endif; ?>
            </form>
        </div>
    </center>
</body>
</html>
