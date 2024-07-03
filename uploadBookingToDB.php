<?php
namespace class_space;
use PDO;

include "./class/class.php";
?>
<?php

if(!isset($_POST['sth'])){
	include('./error/404.php');
	header("HTTP/1.1 404 Not Found");
	header("Refresh:3; url=./dashboard.php", TRUE, 301);
	exit;
}else{
	//do things below
}


require_once("connection.php"); //require_once() = used to embed PHP code from another file
session_start();
date_default_timezone_set("Asia/Hong_Kong");

$jsonobj = $_POST['sth'];

//echo $jsonobj;
//$jsonobj = '{"Peter":35,"Ben":37,"Joe":43}';

//echo "<br>";

$arr = json_decode($jsonobj, true);

//var_dump($arr);

/*
echo $arr["list_organizationName"];
echo $arr["list_representativeName"];
echo $arr["list_phoneNumber"];
echo $arr["list_manNumber"];
echo $arr["list_womanNumber"];
echo $arr["list_campType"];
echo $arr["list_specialRate"];
//echo $arr["person_8_Dormitory_array"];
//echo $arr["person_4_Dormitory_array"];
//echo $arr["person_2_Dormitory_array"];
echo $arr["list_checkInDate"];
echo $arr["list_checkInTime"];
echo $arr["list_checkOutDate"];
echo $arr["list_checkOutTime"];
echo $arr["list_totalDays"];
echo $arr["list_totalRoomPrice"];
echo $arr["list_otherPrice"];
echo $arr["list_totalPrice"];
echo $arr["list_paymentStatus"];
echo $arr["list_paidAmount"];
echo $arr["list_outstandingBalance"];
*/


//echo count($arr["person_8_Dormitory_array"]);
//echo $arr["person_8_Dormitory_array"][0];

//==================================================================================

$bookingIDprefix = "B".date("dmY"); //today's data plus 'B' stands for Booking  e.g. B25062023

//echo $bookingIDprefix;

try {
  $conn_PDO = new PDO("mysql:host=$db_host;dbname=$db_db", $db_user, $db_password);
  $conn_PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $conn_PDO->prepare("SELECT * FROM `booking_info` WHERE booking_id LIKE '$bookingIDprefix%' ORDER BY booking_id DESC LIMIT 1");
  $stmt->execute();

  // set the resulting array to associative
  //$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  
  $row = $stmt->fetch(); //Getting a single row
  //$row = $stmt->fetchAll(); //Selecting multiple rows as an array
  //var_dump($row);
  //echo $row["booking_id"];
  
  //find any booking created with above booking prefix
  //if no, create new one starting with 0001
  //if yes, create new one continuing from the last one e.g. 0002
  if ($stmt->rowCount() > 0) {
	//echo "HAHA".$stmt->rowCount()."HEHE";
	//echo "yes";
	$previous_booking_id = $row["booking_id"];
  }else{
	//echo "HAHA".$stmt->rowCount()."HEHE";
	//echo "no";
	$previous_booking_id = $bookingIDprefix."0000";
  }
  
  
  $booking_id_creater = new BookingIDCreater();
  $new_ID = $booking_id_creater->getNewID($previous_booking_id);
  
  echo $new_ID;
  
  //insert into DB
  // prepare sql and bind parameters
  $stmt2 = $conn_PDO->prepare("INSERT INTO `booking_info` (booking_id, organization_name, representative_name, contact_number, no_of_male_camper, no_of_female_camper, camp_type, special_rate, no_of_8_person_dormitory, no_of_4_person_dormitory, no_of_2_person_dormitory, total_number_of_room, checkin_date, checkin_time, checkout_date, checkout_time, no_of_nights, total_room_charges, other_charges, total_payment, payment_status, tenant_deposit_amount, outstanding_balance, booking_status, staff_id) VALUES (:booking_id, :organization_name, :representative_name, :contact_number, :no_of_male_camper, :no_of_female_camper, :camp_type, :special_rate, :no_of_8_person_dormitory, :no_of_4_person_dormitory, :no_of_2_person_dormitory, :total_number_of_room, :checkin_date, :checkin_time, :checkout_date, :checkout_time, :no_of_nights, :total_room_charges, :other_charges, :total_payment, :payment_status, :tenant_deposit_amount, :outstanding_balance, :booking_status, :staff_id)");
  $stmt2->bindParam(':booking_id', $booking_id);
  $stmt2->bindParam(':organization_name', $organization_name);
  $stmt2->bindParam(':representative_name', $representative_name);
  $stmt2->bindParam(':contact_number', $contact_number);
  $stmt2->bindParam(':no_of_male_camper', $no_of_male_camper);
  $stmt2->bindParam(':no_of_female_camper', $no_of_female_camper);
  $stmt2->bindParam(':camp_type', $camp_type);
  $stmt2->bindParam(':special_rate', $special_rate);
  $stmt2->bindParam(':no_of_8_person_dormitory', $no_of_8_person_dormitory);
  $stmt2->bindParam(':no_of_4_person_dormitory', $no_of_4_person_dormitory);
  $stmt2->bindParam(':no_of_2_person_dormitory', $no_of_2_person_dormitory);
  $stmt2->bindParam(':total_number_of_room', $total_number_of_room);
  $stmt2->bindParam(':checkin_date', $checkin_date);
  $stmt2->bindParam(':checkin_time', $checkin_time);
  $stmt2->bindParam(':checkout_date', $checkout_date);
  $stmt2->bindParam(':checkout_time', $checkout_time);
  $stmt2->bindParam(':no_of_nights', $no_of_nights);
  $stmt2->bindParam(':total_room_charges', $total_room_charges);
  $stmt2->bindParam(':other_charges', $other_charges);
  $stmt2->bindParam(':total_payment', $total_payment);
  $stmt2->bindParam(':payment_status', $payment_status);
  $stmt2->bindParam(':tenant_deposit_amount', $tenant_deposit_amount);
  $stmt2->bindParam(':outstanding_balance', $outstanding_balance);
  $stmt2->bindParam(':booking_status', $booking_status);
  $stmt2->bindParam(':staff_id', $staff_id);

  // insert a row
  $booking_id = $new_ID;
  $organization_name = htmlspecialchars($arr["list_organizationName"], ENT_QUOTES);
  $representative_name = htmlspecialchars($arr["list_representativeName"], ENT_QUOTES);
  $contact_number = htmlspecialchars($arr["list_phoneNumber"], ENT_QUOTES);
  $no_of_male_camper = htmlspecialchars($arr["list_manNumber"], ENT_QUOTES);
  $no_of_female_camper = htmlspecialchars($arr["list_womanNumber"], ENT_QUOTES);
  $camp_type = htmlspecialchars($arr["list_campType"], ENT_QUOTES);
  $special_rate = htmlspecialchars($arr["list_specialRate"], ENT_QUOTES);
  $no_of_8_person_dormitory = count($arr["person_8_Dormitory_array"]);
  $no_of_4_person_dormitory = count($arr["person_4_Dormitory_array"]);
  $no_of_2_person_dormitory = count($arr["person_2_Dormitory_array"]);
  $total_number_of_room = count($arr["person_8_Dormitory_array"]) + count($arr["person_4_Dormitory_array"]) + count($arr["person_2_Dormitory_array"]);
  $checkin_date = $arr["list_checkInDate"];
  $checkin_time = $arr["list_checkInTime"];
  $checkout_date = $arr["list_checkOutDate"];
  $checkout_time = $arr["list_checkOutTime"];
  $no_of_nights = htmlspecialchars($arr["list_totalDays"], ENT_QUOTES);
  $total_room_charges = $arr["list_totalRoomPrice"];
  $other_charges = $arr["list_otherPrice"];
  $total_payment = $arr["list_totalPrice"];
  $payment_status = htmlspecialchars($arr["list_paymentStatus"], ENT_QUOTES);
  $tenant_deposit_amount = $arr["list_paidAmount"];
  $outstanding_balance = $arr["list_outstandingBalance"];
  $booking_status = "Effective";
  $staff_id = $_SESSION["staffID"];
  $stmt2->execute();
  
  echo "New booking records created successfully";
  
  
  
  //Reserve the rooms for the booking
  if(count($arr["person_8_Dormitory_array"])>0){
	foreach ($arr["person_8_Dormitory_array"] as $roomNum) {
		$stmt3 = $conn_PDO->prepare("INSERT INTO `room_booking` (booking_id, room_number, status) VALUES (:booking_id, :room_number, :status)");
		$stmt3->bindParam(':booking_id', $booking_id);
		$stmt3->bindParam(':room_number', $room_number);
		$stmt3->bindParam(':status', $status);

		// insert a row
		$booking_id = $new_ID;
		$room_number = $roomNum;
		$status = "Reserved";
		$stmt3->execute();
	}
  }
  
  if(count($arr["person_4_Dormitory_array"])>0){
	foreach ($arr["person_4_Dormitory_array"] as $roomNum) {
		$stmt3 = $conn_PDO->prepare("INSERT INTO `room_booking` (booking_id, room_number, status) VALUES (:booking_id, :room_number, :status)");
		$stmt3->bindParam(':booking_id', $booking_id);
		$stmt3->bindParam(':room_number', $room_number);
		$stmt3->bindParam(':status', $status);

		// insert a row
		$booking_id = $new_ID;
		$room_number = $roomNum;
		$status = "Reserved";
		$stmt3->execute();
	}
  }
  
  if(count($arr["person_2_Dormitory_array"])>0){
	foreach ($arr["person_2_Dormitory_array"] as $roomNum) {
		$stmt3 = $conn_PDO->prepare("INSERT INTO `room_booking` (booking_id, room_number, status) VALUES (:booking_id, :room_number, :status)");
		$stmt3->bindParam(':booking_id', $booking_id);
		$stmt3->bindParam(':room_number', $room_number);
		$stmt3->bindParam(':status', $status);

		// insert a row
		$booking_id = $new_ID;
		$room_number = $roomNum;
		$status = "Reserved";
		$stmt3->execute();
	}
  }
  
  //if camp type is Tent/Day/Evening, assign Z01/D01/E01
  if($arr["list_campType"]=="日營" || $arr["list_campType"]=="Day Camping"){
	$stmt3 = $conn_PDO->prepare("INSERT INTO `room_booking` (booking_id, room_number, status) VALUES (:booking_id, :room_number, :status)");
	$stmt3->bindParam(':booking_id', $booking_id);
	$stmt3->bindParam(':room_number', $room_number);
	$stmt3->bindParam(':status', $status);

	// insert a row
	$booking_id = $new_ID;
	$room_number = "D00";
	$status = "Reserved";
	$stmt3->execute();
  }elseif($arr["list_campType"]=="黃昏營" || $arr["list_campType"]=="Evening Camping"){
	$stmt3 = $conn_PDO->prepare("INSERT INTO `room_booking` (booking_id, room_number, status) VALUES (:booking_id, :room_number, :status)");
	$stmt3->bindParam(':booking_id', $booking_id);
	$stmt3->bindParam(':room_number', $room_number);
	$stmt3->bindParam(':status', $status);

	// insert a row
	$booking_id = $new_ID;
	$room_number = "E00";
	$status = "Reserved";
	$stmt3->execute();
  }elseif($arr["list_campType"]=="露營" || $arr["list_campType"]=="Tent Camping"){
	$stmt3 = $conn_PDO->prepare("INSERT INTO `room_booking` (booking_id, room_number, status) VALUES (:booking_id, :room_number, :status)");
	$stmt3->bindParam(':booking_id', $booking_id);
	$stmt3->bindParam(':room_number', $room_number);
	$stmt3->bindParam(':status', $status);

	// insert a row
	$booking_id = $new_ID;
	$room_number = "Z00";
	$status = "Reserved";
	$stmt3->execute();
  }
  
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

$conn_PDO = null;



?>