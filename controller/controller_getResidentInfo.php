<?php

include ('../connection.php');

$roomNumber0 = $_POST["roomNumber"];
$roomNumber = mysqli_real_escape_string($conn, $roomNumber0);

$query = "SELECT booking_id FROM `room_booking` WHERE room_number = '$roomNumber' AND status ='Occupying'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run); 

$rc = mysqli_fetch_assoc($query_run);

if (mysqli_num_rows($query_run) > 0) { //found
	$bookingID = $rc['booking_id'];
	
	$query2 = "SELECT * FROM `booking_info` WHERE booking_id = '$bookingID'";  
	$query_run2 = mysqli_query($conn, $query2);
	$rc2 = mysqli_fetch_assoc($query_run2);
	
	$jsonArray = array();
	
	$jsonArray['organization_name'] = $rc2['organization_name'];
	$jsonArray['representative_name'] = $rc2['representative_name'];
	$jsonArray['contact_number'] = $rc2['contact_number'];
	
	$jsonObj = json_encode($jsonArray); //{"cars":["Volvo","BMW","Toyota"],"foodsss":["apple","banana","coconut"]}
	
	echo $jsonObj;
	
}else{ //not found
	echo 0;
}
?>