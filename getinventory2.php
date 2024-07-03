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
$sql="SELECT * FROM rental_item_category WHERE item_id = '".$q."' AND item_status = 'Active' AND qty > 0";
$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_array($result);

if(mysqli_num_rows($result) <= 0){
	echo "<b>item not found</b>";
}else{
	echo "<hr>";
	echo "<br>";
	echo "<form action=\"reduction.php\" method=\"post\">";
	echo "<input type=\"hidden\" id=\"itemID\" name=\"itemID\" value='". $row['item_id'] ."' readonly >";
	echo "Name:  &emsp;";
	echo "<input type=\"text\" id=\"itemName\" name=\"itemName\" value='". $row['item_name'] ."' disabled >";
	echo "<br><br>";
	echo "Reduce Quantity:  &emsp;";
	echo "<input type=\"number\" id=\"reduceQty\" name=\"reduceQty\" value='' min=\"1\" max='". $row['qty']."' required >";
	echo "<br><br>";
	
	echo "<input type=\"submit\" class=\"btn btn-warning\" value=\"Confirm\" onclick=\"return confirm('Are you sure?');\"> ";
	echo "</form>";
}






mysqli_close($conn);
?>
</body>
</html>