<?php

session_start();
require_once("connection.php");

//check whether expired or not
$expected_logout_time_milliseconds = $_SESSION["expected_logout_time_milliseconds"];
$expected_logout_time = $expected_logout_time_milliseconds/1000;
$remainTime = $expected_logout_time - time();

$pw = hash('sha256', $_POST["extend_pw"]);
$staffID = $_SESSION["staffID"];

$clear_staffID = mysqli_real_escape_string($conn, $staffID);
$clear_password = mysqli_real_escape_string($conn, $pw);

$sql = "SELECT * FROM staff WHERE staff_id = '$clear_staffID' AND password = '$clear_password' AND status = 'Active'";
$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);



if($remainTime > 0){
	if ($count == 1) { //password correct
		$EnableLoginTime = 60*60*3; //3 hours
		$now_time = time(); //get now time in Unix timestamp format
		$expected_logout_time = $now_time + $EnableLoginTime; //get (now time + 3 hours) in Unix timestamp format
		$expected_logout_time_milliseconds = $expected_logout_time *1000;//in Unix timestamp format & in milliseconds
		//echo $expected_logout_time_milliseconds;
		$_SESSION["expected_logout_time_milliseconds"] = $expected_logout_time_milliseconds;
		setcookie("permission", $_SESSION["permission"] , time()+60*60*3);

		// redirect to previous page

		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit();
	}else{ //invalid password, redirect to logout.php
		echo "<SCRIPT>  alert('Failed. Invalid Password')
		window.location.replace('logout.php');
		</SCRIPT>";
	}

}else{
	header('Location: ' . 'index.html');
	exit();
}









?>