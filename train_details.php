<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('includes/db.php'); // Database connection

// Add new train
if (isset($_POST['add_train'])) {
    $t_name = $_POST['t_name'];
    $t_source = $_POST['t_source'];
    $t_destination = $_POST['t_destination'];
    $t_type = $_POST['t_type'];
    $no_of_seats = $_POST['no_of_seats'];
    $t_duration = $_POST['t_duration'];
    $route = $_POST['route'];

    $addTrainQuery = $conn->prepare("INSERT INTO trains (t_name, t_source, t_destination, t_type, no_of_seats, t_duration, route) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $addTrainQuery->bind_param("ssssiss", $t_name, $t_source, $t_destination, $t_type, $no_of_seats, $t_duration, $route);
    $addTrainQuery->execute();
    $train_id = $conn->insert_id;

    // Add seats for this train
    for ($i = 1; $i <= $no_of_seats; $i++) {
        $seat_number = "S" . str_pad($i, 3, "0", STR_PAD_LEFT);
        $addSeatQuery = $conn->prepare("INSERT INTO seats (train_name, seat_number, is_available, train_id, t_no) VALUES (?, ?, 1, ?, ?)");
        $addSeatQuery->bind_param("ssii", $t_name, $seat_number, $train_id, $train_id);
        $addSeatQuery->execute();
    }

    echo "<script>alert('Train added successfully.'); window.location.href='train_details.php';</script>";
    exit();
}

// Edit train
if (isset($_POST['edit_train'])) {
    $t_no = $_POST['t_no'];
    $t_name = $_POST['t_name'];
    $t_source = $_POST['t_source'];
    $t_destination = $_POST['t_destination'];
    $t_type = $_POST['t_type'];
    $no_of_seats = $_POST['no_of_seats'];
    $t_duration = $_POST['t_duration'];
    $route = $_POST['route'];

    $editTrainQuery = $conn->prepare("UPDATE trains SET t_name = ?, t_source = ?, t_destination = ?, t_type = ?, no_of_seats = ?, t_duration = ?, route = ? WHERE t_no = ?");
    $editTrainQuery->bind_param("ssssissi", $t_name, $t_source, $t_destination, $t_type, $no_of_seats, $t_duration, $route, $t_no);
    $editTrainQuery->execute();
    echo "<script>alert('Train details updated successfully.'); window.location.href='train_details.php';</script>";
    exit();
}

// Delete train
if (isset($_POST['delete_train'])) {
    $t_no = $_POST['t_no'];
    $deleteSeatsQuery = $conn->prepare("DELETE FROM seats WHERE t_no = ?");
    $deleteSeatsQuery->bind_param("i", $t_no);
    $deleteSeatsQuery->execute();

    $deleteTrainQuery = $conn->prepare("DELETE FROM trains WHERE t_no = ?");
    $deleteTrainQuery->bind_param("i", $t_no);
    $deleteTrainQuery->execute();

    echo "<script>alert('Train and associated seats deleted successfully.'); window.location.href='train_details.php';</script>";
    exit();
}

// Fetch trains and seats
$trainQuery = "SELECT * FROM trains";
$trainResult = $conn->query($trainQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Details</title>
    <link rel="stylesheet" href="css/admin_panel.css">
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_panel.php">Dashboard</a>
        <a href="passenger_details.php">Passenger Details</a>
        <a href="station_details.php">Station Details</a>
        <a href="train_details.php" class="active">Train Details</a>
        <a href="reports.php">Reports</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <h1>Train Details</h1>

        <!-- Add Train Form -->
        <form method="POST" class="train-form">
            <h3>Add New Train</h3>
            <input type="text" name="t_name" placeholder="Train Name" required>
            <input type="text" name="t_source" placeholder="Source" required>
            <input type="text" name="t_destination" placeholder="Destination" required>
            <input type="text" name="t_type" placeholder="Train Type" required>
            <input type="number" name="no_of_seats" placeholder="Number of Seats" required>
            <input type="number" name="t_duration" placeholder="Duration (in minutes)" required>
            <input type="text" name="route" placeholder="Route" required>
            <button type="submit" name="add_train" class="button">Add Train</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Train No</th>
                    <th>Train Name</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Seats</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($train = $trainResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($train['t_no']); ?></td>
                        <td><?php echo htmlspecialchars($train['t_name']); ?></td>
                        <td><?php echo htmlspecialchars($train['t_source']); ?></td>
                        <td><?php echo htmlspecialchars($train['t_destination']); ?></td>
                        <td>
                            <?php
                            // Fetch seat availability for this train
                            $seatQuery = "SELECT seat_number, is_available FROM seats WHERE t_no = " . $train['t_no'];
                            $seatResult = $conn->query($seatQuery);
                            while ($seat = $seatResult->fetch_assoc()) {
                                $seat_status = $seat['is_available'] ? "Available" : "Booked";
                                echo $seat['seat_number'] . " - " . $seat_status . "<br>";
                            }
                            ?>
                        </td>
                        <td>
                            <!-- Edit Train -->
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="t_no" value="<?php echo $train['t_no']; ?>">
                                <input type="text" name="t_name" value="<?php echo $train['t_name']; ?>" required>
                                <input type="text" name="t_source" value="<?php echo $train['t_source']; ?>" required>
                                <input type="text" name="t_destination" value="<?php echo $train['t_destination']; ?>" required>
                                <input type="text" name="t_type" value="<?php echo $train['t_type']; ?>" required>
                                <input type="number" name="no_of_seats" value="<?php echo $train['no_of_seats']; ?>" required>
                                <input type="number" name="t_duration" value="<?php echo $train['t_duration']; ?>" required>
                                <input type="text" name="route" value="<?php echo $train['route']; ?>" required>
                                <button type="submit" name="edit_train" class="button">Edit</button>
                            </form>

                            <!-- Delete Train -->
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="t_no" value="<?php echo $train['t_no']; ?>">
                                <button type="submit" name="delete_train" class="button danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
