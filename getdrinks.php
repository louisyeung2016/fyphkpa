<?php
session_start();
include_once("./language/getdrinks_string.php");

$text_color = "";
$border_color = "";
$bg_color = "";
if($_SESSION['themeColorIndex'] == 0){
	$text_color = "";
	$border_color = "";
	$bg_color = "";
}else{
	$text_color = "text-light";
	$border_color = "border-light";
	$bg_color = "bg-dark";
}

//get delete form
if(isset($_GET['d1'])){
	$d = htmlspecialchars($_GET['d1'], ENT_QUOTES);

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
		echo "<b>$list_name_drinksNotFound[$lang]</b>";
	}else{
		
		$drinks_id = $row['drinks_id'];
		$drinks_name = $row['drinks_name'];
		$stock_qty = $row['stock_qty'];
		$price = $row['price'];
		
		$out_str = <<<EOD
			<hr class="$border_color">
			<br>
			<form action="removeDrinks.php" method="post">
			<input type="hidden" id="drinksID" name="drinksID" value='$drinks_id' readonly >
			$list_name_drinksName[$lang]:  &emsp;
			<input type="text" class="$text_color" id="drinksName" name="drinksName" value='$drinks_name' disabled >
			<br><br>
			$list_name_quantity[$lang]:  &emsp;
			<input type="number" class="$text_color" id="stockQty" name="stockQty" value='$stock_qty' disabled >
			<br><br>
			$list_name_price[$lang]:  &emsp;
			<input type="text" class="$text_color" id="drinksPrice" name="drinksPrice" value='$price' disabled >
			<br><br>
			
			<br>
			<img id="drinks_pic" src="imgDrinks/$drinks_id.png" onerror="this.onerror=null; this.src='imgDrinks/000.png'" alt="drinks picture is not yet be uploaded" title="this is the image" class="img-thumbnail rounded  d-block">
			<br><br>
			
			<button type="submit" class="btn btn-danger" onclick="return confirm('$list_name_areYouSure[$lang]');"> <i class="fa fa-exclamation-triangle"></i> $list_name_confirmButton[$lang]</button>
			</form>
		EOD;
			
		echo $out_str;
		
		/*
		echo "<hr>";
		echo "<br>";
		echo "<form action=\"removeDrinks.php\" method=\"post\">";
		echo "<input type=\"hidden\" id=\"drinksID\" name=\"drinksID\" value='". $row['drinks_id'] ."' readonly >";
		echo "Name:  &emsp;";
		echo "<input type=\"text\" id=\"drinksName\" name=\"drinksName\" value='". $row['drinks_name'] ."' disabled >";
		echo "<br><br>";
		echo "Quantity:  &emsp;";
		echo "<input type=\"number\" id=\"stockQty\" name=\"stockQty\" value='". $row['stock_qty'] ."' disabled >";
		echo "<br><br>";
		echo "Price:  &emsp;";
		echo "<input type=\"text\" id=\"drinksPrice\" name=\"drinksPrice\" value='". $row['price'] ."' disabled >";
		echo "<br><br>";
		echo "<button type=\"submit\" class=\"btn btn-danger\" onclick=\"return confirm('Are you sure?');\"> <i class=\"fa fa-exclamation-triangle\"></i> Confirm</button>";
		echo "</form>";
		*/
	}

	mysqli_close($conn);
}

//get edit form
if(isset($_GET['d2'])){
	$d = htmlspecialchars($_GET['d2'], ENT_QUOTES);

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
		echo "<b>$list_name_drinksNotFound[$lang]</b>";
	}else{
		
		$drinks_id = $row['drinks_id'];
		$drinks_name = $row['drinks_name'];
		$stock_qty = $row['stock_qty'];
		$price = $row['price'];
		$barcode = $row['barcode'];
		
		$out_str = <<<EOD
			<hr class="$border_color">
			<br>
			<form action="editDrinksInfo.php" method="post" enctype="multipart/form-data" onsubmit="return varifyEditDrinksInfo()" >
			<input type="hidden" id="drinksID_edit" name="drinksID" value='$drinks_id' readonly >
			$list_name_drinksName[$lang]:  &emsp;
			<input type="text" id="drinksName_edit" name="drinksName" value='$drinks_name' required  >
			<br><br>
			
			$list_name_barcode[$lang]:  &emsp;
			<input type="text" id="drinksBarCode_edit" name="drinksBarCode" value='$barcode' placeholder="drinks BarCode" pattern="^[0-9]*$" title="number only" required  >
			<br><br>
			
			$list_name_price[$lang]:  &emsp;
			<input type="number" id="drinksPrice_edit" name="drinksPrice" value='$price' min="0" step="0.01" required  >
			<br><br>

			$list_name_outOfStockQty[$lang]:  &emsp;
			<input type="number" id="outOfStockQty_edit" name="outOfStockQty" min="0" max="9999" value="0" required >
			<br>
			$list_name_outOfStockLevel_hints[$lang]
			<br><br>

			<br>
			<img id="drinks_pic" src="imgDrinks/$drinks_id.png" onerror="this.onerror=null; this.src='imgDrinks/000.png'" alt="drinks picture is not yet be uploaded" title="this is the image" class="img-thumbnail rounded  d-block">
			<br><br>

			<label class="btn btn-info">
			<input type="file" name="fileToUpload_edit" id="fileToUpload_edit" accept="imgDrinks/png, .png"  style="display:none;" onchange="updateImageDisplay2()" >
			<i class="fa fa-photo"></i> $list_name_uploadDrinksPicture[$lang]
			</label>
			<div style="color:red;">$list_name_fileSize[$lang]</div>

			<div class="preview_edit">
			<p class="$bg_color">$list_name_noFilesCurrentlySelectedForUpload[$lang]</p>
			</div>

			</br>


			<button type="submit" class="btn btn-primary" onclick="return confirm('$list_name_areYouSure[$lang]');"> <i class="fa fa-edit"></i> $list_name_confirmButton[$lang]</button>
			</form>
		EOD;
			
		echo $out_str;
		
		/*
		echo "<hr>";
		echo "<br>";
		echo "<form action=\"editDrinksInfo.php\" method=\"post\" enctype=\"multipart/form-data\" onsubmit=\"return varifyEditDrinksInfo()\" >";
		echo "<input type=\"hidden\" id=\"drinksID_edit\" name=\"drinksID\" value='". $row['drinks_id'] ."' readonly >";
		echo "Name:  &emsp;";
		echo "<input type=\"text\" id=\"drinksName_edit\" name=\"drinksName\" value='". $row['drinks_name'] ."' required  >";
		echo "<br><br>";
		
		echo "BarCode:  &emsp;";
		echo "<input type=\"text\" id=\"drinksBarCode_edit\" name=\"drinksBarCode\" value='". $row['barcode'] ."' placeholder=\"drinks BarCode\" pattern=\"^[0-9]*$\" title=\"number only\" required  >";
		echo "<br><br>";
		
		echo "Price:  &emsp;";
		echo "<input type=\"number\" id=\"drinksPrice_edit\" name=\"drinksPrice\" value='". $row['price'] ."' min=\"0\" step=\"0.01\" required  >";
		echo "<br><br>";

		echo "<br>";
		echo "<img id=\"drinks_pic\" src=\"imgDrinks/".$row['drinks_id'].".png\" onerror=\"this.onerror=null; this.src='imgDrinks/000.png'\" alt=\"drinks picture is not yet be uploaded\" title=\"this is the image\" class=\"img-thumbnail rounded  d-block\">";
		echo "<br><br>";

		echo "<label class=\"btn btn-info\">";
		echo "<input type=\"file\" name=\"fileToUpload_edit\" id=\"fileToUpload_edit\" accept=\"imgDrinks/png, .png\"  style=\"display:none;\" onchange=\"updateImageDisplay2()\" >";
		echo "<i class=\"fa fa-photo\"></i> upload Drinks Picture (optional)";
		echo "</label>";
		echo "<div style=\"color:red;\">*file size must be below 500kb</div>";

		echo "<div class=\"preview_edit\">";
		echo "<p>No files currently selected for upload</p>";
		echo "</div>";

		echo "</br>";


		echo "<button type=\"submit\" class=\"btn btn-primary\" onclick=\"return confirm('Are you sure?');\"> <i class=\"fa fa-edit\"></i> Confirm</button>";
		echo "</form>";
		*/
	}






	mysqli_close($conn);
}

?>