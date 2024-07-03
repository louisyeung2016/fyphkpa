<?php
    include('returnProcessing.php');
    $newobj = new returnProcessing();

    if(isset($_POST['statusname'],$_POST['getid'],$_POST['item'],$_POST['itemid'],$_POST['price'])){
        $statusid = $_POST['statusname'];
        $id = $_POST['getid'];
        $item = $_POST['item'];
		$itemid = $_POST['itemid'];
        $price = $_POST['price'];

        $newobj->getdata($statusid,$id,$item,$itemid,$price);
    }
?>
