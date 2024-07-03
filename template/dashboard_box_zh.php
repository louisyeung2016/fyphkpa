<?php

include_once("./language/main_string.php");

$lang = $_SESSION['language_index'];


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
$box1_content = "<h5> 共借出物品數量: <span id='box1_number1'>0"."</h5>"; //Total Loaned
$box1_content .= "<h5> 未借出物品數量: <span id='box1_number2'>0"."</span></h5>"; //Not Yet Loan
$box1 = selectTempBox("總物品數量", $box1_content);


//box2
$box2_content = "<canvas id=\"box2_number\" width=\"230\" height=\"115\" style=\"\" >Your browser does not support the canvas element.</canvas>"; //ITEM LOAN-OUT RATIO
$box2 = selectTempBox("物品借出比率", $box2_content, "text-primary", "text-center");


//box3
$box3_content = "<h4> 共有 : <span id='box3_number'>0"."</span> room(s)</h4>"; //NUMBER OF ROOM BORROWING ITEMS
$box3 = selectTempBox("有借物品房間的數量", $box3_content);

//box4
$box4_content = "<h4>物品種類: <span id='box4_number'>0"."</span></h4>"; //LOANABLE ITEM
$box4 = selectTempBox("可借物品種類", $box4_content);

//Camp Bookings
//box5
$box5_content = "<h5>8人房: <span id='box5_number1'>0</span>/20</h5>"."<h5>4人房: <span id='box5_number2'>0</span>/4</h5>"."<h5>2人房: <span id='box5_number3'>0</span>/2</h5>"."<progress id='room-progress-bar' value='0' max='26' style='width:100%;'></progress>"; //ROOM STATUS
$box5 = selectTempBox("房間狀態", $box5_content);

//box6
$box6_content = "<h4>狀態: <span id='box6_number'>0</span>/4</h4><meter id='tentcamp-meter' low='2' high='3' optimum='0' min='0' max='4' value='0' style='width:100%;'></meter>"; //TENT CAMP
$box6 = selectTempBox("露營", $box6_content);

//box7
$box7_content = "<h4>狀態: <span id='box7_number'>0</span>/4</h4><meter id='daycamp-meter' low='2' high='3' optimum='0' min='0' max='4' value='0' style='width:100%;'></meter>"; //DAY CAMP
$box7 = selectTempBox("日營", $box7_content);

//box8
$box8_content = "<h4>狀態: <span id='box8_number'>0</span>/4</h4><meter id='eveningcamp-meter' low='2' high='3' optimum='0' min='0' max='4' value='0' style='width:100%;'></meter>"; //EVENING CAMP
$box8 = selectTempBox("黃昏營", $box8_content);

//Drinks Sales
//box9
$box9_content = "<h4>共賣出: <span id='box9_number'>0</span></h4>"; //TODAY SALES VOLUME
$box9 = selectTempBox("今日銷量", $box9_content);

//box10
$box10_content = "<h4>種類數量: <span id='box10_number'>8</span></h4>"; //SELLABLE DRINKS
$box10 = selectTempBox("飲品種類", $box10_content);


$box11 = selectTempBox();
$box12 = selectTempBox();

//Staff Management
$box13_content = "<h5> 管理員 : <span id='box13_number1'>0</span> </h5>"."<h5> 經理 : <span id='box13_number2'>0</span> </h5>"."<h5> 員工 : <span id='box13_number3'>0</span> </h5>"; //NUMBER OF USER(S)
$box13 = selectTempBox("用戶數量", $box13_content);

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