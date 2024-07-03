<?php
namespace class_space;
//use PDO;

include "./class/class.php";
?>
<?php
if(!isset($_POST['booking_id'])){
	include('./error/404.php');
	header("HTTP/1.1 404 Not Found");
	header("Refresh:3; url=./dashboard.php", TRUE, 301);
	exit;
}else{
	//do things below
}


session_start();

require_once("connection.php"); 

$booking_id = $_POST['booking_id'];
$staff = $_SESSION["staffID"];

//check whether it is 團體營/家庭營/日營/黃昏營/露營

//if it is 團體營/家庭營, check whether the rooms is bring occupying or not

//if it is 日營/黃昏營/露營, check whether other 日營/黃昏營/露營 is exist, room number will adjust D0(n+1) e.g. D01-->D04
//only 4 日營/黃昏營/露營 can be exist at the same time
//how many 日營/黃昏營/露營 can be exist at the same time?????????????????????????????????


$query1 = "SELECT * FROM `booking_info` WHERE booking_id='$booking_id' AND booking_status = 'Effective'";
$query_run1 = mysqli_query($conn, $query1);
$row1 = mysqli_num_rows($query_run1);
$rc1 = mysqli_fetch_assoc($query_run1);
$camp_type = $rc1['camp_type'];

$organization = $rc1['organization_name'];
$representative = $rc1['representative_name'];
$contact_number = $rc1['contact_number'];

//echo $camp_type;


if($camp_type=="團體營"||$camp_type=="家庭營"||$camp_type=="Organizational Booking"||$camp_type=="Individual Booking"){
	$reserved_booking_room_arr = array();
	$occupying_booking_room_arr = array();
	
	$inactivate_rooms_arr = array();
	
	$query2 = "SELECT room_number FROM `room_booking` WHERE booking_id='$booking_id' AND status = 'Reserved'";
	$query_run2 = mysqli_query($conn, $query2);
	$row2 = mysqli_num_rows($query_run2);
	$rc2 = mysqli_fetch_assoc($query_run2);
	do {
		array_push($reserved_booking_room_arr, $rc2['room_number']);
	} while ($rc2 = mysqli_fetch_assoc($query_run2));
	
	$query3 = "SELECT room_number FROM `room_booking` WHERE status = 'Occupying'";
	$query_run3 = mysqli_query($conn, $query3);
	$row3 = mysqli_num_rows($query_run3);
	$rc3 = mysqli_fetch_assoc($query_run3);
	if($row3 > 0){
		do {
			array_push($occupying_booking_room_arr, $rc3['room_number']);
		} while ($rc3 = mysqli_fetch_assoc($query_run3));
	}

	//check whether the booked rooms is active or inactive, if inactive, reject check in
	$query2a = "SELECT * FROM `room_booking`, `room_category` WHERE room_booking.booking_id='$booking_id' AND room_booking.status = 'Reserved' AND room_booking.room_number = room_category.room_number AND room_category.room_status = 'inActivate'";
	$query_run2a = mysqli_query($conn, $query2a);
	$row2a = mysqli_num_rows($query_run2a);
	$rc2a = mysqli_fetch_assoc($query_run2a);
	if($row2a > 0){ //some room is inActivate, reject the check in
		do {
			array_push($inactivate_rooms_arr, $rc2a['room_number']);
		} while ($rc2a = mysqli_fetch_assoc($query_run2a));
		
		$jsonArray = array(-1,$inactivate_rooms_arr);

		echo json_encode($jsonArray);
	}else{
		//print_r($reserved_booking_room_arr);
		//print_r(";");
		//print_r($occupying_booking_room_arr);
		
		//compare any element intersect in this two arrays
		//if yes --> problem; if no --> OK
		$intersect_result = array_intersect($reserved_booking_room_arr,$occupying_booking_room_arr);
		//print_r($intersect_result);
		
		if(empty($intersect_result)){
			//update all records in room_booking from 'Occupying' to 'Checkedout'
			$query4 = "UPDATE `room_booking` SET status = 'Occupying' WHERE booking_id = '$booking_id'";
			$query_run4 = mysqli_query($conn, $query4)
			  or die(mysqli_error($conn)); 
			//echo "no intersect";
			
			//=========================================borrow the room keys to each room===============================
			//step1: make itemArray of roomKey
			
			
			foreach ($reserved_booking_room_arr as $reserved_booking_roomNum) {
				$ibc = new ItemBorrowingController();
				$roomKey_itemArray = array();
				
				$searchKey = $reserved_booking_roomNum."%";
				$itemArray0 = array();
				
				$query4a = "SELECT * FROM `rental_item_category` WHERE `item_name` LIKE '$searchKey' ";
				$query_run4a = mysqli_query($conn, $query4a);
				$rc4a = mysqli_fetch_assoc($query_run4a);
				$item_id = $rc4a['item_id'];
				$item_name = $rc4a['item_name'];
				$qty = $rc4a['qty'];
				
				array_push($itemArray0, $item_id, $item_name, $qty);
				array_push($roomKey_itemArray, $itemArray0);
				
				//step2: borrow all the key
				$ibc->makeBorrowingRecord($reserved_booking_roomNum, $booking_id, $roomKey_itemArray, $staff, $organization, $representative, $contact_number);
				
			} //finish itemArray of roomKey
			
			
			$jsonArray = array(1, "Check-in successful");
			
			echo json_encode($jsonArray);
		}else{
			//echo "intersect"; //problem!
			$jsonArray = array(0, "Some rooms are being occupyed by other Bookings\nPlease check-out other Bookings to leave room for new Booking");
			
			echo json_encode($jsonArray);
		}
	}


	

	
}else{ //日營/黃昏營/露營
	if($camp_type=="日營"||$camp_type=="Day Camping"){
		$query5 = "SELECT room_number FROM `room_booking` WHERE room_number LIKE 'D%' AND status = 'Occupying' ORDER BY room_number DESC";
		$query5a = "SELECT * FROM `room_category` WHERE room_number LIKE 'D%' AND room_status = 'Activate' AND NOT room_number = 'D00'";
	}else if($camp_type=="黃昏營"||$camp_type=="Evening Camping"){
		$query5 = "SELECT room_number FROM `room_booking` WHERE room_number LIKE 'E%' AND status = 'Occupying' ORDER BY room_number DESC";
		$query5a = "SELECT * FROM `room_category` WHERE room_number LIKE 'E%' AND room_status = 'Activate' AND NOT room_number = 'E00'";
	}else{//露營
		$query5 = "SELECT room_number FROM `room_booking` WHERE room_number LIKE 'Z%' AND status = 'Occupying' ORDER BY room_number DESC";
		$query5a = "SELECT * FROM `room_category` WHERE room_number LIKE 'Z%' AND room_status = 'Activate' AND NOT room_number = 'Z00'";
	}
	
	$query_run5 = mysqli_query($conn, $query5);
	$row5 = mysqli_num_rows($query_run5);
	$rc5 = mysqli_fetch_assoc($query_run5);
	
	$query_run5a = mysqli_query($conn, $query5a);
	$row5a = mysqli_num_rows($query_run5a);
	$rc5a = mysqli_fetch_assoc($query_run5a);
	
	if($row5>3){ //there are 4 bookings occupying
		$jsonArray = array(2, "no more than 4 bookings check-in for Day Camping/Evening Camping/Tent Camping at the sametime");
		//echo $jsonArray;
		echo json_encode($jsonArray);
	}else{
		//echo $row5;
		//echo $rc5['room_number'];
		//print_r( $rc5);
		$now_occupying_array = array(); //to store all D01, D02... which are been occupying
		$all_room_in_selected_camptype_array = array(); //to store all D01, D02... 
		
		if($row5>0){
			do {
				array_push($now_occupying_array, $rc5['room_number']);
			} while ($rc5 = mysqli_fetch_assoc($query_run5));
		}
		
		do {
			array_push($all_room_in_selected_camptype_array, $rc5a['room_number']);
		} while ($rc5a = mysqli_fetch_assoc($query_run5a));
		
		$compare_result_arr = array_diff($all_room_in_selected_camptype_array,$now_occupying_array);
		
		$index_compare_result_arr = array_values($compare_result_arr); //re-order array from associative to indexed
		
		$the_target_roomNum = $index_compare_result_arr[0];
		
		//=========================================borrow the room keys to each room===============================
		
		
		//echo $the_target_roomNum; //test
		//echo $booking_id; //test
		
		/*
		//
		$last_room_number = $rc5['room_number'];
		
		//make a new room number e.g. D0(2+1)
		$firstTwoChar = substr($last_room_number,0,2); //D0
		$lastOneChar = substr($last_room_number,-1,1); //2
		
		//echo $firstTwoChar." : ".$lastOneChar;
		
		$int_lastOneChar = intval($lastOneChar);

		$new_int_lastOneChar = $int_lastOneChar + 1;
		
		$new_room_number = $firstTwoChar.strval($new_int_lastOneChar); //D03
		
		//echo $new_room_number;
		*/
		//update all records in room_booking from 'Occupying' to 'Checkedout'
		$query6 = "UPDATE `room_booking` SET status = 'Occupying', room_number = '$the_target_roomNum' WHERE booking_id = '$booking_id'";
		$query_run6 = mysqli_query($conn, $query6) //mysqli_query() function performs a query against a database.
		  or die(mysqli_error($conn)); 
		
		$ibc = new ItemBorrowingController();
		$roomKey_itemArray = array();
		
		$searchKey = $the_target_roomNum."%";
		$itemArray0 = array();
		
		$query5b = "SELECT * FROM `rental_item_category` WHERE `item_name` LIKE '$searchKey' ";
		$query_run5b = mysqli_query($conn, $query5b);
		$rc5b = mysqli_fetch_assoc($query_run5b);
		$item_id = $rc5b['item_id'];
		$item_name = $rc5b['item_name'];
		$qty = $rc5b['qty'];
		
		array_push($itemArray0, $item_id, $item_name, $qty);
		array_push($roomKey_itemArray, $itemArray0);
		
		//step2: borrow all the key
		$ibc->makeBorrowingRecord($the_target_roomNum, $booking_id, $roomKey_itemArray, $staff, $organization, $representative, $contact_number);

		
		$jsonArray = array(1, "Check-in successful");
			
		echo json_encode($jsonArray);
	}
}
?>