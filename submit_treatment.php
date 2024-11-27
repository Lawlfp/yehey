<?php
session_start(); // Start session at the top
$doctor_id=$_SESSION["doctor_id"];

if (isset($_SESSION['patientid'])) {
    $patientid=$_SESSION['patientid'];
}
if(isset($_GET['patientid'])){
	$patientid=$_GET['patientid'];	
}


$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "dbdental";

// Establish database connection
$databaseConnection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check connection status
if ($databaseConnection->connect_error) {
    die("Connection failed: " . $databaseConnection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $treatmentName = $_POST['treatmentName'];
    $treatmentDate = $_POST['treatmentDate'];
     // Use lowercase patientid

    // Check if data is valid (simple validation)
    if (!empty($treatmentName) && !empty($treatmentDate) && !empty($patientid)) {
        // Prepare SQL query to insert a new treatment record
        $insertQuery = "INSERT INTO `treatment` (`treatmentName`, `treatmentDate`, `patientid`) VALUES (?, ?, ?)"; // Use lowercase patientid
        $insertStatement = $databaseConnection->prepare($insertQuery);
        $insertStatement->bind_param("sss", $treatmentName, $treatmentDate, $patientid); // Use lowercase patientid

        // Execute the query
        if ($insertStatement->execute()) {
            echo "<script>
                    alert('New treatment created successfully!');
                    window.location.href = 'treatmentedit.php?patientid=$patientid&id=$patientid'; // Adjust to your treatment editing page
                  </script>";
        } else {
            echo "<script>
                    alert('Error creating treatment: " . $databaseConnection->error . "');
                  </script>";
        }

        // Close statement
        $insertStatement->close();
    } else {
        echo "<script>
                alert('Please fill in all required fields.');
              </script>";
    }
}

// Close database connection
$databaseConnection->close();
?>
