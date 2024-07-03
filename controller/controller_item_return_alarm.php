<?php

include ('../connection.php');

$index = $_POST["index"];

//echo "HAHA".$index."HAHA";

//before 1 hour
$oneHour = 3600;

//get bookings where checkout date is today
date_default_timezone_set("Asia/Hong_Kong");
$today_date = date("Y-m-d");
$today_datetime = date('Y-m-d H:i:s');

//find the occupying bookings
$query = "SELECT booking_id, checkout_date, checkout_time FROM `booking_info` WHERE booking_status = 'Effective' ";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run); 

$rc = mysqli_fetch_assoc($query_run);

$booking_checkout_within_oneHour_arr = array();

if (mysqli_num_rows($query_run) > 0) {
	do {
		$checkout_date = $rc['checkout_date'];
		$checkout_time = $rc['checkout_time'];
		$booking_id = $rc['booking_id'];
		if($today_date==$checkout_date){ //bugs here!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
			$checkout_datetime = $checkout_date." ".$checkout_time;
			//echo $checkout_datetime;
			//echo "<br>";
			//echo $today_datetime;
			//echo "<br>";
			
			$checkout_Unix = strtotime($checkout_datetime);
			$now_Unix = strtotime($today_datetime);
			//echo $checkout_Unix;
			//echo "<br>";
			//echo $now_Unix;
			//echo "<br>";
			//echo $now_Unix-$checkout_Unix;
			//echo "<br>";
			//echo $checkout_Unix-$now_Unix;
			//echo "<br>";
			if(($checkout_Unix-$now_Unix)<=$oneHour){
				//echo "ALERT!!!";
				//echo "<br>";
				array_push($booking_checkout_within_oneHour_arr, $booking_id); //have to check whether these bookings' rooms had not returned items or not
				
			}else{
				//no bookings need to checkout after oneHour
				//echo "You still have time";
				//echo "<br>";
			}
		}else{
			//no bookings' checkout date is today
		}
	} while ($rc = mysqli_fetch_assoc($query_run));
} else {
	//no occupying bookings
}

if(!empty($booking_checkout_within_oneHour_arr)){ //something inside the array
	
	

	//check whether these bookings' rooms had not returned items or not

	$x="";
	if(count($booking_checkout_within_oneHour_arr)>0){
		$x = implode("' OR booking_id = '",$booking_checkout_within_oneHour_arr);
		$x =  " AND(booking_id = '".$x."') ";
	}


	$query1 = "SELECT `room_number`, COUNT(room_number) FROM `rental_record` WHERE status = 'borrow' $x GROUP BY `room_number`";  
	$query_run1 = mysqli_query($conn, $query1);
	$row1 = mysqli_num_rows($query_run1);  //total number of records

	$rc1 = mysqli_fetch_assoc($query_run1);

	//$rc1['room_number']
	//$rc1['COUNT(room_number)'] 

	//make into JSON
	//e.g.

	/*
	{
	"room_number":["A07", "A19", "C02"],
	"num_of_borrowed_item":[4, 1, 3]
	}
	*/

	$jsonArray = array();

	$room_number = array();
	$num_of_borrowed_item = array();

	if (mysqli_num_rows($query_run1) > 0) {
		do {
			array_push($room_number, $rc1['room_number']);
			array_push($num_of_borrowed_item, $rc1['COUNT(room_number)']);
		}
		while ($rc1 = mysqli_fetch_assoc($query_run1));
		
		$jsonArray['room_number'] = $room_number;
		$jsonArray['num_of_borrowed_item'] = $num_of_borrowed_item;
		
		$jsonObj = json_encode($jsonArray); //{"cars":["Volvo","BMW","Toyota"],"foodsss":["apple","banana","coconut"]}
		//echo "<br>";
		
		//echo "<br>";
		
		
		if($index == 0){
			echo $row1; //number of rooms that need to return items within oneHour
		}else{
			echo $jsonObj;
		}
	} else {
		//nothing
	}
		
		
	
	
	
	
}else{ //array is empty, no need to make return alarm
	echo 0;
}










?>