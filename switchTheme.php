<?php
require_once("connection.php");
session_start();

$staffID = $_SESSION["staffID"];
//$themeColorIndex = $_SESSION["themeColorIndex"];

//0=Day Mode; 1=Night Mode

if(!isset($_SESSION["themeColorIndex"])){
	$_SESSION["themeColorIndex"] = 0; 
}

if($_SESSION["themeColorIndex"] == 0){
	$_SESSION["themeColorIndex"] = 1;
}elseif($_SESSION["themeColorIndex"] == 1){
	$_SESSION["themeColorIndex"] = 0;
}else{
	$_SESSION["themeColorIndex"] = 0;
}

//save Theme Color preference to DB
//...
$sql = "SELECT `preference_index` FROM `staff` WHERE `staff`.`staff_id` = '$staffID' ";
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

$preference_index = $rc['preference_index'];

$preference_index_theme = intval($preference_index[2]);
if($preference_index_theme == 0){
	$preference_index_theme = 1;
}else{
	$preference_index_theme = 0;
}

$updated_preference_index = $preference_index[0].$preference_index[1].strval($preference_index_theme);

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