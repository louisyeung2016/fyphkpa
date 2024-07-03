<html><body>
<?php

session_start();

$staff_id = $_POST['staffID'];
$staff_name = $_POST['name'];
$pass = $_POST['pw'];
$per = $_POST['per'];
$perA = $_POST['perA'];

$password_Hash = hash('sha256', $pass);
require_once("connection.php"); //require_once() = used to embed PHP code from another file

if($_SESSION['permission'] != "Admin" && $perA == "Admin"){
	echo '<script type="text/javascript">'; 
	echo 'alert("You have no permission");';
	echo 'window.location.href = "modifyStaff.php";';
	echo '</script>';
	die("HAHA");
}else{
	$sql = "UPDATE staff SET staff_name = '$staff_name', password = '$password_Hash', permission = '$per' WHERE staff_id = '$staff_id'"; //write the SQL statement
	$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));
}


//free memory
mysqli_close($conn);


// redirect to modifystaff.php
echo '<script type="text/javascript">'; 
echo 'alert("Edit successful");';
echo 'window.location.href = "modifyStaff.php";';
echo '</script>';
die("HAHA");


?>
</html></body>