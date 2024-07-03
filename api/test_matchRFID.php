<?php
include('../connection.php');

$rfid=mysqli_real_escape_string($conn, htmlspecialchars($_GET['rfid'], ENT_QUOTES));


$query = "SELECT * FROM `room_booking`, `room_category` WHERE room_booking.room_number = room_category.room_number AND room_booking.status = 'Occupying' AND room_RFID = $rfid;";

try{
	$query_run = mysqli_query($conn, $query);
	$row = mysqli_num_rows($query_run);
	$rc = mysqli_fetch_assoc($query_run);

	if (mysqli_num_rows($query_run) > 0){
		echo $rc['room_number'];
		//echo 1;
	}else{
		echo 0;
	}
}catch(Exception $e){
	echo 0;
}



?>