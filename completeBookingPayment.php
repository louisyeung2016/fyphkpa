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

//find the total payment
$query1 = "SELECT total_payment FROM `booking_info` WHERE booking_id='$booking_id'";
$query_run1 = mysqli_query($conn, $query1);
$row1 = mysqli_num_rows($query_run1);
$rc1 = mysqli_fetch_assoc($query_run1);
$total_payment = $rc1['total_payment'];


//update payment_status to Full Paid
$query = "UPDATE `booking_info` SET payment_status = 'Full Paid', tenant_deposit_amount = '$total_payment', outstanding_balance = '0' WHERE booking_id = '$booking_id'";
$query_run = mysqli_query($conn, $query) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn)); 

echo 1;

?>