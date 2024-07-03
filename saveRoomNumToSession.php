<?php
include('connection.php');
session_start();

$roomNum = $_POST["roomNum"];

$query = $conn->query("SELECT * FROM `room_booking` WHERE room_number = '$roomNum' AND status = 'Occupying'"); 
if($query->num_rows > 0){ //correct room number
	$organizationName = $_POST["organization"];
	$representativeName = $_POST["representative"];
	$contactNumber = $_POST["contact_number"];
	
	$_SESSION["room_Num"] = $roomNum;
	$_SESSION["organization"] = $organizationName;
	$_SESSION["representative"] = $representativeName;
	$_SESSION["contact_number"] = $contactNumber;

	echo $_SESSION["room_Num"];
}else{
	echo '<script type="text/javascript">'; 
	echo 'alert("Invalid Room Number");';
	echo 'window.location.href = "borrow.php";';
	echo '</script>';
	die("");
}






// redirect to borrow.php

header("location: borrow.php");
?>

