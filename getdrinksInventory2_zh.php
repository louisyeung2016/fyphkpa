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
$sql="SELECT * FROM drinks_category WHERE drinks_id = '".$q."' AND drinks_status = 'Active' AND stock_qty > 0";
$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_array($result);

if(mysqli_num_rows($result) <= 0){
	echo "<b>item not found</b>";
}else{
	echo "<hr>";
	echo "<br>";
	echo "<form action=\"drinksReduction.php\" method=\"post\">";
	echo "<input type=\"hidden\" id=\"drinksID\" name=\"drinksID\" value='". $row['drinks_id'] ."' readonly >";
	echo "名稱:  &emsp;";
	echo "<input type=\"text\" id=\"drinksName\" name=\"drinksName\" value='". $row['drinks_name'] ."' disabled >";
	echo "<br><br>";
	echo "減少數量:  &emsp;";
	echo "<input type=\"number\" id=\"reduceDrinksQty\" name=\"reduceDrinksQty\" value='' min=\"1\" max='". $row['stock_qty']."' required >";
	echo "<br><br>";
	echo "成本:  &emsp;";
	echo "<input type=\"number\" id=\"unitCost\" name=\"unitCost\" value='' min=\"1\" step=\"0.01\" required >";
	echo "<br><br>";

	echo "<input type=\"submit\" class=\"btn btn-warning\" value=\"確認\" onclick=\"return confirm('Are you sure?');\"> ";
	echo "</form>";
}






mysqli_close($conn);
?>
</body>
</html>
