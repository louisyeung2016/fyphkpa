<?php

include ('../connection.php');
date_default_timezone_set("Asia/Hong_Kong");

//box1

$query = "SELECT rental_id FROM `rental_record` WHERE status = 'borrow' ORDER BY rental_id";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run); //Total Loaned


$query = "SELECT SUM(qty) FROM `rental_item_category` WHERE item_status = 'Active'";  
$query_run = mysqli_query($conn, $query);
//$row = mysqli_num_rows($query_run);
$rc2 = mysqli_fetch_assoc($query_run);
$not_Yet_Loaned = $rc2['SUM(qty)']; //Not Yet Loaned

$box1_number1 = $row;
$box1_number2 = $not_Yet_Loaned;

//box2

$query = "SELECT * FROM `rental_record` WHERE status = 'borrow'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);

$query = "SELECT SUM(qty) FROM `rental_item_category` WHERE item_status = 'Active'";  
$query_run = mysqli_query($conn, $query);
//$row = mysqli_num_rows($query_run);
$rc2 = mysqli_fetch_assoc($query_run);

$total_item_qty = $rc2['SUM(qty)'];

$loan_out_ratio = ($row/($total_item_qty+$row));

$box2_number = round($loan_out_ratio,4)*2+1.5; //ITEM LOAN-OUT RATIO

//box3

$query = "SELECT DISTINCT room_number FROM `rental_record` WHERE status = 'borrow'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);

$box3_number = $row; //NUMBER OF ROOM BORROWING ITEMS

//box4

$query = "SELECT * FROM `rental_item_category` WHERE item_status = 'Active'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);

$box4_number = $row; //LOANABLE ITEM

//box5 - room status

$query = "SELECT * FROM `room_booking` WHERE room_number LIKE 'A%' AND status = 'Occupying'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);

$box5_number1 = $row; //8-Person Room number

$query = "SELECT * FROM `room_booking` WHERE room_number LIKE 'B%' AND status = 'Occupying'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);

$box5_number2 = $row; //4-Person Room number

$query = "SELECT * FROM `room_booking` WHERE room_number LIKE 'C%' AND status = 'Occupying'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);

$box5_number3 = $row; //2-Person Room number


//box6 - Tent Camp number

$query = "SELECT * FROM `room_booking` WHERE room_number LIKE 'Z%' AND status = 'Occupying'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);

$box6_number = $row; //Tent Camp number



//box7 - Day Camp number

$query = "SELECT * FROM `room_booking` WHERE room_number LIKE 'D%' AND status = 'Occupying'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);

$box7_number = $row; //Day Camp number



//box8 - Evening Camp number

$query = "SELECT * FROM `room_booking` WHERE room_number LIKE 'E%' AND status = 'Occupying'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);

$box8_number = $row; //Evening Camp number



//box9 - TODAY SALES VOLUME

$today_date = date("Y-m-d"); //2023-02-09

$query = "SELECT SUM(drinks_order.qty) FROM drinks_order, drinks_sold_record WHERE drinks_sold_record.order_id = drinks_order.order_id AND drinks_sold_record.order_date = '$today_date'";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);
$rc2 = mysqli_fetch_assoc($query_run);

if($rc2['SUM(drinks_order.qty)'] == null){
	$box9_number = 0;
}else{
	$box9_number = intval($rc2['SUM(drinks_order.qty)']); //TODAY SALES VOLUME
}








//box10 - SELLABLE DRINKS

$query = "SELECT * FROM `drinks_category` WHERE `drinks_status` = 'Active';";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);

$box10_number = $row; //SELLABLE DRINKS number






//box13
$query = "SELECT * FROM staff WHERE permission = 'Admin' AND status = 'Active' ";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);
$box13_number1 = $row; //number of Admin
//echo '<h5> Admin : '.$row.' </h5>';
$query = "SELECT * FROM staff WHERE permission = 'Manager' AND status = 'Active' ";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);
$box13_number2 = $row; //number of Manager
//echo '<h5> Manager : '.$row.' </h5>';
$query = "SELECT * FROM staff WHERE permission = 'Staff' AND status = 'Active' ";  
$query_run = mysqli_query($conn, $query);
$row = mysqli_num_rows($query_run);
$box13_number3 = $row; //number of Staff
//echo '<h5> Staff : '.$row.' </h5>';


//sub all data into array
$result_arr = array("box1_number1"=>$box1_number1,
					"box1_number2"=>$box1_number2, 
					"box2_number"=>$box2_number, 
					"box3_number"=>$box3_number, 
					"box4_number"=>$box4_number,
					"box5_number1"=>$box5_number1,
					"box5_number2"=>$box5_number2,
					"box5_number3"=>$box5_number3,
					"box6_number"=>$box6_number,
					"box7_number"=>$box7_number,
					"box8_number"=>$box8_number,
					"box9_number"=>$box9_number,
					"box10_number"=>$box10_number,
					"box13_number1"=>$box13_number1,
					"box13_number2"=>$box13_number2,
					"box13_number3"=>$box13_number3
					);

//convert array into json
$obj = json_encode($result_arr);

//echo the json
echo $obj; 










?>