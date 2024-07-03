<?php
include ('../connection.php');


$occupyingRooms = array(); //show in gary color
//find all occupying rooms
$query = "SELECT * FROM `room_booking` WHERE status = 'Occupying'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run); 

$rc = mysqli_fetch_assoc($query_run);
if(mysqli_num_rows($query_run) > 0) {
	do{
		$occupying_room_Number = "#".$rc['room_number'];
		array_push($occupyingRooms, $occupying_room_Number);
	}while ($rc = mysqli_fetch_assoc($query_run));
}

$inactivateRooms = array(); //show in red color
//find all inactivate rooms

$query = "SELECT * FROM `room_category` WHERE room_status = 'inActivate' AND room_number NOT LIKE '%00'"; 
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run); 

$rc = mysqli_fetch_assoc($query_run);
if(mysqli_num_rows($query_run) > 0) {
	do{
		$inactivate_room_Number = "#".$rc['room_number'];
		array_push($inactivateRooms, $inactivate_room_Number);
	}while ($rc = mysqli_fetch_assoc($query_run));
}









//print_r($occupyingRooms);
//print_r($inactivateRooms);
$return_array = array("occupyingRooms"=>$occupyingRooms, "inactivateRooms"=>$inactivateRooms);
//print_r($return_array);
$myJSON = json_encode($return_array);
echo $myJSON;

//header("Refresh:3; url=./dashboard.php", TRUE, 301);
//header("Location: ../error/404.php")
?>