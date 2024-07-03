<?php



if(!isset($_POST['hidden_input'])){
	include('./error/404.php');
	header("HTTP/1.1 404 Not Found");
	header("Refresh:3; url=./dashboard.php", TRUE, 301);
	exit;
}else{
	//do things below
}

if(!empty($_POST)){
	var_dump($_POST);
}

session_start();

require_once("connection.php"); //require_once() = used to embed PHP code from another file

$staff = $_SESSION["staffID"];
date_default_timezone_set("Asia/Hong_Kong");
$place_date = date("Y-m-d");
$place_time = date("H:i:s");

$itemID = $_POST['hidden_input'];
$lockerNum = $_POST['lockerNum'];

//echo $staff;
//echo $place_date;
//echo $place_time;

//check whether the selected locker is correct
if($lockerNum != 1 && $lockerNum != 2 && $lockerNum != 3 && $lockerNum != 4){
	echo '<script type="text/javascript">'; 
	echo 'alert("Please choose correct Locker");';
	echo 'window.location.href = "manageSmartLocker.php";';
	echo '</script>';
	die("HAHA");
}

//check whether the selected item is enough inventory
//if inventory == 0 or item not found, go back and alert staff
$sql = "SELECT * FROM `rental_item_category` WHERE `item_id` = '$itemID' AND `item_status` = 'Active' AND `qty`>0 AND NOT item_name LIKE '%Key' ";
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

//$item_inventory = $rc['qty'];

if(mysqli_num_rows($rs) <= 0){
	echo '<script type="text/javascript">'; 
	echo 'alert("Please choose correct item");';
	echo 'window.location.href = "manageSmartLocker.php";';
	echo '</script>';
	die("HAHA");
}else{
	$item_inventory = $rc['qty'];
}


//check whether there is an item placing on the selected locker
//if yes, change its status to replace, and add back 1 to inventory
$sql1 = "SELECT locker_record.status, locker_record.locker_record_id, locker_record.item_id FROM `locker_record` WHERE `locker_number` = '$lockerNum'  ORDER BY locker_record.locker_record_id DESC LIMIT 1 ";
$rs1 = mysqli_query($conn, $sql1) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc1 = mysqli_fetch_assoc($rs1);

echo $rc1['status'];

if(mysqli_num_rows($rs1) == 0 || $rc1['status'] == 'borrowed'){ //this locker has never used before or being borrowed (empty)
	//insert new record of the locker number in which status as 'placed'
	$sql2 = "INSERT INTO `locker_record`(`locker_number`, `item_id`, `place_date`, `place_time`, `staff_id`, `status`) VALUES ('$lockerNum','$itemID','$place_date','$place_time','$staff','placed')";
	
	$rs2 = mysqli_query($conn, $sql2) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 
	
	//reduce 1 from item inventory
	$new_item_inventory = $item_inventory - 1;
	
	$sql3 = "UPDATE rental_item_category SET qty = $new_item_inventory WHERE `item_id` = '$itemID'";
	$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 
	
	echo "CCC";
	
}else if($rc1['status'] == 'placed'){
	//update this record's status to 'replaced' and add back 1 to its inventory
	$this_locker_record_id = $rc1['locker_record_id'];
	$sql4 = "UPDATE locker_record SET status = 'replaced' WHERE `locker_record_id` = '$this_locker_record_id'";
	$rs4 = mysqli_query($conn, $sql4) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 
	
	//find the qty of $rc1['item_id']
	$this_item_id = $rc1['item_id'];
	$sql5 = "SELECT qty FROM `rental_item_category` WHERE `item_id` = '$this_item_id' ";
	$rs5 = mysqli_query($conn, $sql5) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 
	
	$rc5 = mysqli_fetch_assoc($rs5);
	$this_item_old_qty = $rc5['qty'];
	$this_item_new_qty = $this_item_old_qty + 1;
	//add back 1 to its inventory
	$sql6 = "UPDATE rental_item_category SET qty = $this_item_new_qty WHERE `item_id` = '$this_item_id'";
	$rs6 = mysqli_query($conn, $sql6) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 
	
	//insert new record of the locker number in which status as 'placed'
	$sql7 = "INSERT INTO `locker_record`(`locker_number`, `item_id`, `place_date`, `place_time`, `staff_id`, `status`) VALUES ('$lockerNum','$itemID','$place_date','$place_time','$staff','placed')";
	
	$rs7 = mysqli_query($conn, $sql7) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 
	
	//reduce 1 from item inventory
	$new_item_inventory = $item_inventory - 1;
	
	$sql8 = "UPDATE rental_item_category SET qty = $new_item_inventory WHERE `item_id` = '$itemID'";
	$rs8 = mysqli_query($conn, $sql8) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 
	
	mysqli_free_result($rs5);
	echo "BBB";
}else{
	echo '<script type="text/javascript">'; 
	echo 'alert("Something wrong");';
	echo 'window.location.href = "manageSmartLocker.php";';
	echo '</script>';
	die("HAHA");
}

mysqli_free_result($rs);
mysqli_free_result($rs1);

mysqli_close($conn);

// redirect to manageSmartLocker.php
echo "AAA";
header("location: manageSmartLocker.php");
?>