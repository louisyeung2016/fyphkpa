<html><body>
<?php
require_once("connection.php"); //require_once() = used to embed PHP code from another file

$roomNum = $_POST["roomNum"];
$organizationName = $_POST["organization"];

$checkin_date = $_POST["checkin_date"];
$checkin_time = $_POST["checkin_time"];
$checkout_date = $_POST["checkout_date"];
$checkout_time = $_POST["checkout_time"];

//echo $roomNum;
//echo $organizationName;
//echo $checkin_date;
//echo $checkout_date;

//$checkin_time = date("H:i:s");
//$checkout_time = date("H:i:s");

$sql = "INSERT INTO resident_info (room_number, apply_group, checkin_date, checkin_time, checkout_date, checkout_time, checkin_status) VALUES ('$roomNum', '$organizationName', '$checkin_date', '$checkin_time', '$checkout_date', '$checkout_time', 'occupying')"; 

$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn));

// redirect to fillinResidentInfo.php

header("location: fillinResidentInfo.php");
?>
</html></body>