<?php

if(!isset($_POST['drinksID'])){
	include('./error/404.php');
	header("HTTP/1.1 404 Not Found");
	header("Refresh:3; url=./dashboard.php", TRUE, 301);
	exit;
}else{
	//do things below
}

session_start();

$drinks_ID = htmlspecialchars($_POST['drinksID'], ENT_QUOTES);
$addDrinksQty = htmlspecialchars($_POST['addDrinksQty'], ENT_QUOTES);
$unitPrice = htmlspecialchars($_POST['unitCost'], ENT_QUOTES);
$remarks = htmlspecialchars($_POST['remarks'], ENT_QUOTES);

require_once("connection.php"); //require_once() = used to embed PHP code from another file

$remarks = mysqli_real_escape_string($conn, $remarks);
$remarks_len = mb_strlen($remarks, 'UTF-8');

if($remarks_len > 100){ //return to previous page
	//back to modifyItemCategory.php
	echo '<script type="text/javascript">'; 
	echo 'alert("Remarks over 100 characters");';
	echo 'window.location.href = "modifyDrinksInventory.php";';
	echo '</script>';
	die("HAHA");
}

//upload the purchase record to stock_record table first

//find out the last stock_record_id

$sql = "SELECT * FROM `drinks_stock_record` ORDER BY record_id DESC LIMIT 1"; //write the SQL statement
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

if(mysqli_num_rows($rs) <= 0){ //no record found
	$previous_record_id = 0;
}else{
	$previous_record_id = $rc['record_id'];
}


//make a function to update the stock_record_id
function createNewStockRecordId($id) {

  $new_id = $id + 1;

  return $new_id;
}

$next_record_id  = createNewStockRecordId($previous_record_id);

$staff = $_SESSION["staffID"];

date_default_timezone_set("Asia/Hong_Kong");
$amend_date = date("Y-m-d");
$amend_time = date("H:i:s");

$amendment_status = "purchase";


//start the SQL

$sql2 = "INSERT INTO `drinks_stock_record`(`record_id`, `drinks_id`, `unit_cost`, `stock_qty`, `stock_action`, `stock_remarks`, `stock_date`, `stock_time`, `staff_id`) VALUES ($next_record_id, '$drinks_ID', $unitPrice, $addDrinksQty, '$amendment_status', '$remarks', '$amend_date', '$amend_time', '$staff')";

$rs2 = mysqli_query($conn, $sql2) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 


//secondly, update the rental_item table

//selete the original qty from rental_item table
$sql3 = "SELECT * FROM `drinks_category` WHERE drinks_id = '$drinks_ID'"; //write the SQL statement
$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));

$rc3 = mysqli_fetch_assoc($rs3);

$new_qty = $addDrinksQty + $rc3['stock_qty'];

//update $new_qty
$sql4 = "UPDATE `drinks_category` SET stock_qty = $new_qty WHERE drinks_id = '$drinks_ID'";
$rs4 = mysqli_query($conn, $sql4) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));




//free memory
mysqli_free_result($rs); 
mysqli_free_result($rs3); 
mysqli_close($conn);


// redirect to modifyInventory.php
header("location: modifyDrinksInventory.php");


?>