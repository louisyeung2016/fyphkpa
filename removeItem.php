<html><body>
<?php

session_start();

$item_id = $_POST['itemID'];



require_once("connection.php"); //require_once() = used to embed PHP code from another file

//update the item status to inActive

$sql = "UPDATE rental_item_category SET item_status = 'inActive' WHERE item_id = $item_id"; //write the SQL statement
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));





//free memory
mysqli_close($conn);


// redirect to modifyItemCategory.php

echo '<script type="text/javascript">'; 
echo 'alert("Remove successful");';
echo 'window.location.href = "modifyItemCategory.php";';
echo '</script>';
die("HAHA");


?>
</html></body>