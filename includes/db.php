<?php
// Database connection settings
$servername = "localhost";
$username = "root";   // Replace with your MySQL username
$password = "";       // Replace with your MySQL password
$dbname = "nairobi_commuters";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
