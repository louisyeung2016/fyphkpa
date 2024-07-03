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
	echo "<form action=\"editItemInfo.php\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"return varifyEditItemInfo()\">";
	echo "<input type=\"hidden\" id=\"itemID_edit\" name=\"itemID\" value='". $row['item_id'] ."' readonly >";
	echo "Name:  &emsp;";
	echo "<input type=\"text\" id=\"itemName_edit\" name=\"itemName\" value='". $row['item_name'] ."' required  >";
	echo "<br><br>";
	
	echo "Compensation Price:  &emsp;";
	echo "<input type=\"number\" id=\"compensation_edit\" name=\"compensation\" min=\"0.00\" step=\"0.01\" placeholder=\"amount HKD$\" value='". $row['compensation_price'] ."' required  >";
	echo "<br><br>";
	
	echo "<br>";
	echo "<img id=\"item_pic\" src=\"image/".$row['item_id'].".png\" onerror=\"this.onerror=null; this.src='image/000.png'\" alt=\"item picture is not yet be uploaded\" title=\"this is the image\" class=\"img-thumbnail rounded  d-block\">";
	echo "<br><br>";
	
	echo "<label class=\"btn btn-info\">";
	echo "<input type=\"file\" name=\"fileToUpload_edit\" id=\"fileToUpload_edit\" accept=\"image/png, .png\"  style=\"display:none;\" onchange=\"updateImageDisplay2()\" >";
	echo "<i class=\"fa fa-photo\"></i> upload Item Picture (optional)";
	echo "</label>";
	echo "<div style=\"color:red;\">*file size must be below 500kb</div>";

	echo "<div class=\"preview_edit\">";
	echo "<p>No files currently selected for upload</p>";
	echo "</div>";
		
	echo "</br>";
	
	
	echo "<button type=\"submit\" class=\"btn btn-primary\" onclick=\"return confirm('Are you sure?');\"> <i class=\"fa fa-edit\"></i> Confirm</button>";
	echo "</form>";
}






mysqli_close($conn);
?>
</body>
</html>