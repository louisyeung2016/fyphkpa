<html><body>
<?php

session_start();

// remove all session variables
unset($_SESSION["room_Num"]);
unset($_SESSION["organization"]);
unset($_SESSION["representative"]);
unset($_SESSION["contact_number"]);

// destroy the session
//session_destroy();

// redirect to borrow.php

header("location: clearItemListSession.php");
?>
</body></html>