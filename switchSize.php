<?php
require_once("connection.php");
session_start();

$staffID = $_SESSION["staffID"];
//$fontSizeIndex = $_SESSION["fontSizeIndex"];

//0=Normal Size; 1=Large Size

if(!isset($_SESSION["fontSizeIndex"])){
	$_SESSION["fontSizeIndex"] = 0; 
}

if($_SESSION["fontSizeIndex"] == 0){
	$_SESSION["fontSizeIndex"] = 1;
}elseif($_SESSION["fontSizeIndex"] == 1){
	$_SESSION["fontSizeIndex"] = 0;
}else{
	$_SESSION["fontSizeIndex"] = 0;
}

//save Font Size preference to DB
//...
$sql = "SELECT `preference_index` FROM `staff` WHERE `staff`.`staff_id` = '$staffID' ";
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

$preference_index = $rc['preference_index'];

$preference_index_fontSize = intval($preference_index[1]);
if($preference_index_fontSize == 0){
	$preference_index_fontSize = 1;
}else{
	$preference_index_fontSize = 0;
}

$updated_preference_index = $preference_index[0].strval($preference_index_fontSize).$preference_index[2];

//echo $updated_preference_index;
//echo gettype($updated_preference_index);

//update to dba_close
$sql_update = "UPDATE `staff` SET `preference_index` = '$updated_preference_index' WHERE `staff_id` = '$staffID'";
$rs_update = mysqli_query($conn, $sql_update) 
  or die(mysqli_error($conn)); 


//release resources
mysqli_free_result($rs);

mysqli_close($conn);

// redirect to previous page
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>