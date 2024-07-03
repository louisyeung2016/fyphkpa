<html><body>
<?php

session_start();

$drinksName = htmlspecialchars($_POST['drinksName'], ENT_QUOTES);
$drinksBarCode = htmlspecialchars($_POST['drinksBarCode'], ENT_QUOTES);
$stockQty = htmlspecialchars($_POST['stockQty'], ENT_QUOTES);
$outOfStockQty = htmlspecialchars($_POST['outOfStockQty'], ENT_QUOTES);
$drinksPrice = htmlspecialchars($_POST['drinksPrice'], ENT_QUOTES);
//$qrcode = $_POST['qrcode'];

require_once("connection.php"); //require_once() = used to embed PHP code from another file

$drinksName = mysqli_real_escape_string($conn, $drinksName);
$drinksBarCode = mysqli_real_escape_string($conn, $drinksBarCode);

//find out the last item id

$sql = "SELECT * FROM drinks_category ORDER BY drinks_id DESC LIMIT 1"; //write the SQL statement
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

$previous_drinks_id = $rc['drinks_id'];

//make a function
function createNewItemId($drinks_id) {

  $int_drinks_id = intval($drinks_id);

  $new_int_drinks_id = $int_drinks_id + 1;

  if($new_int_drinks_id < 10){
  	$new_drinks_id = "00".strval($new_int_drinks_id);
  }else if($new_int_drinks_id >= 10 && $new_int_drinks_id < 100){
  	$new_drinks_id = "0".strval($new_int_drinks_id);
  }else if($new_int_drinks_id >= 100 && $new_int_drinks_id < 1000){
  	$new_drinks_id = strval($new_int_drinks_id);
  }else{
  	$new_drinks_id = "000";
  }


  return $new_drinks_id;
}

$next_drinks_id = createNewItemId($previous_drinks_id);

//generate a random qr code
function generateRandomString($length = 13) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$new_BarCode = "";

while(true){
	$random_BarCode = generateRandomString();

	$sql2 = "SELECT * FROM drinks_category WHERE barcode = '$random_BarCode'"; //write the SQL statement
	$rs2 = mysqli_query($conn, $sql2) //mysqli_query() function performs a query against a database.
		or die(mysqli_error($conn));

	$rc2 = mysqli_fetch_assoc($rs);

	if(mysqli_num_rows($rs2) <= 0){ //no repeated QRcode found, this QRcode can be used
		$new_BarCode = $random_BarCode;
		break;
	}else{
		//do nothing and continue to loop
	}
}

//check whether compensation price is negative
function checkCompensationPriceNegative($drinkPrice){ //not finish
	if($drinkPrice < 0){ //negative input
		return false;
	}else{ //positive input
		return true;
	}

}


//cope with image upload
if (!is_dir('imgDrinks/'))
{
    mkdir('imgDrinks/', 0755, true);
}
$target_dir = "imgDrinks/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
if (isset($_POST["fileToUpload"]))
{
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false)
    {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    }
    else
    {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
/*
//Check if file already exists
if (file_exists($target_file)) {
	//echo "Sorry, file already exists.";
	//back to modifyItemCategory.php
	echo '<script type="text/javascript">'; 
	echo 'alert("Sorry, file already exists.");';
	echo 'window.location.href = "modifyItemCategory.php";';
	echo '</script>';
	die("HAHA");
	$uploadOk = 0;
}
*/

//Limit File Size
if ($_FILES["fileToUpload"]["size"] > 500000) {
	echo "Sorry, your file is too large.";
	//back to modifyItemCategory.php
	echo '<script type="text/javascript">'; 
	echo 'alert("Sorry, your file is too large.");';
	echo 'window.location.href = "modifyDrinksCategory.php";';
	echo '</script>';
	die("HAHA");
	$uploadOk = 0;
}

$newfilename = $target_dir .$next_drinks_id.".png"; //rename the file name to XXX.png






if(checkCompensationPriceNegative($drinksPrice)){ //check is true, upload to DB
	$sql3 = "INSERT INTO drinks_category (drinks_id, drinks_name, stock_qty, shortage_level, price, barcode, drinks_status) VALUES ('$next_drinks_id', '$drinksName', $stockQty, $outOfStockQty, $drinksPrice, '$drinksBarCode', 'Active')"; 

	$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn)); 

	//really upload
	if ($uploadOk == 0)
	{
		echo "Sorry, your file was not uploaded.<br>";
	}
	else
	{
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newfilename))
		{
			echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.<br>";
		}
		else
		{
			echo "Sorry, there was an error uploading your file.<br>";
		}
	}

}else{
	//back to modifyItemCategory.php
	echo '<script type="text/javascript">'; 
	echo 'alert("invalid Quantity");';
	echo 'window.location.href = "modifyDrinksCategory.php";';
	echo '</script>';
	die("HAHA");
}

//free memory
mysqli_free_result($rs); 
mysqli_free_result($rs2); 
mysqli_close($conn);


// redirect to modifyItemCategory.php

header("location: modifyDrinksCategory.php");


?>
</html></body>