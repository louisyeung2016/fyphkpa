<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
$d = htmlspecialchars($_GET['d'], ENT_QUOTES);

require_once("connection.php"); //require_once() = used to embed PHP code from another file
/*
$con = mysqli_connect('localhost','peter','abc123','my_db');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
*/

mysqli_select_db($conn,$db_db);
$sql="SELECT * FROM drinks_category WHERE drinks_id = '".$d."' AND drinks_status = 'Active'";
$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_array($result);

if(mysqli_num_rows($result) <= 0){
	echo "<b>drinks not found</b>";
}else{
	echo "<hr>";
	echo "<br>";
	echo "<form action=\"removeDrinks.php\" method=\"post\">";
	echo "<input type=\"hidden\" id=\"drinksID\" name=\"drinksID\" value='". $row['drinks_id'] ."' readonly >";
	echo "名稱:  &emsp;";
	echo "<input type=\"text\" id=\"drinksName\" name=\"drinksName\" value='". $row['drinks_name'] ."' disabled >";
	echo "<br><br>";
	echo "數量:  &emsp;";
	echo "<input type=\"number\" id=\"stockQty\" name=\"stockQty\" value='". $row['stock_qty'] ."' disabled >";
	echo "<br><br>";
	echo "價格:  &emsp;";
	echo "<input type=\"text\" id=\"drinksPrice\" name=\"drinksPrice\" value='". $row['price'] ."' disabled >";
	echo "<br><br>";
	//echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Confirm\" onclick=\"return confirm('Are you sure?');\"> ";
	echo "<button type=\"submit\" class=\"btn btn-danger\" onclick=\"return confirm('Are you sure?');\"> <i class=\"fa fa-exclamation-triangle\"></i> 確認</button>";
	echo "</form>";
}






mysqli_close($conn);
?>
</body>
</html>
