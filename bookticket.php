<?php 
session_start();

if (empty($_SESSION['user_info'])) {
    echo "<script type='text/javascript'>
            alert('Please login before proceeding further!');
            window.location.href='login.php';
          </script>";
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "nairobi_commuters");
if ($conn->connect_error) {
    echo "<script type='text/javascript'>
            alert('Database connection failed. Please try again later.');
            window.location.href='login.php';
          </script>";
    exit();
}

// Generate a unique PNR
function generatePNR() {
    return substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
}

if (isset($_POST['submit'])) {
    $train_name = $_POST['trains'];
    $seat_number = $_POST['seats'];
    $email = $_SESSION['user_info'];

    // Check seat availability
    $seat_check_stmt = $conn->prepare("SELECT is_available FROM seats 
                                       WHERE t_no = (SELECT t_no FROM trains WHERE t_name = ?) 
                                       AND seat_number = ?");
    $seat_check_stmt->bind_param("ss", $train_name, $seat_number);
    $seat_check_stmt->execute();
    $seat_result = $seat_check_stmt->get_result();

    if ($seat_result && $seat_row = $seat_result->fetch_assoc()) {
        if ($seat_row['is_available'] == 0) {
            echo "<script type='text/javascript'>
                    alert('Seat is already booked. Please choose another seat.');
                    window.location.href='book_ticket.php';
                  </script>";
            exit();
        }
    } else {
        echo "<script type='text/javascript'>
                alert('Invalid seat selection. Please try again.');
                window.location.href='book_ticket.php';
              </script>";
        exit();
    }
    $seat_check_stmt->close();

    // Generate unique PNR
    do {
        $pnr = generatePNR();
        $check_stmt = $conn->prepare("SELECT PNR FROM passengers WHERE PNR = ?");
        $check_stmt->bind_param("s", $pnr);
        $check_stmt->execute();
        $check_stmt->store_result();
    } while ($check_stmt->num_rows > 0);
    $check_stmt->close();

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Update seat as booked
        $update_seat_stmt = $conn->prepare("UPDATE seats 
                                            SET is_available = 0, passenger_email = ? 
                                            WHERE t_no = (SELECT t_no FROM trains WHERE t_name = ?) 
                                            AND seat_number = ?");
        $update_seat_stmt->bind_param("sss", $email, $train_name, $seat_number);
        $update_seat_stmt->execute();
        $update_seat_stmt->close();

        // Insert passenger details
        $insert_passenger_stmt = $conn->prepare(
            "INSERT INTO passengers (email, t_no, seat_number, PNR, payment_status) 
             VALUES (?, (SELECT t_no FROM trains WHERE t_name = ?), ?, ?, 'Pending')"
        );
        $insert_passenger_stmt->bind_param("ssss", $email, $train_name, $seat_number, $pnr);
        $insert_passenger_stmt->execute();
        $insert_passenger_stmt->close();

        // Commit transaction
        $conn->commit();

        // Redirect to payment page
        $_SESSION['pnr'] = $pnr;
        header("Location: payment.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script type='text/javascript'>
                alert('Transaction failed. Please try again.');
                window.location.href='book_ticket.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book a Ticket</title>
    <link rel="stylesheet" href="style.css">
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background: url('img/bg7.webp') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
        }
        #booktkt {
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }
        #text {
            text-align: center;
            font-size: 2rem;
            font-family: "Comic Sans MS", cursive, sans-serif;
            margin-bottom: 20px;
        }
        select {
            display: block;
            margin: 15px auto;
            width: 90%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            border: none;
            background: #fff;
            color: #333;
        }
        #submit {
            display: block;
            margin: 20px auto;
            padding: 10px 25px;
            background: #00bfff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        #submit:hover {
            background: #007acc;
        }
        @media (max-width: 600px) {
            #booktkt {
                width: 95%;
                padding: 20px;
            }
            #text {
                font-size: 1.5rem;
            }
            select, #submit {
                width: 100%;
                font-size: 1rem;
            }
        }
    </style>
    <script type="text/javascript">
        function validate() {
            const trains = document.getElementById("trains");
            const seats = document.getElementById("seats");
            if (trains.selectedIndex === 0) {
                alert("Please select a train.");
                trains.focus();
                return false;        
            }
            if (seats.selectedIndex === 0) {
                alert("Please select a seat.");
                seats.focus();
                return false;
            }
            return true;
        }

        
        function fetchSeats(trainName) {
            if (!trainName) return;
            fetch(`fetch_seats.php?train_name=${encodeURIComponent(trainName)}`)
                .then(response => response.json())
                .then(data => {
                    const seatsDropdown = document.getElementById("seats");
                    seatsDropdown.innerHTML = '<option selected disabled>-- Select seat --</option>';
                    data.forEach(seat => {
                        const option = document.createElement("option");
                        option.value = seat.seat_number;
                        option.textContent = seat.seat_number;
                        seatsDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching seats:', error));
        }
    </script>
</head>
<body>
    <?php include('header.php'); ?>
    <div id="booktkt">
        <h1 id="text">Choose Your Journey</h1>
        <form method="post" onsubmit="return validate()">
            <select id="trains" name="trains" onchange="fetchSeats(this.value)" required>
                <option selected disabled>-- Select a Train --</option>
                <option value="Express A">Express A - Embakasi Village to Ruiru</option>
                <option value="Commuter X">Commuter X - Syokimau to Embakasi Village</option>
            </select>
            <select id="seats" name="seats" required>
                <option selected disabled>-- Select a Seat --</option>
                
            </select>
            <button type="submit" name="submit" id="submit">Submit</button>
        </form>
    </div>
</body>
</html>
