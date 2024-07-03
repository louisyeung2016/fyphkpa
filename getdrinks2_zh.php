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
	echo "<form action=\"editDrinksInfo.php\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"return varifyEditDrinksInfo()\" >";
	echo "<input type=\"hidden\" id=\"drinksID_edit\" name=\"drinksID\" value='". $row['drinks_id'] ."' readonly >";
	echo "名稱:  &emsp;";
	echo "<input type=\"text\" id=\"drinksName_edit\" name=\"drinksName\" value='". $row['drinks_name'] ."' required  >";
	echo "<br><br>";
	
	echo "BarCode:  &emsp;";
	echo "<input type=\"text\" id=\"drinksBarCode_edit\" name=\"drinksBarCode\" value='". $row['barcode'] ."' placeholder=\"drinks BarCode\" pattern=\"^[0-9]*$\" title=\"number only\" required  >";
	echo "<br><br>";
	
	echo "價格:  &emsp;";
	echo "<input type=\"number\" id=\"drinksPrice_edit\" name=\"drinksPrice\" value='". $row['price'] ."' min=\"0\" step=\"0.01\" required  >";
	echo "<br><br>";

	echo "<br>";
	echo "<img id=\"drinks_pic\" src=\"imgDrinks/".$row['drinks_id'].".png\" onerror=\"this.onerror=null; this.src='imgDrinks/000.png'\" alt=\"drinks picture is not yet be uploaded\" title=\"this is the image\" class=\"img-thumbnail rounded  d-block\">";
	echo "<br><br>";

	echo "<label class=\"btn btn-info\">";
	echo "<input type=\"file\" name=\"fileToUpload_edit\" id=\"fileToUpload_edit\" accept=\"imgDrinks/png, .png\"  style=\"display:none;\" onchange=\"updateImageDisplay2()\" >";
	echo "<i class=\"fa fa-photo\"></i> 上傳飲品圖片 (可選)";
	echo "</label>";
	echo "<div style=\"color:red;\">*圖片大小要小於 500kb</div>";

	echo "<div class=\"preview_edit\">";
	echo "<p>沒有圖片上傳</p>";
	echo "</div>";

	echo "</br>";


	echo "<button type=\"submit\" class=\"btn btn-primary\" onclick=\"return confirm('Are you sure?');\"> <i class=\"fa fa-edit\"></i> 確認</button>";
	echo "</form>";
}






mysqli_close($conn);
?>
</body>
</html>
