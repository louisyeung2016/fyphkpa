<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
$q = htmlspecialchars($_GET['q'], ENT_QUOTES);

require_once("connection.php"); //require_once() = used to embed PHP code from another file
/*
$con = mysqli_connect('localhost','peter','abc123','my_db');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}
*/

mysqli_select_db($conn,$db_db);
$sql="SELECT * FROM rental_item_category WHERE item_id = '".$q."' AND item_status = 'Active'";
$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_array($result);

if(mysqli_num_rows($result) <= 0){
	echo "<b>item not found</b>";
}else{
	echo "<hr>";
	echo "<br>";
	echo "<form action=\"removeItem.php\" method=\"post\">";
	echo "<input type=\"hidden\" id=\"itemID\" name=\"itemID\" value='". $row['item_id'] ."' readonly >";
	echo "名稱:  &emsp;";
	echo "<input type=\"text\" id=\"itemName\" name=\"itemName\" value='". $row['item_name'] ."' disabled >";
	echo "<br><br>";
	echo "數量:  &emsp;";
	echo "<input type=\"number\" id=\"itemQty\" name=\"itemQty\" value='". $row['qty'] ."' disabled >";
	echo "<br><br>";
	echo "賠償價錢:  &emsp;";
	echo "<input type=\"text\" id=\"compensation\" name=\"compensation\" value='". $row['compensation_price'] ."' disabled >";
	echo "<br><br>";
	//echo "<input type=\"submit\" class=\"btn btn-danger\" value=\"Confirm\" onclick=\"return confirm('Are you sure?');\"> ";
	echo "<button type=\"submit\" class=\"btn btn-danger\" onclick=\"return confirm('Are you sure?');\"> <i class=\"fa fa-exclamation-triangle\"></i> 確認</button>";
	echo "</form>";
}






mysqli_close($conn);
?>
</body>
</html>
