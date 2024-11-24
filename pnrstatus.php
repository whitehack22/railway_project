<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "nairobi_commuters");
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Function to check PNR status
function checkPNRStatus($conn, $pnr)
{
    $stmt = $conn->prepare("SELECT t_status FROM tickets WHERE PNR = ?");
    if (!$stmt) {
        return ['error' => 'SQL prepare failed: ' . $conn->error];
    }

    $stmt->bind_param("s", $pnr); // Use 's' for string PNR
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        return ['error' => 'Query failed: ' . $stmt->error];
    }

    $row = $result->fetch_assoc();
    $stmt->close();

    if ($row === null) {
        return ['message' => 'PNR not found. Please check your PNR.'];
    }

    return ['status' => $row['t_status']];
}

// Function to cancel ticket
function cancelTicket($conn, $pnr)
{
    $stmt = $conn->prepare("DELETE FROM tickets WHERE PNR = ?");
    if (!$stmt) {
        return ['error' => 'SQL prepare failed: ' . $conn->error];
    }

    $stmt->bind_param("s", $pnr); // Use 's' for string PNR
    if ($stmt->execute()) {
        $stmt->close();
        return ['message' => 'Your ticket has been successfully cancelled.'];
    } else {
        $stmt->close();
        return ['error' => 'Ticket cancellation failed. Please try again.'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pnr = trim($_POST['pnr']); // Sanitize input

    if (empty($pnr)) {
        echo "<script>alert('PNR is required.');</script>";
    } elseif (isset($_POST['submit'])) {
        // Check PNR status
        $response = checkPNRStatus($conn, $pnr);
        if (isset($response['error'])) {
            echo "<script>alert('Error: {$response['error']}');</script>";
        } elseif (isset($response['message'])) {
            echo "<script>alert('{$response['message']}');</script>";
        } else {
            echo "<script>alert('Your ticket status is: {$response['status']}');</script>";
        }
    } elseif (isset($_POST['cancel'])) {
        // Cancel ticket
        $response = cancelTicket($conn, $pnr);
        if (isset($response['error'])) {
            echo "<script>alert('Error: {$response['error']}');</script>";
        } else {
            echo "<script>alert('{$response['message']}');</script>";
        }
    }
}

// Close the database connection
mysqli_close($conn);
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
                    <input 
                        type="text" 
                        name="pnr" 
                        size="30" 
                        maxlength="10" 
                        placeholder="Enter PNR here" 
                        required 
                        pattern="[A-Za-z0-9]+" 
                        title="PNR should be alphanumeric (letters and/or numbers)"
                    />
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

    <script>
        // Confirm cancellation
        const cancelButton = document.querySelector('[name="cancel"]');
        if (cancelButton) {
            cancelButton.addEventListener('click', function (e) {
                if (!confirm('Are you sure you want to cancel this ticket?')) {
                    e.preventDefault();
                }
            });
        }
    </script>
</body>
</html>
