<html><body>
<?php

session_start();

$staffID = $_POST['staffID'];
$perA = $_POST['per'];


require_once("connection.php"); //require_once() = used to embed PHP code from another file

if($_SESSION['permission'] != "Admin" && $perA == "Admin"){
	echo '<script type="text/javascript">'; 
	echo 'alert("You have no permission");';
	echo 'window.location.href = "modifystaff.php";';
	echo '</script>';
	die("HAHA");
}else{
//update the staff status to inActive
	$sql = "UPDATE staff SET status = 'inActive' WHERE staff_id = '$staffID'"; //write the SQL statement
	$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
		or die(mysqli_error($conn));
}


//free memory
mysqli_close($conn);


// redirect to modifystaff.php
echo '<script type="text/javascript">'; 
echo 'alert("Remove successful");';
echo 'window.location.href = "modifystaff.php";';
echo '</script>';
die("HAHA");


?>
</html></body>