<?php
session_start();

$uname = $_SESSION['username'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbdental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pass = $_POST['password'];

    // Corrected query syntax
    $countQuery = "SELECT id FROM login WHERE username='$uname' AND password='$pass'";

    $resulta = $conn->query($countQuery);
    if ($resulta->num_rows > 0) {
        $row = $resulta->fetch_assoc(); // Fetch the result as an associative array
        $id = $row['id']; // Retrieve the 'id' column

        // Query to fetch the doctor's lastName and Expertise
        $doctorQuery = "
            SELECT lastName, Expertise 
            FROM doctors 
            WHERE doctor_id = (
                SELECT doctor_id 
                FROM login 
                WHERE id = '$id'
            )
        ";

        $doctorResult = $conn->query($doctorQuery);
        if ($doctorResult->num_rows > 0) {
            $doctorData = $doctorResult->fetch_assoc();
            $_SESSION['doctor_lastName'] = $doctorData['lastName']; // Store lastName in session
            $_SESSION['doctor_expertise'] = $doctorData['Expertise']; // Store Expertise in session

            echo "<script>
                        alert('Success!');
                        window.location.href = 'dash.php?id=$id'; // Redirect to dashboard with ID
                  </script>";
        } else {
            echo "<script>
                        alert('Doctor details not found.');
                        window.location.href = 'login.html'; // Redirect to login page
                  </script>";
        }
    } else {
        echo "<script>
                    alert('Wrong Password');
                    window.location.href = 'login.html'; // Redirect to login page
              </script>";
    }
}
?>
