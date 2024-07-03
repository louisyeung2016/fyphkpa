<?php
namespace class_space;
//use PDO;

include "./class/class.php";
?>
<?php

$itemOne = array('039', 'Basketball', 99);
$itemTwo = array('042', 'Poker', 99);

$itemArray = array($itemOne, $itemTwo);



$ibc = new ItemBorrowingController();

$ibc->makeBorrowingRecord('A01', 'B020220230002', $itemArray, '001', 'Test', 'TestMan', '88889999');

?>