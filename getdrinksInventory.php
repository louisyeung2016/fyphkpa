<?php
session_start();
include_once("./language/getdrinksInventory_string.php");

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
	$sql="SELECT * FROM drinks_category WHERE drinks_id = '".$q."' AND drinks_status = 'Active'";
	$result = mysqli_query($conn,$sql);

	$row = mysqli_fetch_array($result);

	if(mysqli_num_rows($result) <= 0){
		echo "<b>$list_name_drinksNotFound[$lang]</b>";
	}else{
		$drinks_id = $row['drinks_id'];
		$drinks_name = $row['drinks_name'];
		
		$out_str = <<<EOD
			<hr class="$border_color">
			<br>
			<form action="drinksPurchase.php" method="post" onsubmit="return (checkRemarkNum_1() && varifyPurchaseRemarks())">
			<input type='hidden' id='drinksID' name='drinksID' value='$drinks_id' readonly >
			$list_name_drinksName[$lang]:  &emsp;
			<input type="text" class="$text_color" id="drinksName" name="drinksName" value='$drinks_name' disabled >
			<br><br>
			$list_name_addQuantity[$lang]:  &emsp;
			<input type="number" id="addDrinksQty" name="addDrinksQty" value='' min="1" required >
			<br><br>
			$list_name_unitCost[$lang]:  &emsp;
			<input type="number" id="unitCost" name="unitCost" value='' min="1" step="0.01" required >
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
	$sql="SELECT * FROM drinks_category WHERE drinks_id = '".$q."' AND drinks_status = 'Active' AND stock_qty > 0";
	$result = mysqli_query($conn,$sql);

	$row = mysqli_fetch_array($result);

	if(mysqli_num_rows($result) <= 0){
		echo "<b>$list_name_drinksNotFound[$lang]</b>";
	}else{
		
		$drinks_id = $row['drinks_id'];
		$drinks_name = $row['drinks_name'];
		$stock_qty = $row['stock_qty'];
		
		$out_str = <<<EOD
			<hr class="$border_color">
			<br>
			<form action="drinksReduction.php" method="post" onsubmit="return (checkRemarkNum_2() && varifReductionRemarks())">
			<input type="hidden" id="drinksID" name="drinksID" value='$drinks_id' readonly >
			$list_name_drinksName[$lang]:  &emsp;
			<input type="text" class="$text_color" id="drinksName" name="drinksName" value='$drinks_name' disabled >
			<br><br>
			$list_name_reduceQuantity[$lang]:  &emsp;
			<input type="number" id="reduceDrinksQty" name="reduceDrinksQty" value='' min=\"1\" max='$stock_qty' required >
			<br><br>
			$list_name_unitCost[$lang]:  &emsp;
			<input type="number" id="unitCost" name="unitCost" value='' min="1" step="0.01" required >
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
		
	}

	mysqli_close($conn);
}
?>