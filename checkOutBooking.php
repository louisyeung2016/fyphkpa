<?php
require_once("connection.php"); 

if(!isset($_POST['booking_id'])){
	include('./error/404.php');
	header("HTTP/1.1 404 Not Found");
	header("Refresh:3; url=./dashboard.php", TRUE, 301);
	exit;
}else{
	//do things below
}


$booking_id = $_POST['booking_id'];

//echo "php: ".$booking_id." ; ".gettype($booking_id);

//check any item not yet returned
$query1 = "SELECT COUNT(room_number) FROM `rental_record` WHERE booking_id='$booking_id' AND status = 'borrow'";
$query_run1 = mysqli_query($conn, $query1);
$row1 = mysqli_num_rows($query_run1);
$rc1 = mysqli_fetch_assoc($query_run1);
$booking_borrowing_Qty = $rc1['COUNT(room_number)'];

//what if payment status is not "Paid"-->???????????????????
$query1a = "SELECT payment_status FROM `booking_info` WHERE booking_id='$booking_id'";
$query_run1a = mysqli_query($conn, $query1a);
$row1a = mysqli_num_rows($query_run1a);
$rc1a = mysqli_fetch_assoc($query_run1a);
$payment_status = $rc1a['payment_status'];

//set check out date time to actual check-out date-time??????????????????????????

if($booking_borrowing_Qty > 0){ //there are some items not yet returned
	echo 0;
}else if($payment_status != "Full Paid"){
	echo 1;
}else{ //all items are returned, the booking and rooms can be checked out
	
	//update all records in room_booking from 'Occupying' to 'Checkedout'
	$query2 = "UPDATE `room_booking` SET status = 'Checkedout' WHERE booking_id = '$booking_id'";
	$query_run2 = mysqli_query($conn, $query2) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 
	
	echo 2;
}
?>