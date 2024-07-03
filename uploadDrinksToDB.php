<?php
namespace class_space;
//use PDO;

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


session_start();

require_once("connection.php"); //require_once() = used to embed PHP code from another file

$staff = $_SESSION["staffID"];
date_default_timezone_set("Asia/Hong_Kong");
$order_date = date("Y-m-d");
$order_time = date("H:i:s");

echo $staff;

$orderIDprefix = date("Ymd");


$sql = "SELECT * FROM drinks_sold_record WHERE order_id LIKE '$orderIDprefix%' ORDER BY order_id DESC LIMIT 1"; //write the SQL statement
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

if(mysqli_num_rows($rs) <= 0){ //no record, should start from 0001
	$previous_order_id = $orderIDprefix."0000";
}else{ //had borrowed before, should start from the last rental ID plus one
	$previous_order_id = $rc['order_id'];
}




//make a function
/*
function createNewOrderId($order_id) {
  $prefix = substr($order_id,0,-4);

  $postfix = substr($order_id, 8);

  $int_postfix = intval($postfix);

  $new_int_postfix = $int_postfix + 1;
  
  if($new_int_postfix < 10){
  	$new_order_id = $prefix."000".strval($new_int_postfix);
  }else if($new_int_postfix >= 10 && $new_int_postfix < 100){
  	$new_order_id = $prefix."00".strval($new_int_postfix);
  }else if($new_int_postfix >= 100 && $new_int_postfix < 1000){
  	$new_order_id = $prefix."0".strval($new_int_postfix);
  }else if($new_int_postfix >= 1000 && $new_int_postfix < 10000){
  	$new_order_id = $prefix.strval($new_int_postfix);
  }else{
  	$new_order_id = $prefix."0000"; //over 9999 will become 0000
  }
  
  //$new_order_id = $prefix."000".strval($new_int_postfix);

  return $new_order_id;
}
*/

$drinksOrder_id_creater = new IDCreater();
$new_order_id = $drinksOrder_id_creater->getNewID($previous_order_id);

//$new_order_id = createNewOrderId($previous_order_id);

echo $new_order_id;


print_r($_POST);

/*------------------------------------------------------------------------------------*/

$jsonobj = $_POST['sth'];

//echo $jsonobj;

echo "<br>";

$arr = json_decode($jsonobj, true);

//var_dump($arr);

echo "length of shopping Cart: ".count($arr);

echo "<br>";
echo '\n';

$countDrinks = array(); //how many drinks ordered?
$total_sold_amount = 0;

for ($x = 0; $x < count($arr); $x++) {
	echo $arr[$x][1];
	echo $arr[$x][2];
	array_push($countDrinks,$arr[$x][1]);
	$total_sold_amount += $arr[$x][2];
	echo '\n';
}

print_r($countDrinks);



echo "total_sold_amount: HKD$".$total_sold_amount;

$DrinksTypeOrdered = array_count_values($countDrinks); //how many type of drinks ordered?
echo "Number of Drinks Type ordered: ".count($DrinksTypeOrdered);

print_r(array_count_values($countDrinks));


//echo $DrinksTypeOrdered[0]; //error because this is an associated array
//echo $DrinksTypeOrdered[1];



/*------------------------------------------------------------------------------------*/
/*--------------upload things to Database------------------------*/


$sql2 = "INSERT INTO drinks_sold_record (order_id, total_sold_amount, order_date, order_time, staff_id) VALUES ('$new_order_id', '$total_sold_amount', '$order_date', '$order_time', '$staff')"; 

$rs2 = mysqli_query($conn, $sql2) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 


//insert into drinks_order

foreach($DrinksTypeOrdered as $x => $x_value) {
	
	$sql3 = "SELECT * FROM drinks_category WHERE drinks_name = '$x'"; 
	$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 
	
	$rc3 = mysqli_fetch_assoc($rs3);
	
	$drinks_ID = $rc3['drinks_id'];
	$drinks_price = $rc3['price'];
	

	$sql4 = "INSERT INTO drinks_order (order_id, drinks_id, qty, price) VALUES ('$new_order_id', '$drinks_ID', '$x_value', '$drinks_price')"; 
	
	$rs4 = mysqli_query($conn, $sql4) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 

	
	
	$original_stockQuantity = $rc3['stock_qty'];
	
	$new_stockQuantity = $original_stockQuantity - $x_value;
	
	//update new stockQuantity to rental_item
	$sql5 = "UPDATE drinks_category SET stock_qty = $new_stockQuantity WHERE drinks_name = '$x'";
	$rs5 = mysqli_query($conn, $sql5) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 
}

//deduct drinks_category's stockQuantity from itemArray
//.................code here

//free memory
mysqli_free_result($rs); 
mysqli_free_result($rs3); 
mysqli_close($conn);

?>


