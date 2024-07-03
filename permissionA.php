<?php 
// set the admin page permission
    session_start();
    if($_SESSION['permission'] != "Admin" && $_SESSION['permission'] != "Manager"){
        echo "<SCRIPT>  alert('You have no permission!')
            window.location.replace('index.html');
        </SCRIPT>";
        exit;
    }
?>
