<?php
include('connection.php');

$roomNum = $_POST['roomNum'];

$roomStatus = $_POST['roomStatus'];

$query = $conn->query("SELECT * FROM `room_category` WHERE room_number = '$roomNum' AND room_number NOT LIKE '%00'"); 

if($query->num_rows > 0){ //correct room number
	$query2 = $conn->query("SELECT * FROM `room_booking` WHERE room_number = '$roomNum' AND status = 'Occupying'");
	if($query2->num_rows > 0){ //the room is occupying, you cannot change the room status!!
		echo '<script type="text/javascript">'; 
		echo 'alert("Room in use. You cannot modify the status. Please check-out the room first.");';
		echo 'window.location.href = "modifyRoom.php";';
		echo '</script>';
		die("");
	}else{
		$query3 = $conn->query("UPDATE `room_category` SET room_status = '$roomStatus' WHERE room_number = '$roomNum'"); 
		$conn->close();
	}

}else{
	echo '<script type="text/javascript">'; 
	echo 'alert("Invalid Room Number");';
	echo 'window.location.href = "modifyRoom.php";';
	echo '</script>';
	die("");
}

// redirect to modifyRoom.php

header("location: modifyRoom.php");

?>