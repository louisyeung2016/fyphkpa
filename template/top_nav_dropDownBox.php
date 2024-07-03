<?php

include_once("./language/main_string.php");

$lang = $_SESSION['language_index'];

$staffName = $_SESSION["staffName"];

$themeColorIndex = $_SESSION['themeColorIndex'];


if($themeColorIndex == 0){ //Day Mode
	$themeColor = "Day Mode";
}else if($themeColorIndex == 1){ //Night Mode
	$themeColor = "Night Mode";
}else{
	$themeColor = "Day Mode";
}



if($_SESSION['fontSizeIndex'] == 0){ //Normal Size
	$fontSize = "Normal Size";
}else if($_SESSION['fontSizeIndex'] == 1){ //Large Size
	$fontSize = "Large Size";
}else{
	$fontSize = "Normal Size";
}


$top_nav_dropDownBox_str = <<<EOD

	<span class="nav-link menu-item" >
		<span > $staffName </span>
		<div class="drop-down-menu bg-dark text-white">
			<span style="padding: 0 0 0 0;">Remain Time :</span>
			<div id="logoutCounter" class="h5" ></div>
			<button id="flip" class="btn btn-outline-info btn-sm">Extend Session</button>
			
			<form method="POST" action="extendSession.php" style="display:inline;">
				<div class="input-group input-group-sm mb-3 mt-2" id="panel" style="display: none;">
				  <input type="password" name="extend_pw" class="form-control rounded-left" placeholder="password" aria-label="password" aria-describedby="button-gotoExtend">
				  <div class="input-group-append">
					<button type="submit" class="btn btn-outline-secondary" type="button" id="button-gotoExtend">
					  <i class='fas fa-arrow-right'></i>
					</button>
				  </div>
				</div>
			</form>
			
			<hr class="mx-1 border-light">
			
			<div style="display: flex; justify-content: space-around" class="my-2">
				<span style="padding: 0 0 0 0;display:inline;">Theme : </span>
				<a class="" style="margin-left: auto;margin-right: 0;text-decoration: none;"  href="switchTheme.php">
					
					$themeColor
					
				</a>
			</div>
			<div style="display: flex; justify-content: space-around" class="my-2">
				<span style="padding: 0 0 0 0;display:inline;">Text Size  : </span>
				<a class="" style="margin-left: auto;margin-right: 0;text-decoration: none;" href="switchSize.php">
					
					$fontSize
					
				</a>
			</div>
			
		</div>
	</span>

EOD;




?>