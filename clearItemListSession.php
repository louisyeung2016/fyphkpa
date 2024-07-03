<html><body>
<?php

session_start();

// remove all session variables
unset($_SESSION["itemArray"]);

// destroy the session
//session_destroy();

// redirect to borrow.php

header("location: borrow.php");
?>
</body></html>