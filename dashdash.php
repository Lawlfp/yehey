<?php
session_start();

if (isset($_SESSION['doctor_lastName']) && isset($_SESSION['doctor_expertise'])) {
    $last = $_SESSION['doctor_lastName'];
    $exp = $_SESSION['doctor_expertise'];
}



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbdental";
$records_per_page = 5;

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
} elseif (isset($_POST["id"])) {
    $id = intval($_POST["id"]);
} elseif (isset($_SESSION["id"])) {
    $id = intval($_SESSION["id"]);
}
$doctor_id=$_SESSION["doctor_id"];
$doctorid=$doctor_id;
if(isset($_GET["patientid"])){
	$patientid=$_GET["patientid"];
}


// Get the current page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $records_per_page;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Delete record
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_sql = "DELETE FROM bookings WHERE booking_id = $delete_id";
    $conn->query($delete_sql);
}

$sql = "SELECT * FROM patient
        WHERE (`id` LIKE '%$search%'
        OR `firstName` LIKE '%$search%'
        OR `middleName` LIKE '%$search%'
        OR `lastName` LIKE '%$search%'
        OR `contactNumber` LIKE '%$search%'
        OR `doctorid` LIKE '%$search%'
        OR `lastDiagnosis` LIKE '%$search%')
        AND `doctorid` = $doctorid
        LIMIT $offset, $records_per_page";


$result = $conn->query($sql);

if(isset($_GET['id'])){
$id = $_GET['id'];
$_SESSION["id"]=$id;
}

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

$sql_doctor = "SELECT * FROM doctors WHERE doctor_id=$id";
$sql_login = "SELECT * FROM login WHERE id=$id";
$resultq = $conn->query($sql_doctor);
$result1 = $conn->query($sql_login);

$resultz = $conn->query("SELECT * FROM `login` WHERE id=$id");

if ($resultz && $row = $resultz->fetch_assoc()) {
    // Set the background image URL using data URI
    $imageData = base64_encode($row['image']);
    $backgroundImageURL = 'data:image/jpeg;base64,' . $imageData;
} else {
    $backgroundImageURL = ''; // Default to an empty string if no image is available
}
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
font-size: 20px;
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
		width: 1049px;
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
		width: 1049px;
height: 65px;
flex-shrink: 0;
border-radius: 10px;
background: #f4efef;
display: flex; /* Add display flex */
    align-items: center; /* Center vertically */
	border:1px lightgrey solid;
		}
		.container{
width: 84.5vw;
height: 72.3vh;
margin-top:1.5%;
border-radius: 0.6em;

display:flex;
flex-direction:row;
flex-wrap:wrap;

}
.search{
width:30%;
height:10%;

display: flex;
}
.search1{
width:70%;
height:10%;
}
.containerforsearch{
	border-bottom: 1px solid #A9A9A9;
	height:41%;
	width:50%;
	margin-left:1.5%;
	margin-top:0.2%;
	
	
}
.searchinput{
	height:100%;
	width:100%;
	border-bottom: 1px solid #A9A9A9;
	border-top:none;
	border-left:none;
	border-right:none;
	outline:none;
	font-family: 'Amiri';
        font-size: 15px;
        color: black;
}
.searchinput::placeholder {
        font-family: 'Amiri', sans-serif;
        font-size: 15px;
        color: #A9A9A9;
    }
button:hover{
cursor:pointer;
}
.con{
	
	margin-left:1.5%;
	height:100%;
	width:100%;
}
.darkgreypart{
height:65px;
background-color:#EEE5E5;
width:1115px;
margin-top:-0.7%;
margin-left:auto;
margin-right:auto;
border-radius:10px;
display: flex;
    align-items: center; /* Align content vertically center */
}
.title{
width:114px;
font-family:Amiri;
font-weight: bold;
font-size:15px;
color:white;
margin-left:1.5%;
letter-spacing:0.5px;

}
.title1{
font-family:Amiri;
font-weight: bold;
font-size:15px;
color:white;
margin-left:10px;
letter-spacing:0.5px;
}
.nottitle{
font-family:Amiri;

font-size:15px;
color:black;
margin-left:10px;
letter-spacing:0px;
}
.darkgreypart{
height:65px;
background-color:#EEE5E5;
width:82vw;
margin-top:-0.7%;
margin-left:auto;
margin-right:auto;
border-radius:10px;
display: flex;
    align-items: center; /* Align content vertically center */
}
.lightgreypart{
height:65px;
background-color:#f4efef;
width:82vw;
margin-top:0.6%;
margin-left:auto;
margin-right:auto;
border-radius:10px;
display: flex;
    align-items: center; /* Align content vertically center */
}
.email{
font-size:12px;
margin-left:10px;
font-family:Amiri;
}
.nottitlefirst{
width:114px;
font-family:Amiri;

font-size:15px;
color:black;
margin-left:1.5%;
letter-spacing:0.5px;
}
.nottitlegreen{
font-family:Amiri;
font-weight:600;
font-size:15px;
color:#299F00;
margin-left:10px;
letter-spacing:0px;
}
.bottom{
position: absolute;
bottom:4.9%;
left:16.7%;

width:1099px;
height:54px;
display:flex;
flex-direction:row;
}
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px; /* Adjust the margin as needed */
}

.pagination a {
    display: inline-block;
    padding: 8px 16px;
    text-decoration: none;
    background-color: #3498DB;
    color: #fff;
    border-radius: 5px;
    margin: 0 5px;
}

.pagination a:hover {
    background-color: #2980B9;
}
    </style>
</head>
<body>
    <div class="left-container">
        <img src="goldenlogo.png" style="width:24px; height:24px; display:block; margin:14px auto 0;">
		<span class="logotext" style="margin-top:2px;">GOLDEN DENTAL</span>
		<div class="picture"></div>
		<span class="pictext1">Dr.<?php echo $last;?></span>
<span class="pictext2"><?php echo $exp;?></span>
		<hr></hr>
		<a href="dash.php?doctor_id=<?php echo $doctor_id;?>"	 class="dashboard1st" id="notactive"><img src="dashboardicon.png" class="icons"><span class="dashtext" style="font-weight:normal;">Dashboard</span></a>
		<a href="newappointment.php?doctor_id=<?php echo $doctor_id;?>"	 class="dashboard2" id="notactive"><img src="appointments.png" class="icons"><span class="dashtext">Appointment</span></a>
		<a href="newprofile.php?doctor_id=<?php echo $doctor_id;?>"	 class="dashboard3" id="notactive"><img src="profileicon.png" class="icons"><span class="dashtext">Profile</span></a>
		<a href=""	 class="dashboard5" id="active"><img src="patient.png" class="icons"><span class="dashtext">Patients</span></a>
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
																												">Patients</span>
																										</div>
																										<div style="display:inline-block;height:72px;width:74.05%;"></div>			
																										
															</div>
															
															
															
																<div class="margintop">
               <span class="texts"></span>
               
			   
			   <form action='' method='get' class='search-form'>
			   <div class="container">
						<div class="search"><button type="submit" style="background-image:url(search.png);margin-left:7%;margin-top:1%;width:20px;height:20px;border:none;"></button><div class="containerforsearch"><input type="text" class="searchinput" placeholder="Search Patients" name="search"></input></div></div>
						</form><div class="search1"></div>
						
						<div class="con"><div class="darkgreypart">
											<span class="title">Patient ID</span>
											<span class="title1" style="width:201px;">Patient</span>
											<span class="title1" style="width:145px;">Contact Number</span>
											<span class="title1" style="width:222px;">Last Diagnosis</span>
											
											<span class="title1" style="width:177px;">Birthdate(ymd)</span>
										</div>
										
										<?php 
										if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="lightgreypart">';
        echo '<span class="nottitlefirst">' . $row["id"] . '</span>';
        echo '<div style="display: flex; flex-direction: column;">';
        echo '<span class="nottitle" style="width:201px; margin-top:5%;"><b>' . $row["firstName"] . $row["middleName"] . $row["lastName"] . '</b></span>';
        echo '</div>';
        echo '<span class="nottitle" style="width:145px;">' . $row["contactNumber"] . '</span>';
        echo '<span class="nottitle" style="width:225px;">' . $row["lastDiagnosis"] . '</span>';
        echo '<span class="nottitle" style="width:122px;">' . $row["birthdate"] . '</span>';
        echo '<a href ="patientrec.php?id='.$row["id"].'&patientid='.$row["id"].'"><span class="nottitle" style="width:122px;color:blue;">Profile</span></a>';
        echo "</div>";
    }

    // Pagination
    $total_pages_sql = "SELECT COUNT(*) FROM patient 
                        WHERE doctorid = $doctorid 
                        AND (`id` LIKE '%$search%' 
                        OR `firstName` LIKE '%$search%' 
                        OR `middleName` LIKE '%$search%' 
                        OR `lastName` LIKE '%$search%' 
                        OR `contactNumber` LIKE '%$search%' 
                        OR `doctorid` LIKE '%$search%' 
                        OR `lastDiagnosis` LIKE '%$search%')";
    $total_pages_result = $conn->query($total_pages_sql);

    if ($total_pages_result) {
        $total_records = $total_pages_result->fetch_array()[0];
        $total_pages = ceil($total_records / $records_per_page);

        echo "<div class='pagination'>";
        if ($current_page > 1) {
            echo "<a href='?page=" . ($current_page - 1) . "&search=$search&id=$id'> < </a>";
        }

        if ($current_page < $total_pages) {
            echo "<a href='?page=" . ($current_page + 1) . "&search=$search&id=$id'> > </a>";
        }
        echo "</div>";
    } else {
        echo "Error with pagination query.";
    }
} else {
    echo "0 results";
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
