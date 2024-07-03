<?php

include ('../connection.php');

$rfid0 = $_POST["RFID"];
$rfid = mysqli_real_escape_string($conn, $rfid0);

$query = "SELECT room_number FROM `room_category` WHERE room_RFID = '$rfid'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run); 

$rc = mysqli_fetch_assoc($query_run);

if (mysqli_num_rows($query_run) > 0) { //found
	$roomNum = $rc['room_number'];
	echo $roomNum;
}else{ //not found
	echo 0;
}

?>