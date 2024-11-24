<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('includes/db.php'); // Include database connection

// Add new station
if (isset($_POST['add_station'])) {
    $s_name = $_POST['s_name'];
    $s_no_of_platforms = $_POST['s_no_of_platforms'];

    $addStationQuery = $conn->prepare("INSERT INTO station (s_name, s_no_of_platforms) VALUES (?, ?)");
    $addStationQuery->bind_param("si", $s_name, $s_no_of_platforms);
    $addStationQuery->execute();
    $addStationQuery->close();

    echo "<script>alert('Station added successfully.'); window.location.href='station_details.php';</script>";
    exit();
}

// Edit a station
if (isset($_POST['edit_station'])) {
    $s_no = $_POST['s_no'];
    $s_name = $_POST['s_name'];
    $s_no_of_platforms = $_POST['s_no_of_platforms'];

    $editStationQuery = $conn->prepare("UPDATE station SET s_name = ?, s_no_of_platforms = ? WHERE s_no = ?");
    $editStationQuery->bind_param("sii", $s_name, $s_no_of_platforms, $s_no);
    $editStationQuery->execute();
    $editStationQuery->close();

    echo "<script>alert('Station updated successfully.'); window.location.href='station_details.php';</script>";
    exit();
}

// Delete a station
if (isset($_POST['delete_station'])) {
    $s_no = $_POST['s_no'];
    $deleteStationQuery = $conn->prepare("DELETE FROM station WHERE s_no = ?");
    $deleteStationQuery->bind_param("i", $s_no);
    $deleteStationQuery->execute();
    $deleteStationQuery->close();

    echo "<script>alert('Station deleted successfully.'); window.location.href='station_details.php';</script>";
    exit();
}

// Fetch stations
$stationQuery = "SELECT * FROM station";
$stationResult = $conn->query($stationQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Station Details</title>
    <link rel="stylesheet" href="css/admin_panel.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="admin_panel.php">Dashboard</a>
        <a href="passenger_details.php">Passenger Details</a>
        <a href="station_details.php" class="active">Station Details</a>
        <a href="train_details.php">Train Details</a>
        <a href="reports.php">Reports</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="content">
        <h1>Station Details</h1>

        <!-- Add Station Form -->
        <form method="POST" class="station-form">
            <h3>Add New Station</h3>
            <input type="text" name="s_name" placeholder="Station Name" required>
            <input type="number" name="s_no_of_platforms" placeholder="Number of Platforms" required min="1" max="99">
            <button type="submit" name="add_station" class="button">Add Station</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Station Number</th>
                    <th>Station Name</th>
                    <th>Number of Platforms</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stationResult->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['s_no']); ?></td>
                        <td><?php echo htmlspecialchars($row['s_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['s_no_of_platforms']); ?></td>
                        <td>
                            <!-- Edit Station -->
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="s_no" value="<?php echo $row['s_no']; ?>">
                                <input type="text" name="s_name" value="<?php echo $row['s_name']; ?>" required>
                                <input type="number" name="s_no_of_platforms" value="<?php echo $row['s_no_of_platforms']; ?>" required min="1" max="99">
                                <button type="submit" name="edit_station" class="button">Edit</button>
                            </form>
                            
                            <!-- Delete Station -->
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="s_no" value="<?php echo $row['s_no']; ?>">
                                <button type="submit" name="delete_station" class="button danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>
