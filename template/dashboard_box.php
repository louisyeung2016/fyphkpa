<?php

include_once("./language/main_string.php");
include_once("./language/dashboard_box_string.php");

$lang = $_SESSION['language_index'];

$dashboard_box_bg_color = "bg-light";
$dashboard_box_title_color1 = "text-primary";
$dashboard_box_title_color2 = "text-primary";
$dashboard_box_title_color3 = "text-primary";
$dashboard_box_title_color4 = "text-primary";

if($_SESSION['themeColorIndex'] == 0){
	$dashboard_box_bg_color = "bg-light";
	$dashboard_box_title_color1 = "text-primary";
	$dashboard_box_title_color2 = "text-primary";
	$dashboard_box_title_color3 = "text-primary";
	$dashboard_box_title_color4 = "text-primary";
}else if($_SESSION['themeColorIndex'] == 1){
	$dashboard_box_bg_color = "bg-dark";
	$dashboard_box_title_color1 = "text-green";
	$dashboard_box_title_color2 = "text-blue";
	$dashboard_box_title_color3 = "text-purple";
	$dashboard_box_title_color4 = "text-red";
}else{
	$dashboard_box_bg_color = "bg-light";
}

function selectTempBox($title = "To be confirmed", $content = "N/A", $title_color = "text-primary", $text_color = "text-gray-800", $bg_color = "", $extra_elements = "") {

	$up_str = "
		<div class='col-xl-3 col-md-6 mb-4 '>
          <div class='card border-left-primary shadow h-100 py-2 $bg_color'>
            <div class='card-body'>
              <div class='row no-gutters align-items-center'>
                <div class='col mr-2'>
                <div class='text-xs font-weight-bold $title_color text-uppercase mb-1'>$title</div>
                  <div class='h5 mb-0 font-weight-bold $text_color'>
	";

	$down_str = "
			  </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	";

	return $up_str.$content.$extra_elements.$down_str;
}

//extra elements
//<div class="col-auto">
//  <i class="fas fa-calendar fa-2x text-gray-300"></i>
//  <button>Click</button>
//</div>

//Item Inventory
//box1
$box1_content; //TOTAL LOANED ITEMS
$box1_content = "<h5>$list_name_box1_content1[$lang]<span id='box1_number1'>0"."</h5>"; //Total Loaned
$box1_content .= "<h5>$list_name_box1_content2[$lang]<span id='box1_number2'>0"."</span></h5>"; //Not Yet Loan
$box1 = selectTempBox($list_name_box1_title[$lang], $box1_content, $dashboard_box_title_color1, "text-gray-800", $dashboard_box_bg_color);


//box2
$box2_content = "<canvas id=\"box2_number\" width=\"230\" height=\"115\" style=\"\" >Your browser does not support the canvas element.</canvas>"; //ITEM LOAN-OUT RATIO
$box2 = selectTempBox($list_name_box2_title[$lang], $box2_content, $dashboard_box_title_color1, "text-center", $dashboard_box_bg_color);


//box3
$box3_content = "<h4>$list_name_box3_content1[$lang]<span id='box3_number'>0"."</span>$list_name_box3_content2[$lang]</h4>"; //NUMBER OF ROOM BORROWING ITEMS
$box3 = selectTempBox($list_name_box3_title[$lang], $box3_content, $dashboard_box_title_color1, "text-gray-800", $dashboard_box_bg_color);

//box4
$box4_content = "<h4>$list_name_box4_content1[$lang]<span id='box4_number'>0"."</span></h4>"; //LOANABLE ITEM
$box4 = selectTempBox($list_name_box4_title[$lang], $box4_content, $dashboard_box_title_color1, "text-gray-800", $dashboard_box_bg_color);

//Camp Bookings
//box5
$box5_content = "<h5>$list_name_box5_content1[$lang]<span id='box5_number1'>0</span>/20</h5>"."<h5>$list_name_box5_content2[$lang]<span id='box5_number2'>0</span>/4</h5>"."<h5>$list_name_box5_content3[$lang]<span id='box5_number3'>0</span>/2</h5>"."<progress id='room-progress-bar' value='0' max='26' style='width:100%;'></progress>"; //ROOM STATUS
$box5 = selectTempBox($list_name_box5_title[$lang], $box5_content, $dashboard_box_title_color2, "text-gray-800", $dashboard_box_bg_color);

//box6
$box6_content = "<h4>$list_name_box6_content1[$lang]<span id='box6_number'>0</span>/10</h4><meter id='tentcamp-meter' low='4' high='7' optimum='0' min='0' max='10' value='0' style='width:100%;'></meter>"; //TENT CAMP
$box6 = selectTempBox($list_name_box6_title[$lang], $box6_content, $dashboard_box_title_color2, "text-gray-800", $dashboard_box_bg_color);

//box7
$box7_content = "<h4>$list_name_box7_content1[$lang]<span id='box7_number'>0</span>/10</h4><meter id='daycamp-meter' low='4' high='7' optimum='0' min='0' max='10' value='0' style='width:100%;'></meter>"; //DAY CAMP
$box7 = selectTempBox($list_name_box7_title[$lang], $box7_content, $dashboard_box_title_color2, "text-gray-800", $dashboard_box_bg_color);

//box8
$box8_content = "<h4>$list_name_box8_content1[$lang]<span id='box8_number'>0</span>/10</h4><meter id='eveningcamp-meter' low='4' high='7' optimum='0' min='0' max='10' value='0' style='width:100%;'></meter>"; //EVENING CAMP
$box8 = selectTempBox($list_name_box8_title[$lang], $box8_content, $dashboard_box_title_color2, "text-gray-800", $dashboard_box_bg_color);

//Drinks Sales
//box9
$box9_content = "<h4>$list_name_box9_content1[$lang]<span id='box9_number'>0</span></h4>"; //TODAY SALES VOLUME
$box9 = selectTempBox($list_name_box9_title[$lang], $box9_content, $dashboard_box_title_color3, "text-gray-800", $dashboard_box_bg_color);

//box10
$box10_content = "<h4>$list_name_box10_content1[$lang]<span id='box10_number'>8</span></h4>"; //SELLABLE DRINKS
$box10 = selectTempBox($list_name_box10_title[$lang], $box10_content, $dashboard_box_title_color3, "text-gray-800", $dashboard_box_bg_color);


$box11 = selectTempBox("To be confirmed", "N/A", $dashboard_box_title_color3, "text-gray-800", $dashboard_box_bg_color);
$box12 = selectTempBox("To be confirmed", "N/A", $dashboard_box_title_color3, "text-gray-800", $dashboard_box_bg_color);

//Staff Management
$box13_content = "<h5>$list_name_box13_content1[$lang]<span id='box13_number1'>0</span> </h5>"."<h5>$list_name_box13_content2[$lang]<span id='box13_number2'>0</span> </h5>"."<h5>$list_name_box13_content3[$lang]<span id='box13_number3'>0</span> </h5>"; //NUMBER OF USER(S)
$box13 = selectTempBox($list_name_box13_title[$lang], $box13_content, $dashboard_box_title_color4, "text-gray-800", $dashboard_box_bg_color);

//============================================================================

$dashboard_box_rentalItem_str = <<<EOD

	$box1
	$box2
	$box3
	$box4

EOD;

$dashboard_box_bookings_str = <<<EOD

	$box5
	$box6
	$box7
	$box8

EOD;
$dashboard_box_salesDrinks_str = <<<EOD

	$box9
	$box10
	$box11
	$box12

EOD;

$dashboard_box_staffManagement_str = <<<EOD

	$box13

EOD;
?>
