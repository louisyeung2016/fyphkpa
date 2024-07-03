<?php
session_start();
include_once("./language/getitem_string.php");

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
if(isset($_GET['q1'])){
	$q = htmlspecialchars($_GET['q1'], ENT_QUOTES);

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
		echo "<b>$list_name_itemNotFound[$lang]</b>";
	}else{
		
		$item_id = $row['item_id'];
		$item_name = $row['item_name'];
		$qty = $row['qty'];
		$compensation_price = $row['compensation_price'];
		
		$out_str = <<<EOD
			<hr class="$border_color">
			<br>
			<form action="removeItem.php" method="post">
			<input type="hidden" id="itemID" name="itemID" value='$item_id' readonly >
			$list_name_itemName[$lang]:  &emsp;
			<input type="text" class="$text_color" id="itemName" name="itemName" value='$item_name' disabled >
			<br><br>
			$list_name_quantity[$lang]:  &emsp;
			<input type="number" class="$text_color" id="itemQty" name="itemQty" value='$qty' disabled >
			<br><br>
			$list_name_comPrice[$lang]:  &emsp;
			<input type="text" class="$text_color" id="compensation" name="compensation" value='$compensation_price' disabled >
			<br><br>
			
			<br>
			<img id="item_pic" src="image/$item_id.png" onerror="this.onerror=null; this.src='image/000.png'" alt="item picture is not yet be uploaded" title="this is the image" class="img-thumbnail rounded  d-block">
			<br><br>
			
			<button type="submit" class="btn btn-danger" onclick="return confirm('$list_name_areYouSure[$lang]');"> <i class="fa fa-exclamation-triangle"></i> $list_name_confirmButton[$lang]</button>
			</form>
		EOD;
		
		
		echo $out_str;
		/*
		echo "<hr>";
		echo "<br>";
		echo "<form action=\"removeItem.php\" method=\"post\">";
		echo "<input type=\"hidden\" id=\"itemID\" name=\"itemID\" value='". $row['item_id'] ."' readonly >";
		echo "Name:  &emsp;";
		echo "<input type=\"text\" id=\"itemName\" name=\"itemName\" value='". $row['item_name'] ."' disabled >";
		echo "<br><br>";
		echo "Quantity:  &emsp;";
		echo "<input type=\"number\" id=\"itemQty\" name=\"itemQty\" value='". $row['qty'] ."' disabled >";
		echo "<br><br>";
		echo "Compensation Price:  &emsp;";
		echo "<input type=\"text\" id=\"compensation\" name=\"compensation\" value='". $row['compensation_price'] ."' disabled >";
		echo "<br><br>";
		echo "<button type=\"submit\" class=\"btn btn-danger\" onclick=\"return confirm('Are you sure?');\"> <i class=\"fa fa-exclamation-triangle\"></i> Confirm</button>";
		echo "</form>";
		*/
	}

	mysqli_close($conn);
}

//get edit form
if(isset($_GET['q2'])){
	$q = htmlspecialchars($_GET['q2'], ENT_QUOTES);

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
		echo "<b>$list_name_itemNotFound[$lang]</b>";
	}else{
		
		$item_id = $row['item_id'];
		$item_name = $row['item_name'];
		$qty = $row['qty'];
		$compensation_price = $row['compensation_price'];
		
		$out_str = <<<EOD
			<hr class="$border_color">
			<br>
			<form action="editItemInfo.php" method="post" enctype="multipart/form-data" onsubmit="return varifyEditItemInfo()">
			<input type="hidden" id="itemID_edit" name="itemID" value='$item_id' readonly >
			$list_name_itemName[$lang]:  &emsp;
			<input type="text" id="itemName_edit" name="itemName" value='$item_name' required  >
			<br><br>
			
			$list_name_comPrice[$lang]:  &emsp;
			<input type="number" id="compensation_edit" name="compensation" min="0.00" step="0.01" placeholder="amount HKD$" value='$compensation_price' required  >
			<br><br>
			
			<br>
			<img id="item_pic" src="image/$item_id.png" onerror="this.onerror=null; this.src='image/000.png'" alt="item picture is not yet be uploaded" title="this is the image" class="img-thumbnail rounded  d-block">
			<br><br>
			
			<label class="btn btn-info">
			<input type="file" name="fileToUpload_edit" id="fileToUpload_edit" accept="image/png, .png"  style="display:none;" onchange="updateImageDisplay2()" >
			<i class="fa fa-photo"></i> $list_name_uploadItemPicture[$lang]
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
		*/
	}






	mysqli_close($conn);
}
?>