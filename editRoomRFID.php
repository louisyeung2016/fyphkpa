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

$roomNum = htmlspecialchars($_POST['roomNum'], ENT_QUOTES);

$rfidCode = htmlspecialchars($_POST['rfidCode'], ENT_QUOTES);

$rfidCode = mysqli_real_escape_string($conn, $rfidCode);

//check collusion
$query = $conn->query("SELECT * FROM `room_category` WHERE room_RFID = '$rfidCode'"); 

if ($query->num_rows > 0) { //collused, you cannot use this RFID code
	echo '<script type="text/javascript">'; 
	echo 'alert("RFID code cannot be used for more than one room.");';
	echo 'window.location.href = "modifyRoom.php";';
	echo '</script>';
	die("");
} else {
	$query2 = $conn->query("UPDATE `room_category` SET room_RFID = '$rfidCode' WHERE room_number = '$roomNum'"); 
	$conn->close();
}

// redirect to modifyRoom.php

header("location: modifyRoom.php");

?>