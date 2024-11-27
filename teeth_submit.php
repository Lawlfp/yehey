<?php
session_start();
if (isset($_GET['patientid'])) {
    $_SESSION['patientid'] = $_GET['patientid'];  // Save patientid in session if it's passed in the URL
}
$servername = "localhost"; // e.g., "localhost"
$username = "root";
$password = "";
$dbname = "dbdental";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
	$patientid=$_GET["patientid"];
    $tooth_number = $_POST['tooth_number'];
    $issue = $_POST['issue'];
    $date = $_POST['date'];
    $other = isset($_POST['other']) ? $_POST['other'] : null; // Optional "Other" field
    $note = isset($_POST['note']) ? $_POST['note'] : null; // Optional note field

    // Database connection (ensure this is correct)
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO teeth (patientid, tooth_number, issue, date, other) VALUES (?, ?, ?, ?, ?)");
    // Assuming patient ID is available in session or passed to the script
     // Example: Get patient ID from session

    $stmt->bind_param("iisss", $patientid, $tooth_number, $issue, $date, $other);
	$id=$patientid;
    // Execute and check for success
    if ($stmt->execute()) {
        echo "Record saved successfully.";
        echo "<script>
                alert('New teeth history submitted successfully!');
                window.location.href = 'patientrec.php?id=$id&patientid=$id'; // Redirect with patient ID
          </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>