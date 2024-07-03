<?php
session_start();
include_once("./language/getInventory_string.php");

$text_color = "";
$border_color = "";
if($_SESSION['themeColorIndex'] == 0){
	$text_color = "";
	$border_color = "";
}else{
	$text_color = "text-light";
	$border_color = "border-light";
}

//get purchase form
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
		
		$out_str = <<<EOD
			<hr class="$border_color">
			<br>
			<form action="purchase.php" method="post" onsubmit="return (checkRemarkNum_1() && varifyPurchaseRemarks())">
			<input type="hidden" id="itemID" name="itemID" value='$item_id' readonly >
			$list_name_itemName[$lang]:  &emsp;
			<input type="text" class="$text_color" id="itemName" name="itemName" value='$item_name' disabled >
			<br><br>
			$list_name_addQuantity[$lang]:  &emsp;
			<input type="number" id="addQty" name="addQty" value='' min="1" required >
			<br><br>
			$list_name_remarks[$lang]:  &emsp;
			<input type="text" id="remarks_1" name="remarks" style='width:500px' placeholder='less than 100 words...' onkeyup="countChar_1(this.value)">
			<br>
			<div>word count: <span id="countedChar_1">0</span></div>
			<br><br>
			
			<input type="submit" class="btn btn-primary" value="$list_name_confirmButton[$lang]" onclick="return confirm('$list_name_areYouSure[$lang]');"> 
			</form>
		EOD;
			
		echo $out_str;
		
		/*
		echo "<hr>";
		echo "<br>";
		echo "<form action=\"purchase.php\" method=\"post\">";
		echo "<input type=\"hidden\" id=\"itemID\" name=\"itemID\" value='". $row['item_id'] ."' readonly >";
		echo "Name:  &emsp;";
		echo "<input type=\"text\" id=\"itemName\" name=\"itemName\" value='". $row['item_name'] ."' disabled >";
		echo "<br><br>";
		echo "Add Quantity:  &emsp;";
		echo "<input type=\"number\" id=\"addQty\" name=\"addQty\" value='' min=\"1\" required >";
		echo "<br><br>";
		
		echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"Confirm\" onclick=\"return confirm('Are you sure?');\"> ";
		echo "</form>";
		*/
	}



	mysqli_close($conn);
}

//get reduction form
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
	$sql="SELECT * FROM rental_item_category WHERE item_id = '".$q."' AND item_status = 'Active' AND qty > 0";
	$result = mysqli_query($conn,$sql);

	$row = mysqli_fetch_array($result);

	if(mysqli_num_rows($result) <= 0){
		echo "<b>$list_name_itemNotFound[$lang]</b>";
	}else{
		$item_id = $row['item_id'];
		$item_name = $row['item_name'];
		$qty = $row['qty'];
		
		$out_str = <<<EOD
			<hr class="$border_color">
			<br>
			<form action="reduction.php" method="post" onsubmit="return (checkRemarkNum_2() && varifReductionRemarks())">
			<input type="hidden" id="itemID" name="itemID" value='$item_id' readonly >
			$list_name_itemName[$lang]:  &emsp;
			<input type="text" class="$text_color" id="itemName" name="itemName" value='$item_name' disabled >
			<br><br>
			$list_name_reduceQuantity[$lang]:  &emsp;
			<input type="number" id="reduceQty" name="reduceQty" value='' min="1" max='$qty' required >
			<br><br>
			$list_name_remarks[$lang]:  &emsp;
			<input type="text" id="remarks_2" name="remarks" style='width:500px' placeholder='less than 100 words...' onkeyup="countChar_2(this.value)">
			<br>
			<div>word count: <span id="countedChar_2">0</span></div>
			<br><br>
			
			<input type="submit" class="btn btn-warning" value="$list_name_confirmButton[$lang]" onclick="return confirm('$list_name_areYouSure[$lang]');"> 
			</form>
		EOD;
			
		echo $out_str;
		
		/*
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
		*/
	}






	mysqli_close($conn);
}

?>