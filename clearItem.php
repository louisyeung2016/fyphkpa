<?php
session_start();

echo $_POST["code"];

if(isset($_SESSION["itemArray"])) {
		foreach($_SESSION["itemArray"] as $k => $v) {
			//echo $k;
			//echo $v;
			if($_POST["code"] == $k)
				unset($_SESSION["itemArray"][$k]);				
			if(empty($_SESSION["itemArray"]))
				unset($_SESSION["itemArray"]);
		}
	}

// redirect to borrow.php

header("location: borrow.php");
?>