<?php 

if(!isset($_COOKIE["permission"])){
    unset($_COOKIE['permission']);

    session_start();
    setcookie('permission', $_SESSION["permission"], time() - 60*60*3, '/');

    // Destroy the session.
    session_destroy();
     
    // Redirect to login page
    header("location: index.html");
    exit;
}
?>
