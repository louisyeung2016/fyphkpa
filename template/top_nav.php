<?php

include_once("./language/main_string.php");

$lang = $_SESSION['language_index'];

$border_buttom = "border-bottom border-danger border-5";
/*
if ($_SESSION['permission'] == "Admin" || $_SESSION['permission'] == "Manager") {
	$border_buttom = "border-bottom border-danger border-5";
}
*/

$top_nav_str = <<<EOD

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow ">
	<!-- change name on left top side -->
  <div class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" ><a class="text-white" style="text-decoration:none;" href="./dashboard.php">HKPA - $list_name_siteName[$lang]</a></div>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation" onclick="openNav()">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">


EOD;

$top_nav_admin_str = <<<EOD

<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow $border_buttom">
	<!-- change name on left top side -->
  <div class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" ><a class="text-white" style="text-decoration:none;" href="./dashboard.php">HKPA - $list_name_siteName[$lang]</a></div>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation" onclick="openNav()">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">


EOD;

$top_nav_str2 = <<<EOD

      <a class="nav-link" style="display:inline;" href="logout.php">$list_name_signOut[$lang]</a>
    </li>
  </ul>
</nav>

EOD;


?>