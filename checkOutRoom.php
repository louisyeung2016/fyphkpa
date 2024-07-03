<html><body>
<?php

require_once("connection.php"); //require_once() = used to embed PHP code from another file


$roomNumber = $_POST["roomNumber"];



$sql = "UPDATE resident_info SET checkin_status = 'checked out' WHERE room_number = '$roomNumber'"; 

$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn));


header("location: viewRoomStatus.php");
?>
</html></body>
