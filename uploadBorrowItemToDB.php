<?php
namespace class_space;
//use PDO;

include "./class/class.php";
?>
<?php

session_start();

require_once("connection.php"); //require_once() = used to embed PHP code from another file

if(!isset($_SESSION["itemArray"])){
	echo '<script type="text/javascript">'; 
	echo 'alert("Please choose items");';
	echo 'window.location.href = "borrow.php";';
	echo '</script>';
	die("HAHA");
}

$temp_itemArray = $_SESSION["itemArray"]; //copy an array

$itemArray = array();

foreach ($temp_itemArray as $value) {
  array_push($itemArray, $value);
}



//count the amount of identical items
$result = array_count_values(array_column($itemArray, 1));
//$result = array("Basketball"=>2, "Head Dryer"=>1);

//compare $itemArray and $result
foreach($result as $x => $x_value) {
  //echo "Key=" . $x . ", Value=" . $x_value;
  //echo "<br>";
  for($row = 0; $row < count($itemArray); $row++) {
  	for ($col = 0; $col < 1; $col++){ 
    	//echo $itemArray[$row][0];
        if($itemArray[$row][1] == $x){ //find equal name
        	//echo $itemArray[$row][1];
            if($itemArray[$row][2]<$x_value){
				//echo "not enough";
				//popup an alert box
            	//echo "<script>alert(\"".$itemArray[$row][1]." is not enough inventory\")</script>";
				//back to borrow.php
				//header("location: borrow.php"); //bug here
				//die("HAHA");
				echo '<script type="text/javascript">'; 
				echo 'alert("'.$itemArray[$row][1].' is not enough");';
				echo 'window.location.href = "borrow.php";';
				echo '</script>';
				die("HAHA");
            }else{
            	//echo "enough";
            }
        }else{
        	//echo "not match";
        }
        //echo $itemArray[$row][$col];
        //echo "<br>";
    }
  }
  //echo "<br>";
}

//get current date and roomNum and combine together

$roomNum = htmlspecialchars($_SESSION["room_Num"], ENT_QUOTES);

$staff = htmlspecialchars($_SESSION["staffID"], ENT_QUOTES);
$organization = htmlspecialchars($_SESSION["organization"], ENT_QUOTES);
$representative = htmlspecialchars($_SESSION["representative"], ENT_QUOTES);
$contact_number = htmlspecialchars($_SESSION["contact_number"], ENT_QUOTES);
date_default_timezone_set("Asia/Hong_Kong");
$borrow_date = date("Y-m-d");

$borrow_time = date("H:i:s");

/*===============================get the booking ID by room_Num=========================================*/
$query = "SELECT booking_id FROM `room_booking` WHERE room_number = '$roomNum' AND status = 'Occupying'";
$query_run = mysqli_query($conn, $query)
	or die(mysqli_error($conn));

$row = mysqli_num_rows($query_run);
$rc0 = mysqli_fetch_assoc($query_run);

$booking_id = $rc0['booking_id'];
/*===============================get the booking ID by room_Num=========================================*/


$ibc = new ItemBorrowingController();

$ibc->makeBorrowingRecord($roomNum, $booking_id, $itemArray, $staff, $organization, $representative, $contact_number);



//clear session
// remove all session variables
unset($_SESSION["itemArray"]);

unset($_SESSION["room_Num"]);
unset($_SESSION["organization"]);
unset($_SESSION["representative"]);
unset($_SESSION["contact_number"]);


//free memory

mysqli_close($conn);


// redirect to borrow.php

header("location: borrow.php");
?>
