<?php
session_start();
$_SESSION["patientid"] = $_GET["patientid"];
$patientid = $_SESSION["patientid"];

$servername = "localhost"; // e.g., "localhost"
$username = "root";
$password = "";
$dbname = "dbdental";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $note = $_POST['note'];
    
    // Database connection (ensure this is correct)
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Check if there is an existing note for this patient
    $sqlt = "SELECT patientid, note FROM teethnote WHERE patientid = $patientid";
    $result = $conn->query($sqlt);
    
    if ($result->num_rows > 0) {
        // If the note exists, update it
        $sql = "UPDATE teethnote SET note = '$note' WHERE patientid = $patientid";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('Note updated successfully!');
                window.location.href = 'patientrec.php?id=$patientid&patientid=$patientid'; // Adjust to your treatment editing page
            </script>";
        } else {
            echo "<script>
                alert('Error updating note!');
            </script>";
        }
    } else {
        // If no note exists, insert a new record
        $sql = "INSERT INTO teethnote (note, patientid) VALUES ('$note', $patientid)";
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                alert('Note saved successfully!');
                window.location.href = 'patientrec.php?id=$patientid&patientid=$patientid'; // Adjust to your treatment editing page
            </script>";
        } else {
            echo "<script>
                alert('Error saving note!');
            </script>";
        }
    }

    $conn->close();
}
?>
