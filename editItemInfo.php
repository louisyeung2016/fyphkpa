<html><body>
<?php

session_start();

$item_id = htmlspecialchars($_POST['itemID'], ENT_QUOTES);
$item_name = htmlspecialchars($_POST['itemName'], ENT_QUOTES);
$compensation = htmlspecialchars($_POST['compensation'], ENT_QUOTES);



require_once("connection.php"); //require_once() = used to embed PHP code from another file

function checkCompensationPriceNegative($compensation){ //not finish
	if($compensation < 0){ //negative input
		return false;
	}else{ //positive input
		return true;
	}
}


//cope with image upload
if (!is_dir('image/'))
{
    mkdir('image/', 0755, true);
}
$target_dir = "image/";
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
	//back to modifyItemCategory.php
	echo '<script type="text/javascript">'; 
	echo 'alert("Sorry, your file is too large.");';
	echo 'window.location.href = "modifyItemCategory.php";';
	echo '</script>';
	die("HAHA");
	$uploadOk = 0;
}

$old_filename = $target_dir .$item_id.".png";

//Check if file already exists
if (isset($_POST["fileToUpload_edit"])){
	if (file_exists($old_filename)) {
		unlink($old_filename);
		$uploadOk = 1;
	}
}


if(checkCompensationPriceNegative($compensation)){
	//update the item name and compensation price by item id

	$sql = "UPDATE rental_item_category SET item_name = '$item_name', compensation_price = $compensation WHERE item_id = $item_id"; //write the SQL statement
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
	//back to modifyItemCategory.php
	echo '<script type="text/javascript">'; 
	echo 'alert("invalid Quantity");';
	echo 'window.location.href = "modifyItemCategory.php";';
	echo '</script>';
	die("HAHA");
}







//free memory
mysqli_close($conn);

//clear browser cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// redirect to modifyItemCategory.php

echo '<script type="text/javascript">'; 
echo 'alert("Edit successful");';
echo 'window.location.href = "modifyItemCategory.php";';
echo '</script>';
die("HAHA");


?>
</html></body>