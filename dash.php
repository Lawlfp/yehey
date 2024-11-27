<?php
session_start();
// Check if the session variables are set
if (isset($_SESSION['doctor_lastName']) && isset($_SESSION['doctor_expertise'])) {
    $last = $_SESSION['doctor_lastName'];
    $exp = $_SESSION['doctor_expertise'];
} else {
    // Handle the case where session variables are not set
    echo "<script>
            alert('Session variables are not set. Please log in again.');
            window.location.href = 'login.html'; // Redirect to login page
          </script>";
    exit; // Prevent further script execution
}

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
} elseif (isset($_POST["id"])) {
    $id = intval($_POST["id"]);
} elseif (isset($_SESSION["id"])) {
    $id = intval($_SESSION["id"]);
}

if ($id === null) {
    die("ID is not set or invalid.");
}
if(isset($_SESSION["id"])){
	$_SESSION["id"]=$id;
}
$doctor_id=$_SESSION["doctor_id"];
$_SESSION["doctor_id"]=$id;

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

$sql="SELECT * FROM doctors WHERE doctor_id=$id";
$sql2="SELECT * FROM login WHERE id=$id";
$result = $conn->query($sql);
$result1 = $conn->query($sql2);

$resultz = $conn->query("SELECT * FROM `login` WHERE id=$id");

    if ($resultz && $row = $resultz->fetch_assoc()) {
        // Set the background image URL using data URI
        $imageData = base64_encode($row['image']);
        $backgroundImageURL = 'data:image/jpeg;base64,' . $imageData;
    } else {
        $backgroundImageURL = ''; // Default to an empty string if no image is available
    }
	
	
$countQuery = "SELECT COUNT(doctor_id) AS total_doctors FROM doctors";
$resulta = $conn->query($countQuery);

$totalDoctors = 0;

if ($resulta->num_rows > 0) {
    // Output data of each row
    while ($row = $resulta->fetch_assoc()) {
        $totalDoctors = $row["total_doctors"];
    }
} else {
    
}


$today = date("Y-m-d");

// SQL query to count records with the same date as today
$sql = "SELECT COUNT(*) as count_today FROM bookings WHERE DATE(preferredDateTime) = '$today'";

$resultx = $conn->query($sql);

$countToday = 0; // Initialize variable

if ($resultx->num_rows > 0) {
    // Fetch the result
    $row = $resultx->fetch_assoc();
    

    $countToday = $row['count_today'];
} else {

}

$sql = "SELECT `id`, `firstName`, `middleName`, `lastName`, `birthdate`, `sex`, `contactNumber`, `email`, `address`, `doctorid`, `lastDiagnosis` FROM `patient` WHERE `doctorid` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id); // "i" denotes the doctor id is an integer
$stmt->execute();
$result = $stmt->get_result();

// Get total number of patients for display
$total_patients = $result->num_rows;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Split Centered Container</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Anton:wght@400;700&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Content:wght@400;700&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap');
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
           overflow-x:hidden;
        }
		span{
		margin:0;
		padding:0;
		}
        .left-container {
    width: 10.7%;
    height: 100%;
    background: linear-gradient(to bottom, #0C3B67, #2CA6B6);
    box-shadow: 4px 0px 4px 0px rgba(0, 0, 0, 0.25);
    z-index: 9; /* Bring the left container in front */
    display: flex;
    flex-direction: column; /* Stack items vertically */
    align-items: center; /* Center items horizontally */
    position:fixed;
	overflow:hidden;
	
    color: white; /* Text color for better visibility */
}
		.picture{
		width: 25px;
		height: 25px;
		border-radius: 85px;
		margin-top:11px;
//background: url(<path-to-image>), lightgray 50% / cover no-repeat;//
		}
		
		.pictext1{
		color: #FFF;
text-align: center;
font-family: Amiri;
font-size: 20px;
font-style: normal;
font-weight: normal;
line-height: normal;
margin-top:6px;
		}
		.pictext2{
		color: #FFF;
text-align: center;
font-family: Amiri;
font-size: 15px;
font-style: normal;
margin-top:-12px;
line-height: normal;
		}
        .right-container {
            width: 100%;
            
            display: flex;
            flex-direction: column; /* Stack top and bottom sections vertically */
			
        }
        .top-section {
			width:100%;
			position:fixed;
            height:	9.1%;	
            background: linear-gradient(to right, #0C3C68, #2DA6B6);
			
            z-index: 8; /* Send the top section to the back */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bottom-section {
             display: flex;
  flex-direction: row; /* Default: left to right */
            background-color: white;
            
        }

		
		.logotext{
		color: #FFF;
text-align: center;
font-family: Anton;
font-size: 20px;
font-style: normal;
font-weight: 400;
line-height: normal;
margin-top: -1px;
		}
		

		.margintop {
			margin-top:20px;
			width:100%;
			height:100%;
        }
        

        
		
		hr{
		background-color:white;
		width:76%;
		margin-top:9px;
		}
		/* ... Existing styles ... */
#notactive{
	border-color:transparent;
}
#active{
	border-color:white;
}
.dashboard1st {
text-decoration:none;
    width: 98%;
    height: 3%;
    margin-top: 3px;
    border-left: 5px;
    border-style: solid;
    border-right: 0px;
    border-top: 0px;
    border-bottom: 0px;
    display: flex;
    align-items: center; /* Align items vertically center */
}
.dashboard2 {
text-decoration:none;
    width: 98%;
    height: 3%;
    margin-top: 17px;
    border-left: 5px;
    border-style: solid;
    border-right: 0px;
    border-top: 0px;
    border-bottom: 0px;
    display: flex;
    align-items: center; /* Align items vertically center */
}
.dashboard3 {
text-decoration:none;
    width: 98%;
    height: 3%;
    margin-top: 17px;
    border-left: 5px;
    border-style: solid;
    border-right: 0px;
    border-top: 0px;
    border-bottom: 0px;
    display: flex;
    align-items: center; /* Align items vertically center */
}
.dashboard3 {
text-decoration:none;
    width: 98%;
    height: 3%;
    margin-top: 20px;
    border-left: 5px;
    border-style: solid;
    border-right: 0px;
    border-top: 0px;
    border-bottom: 0px;
    display: flex;
    align-items: center; /* Align items vertically center */
}
.dashboard4 {
text-decoration:none;
    width: 98%;
    height: 3%;
    margin-top: 2px;
    border-left: 5px;
    border-style: solid;
    border-right: 0px;
    border-top: 0px;
    border-bottom: 0px;
    display: flex;
    align-items: center; /* Align items vertically center */
}
.dashboard5 {
text-decoration:none;
    width: 98%;
    height: 3%;
    margin-top: 20px;
    border-left: 5px;
    border-style: solid;
    border-right: 0px;
    border-top: 0px;
    border-bottom: 0px;
    display: flex;
    align-items: center; /* Align items vertically center */
}
.icons {
    margin-left: 30px;
	width:20px;
	height:20px;
}

.dashtext {
	
	display:block;
    color: #FFF;
    font-family: Anton;
    font-size: 0.98rem;
	
    font-weight: 400 !important;
	transform: scaleX(1.1) scaleY(1);
    margin-left: 21px; /* Add some space between icon and text */
}

.dashboard6 {
text-decoration:none;
    width: 98%;
    height: 5%;
    margin-top: 450px;
    border-left: 5px;
    border-style: solid;
    border-right: 0px;
    border-top: 0px;
    border-bottom: 0px;
    display: block; 
	text-align: center;
    align-items: center; /* Align items vertically center */
	
}
.dashtextlogout {
	
    color: #FFFFFF;
    font-family: Content;
    font-size: 15px;

    line-height: normal;
    margin-left: 10px; /* Add some space between icon and text */
}
.logouticons {
vertical-align: middle;
margin-left:0px;
	width:19px;
	height:22px;
}
.fullbody{
	position:absolute;
	top:107px;
	left:205px;
	width:100%;
	height:100%;
	margin-top:0;
	display: flex;
    flex-direction: column;
	
}
.patientcontainer{
	width:30%;
	height:80%;
	position:absolute;
	background:#FFFFFF;
	border-radius:7px;
	left:240px;
	top:150px;
	
	
}

.patientcontainer2{
	width:369px;
	height:272px;
	position:absolute;
	background:#FFFFFF;
	border-radius:10px;
	left:150px;
	top:160px;
	
	box-shadow: 1px 1px #ABABAB;
	
	transform:scale(1.5);
}
.flexcontainernoline{
	display:flex;
margin-top:15px;
}

.flexcontainernoline span{
	font-family:Roboto;
	font-size:12px;
	font-weight:bold;

}
.flexcontainer1{
display:flex;
}
.smallicons{
	width:16px;
	height:16px;
	position:relative;
}
.flexcontainergrey{
display:flex;
margin-top:6px;
}
.flexcontainergrey span{
font-family:Roboto;
font-size:11px;
font-weight:bold;
color:#969696;
}

.flexcontainernoline input{
font-family:Roboto;
font-size:11px;
font-weight:bold;

outline:none;
border:none;
}
.leftalign{
	margin-left:34px;
	width:193px;
}
.aligninput{
width:188px;
margin-left:35px;
}
.align{
width:193px;
margin-left:35px;
}
.box2 {
			
            margin-left: 40px;
            width: 250px;
            height: 142px;
            background: linear-gradient(to right, #0C3C68, #2DA6B6);
            border-radius: 10px;
            position: absolute; /* Add relative positioning */
			
        }
		
.text2 {
            position: absolute; /* Change to absolute positioning */
            top: 68%;
            transform: translateY(-50%);
            color: #FFF;
            text-shadow: 0px 4px 0px rgba(0, 0, 0, 0.25);
            font-family: Anton;
            font-size: 25px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            letter-spacing: 2.5px;
            margin-left: 19px;
        }		
		
.ellipse-wrapper {
			
            width: 160px;
            height: 144px;
            position: relative; /* Change to absolute positioning */
            filter: drop-shadow(4px 4px 0px rgba(0, 0, 0, 1));
            top: -2%; /* Adjust these values according to your layout needs */
            left: 69%;

            z-index: 3; /* Increase z-index to bring it to the front */
        }
.ellipse-2 {
            background: #86caf9;
            border-radius: 50%;
            width: 100%;
            height: 100%;
            clip-path: polygon(0% 0%, 50% 0%, 50% 100%, 0% 100%);
            z-index: 3; /* Make sure it matches the z-index of .ellipse-wrapper */
        }	
.text {
            position: absolute; /* Change to absolute positioning */
            top: 35%;
            transform: translateY(-50%);
            color: #FFF;
            text-shadow: 0px 4px 0px rgba(0, 0, 0, 0.25);
            font-family: Anton;
            font-size: 25px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
            letter-spacing: 2.5px;
            margin-left: 19px;
        }
.ellipse-img {
    position: absolute;
    top: 50%;
    left: 28%;
    transform: translate(-50%, -50%);
    width: 66px;
    height: 66px;

}
.ellipse-link {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    text-decoration: none;
}		
.box3 {
			
            margin-left: 340px;
            width: 250px;
            height: 142px;
            background: linear-gradient(to right, #0C3C68, #2DA6B6);
            border-radius: 10px;
            position: absolute; /* Add relative positioning */
			
        }
		.box4 {
			
            margin-left: 645px;
            width: 250px;
            height: 142px;
            background: linear-gradient(to right, #0C3C68, #2DA6B6);
            border-radius: 10px;
            position: absolute; /* Add relative positioning */
			
        }
		.textnewly{
		position: absolute; /* Change to absolute positioning */
            top: 32%;
            transform: translateY(-50%);
            color: #FFF;
            text-shadow: 0px 4px 0px rgba(0, 0, 0, 0.25);
            font-family: Anton;
            font-size: 25px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;

            margin-left: 19px;
		}
		.texttoday{
		position: absolute; /* Change to absolute positioning */
            top: 32%;
            transform: translateY(-50%);
            color: #FFF;
            text-shadow: 0px 4px 0px rgba(0, 0, 0, 0.25);
            font-family: Anton;
            font-size: 20px;
            font-style: normal;
            font-weight: 400;
            line-height: normal;
			letter-spacing: 2px;
            margin-left: 19px;
			display: flex;
width: 146px;
height: 46px;
flex-direction: column;
justify-content: center;
flex-shrink: 0;
		}
		.session-container {
    display: flex;
    flex-direction: column;

    margin-top: 20px; /* Adjust the margin as needed */
}
.headingfirst{
margin-left:10px;
color: #FFFFFF;
font-family: Amiri;
font-size: 20px;
font-style: normal;
font-weight: 700;
line-height: normal;
}
.heading{
margin-left:10px;
color: #000;
font-family: Amiri;
font-size: 16px;
font-style: normal;
font-weight: 400;
line-height: normal;
}
.session{
		margin-left:40px;
		margin-top:80px;
		color: #3498DB;
font-family: Anton;
font-size: 25px;
font-style: normal;
font-weight: 400;
line-height: normal;
		}
		.darkgreypart{
		
		margin-top:5px;
		margin-left:43px;
		width: 1449px;
height: 65px;
flex-shrink: 0;
border-radius: 10px;
background: linear-gradient(to left, #0C3C68, #2DA6B6);
display: flex; /* Add display flex */
    align-items: center; /* Center vertically */

		}
		.greypart{
		
		margin-top:5px;
		margin-left:43px;
		width: 1449px;
height: 65px;
flex-shrink: 0;
border-radius: 10px;
background: #f4efef;
display: flex; /* Add display flex */
    align-items: center; /* Center vertically */
	border:1px lightgrey solid;
		}
    </style>
</head>
<body>
    <div class="left-container">
        <img src="goldenlogo.png" style="width:24px; height:24px; display:block; margin:14px auto 0;">
		<span class="logotext" style="margin-top:2px;">GOLDEN DENTAL</span>
		<div class="picture"></div>
		<span class="pictext1">Dr. <?php echo $last;?></span>
		<span class="pictext2"><?php echo $exp;?></span>
		<hr></hr>
		<a href=""	 class="dashboard1st" id="active"><img src="dashboardicon.png" class="icons"><span class="dashtext" style="font-weight:normal;">Dashboard</span></a>
		<a href="newappointment.php"	 class="dashboard2" id="notactive"><img src="appointments.png" class="icons"><span class="dashtext">Appointment</span></a>
		<a href="newprofile.php"	 class="dashboard3" id="notactive"><img src="profileicon.png" class="icons"><span class="dashtext">Profile</span></a>
		<a href="dashdash.php"	 class="dashboard5" id="notactive"><img src="patient.png" class="icons"><span class="dashtext">Patients</span></a>
		<div style="width: 100%;
    height: auto;
    text-align: center;"><div style="width: 126px;height:29px;margin: 0 auto;background-color: #EB480B;border-radius:8px;box-shadow: 4px 4px 4px rgba(0, 0, 0, 0.25);"><a href="login.html"	 class="dashboard6" id="notactive"><img src="exit.png" class="logouticons"><span class="dashtextlogout">Log Out</span></a></div></div>
    </div>
    <div class="right-container">
        <div class="top-section">
            <!-- Top content goes here -->
            
        </div>
        <div class="bottom-section">
            <div class="margintop">
				<div class="fullbody">                      <div style="width:100%;height:72px;display:flex;flex-direction:row;">
																<div style="display:inline-block;
																width:24.5%;height:72px;margin-left:25px;"><span style="													
																color:#248AA2;font-family: Anton;font-size: 25px;font-style: normal;font-weight: 400;line-height: normal;
																												"></span>
																										</div>
																										<div style="display:inline-block;height:72px;width:74.05%;"></div>			
																										
															</div>
															
															
															<div class="box2">
														<a href="dashdash.php"><span class="text">PATIENTS</span>
														<span class="text2"><?php echo $total_patients;?></span></a>
														<div class="ellipse-wrapper">
															<div class="ellipse-2">
															<a href="dashdash.php" class="ellipse-link">
															<img src="but2.png" class="ellipse-img"></div></a>
														</div>
													</div>
															
															<div class="box3">
																<a href="newappointment.php"><span class="textnewly">NEWLY BOOKED</span>
																<span class="text2"></span></a>
																<div class="ellipse-wrapper">
																	<div class="ellipse-2">
																	<a href="newappointment.php" class="ellipse-link">
																	<img src="but3.png" class="ellipse-img"></div></a>
																</div>
															</div>
																				<!-- -->
																													
																	<div class="box4">
																			<a href="newappointment.php"><span class="texttoday">TODAY'S APPOINTMENTS</span>
																			<span class="text2"><?php echo $countToday ?></span></a>
																			<div class="ellipse-wrapper">
																				<div class="ellipse-2">
																				<a href="newappointment.php" class="ellipse-link">
																				<img src="but4.png" class="ellipse-img"></div></a>
																			</div>
																		</div>
																														<div class="session-container">
																															<span class="session">Today's Appointments</span>
																															<!-- 1st greypart -->
																															<div class="darkgreypart">
																															<span style="margin-left:16px;
																																	color: #FFFFFF;
																																	font-family: Amiri;
																																	font-size: 20px;
																																	font-style: normal;
																																	font-weight: 700;
																																	line-height: normal;
																																	">Appointment ID</span>
																															<span class="headingfirst" style="display: flex;
																																	width: 400px;
																																	height: 65px;
																																	flex-direction: column;
																																	justify-content: center;
																																	">Patient Name</span>
																															<span class="headingfirst" style="display: flex;
																																	width: 400px;
																																	height: 65px;
																																	flex-direction: column;
																																	justify-content: center;">Time</span>
																															<span class="headingfirst" style="display: flex;
																																	width: 277px;
																																	height: 65px;
																																	flex-direction: column;
																																	justify-content: center;">Email</span>
																															<span class="headingfirst" style="display: flex;
																																	width: 222px;
																																	height: 65px;
																																	flex-direction: column;
																																	justify-content: center;">Treatment</span>
																															</div>
																															
																															<!-- 2nd greypart -->
																															<?php 
																															
																															$query=mysqli_query($conn,"select * from `bookings` WHERE doctor_id='$id' AND DATE(preferredDateTime) = '$today' LIMIT 10");
																															while($row=mysqli_fetch_array($query)){
																																	echo '<div class="greypart">
																															<span style="margin-left:16px;
																																	display: flex;
																																	width:130px;
																																	height: 65px;
																																	flex-direction: column;
																																	justify-content: center;
																																	flex-shrink: 0;
																																	"
																																	class="heading">'.$row['booking_id'].'</span>
																															<span class="heading" style="display: flex;
																																	width: 390px;
																																	height: 65px;
																																	flex-direction: column;
																																	justify-content: center;">'.$row['name'].'</span>
																															<span class="heading" style="display: flex;
																																	width: 385px;
																																	height: 65px;
																																	flex-direction: column;
																																	justify-content: center;">'.$row['preferredDateTime'].'</span>
																															<span class="heading" style="display: flex;
																																	width: 280px;
																																	height: 65px;
																																	flex-direction: column;
																																	justify-content: center;">'.$row['email'].'</span>
																															<span class="heading" style="display: flex;
																																	width: 222x;
																																	height: 65px;
																																	flex-direction: column;
																																	justify-content: center;">'.$row['service'].'</span>
																															</div> ';

																															}
																															
																															?>
																															
																															
</div>										
															<div style="height:2000px;"></div>
																				
										
										
				</div>							
			</div>
            </div>
			
			
        </div>
		
		
    </div>
	

</body>
</html>
