<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "nairobi_commuters");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['train_name'])) {
    $train_name = $_GET['train_name'];

    // Query to get available seats for the selected train
    $stmt = $conn->prepare("SELECT seat_number FROM seats WHERE train_name = ? AND is_available = 1");
    $stmt->bind_param("s", $train_name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $seats = [];
    while ($row = $result->fetch_assoc()) {
        $seats[] = $row;
    }
    
    echo json_encode($seats);
    $stmt->close();
}

mysqli_close($conn);
?>
