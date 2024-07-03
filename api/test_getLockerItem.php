<?php
include('../connection.php');



//get items which being in Locker now from Database
$sql1 = "SELECT locker_record.item_id, rental_item_category.item_name FROM `locker_record` INNER JOIN `rental_item_category` ON locker_record.item_id = rental_item_category.item_id WHERE locker_record.status = 'placed' AND locker_record.locker_number = 1 LIMIT 1 ";
$rs1 = mysqli_query($conn, $sql1) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc1 = mysqli_fetch_assoc($rs1);

$lockerOne_itemID = "000";
$lockerOne_itemName = "No item Placed";

if(mysqli_num_rows($rs1) > 0){
	$lockerOne_itemID = $rc1['item_id'];
	$lockerOne_itemName = $rc1['item_name'];
}

$array_one = array($lockerOne_itemID, $lockerOne_itemName);

$sql2 = "SELECT locker_record.item_id, rental_item_category.item_name FROM `locker_record` INNER JOIN `rental_item_category` ON locker_record.item_id = rental_item_category.item_id WHERE locker_record.status = 'placed' AND locker_record.locker_number = 2 LIMIT 1 ";
$rs2 = mysqli_query($conn, $sql2) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc2 = mysqli_fetch_assoc($rs2);

$lockerTwo_itemID = "000";
$lockerTwo_itemName = "No item Placed";

if(mysqli_num_rows($rs2) > 0){
	$lockerTwo_itemID = $rc2['item_id'];
	$lockerTwo_itemName = $rc2['item_name'];
}

$array_two = array($lockerTwo_itemID, $lockerTwo_itemName);

$sql3 = "SELECT locker_record.item_id, rental_item_category.item_name FROM `locker_record` INNER JOIN `rental_item_category` ON locker_record.item_id = rental_item_category.item_id WHERE locker_record.status = 'placed' AND locker_record.locker_number = 3 LIMIT 1 ";
$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc3 = mysqli_fetch_assoc($rs3);

$lockerThree_itemID = "000";
$lockerThree_itemName = "No item Placed";

if(mysqli_num_rows($rs3) > 0){
	$lockerThree_itemID = $rc3['item_id'];
	$lockerThree_itemName = $rc3['item_name'];
}

$array_three = array($lockerThree_itemID, $lockerThree_itemName);

$sql4 = "SELECT locker_record.item_id, rental_item_category.item_name FROM `locker_record` INNER JOIN `rental_item_category` ON locker_record.item_id = rental_item_category.item_id WHERE locker_record.status = 'placed' AND locker_record.locker_number = 4 LIMIT 1 ";
$rs4 = mysqli_query($conn, $sql4) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc4 = mysqli_fetch_assoc($rs4);

$lockerFour_itemID = "000";
$lockerFour_itemName = "No item Placed";

if(mysqli_num_rows($rs4) > 0){
	$lockerFour_itemID = $rc4['item_id'];
	$lockerFour_itemName = $rc4['item_name'];
}

$array_four = array($lockerFour_itemID, $lockerFour_itemName);

$output_arr = array($array_one, $array_two, $array_three, $array_four);

$myJSON = json_encode($output_arr);

echo $myJSON;

?>