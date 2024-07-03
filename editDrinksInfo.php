<?php

session_start();

$drinks_id = htmlspecialchars($_POST['drinksID'], ENT_QUOTES);
$drinksBarCode = htmlspecialchars($_POST['drinksBarCode'], ENT_QUOTES);
$drinksName = htmlspecialchars($_POST['drinksName'], ENT_QUOTES);
$drinksPrice = htmlspecialchars($_POST['drinksPrice'], ENT_QUOTES);
$outOfStockQty = htmlspecialchars($_POST['outOfStockQty'], ENT_QUOTES);



require_once("connection.php"); //require_once() = used to embed PHP code from another file

$drinksName = mysqli_real_escape_string($conn, $drinksName);
$drinksBarCode = mysqli_real_escape_string($conn, $drinksBarCode);

function checkCompensationPriceNegative($drinksPrice){ //not finish
	if($drinksPrice < 0){ //negative input
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
$target_file = $target_dir . basename($_FILES["fileToUpload_edit"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
if (isset($_POST["fileToUpload_edit"]))
{
    $check = getimagesize($_FILES["fileToUpload_edit"]["tmp_name"]);
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

//Limit File Size
if ($_FILES["fileToUpload_edit"]["size"] > 500000) {
	echo "Sorry, your file is too large.";
	//back to modifyDrinksCategory.php
	echo '<script type="text/javascript">'; 
	echo 'alert("Sorry, your file is too large.");';
	echo 'window.location.href = "modifyDrinksCategory.php";';
	echo '</script>';
	die("HAHA");
	$uploadOk = 0;
}

$old_filename = $target_dir .$drinks_id.".png";

//Check if file already exists
if (isset($_POST["fileToUpload_edit"])){
	if (file_exists($old_filename)) {
		unlink($old_filename);
		$uploadOk = 1;
	}
}


if(checkCompensationPriceNegative($drinksPrice)){
	//update the drinks name and price by drinks id

	$sql = "UPDATE drinks_category SET drinks_name = '$drinksName', price = $drinksPrice, barcode = $drinksBarCode, shortage_level = $outOfStockQty WHERE drinks_id = $drinks_id"; //write the SQL statement
	$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
		or die(mysqli_error($conn));

	//really upload
	if ($uploadOk == 0)
	{
		echo "Sorry, your file was not uploaded.<br>";
	}
	else
	{
		if (move_uploaded_file($_FILES["fileToUpload_edit"]["tmp_name"], $old_filename))
		{
			echo "The file " . basename($_FILES["fileToUpload_edit"]["name"]) . " has been uploaded.<br>";
		}
		else
		{
			echo "Sorry, there was an error uploading your file.<br>";
		}
	}

}else{
	//back to modifyDrinksCategory.php
	echo '<script type="text/javascript">'; 
	echo 'alert("invalid Quantity");';
	echo 'window.location.href = "modifyDrinksCategory.php";';
	echo '</script>';
	die("HAHA");
}







//free memory
mysqli_close($conn);

//clear browser cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// redirect to modifyDrinksCategory.php

echo '<script type="text/javascript">'; 
echo 'alert("Edit successful");';
echo 'window.location.href = "modifyDrinksCategory.php";';
echo '</script>';
die("HAHA");


?>
