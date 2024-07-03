<?php

include_once("./language/main_string.php");

$lang = $_SESSION['language_index'];


function selectTempMessageBox($content = "N/A", $index = 0, $link = "") {

	if($link==""){
		$link_with_tag="";
	}else{
		$link_with_tag="<a href='".$link."' class='alert-link'>To Return Page</a>";
	}
	
	$up_str = <<<EOD
	<div class=\'alert alert-warning alert-dismissible fade show\' role=\'alert\'><h4 class=\'alert-heading\'>Item Return Alert!</h4><span id=\'core_message\'>
	EOD;

	$down_str = <<<EOD
		</span><br>$link_with_tag<button type=\'button\' class=\'close\' data-dismiss=\'alert\' aria-label=\'Close\'><span aria-hidden=\'true\'>&times;</span></button></div>
	EOD;
	
	$tempMessageBox0 = array($up_str, $down_str);
	
	$up_str = <<<EOD
	<div class=\"alert alert-primary\" role=\"alert\"><span id=\'core_message\'>
	EOD;

	$down_str = <<<EOD
	</span><hr>$link_with_tag</div>
	EOD;
	
	$tempMessageBox1 = array($up_str, $down_str);
	
	$up_str = <<<EOD
	<div class=\"alert alert-danger\" role=\"alert\"><span id=\'core_message\'>
	EOD;

	$down_str = <<<EOD
	</span><br>$link_with_tag</div>
	EOD;
	
	$tempMessageBox2 = array($up_str, $down_str);
	
	
	
	
	
	$tempMessageBox_array = array($tempMessageBox0, $tempMessageBox1, $tempMessageBox2);

	return $tempMessageBox_array[$index][0].$content.$tempMessageBox_array[$index][1];
}


?>
