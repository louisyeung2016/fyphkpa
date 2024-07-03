<?php
include('../connection.php');

if(isset($_POST['itemStockRequest'])){
	$inputMonth = $_POST['itemStockRequest'];
	$sql = "SELECT * FROM `item_stock_record` WHERE amend_date LIKE '$inputMonth%';"; 
	$rs = mysqli_query($conn, $sql) 
	  or die(mysqli_error($conn));

	$rc = mysqli_fetch_assoc($rs);
	
	//echo gettype($sth);
	
	$out_arr = array();
	
	if (mysqli_num_rows($rs) > 0){
		do{
			$in_arr = array();
			
			$stock_record_id = $rc['stock_record_id'];
			$item_id = $rc['item_id'];
			$amendment_qty = $rc['amendment_qty'];
			$amendment_status = $rc['amendment_status'];
			$amendment_remarks = $rc['amendment_remarks'];
			$amend_date = $rc['amend_date'];
			$amend_time = $rc['amend_time'];
			$staff_id = $rc['staff_id'];
			

			array_push($in_arr, $stock_record_id, $item_id, $amendment_qty, $amendment_status, $amendment_remarks, $amend_date, $amend_time, $staff_id);
			array_push($out_arr, $in_arr);
	
		}while ($rc = mysqli_fetch_assoc($rs));
		
		//make JSON
		$jsonObj = json_encode($out_arr); 
		
		echo $jsonObj;
	}else{
		//no record found
		echo 0;
	}
}else if(isset($_POST['drinksStockRequest'])){
	$inputMonth = $_POST['drinksStockRequest'];
	$sql = "SELECT * FROM `drinks_stock_record` WHERE stock_date LIKE '$inputMonth%';"; 
	$rs = mysqli_query($conn, $sql) 
	  or die(mysqli_error($conn));

	$rc = mysqli_fetch_assoc($rs);
	
	//echo gettype($sth);
	
	$out_arr = array();
	
	if (mysqli_num_rows($rs) > 0){
		do{
			$in_arr = array();
			
			$record_id = $rc['record_id'];
			$drinks_id = $rc['drinks_id'];
			$unit_cost = $rc['unit_cost'];
			$stock_qty = $rc['stock_qty'];
			$stock_action = $rc['stock_action'];
			$stock_remarks = $rc['stock_remarks'];
			$stock_date = $rc['stock_date'];
			$stock_time = $rc['stock_time'];
			$staff_id = $rc['staff_id'];
			

			array_push($in_arr, $record_id, $drinks_id, $unit_cost, $stock_qty, $stock_action, $stock_remarks, $stock_date, $stock_time, $staff_id);
			array_push($out_arr, $in_arr);
	
		}while ($rc = mysqli_fetch_assoc($rs));
		
		//make JSON
		$jsonObj = json_encode($out_arr); 
		
		echo $jsonObj;
	}else{
		//no record found
		echo 0;
	}
}else{
	//no $_POST['itemStockRequest'] or $_POST['drinksStockRequest']
}




?>