

<html><body>
<?php

session_start();

$copied_qrcode = $_GET["copied_qrcode"];


$_SESSION["copied_qrcode"] = $copied_qrcode;


echo $_SESSION["copied_qrcode"];


// redirect to borrow.php

header("location: generateQRCode.php");
?>
</body></html>
