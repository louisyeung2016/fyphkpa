<?php
require_once("connection.php"); //require_once() = used to embed PHP code from another file


$bookingID = $_POST['booking_id'];

$jsonArray = array();
$jsonArray_bookedRooms = array();

$sql = "SELECT * FROM `booking_info` WHERE booking_id = '$bookingID';"; //write the SQL statement
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

if(mysqli_num_rows($rs) > 0){
	$jsonArray['organization_name'] = $rc['organization_name'];
	$jsonArray['representative_name'] = $rc['representative_name'];
	$jsonArray['contact_number'] = $rc['contact_number'];
	$jsonArray['no_of_male_camper'] = $rc['no_of_male_camper'];
	$jsonArray['no_of_female_camper'] = $rc['no_of_female_camper'];
	$jsonArray['camp_type'] = $rc['camp_type'];
	$jsonArray['special_rate'] = $rc['special_rate'];
	$jsonArray['total_number_of_room'] = $rc['total_number_of_room'];
	$jsonArray['checkin_date'] = $rc['checkin_date'];
	$jsonArray['checkin_time'] = $rc['checkin_time'];
	$jsonArray['checkout_date'] = $rc['checkout_date'];
	$jsonArray['checkout_time'] = $rc['checkout_time'];
	$jsonArray['no_of_nights'] = $rc['no_of_nights'];
	$jsonArray['total_room_charges'] = $rc['total_room_charges'];
	$jsonArray['other_charges'] = $rc['other_charges'];
	$jsonArray['total_payment'] = $rc['total_payment'];
	$jsonArray['payment_status'] = $rc['payment_status'];
	$jsonArray['tenant_deposit_amount'] = $rc['tenant_deposit_amount'];
	$jsonArray['outstanding_balance'] = $rc['outstanding_balance'];
	$jsonArray['booking_status'] = $rc['booking_status'];
	
	$staffID = $rc['staff_id'];
	$jsonArray['staff_id'] = $staffID;
	
	//get the staff name by staff_id
	$sql1 = "SELECT staff_name FROM `staff` WHERE staff_id = '$staffID';"; //write the SQL statement
	$rs1 = mysqli_query($conn, $sql1) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn));

	$rc1 = mysqli_fetch_assoc($rs1);

	$jsonArray['staff_name'] = $rc1['staff_name'];
	
	//get all booked rooms of this booking_id
	$sql2 = "SELECT room_number FROM `room_booking` WHERE booking_id = '$bookingID';"; //write the SQL statement
	$rs2 = mysqli_query($conn, $sql2) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn));

	$rc2 = mysqli_fetch_assoc($rs2);
	
	if (mysqli_num_rows($rs2) > 0) {
		do {
			array_push($jsonArray_bookedRooms, $rc2['room_number']);
		}
		while ($rc2 = mysqli_fetch_assoc($rs2));
	}else{
		//nothing
	}
	
	$jsonArray['booked_rooms'] = $jsonArray_bookedRooms;
	
	//make JSON
	$jsonObj = json_encode($jsonArray); 
	
	echo $jsonObj;
	
	//free memory
	mysqli_free_result($rs1);
	mysqli_free_result($rs2);
}else{
	echo 0;
}



//free memory
mysqli_free_result($rs); 
mysqli_close($conn);

?>


