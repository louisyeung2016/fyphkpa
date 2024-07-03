<?php
include('permissionA.php');
include('connection.php');

if(!isset($_POST['dataType'],$_POST['startMonth'],$_POST['endMonth'])){
	include('./error/404.php');
	header("HTTP/1.1 404 Not Found");
	header("Refresh:3; url=./dashboard.php", TRUE, 301);
	exit;
}else{
	
	$dataType = $_POST['dataType'];
	$startMonth = $_POST['startMonth']."-01"; //2023-11
	$endMonth = $_POST['endMonth']."-01"; //2023-11

	//echo $dataType;

	if($dataType == "2"){
		$dataType = "item_borrow";
		$query = $conn->query("SELECT * FROM `rental_record` WHERE borrow_date BETWEEN '$startMonth' AND LAST_DAY('$endMonth')"); 
		//if($query->num_rows > 0){ 
		$delimiter = ","; 
		$filename = str_replace(" ","_","$dataType") ."_". date('Y-m-d') . ".csv"; 
		 
		// Create a file pointer 
		$f = fopen('php://memory', 'w'); 
		 
		// output BOM
		//fwrite($f, "\xEF\xBB\xBF");
		
		// Set column headers 
		$fields = array('rental_id', 'item_id', 'booking_id', 'room_number', 'organization_name', 'representative_name', 'contact_number', 'borrow_date', 'borrow_time', 'borrow_staff_id', 'return_date', 'return_time', 'return_staff_id', 'status', 'compensation'); 
		fputcsv($f, $fields, $delimiter); 
		if($query->num_rows > 0){ 
			// Output each row of the data, format line as csv and write to file pointer 
			while($row = $query->fetch_assoc()){ 
				//$status = ($row['status'] == 1)?'Active':'Inactive'; 
				$lineData = array($row['rental_id'], $row['item_id'], $row['booking_id'], $row['room_number'], mb_convert_encoding($row['organization_name'],"big5","utf-8"), mb_convert_encoding($row['representative_name'],"big5","utf-8"), $row['contact_number'], $row['borrow_date'], $row['borrow_time'], $row['borrow_staff_id'], $row['return_date'], $row['return_time'], $row['return_staff_id'], $row['status']); 
				if($row['status'] == "brokenOrlost"){
					$rental_id = $row['rental_id'];
					$query2 = $conn->query("SELECT compensation_price FROM `compensation` WHERE rental_id='$rental_id'");
					$row2 = $query2->fetch_assoc();
					array_push($lineData, $row2['compensation_price']);
				}
				fputcsv($f, $lineData, $delimiter); 
			} 
		}	 
		// Move back to beginning of file 
		fseek($f, 0); 
		 
		// Set headers to download file rather than displayed 
		header('Content-Type: text/csv'); 
		header('Content-Disposition: attachment; filename="' . $filename . '";'); 
		 
		//output all remaining data on a file pointer 
		fpassthru($f); 
		 
		exit; 
	}else if($dataType == "3"){
		$dataType = "room_booking";
		$query = $conn->query("SELECT * FROM `booking_info` WHERE checkin_date BETWEEN '$startMonth' AND LAST_DAY('$endMonth')"); 
		
		$delimiter = ","; 
		$filename = str_replace(" ","_","$dataType") ."_". date('Y-m-d') . ".csv"; 
		 
		// Create a file pointer 
		$f = fopen('php://memory', 'w'); 

		// Set column headers 
		$fields = array('booking_id', 'organization_name', 'representative_name', 'contact_number', 'no_of_male_camper', 'no_of_female_camper', 'camp_type', 'special_rate', 'no_of_8_person_dormitory', 'no_of_4_person_dormitory', 'no_of_2_person_dormitory', 'total_number_of_room', 'checkin_date', 'checkin_time', 'checkout_date', 'checkout_time', 'no_of_nights', 'total_room_charges', 'other_charges', 'total_payment', 'payment_status', 'tenant_deposit_amount', 'outstanding_balance', 'booking_status', 'staff_id', 'booked_rooms'); 
		fputcsv($f, $fields, $delimiter); 
		if($query->num_rows > 0){ 
			// Output each row of the data, format line as csv and write to file pointer 
			while($row = $query->fetch_assoc()){ 
				//$status = ($row['status'] == 1)?'Active':'Inactive'; 
				$lineData = array($row['booking_id'], mb_convert_encoding($row['organization_name'],"big5","utf-8"), mb_convert_encoding($row['representative_name'],"big5","utf-8"), $row['contact_number'], $row['no_of_male_camper'], $row['no_of_female_camper'], mb_convert_encoding($row['camp_type'],"big5","utf-8"), $row['special_rate'], $row['no_of_8_person_dormitory'], $row['no_of_4_person_dormitory'], $row['no_of_2_person_dormitory'], $row['total_number_of_room'], $row['checkin_date'], $row['checkin_time'], $row['checkout_date'], $row['checkout_time'], $row['no_of_nights'], $row['total_room_charges'], $row['other_charges'], $row['total_payment'], $row['payment_status'], $row['tenant_deposit_amount'], $row['outstanding_balance'], $row['booking_status'], $row['staff_id']); 
				
					$booking_id = $row['booking_id'];
					$booked_rooms_arr = array();
					$query2 = $conn->query("SELECT room_number FROM `room_booking` WHERE booking_id='$booking_id'");
					while($row2 = $query2->fetch_assoc()){
						array_push($booked_rooms_arr, $row2['room_number']);
					}
					$txt = implode(" ",$booked_rooms_arr);
					
					array_push($lineData, $txt);
				
				fputcsv($f, $lineData, $delimiter); 
			} 
		}	 
		// Move back to beginning of file 
		fseek($f, 0); 
		 
		// Set headers to download file rather than displayed 
		header('Content-Type: text/csv'); 
		header('Content-Disposition: attachment; filename="' . $filename . '";'); 
		 
		//output all remaining data on a file pointer 
		fpassthru($f); 
		 
		exit; 
	}else if($dataType == "1"){
		$dataType = "drinks_sales";
		$query = $conn->query("SELECT drinks_sold_record.*, drinks_order.drinks_id, drinks_order.qty, drinks_order.price FROM drinks_sold_record CROSS JOIN drinks_order WHERE drinks_order.order_id = drinks_sold_record.order_id AND (drinks_sold_record.order_date BETWEEN '$startMonth' AND LAST_DAY('$endMonth'))"); 
		
		$delimiter = ","; 
		$filename = str_replace(" ","_","$dataType") ."_". date('Y-m-d') . ".csv"; 
		 
		// Create a file pointer 
		$f = fopen('php://memory', 'w'); 
		
		// Set column headers 
		$fields = array('order_id', 'total_sold_amount', 'order_date', 'order_time', 'staff_id', 'drinks_id', 'qty', 'price'); 
		fputcsv($f, $fields, $delimiter); 
		if($query->num_rows > 0){ 
			// Output each row of the data, format line as csv and write to file pointer 
			while($row = $query->fetch_assoc()){ 
				$lineData = array($row['order_id'], $row['total_sold_amount'], $row['order_date'], $row['order_time'], $row['staff_id'], $row['drinks_id'], $row['qty'], $row['price']); 

				fputcsv($f, $lineData, $delimiter); 
			} 
		}	 
		// Move back to beginning of file 
		fseek($f, 0); 
		 
		// Set headers to download file rather than displayed 
		header('Content-Type: text/csv'); 
		header('Content-Disposition: attachment; filename="' . $filename . '";'); 
		 
		//output all remaining data on a file pointer 
		fpassthru($f); 
		 
		exit; 
	}

}
?>