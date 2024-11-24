<?php
$conn = new mysqli("localhost", "root", "", "nairobi_commuters");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT t_name FROM trains");

$trains = [];
while ($row = $result->fetch_assoc()) {
    $trains[] = $row;
}

echo json_encode($trains);
?>
