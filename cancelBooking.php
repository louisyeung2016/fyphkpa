<?php
require_once("./connection.php");

$booking_id = $_POST['bookingID'];
//echo $booking_id;

$query = "UPDATE `booking_info` SET booking_status = 'Cancelled' WHERE booking_id = '$booking_id';";
$query_run = mysqli_query($conn, $query)
	or die(mysqli_error($conn));

$query2 = "UPDATE `room_booking` SET status = 'Cancelled' WHERE booking_id = '$booking_id';";
$query_run = mysqli_query($conn, $query)
	or die(mysqli_error($conn));

//echo "<script type='text/javascript'>alert('booking $booking_id cancelled');</script>";

//redirect to manageBooking.php
header("location: manageBooking.php");
?>