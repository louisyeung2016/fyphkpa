<?php
namespace class_space;
//this file is used for storing all class which will be repeatly used in other files
//the purpose is to reduce the hard-code and better maintenance

//this class is for creating new ID with pattern yyyymmdd{something}{4-digit sequence number}
//it maybe use in create dirnks sale ID, booking ID, rental ID
//new IDCreater()->getNewID($old_ID);
Class IDCreater{
	//index = 0 or other int, it will return new ID; index = 1, it will return yyyymmdd; index = 2, it will return new sequence number; 
	function getNewID($old_ID, $index=0){
		//20220926A010001
		//202209260001
		$sequence_num = substr($old_ID, -4); //0001
		$prefix_date = substr($old_ID, 0, -(strlen($old_ID)-8)); //20220926
		
		$prefix_justNoSequenceNum = substr($old_ID, 0, -4); //20220926A01 or 20220926
		
		$int_sequence_num = intval($sequence_num);

		$new_int_sequence_num = $int_sequence_num + 1;
		
		if($new_int_sequence_num < 10){
			$new_ID = $prefix_justNoSequenceNum."000".strval($new_int_sequence_num);
		}else if($new_int_sequence_num >= 10 && $new_int_sequence_num < 100){
			$new_ID = $prefix_justNoSequenceNum."00".strval($new_int_sequence_num);
		}else if($new_int_sequence_num >= 100 && $new_int_sequence_num < 1000){
			$new_ID = $prefix_justNoSequenceNum."0".strval($new_int_sequence_num);
		}else if($new_int_sequence_num >= 1000 && $new_int_sequence_num < 10000){
			$new_ID = $prefix_justNoSequenceNum.strval($new_int_sequence_num);
		}else{
			$new_ID = $prefix_justNoSequenceNum."0000"; //over 9999 will become 0000
		}
		
		if($index == 1){
			return $prefix_date; //20220926
		}else if($index == 2){
			return substr($new_ID, -4); // new sequence_num 0002
		}else{
			return $new_ID;
		}
		
	}
}

Class BookingIDCreater{ //Object Adapter
	public $idcreater;

	public function __construct() {
		$this->idcreater = new IDCreater();
	}
	
	function getNewID($old_ID, $index=0){
		//remove the 'B'
		$old_ID_without_B = ltrim($old_ID,"B");
		$new_ID = "B".$this->idcreater->getNewID($old_ID_without_B, $index);
		return $new_ID;
	}
}

Class ItemBorrowingController{
	private $link;

	function __construct(){
		$conn_location = __DIR__."/../connection.php";
		include($conn_location); //only change variables in connection.php
		//echo $db_host;
		$this->link= mysqli_connect($db_host,$db_user,$db_password,$db_db);
		if(mysqli_connect_errno()){
			die ("connection failed".mysqli_connect_errno());
		}
	}
	
	function makeBorrowingRecord($roomNum, $bookingID, array $itemArray, $staffID, $organization, $representative, $contact_number){
		//echo "room nuumber is ".$roomNum."<br>";
		//print_r($itemArray);
		$id_creater = new IDCreater();
		//echo $id_creater->getNewID('20220926A010001');
		date_default_timezone_set("Asia/Hong_Kong");
		$borrow_date = date("Y-m-d");
		$borrow_time = date("H:i:s");
		
		$query = "SELECT booking_id FROM `room_booking` WHERE room_number = '$roomNum' AND status = 'Occupying'";
		$query_run = mysqli_query($this->link, $query)
			or die(mysqli_error($this->link));

		$row = mysqli_num_rows($query_run);
		$rc0 = mysqli_fetch_assoc($query_run);

		$booking_id = $rc0['booking_id'];
		
		$rentalIDprefix = date("Ymd").$roomNum;
		
		$sql = "SELECT * FROM rental_record WHERE rental_id LIKE '$rentalIDprefix%' ORDER BY rental_id DESC LIMIT 1"; //write the SQL statement
		$rs = mysqli_query($this->link, $sql) //mysqli_query() function performs a query against a database.
			or die(mysqli_error($this->link));

		$rc = mysqli_fetch_assoc($rs);

		if(mysqli_num_rows($rs) <= 0){ //no record, should start from 0001
			$previous_rental_id = $rentalIDprefix."0000";
		}else{ //had borrowed before, should start from the last rental ID plus one
			$previous_rental_id = $rc['rental_id'];
		}
		
		//append a correct rentalID to every rental item in itemArray
		for($i = 0; $i < count($itemArray); $i++){
			//$new_rental_id = createNewRetailId($previous_rental_id);
			$new_rental_id = $id_creater->getNewID($previous_rental_id);
			array_push($itemArray[$i], $new_rental_id);
			$previous_rental_id = $new_rental_id;
		}
		
		foreach ($itemArray as $value){
			$itemID = $value[0];
			$rental_ID = $value[3];
			
			if($organization != "" ){
				$sql5 = "INSERT INTO rental_record (rental_id, item_id, booking_id, room_number, organization_name, representative_name, contact_number, borrow_date, borrow_time, borrow_staff_id, status) VALUES ('$rental_ID', '$itemID', '$booking_id', '$roomNum', '$organization', '$representative', '$contact_number', '$borrow_date', '$borrow_time', '$staffID', 'borrow')"; 
			}else{ //not neccessary
				$sql5 = "INSERT INTO rental_record (rental_id, item_id, booking_id, room_number, organization_name, borrow_date, borrow_time, borrow_staff, status) VALUES ('$rental_ID', '$itemID', '$booking_id', '$roomNum', NULL, '$borrow_date', '$borrow_time', '$staffID', 'borrow')"; 
			}
			
			
			
			$rs5 = mysqli_query($this->link, $sql5) //mysqli_query() function performs a query against a database.
			  or die(mysqli_error($this->link)); 
			
			//deduct stockQuantity from itemArray
			
			$sql6 = "SELECT * FROM rental_item_category WHERE item_id = '$itemID'"; 
			$rs6 = mysqli_query($this->link, $sql6) //mysqli_query() function performs a query against a database.
			  or die(mysqli_error($this->link)); 
			
			$rc6 = mysqli_fetch_assoc($rs6);
			
			$original_stockQuantity = $rc6['qty'];
			
			$new_stockQuantity = $original_stockQuantity - 1;
			
			//update new stockQuantity to rental_item_category 
			$sql7 = "UPDATE rental_item_category  SET qty = $new_stockQuantity WHERE item_id = '$itemID'";
			$rs7 = mysqli_query($this->link, $sql7) //mysqli_query() function performs a query against a database.
			  or die(mysqli_error($this->link)); 
		}
		
		mysqli_free_result($rs); 
		mysqli_free_result($rs6); 
		mysqli_close($this->link);
		
	}
	
	function makeBorrowingRecord_SmartLocker($roomNum, $bookingID, array $itemArray, $staffID, $organization, $representative, $contact_number){
		//echo "room nuumber is ".$roomNum."<br>";
		//print_r($itemArray);
		$id_creater = new IDCreater();
		//echo $id_creater->getNewID('20220926A010001');
		date_default_timezone_set("Asia/Hong_Kong");
		$borrow_date = date("Y-m-d");
		$borrow_time = date("H:i:s");
		
		$query = "SELECT booking_id FROM `room_booking` WHERE room_number = '$roomNum' AND status = 'Occupying'";
		$query_run = mysqli_query($this->link, $query)
			or die(mysqli_error($this->link));

		$row = mysqli_num_rows($query_run);
		$rc0 = mysqli_fetch_assoc($query_run);

		$booking_id = $rc0['booking_id'];
		
		$rentalIDprefix = date("Ymd").$roomNum;
		
		$sql = "SELECT * FROM rental_record WHERE rental_id LIKE '$rentalIDprefix%' ORDER BY rental_id DESC LIMIT 1"; //write the SQL statement
		$rs = mysqli_query($this->link, $sql) //mysqli_query() function performs a query against a database.
			or die(mysqli_error($this->link));

		$rc = mysqli_fetch_assoc($rs);

		if(mysqli_num_rows($rs) <= 0){ //no record, should start from 0001
			$previous_rental_id = $rentalIDprefix."0000";
		}else{ //had borrowed before, should start from the last rental ID plus one
			$previous_rental_id = $rc['rental_id'];
		}
		
		//append a correct rentalID to every rental item in itemArray
		for($i = 0; $i < count($itemArray); $i++){
			//$new_rental_id = createNewRetailId($previous_rental_id);
			$new_rental_id = $id_creater->getNewID($previous_rental_id);
			array_push($itemArray[$i], $new_rental_id);
			$previous_rental_id = $new_rental_id;
		}
		
		foreach ($itemArray as $value){
			$itemID = $value[0];
			$rental_ID = $value[3];
			
			if($organization != "" ){
				$sql5 = "INSERT INTO rental_record (rental_id, item_id, booking_id, room_number, organization_name, representative_name, contact_number, borrow_date, borrow_time, borrow_staff_id, status) VALUES ('$rental_ID', '$itemID', '$booking_id', '$roomNum', '$organization', '$representative', '$contact_number', '$borrow_date', '$borrow_time', '$staffID', 'borrow')"; 
			}else{ //not neccessary
				$sql5 = "INSERT INTO rental_record (rental_id, item_id, booking_id, room_number, organization_name, borrow_date, borrow_time, borrow_staff, status) VALUES ('$rental_ID', '$itemID', '$booking_id', '$roomNum', NULL, '$borrow_date', '$borrow_time', '$staffID', 'borrow')"; 
			}
			
			
			
			$rs5 = mysqli_query($this->link, $sql5) //mysqli_query() function performs a query against a database.
			  or die(mysqli_error($this->link)); 
			
			//deduct stockQuantity from itemArray
			//no need to do this, because it is already deducted when staff placing it in locker
			
		}
		
		mysqli_free_result($rs); 
		//mysqli_free_result($rs6); 
		mysqli_close($this->link);
		
	}
}
?>