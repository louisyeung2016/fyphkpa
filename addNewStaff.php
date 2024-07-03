<?php

if(!isset($_POST['Sname'])){
	include('./error/404.php');
	header("HTTP/1.1 404 Not Found");
	header("Refresh:3; url=./dashboard.php", TRUE, 301);
	exit;
}else{
	//do things below
}

session_start();

$staffName = htmlspecialchars($_POST['Sname'], ENT_QUOTES);
$staffPer = htmlspecialchars($_POST['Sper'], ENT_QUOTES);

require_once("connection.php"); //require_once() = used to embed PHP code from another file

$staffName = mysqli_real_escape_string($conn, $staffName);

//find out the last item id
$sql = "SELECT COUNT(staff_id) FROM staff";
$rs = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($rs);
$id = $row['COUNT(staff_id)'] + 1;
$hash = hash('sha256', $_POST['Spw']);   

$sql1 = "INSERT INTO staff (staff_id, staff_name, password, permission, preference_index, status) VALUES ('$id', '$staffName', '$hash', '$staffPer', '000', 'Active')"; //write the SQL statement
$rs1 = mysqli_query($conn, $sql1) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));


//free memory
mysqli_close($conn);

// redirect to modifystaff.php
header("location: modifystaff.php");


?>