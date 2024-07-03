<?php

include ('../connection.php');

$index = $_POST["index"];

//find the out-of-stock active drinks
$query = "SELECT drinks_name FROM `drinks_category` WHERE `stock_qty` <= `shortage_level` AND `drinks_status` = 'Active'; ";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run); 

$rc = mysqli_fetch_assoc($query_run);

$out_of_stock_active_drinks_arr = array();

if (mysqli_num_rows($query_run) > 0) {
	do {
		array_push($out_of_stock_active_drinks_arr, $rc['drinks_name']);
	} while ($rc = mysqli_fetch_assoc($query_run));
	
	$jsonObj = json_encode($out_of_stock_active_drinks_arr);
	echo $jsonObj;
}else{
	echo 0;
}


?>

