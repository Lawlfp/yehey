<?php
session_start();

if (isset($_SESSION['doctor_lastName']) && isset($_SESSION['doctor_expertise'])) {
    $last = $_SESSION['doctor_lastName'];
    $exp = $_SESSION['doctor_expertise'];
}

if(!isset($doctor_id)){
	$doctor_id=$_SESSION["id"];
}
$id=$_SESSION["id"];
$_SESSION["id"]=$id;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbdental";
$records_per_page = 5;

// Get the current page number
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($current_page - 1) * $records_per_page;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the doctor ID (assumes it's stored in the session or passed via GET)

if (!$doctor_id) {
    die("Invalid doctor ID.");
}

// Search functionality
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Delete record (only if it belongs to the logged-in doctor)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_sql = "DELETE FROM bookings WHERE booking_id = $delete_id AND doctor_id = $doctor_id";
    $conn->query($delete_sql);
}

// Retrieve bookings for the logged-in doctor
$sql = "SELECT `booking_id`, `name`, `email`, `contact`, `gender`, `service`, `preferredDateTime`, `doctor_id`, `birthdate`
        FROM bookings 
        WHERE `doctor_id` = $doctor_id
        AND (
            `booking_id` LIKE '%$search%' OR
            `name` LIKE '%$search%' OR
            `email` LIKE '%$search%' OR
            `contact` LIKE '%$search%' OR
            `birthdate` LIKE '%$search%' OR
            `gender` LIKE '%$search%' OR
            `service` LIKE '%$search%' OR
            `preferredDateTime` LIKE '%$search%'
        )
        LIMIT $offset, $records_per_page";

$result = $conn->query($sql);

// Pagination logic
$total_pages_sql = "SELECT COUNT(*) 
                    FROM bookings 
                    WHERE `doctor_id` = $doctor_id
                    AND (
                        `booking_id` LIKE '%$search%' OR
                        `name` LIKE '%$search%' OR
                        `email` LIKE '%$search%' OR
                        `contact` LIKE '%$search%' OR
                        `birthdate` LIKE '%$search%' OR
                        `gender` LIKE '%$search%' OR
                        `service` LIKE '%$search%' OR
                        `preferredDateTime` LIKE '%$search%'
                    )";

$total_pages_result = $conn->query($total_pages_sql);
$total_records = $total_pages_result->fetch_array()[0];
$total_pages = ceil($total_records / $records_per_page);

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
           overflow:hidden;
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
color:#EEE5E5;
margin-left:1.5%;
letter-spacing:0.5px;


}
.title1{
font-family:Amiri;
font-weight: bold;
font-size:15px;
color:#EEE5E5;
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
background: linear-gradient(to bottom, #0C3B67, #2CA6B6);
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
border:lightgray solid 1px;
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
		<span class="pictext1">Dr. <?php echo $last;?></span>
		<span class="pictext2"><?php echo $exp;?></span>
		<hr></hr>
		<a href="dash.php?id=<?php echo $id; ?>"	 class="dashboard1st" id="notactive"><img src="dashboardicon.png" class="icons"><span class="dashtext" style="font-weight:normal;">Dashboard</span></a>
		<a href=""	 class="dashboard2" id="active"><img src="appointments.png" class="icons"><span class="dashtext">Appointment</span></a>
		<a href="newprofile.php"	 class="dashboard3" id="notactive"><img src="profileicon.png" class="icons"><span class="dashtext">Profile</span></a>
		<a href="dashdash.php?id=<?php echo $id; ?>"	 class="dashboard5" id="notactive"><img src="patient.png" class="icons"><span class="dashtext">Patients</span></a>
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
																												">Appointment</span>
																										</div>
																										<div style="display:inline-block;height:72px;width:74.05%;"></div>			
																										
															</div>
															
															
															<div class="margintop">
               <span class="texts"></span>
               
			   
			   <form action='' method='get' class='search-form'>
			   <div class="container">
						<div class="search"><button type="submit" style="background-image:url(search.png);margin-left:7%;margin-top:1%;width:20px;height:20px;border:none;"></button><div class="containerforsearch"><input type="text" class="searchinput" placeholder="Search Appointment" name="search"></input></div></div>
						</form><div class="search1"></div>
						
						<div class="con"><div class="darkgreypart">
											<span class="title">Appointment #</span>
											<span class="title1" style="width:201px;">Patient</span>
											<span class="title1" style="width:145px;">Contact Number</span>
											<span class="title1" style="width:222px;">Preferred Date and Time</span>
											<span class="title1" style="width:189px;">Treatment</span>
											<span class="title1" style="width:177px;">Birthdate</span>
										</div>
										
										<?php 
										if ($result->num_rows > 0) {
											while($row = $result->fetch_assoc()) {
												echo '<div class="lightgreypart">';
												echo '<span class="nottitlefirst">' . $row["booking_id"] . '</span>';
												echo '<div style="display: flex; flex-direction: column;">';
												echo '<span class="nottitle" style="width:201px; margin-top:5%;"><b>' . $row["name"] . '</b></span>';
												echo '<span class="email" style="margin-top:-4%;">' . $row["email"] . '</span>';
												echo '</div>';
												echo '<span class="nottitle" style="width:145px;">' . $row["contact"] . '</span>';
												echo '<span class="nottitlegreen" style="width:222px;">' . $row["preferredDateTime"] . '</span>';
												echo '<span class="nottitle" style="width:189px;">' . $row["service"] . '</span>';
												echo '<span class="nottitle" style="width:122px;">' . $row["birthdate"] . '</span>';
												echo "</div>";
											}
															// Pagination
                                                                $total_pages_sql = "SELECT COUNT(*) FROM bookings 
                                                                WHERE `booking_id` LIKE '%$search%'
                                                                OR `name` LIKE '%$search%'
                                                                OR `email` LIKE '%$search%'
                                                                OR `contact` LIKE '%$search%'
                                                                OR `gender` LIKE '%$search%'
                                                                OR `service` LIKE '%$search%'
                                                                OR `preferredDateTime` LIKE '%$search%'
                                                                OR `doctor_id` LIKE '%$search%'";
                                                            $total_pages_result = $conn->query($total_pages_sql);
                                                            $total_records = $total_pages_result->fetch_array()[0];
                                                            $total_pages = ceil($total_records / $records_per_page);

                                                            echo "<div class='pagination'>";
                                                            if ($current_page > 1) {
                                                            echo "<a href='?page=".($current_page - 1)."&search=$search&id=$id'> < </a>";

                                                            }

                                                            if ($current_page < $total_pages) {
                                                            echo "<a href='?page=".($current_page + 1)."&search=$search&id=$id'> > </a>";
                                                            }
                                                            echo "</div>";
                                                            } else {
                                                            echo '<div style="margin-left: 20px;">No results found.</div>';
                                                            }
															
                                                            ?>
                                                        
											
											<div class="bottom">
                                                <div style="width:240px;height:54px;border-radius:5px;background-color:#; display:flex;align-items:center; justify-content:center;, margin-top:50px;">
                                                <span style="font-family:Anton; font-size:20px; color:#FFFFFF;"><!-- Create New Appointment--></span>
                                            </div>
										<script>
												function deleteRecord(bookingId) {
													if (confirm("Are you sure you want to delete this record?")) {
														window.location.href = '?delete=' + bookingId;
													}
												}
											</script>
							
						
						
			   </div>			   
			   
			   </div></div></div>
																															
</div>										
															<div style="height:2000px;"></div>
																				
										
										
				</div>							
			</div>
            </div>
			
			
        </div>
		
		
    </div>
	

</body>
</html>
