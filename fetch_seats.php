<?php
$conn = new mysqli("localhost", "root", "", "nairobi_commuters");

if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['train_name'])) {
    $train_name = $_GET['train_name'];
    $stmt = $conn->prepare("
        SELECT seat_number 
        FROM seats 
        WHERE t_no = (SELECT t_no FROM trains WHERE t_name = ?) 
        AND is_available = 1
    ");
    $stmt->bind_param("s", $train_name);
    $stmt->execute();
    $result = $stmt->get_result();

    $seats = [];
    while ($row = $result->fetch_assoc()) {
        $seats[] = $row;
    }

    echo json_encode($seats ?: [["seat_number" => "No seats available"]]);
    $stmt->close();
}

$conn->close();
?>

