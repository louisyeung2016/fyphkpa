<?php

if(!isset($_POST['roomNum'])){
	include('./error/404.php');
	header("HTTP/1.1 404 Not Found");
	header("Refresh:3; url=./dashboard.php", TRUE, 301);
	exit;
}else{
	//do things below
}

include('connection.php');

$roomNum = $_POST['roomNum'];

$roomRemarks = $_POST['roomRemarks'];


$roomRemarks = mysqli_real_escape_string($conn, $roomRemarks);

$remarks_len = mb_strlen($roomRemarks, 'UTF-8');

if($remarks_len > 100){ //return to previous page
	//back to modifyItemCategory.php
	echo '<script type="text/javascript">'; 
	echo 'alert("Remarks over 100 characters");';
	echo 'window.location.href = "modifyRoom.php.php";';
	echo '</script>';
	die("HAHA");
}


$query1 = $conn->query("UPDATE `room_category` SET remarks = '$roomRemarks' WHERE room_number = '$roomNum'"); 
$conn->close();


// redirect to modifyRoom.php

header("location: modifyRoom.php");

?>