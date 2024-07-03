<?php
namespace class_space;
//use PDO;

include "../class/class.php";
?>
<?php
require_once("../connection.php"); 

$jsonobj = $_GET['sth'];

$arr = json_decode($jsonobj, true); //json string to assoc array

$item_id = $arr["itemid"];
$locker_num = $arr["lockernum"];
$room_num = $arr["roomnum"];

$query1 = "SELECT * FROM `room_booking` WHERE room_number='$room_num' AND status = 'Occupying'";
$query_run1 = mysqli_query($conn, $query1);
$row1 = mysqli_num_rows($query_run1);
$rc1 = mysqli_fetch_assoc($query_run1);

$booking_id = $rc1['booking_id'];

$query2 = "SELECT * FROM `booking_info` WHERE booking_id='$booking_id'";
$query_run2 = mysqli_query($conn, $query2);
$row2 = mysqli_num_rows($query_run2);
$rc2 = mysqli_fetch_assoc($query_run2);

$organization_name = $rc2['organization_name'];
$representative_name = $rc2['representative_name'];
$contact_number = $rc2['contact_number'];

//get item details

$out_itemArray = array();

$itemArray0 = array();

$query3 = "SELECT * FROM `rental_item_category` WHERE item_id='$item_id' ";
$query_run3 = mysqli_query($conn, $query3);
$rc3 = mysqli_fetch_assoc($query_run3);

$item_name = $rc3['item_name'];
$qty = $rc3['qty'];

array_push($itemArray0, $item_id, $item_name, $qty);
array_push($out_itemArray, $itemArray0);

//upload to borrow record DB
$staffID = '2';

$ibc = new ItemBorrowingController();
$ibc->makeBorrowingRecord_SmartLocker($room_num, $booking_id, $out_itemArray, $staffID, $organization_name, $representative_name, $contact_number);



//======================update locker record change the status to borrowed

$sql4 = "SELECT locker_record.locker_record_id FROM `locker_record` WHERE `locker_number` = '$locker_num' AND `status` = 'placed' AND `item_id` = '$item_id' LIMIT 1";
$rs4 = mysqli_query($conn, $sql4) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc4 = mysqli_fetch_assoc($rs4);

$this_locker_record_id = $rc4['locker_record_id'];

$sql5 = "UPDATE locker_record SET status = 'borrowed' WHERE `locker_record_id` = '$this_locker_record_id'";
$rs5 = mysqli_query($conn, $sql5) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 

mysqli_free_result($query_run1);
mysqli_free_result($query_run2);
mysqli_free_result($query_run3);
mysqli_free_result($rs4);

mysqli_close($conn);

echo "OK";
?>