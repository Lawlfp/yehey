<?php
// Establish connection using mysqli
$servername = "localhost"; // e.g., "localhost"
$username = "root";
$password = "";
$dbname = "dbdental";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
