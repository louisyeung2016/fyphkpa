<?php

include_once("./language/main_string.php");

$lang = $_SESSION['language_index'];

$sidebar_bg_color = "bg-light";

if($_SESSION['themeColorIndex'] == 0){
	$sidebar_bg_color = "bg-light";
}else if($_SESSION['themeColorIndex'] == 1){
	$sidebar_bg_color = "bg-sidebar-dark";
}else{
	$sidebar_bg_color = "bg-light";
}

//selectTemp(the contect within, 0 is title and 1 is link, if you choose 1 you should provide a link)
function selectTemp($contect = "N/A", $temp_index = 0, $href_link = "") {
	//if you want to change style of temp, change the element in $up_str_arr and $down_str_arr
	//if you want to add new style of temp, add to the end of $up_str_arr and $down_str_arr, and the index will be 2
	$up_str_arr = [
	"<ul class='nav flex-column'><li class='nav-item'><a class='nav-link' href='$href_link'><span data-feather='file-text'></span>",
	"<h6 class='sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted'><span>"
	];
	$down_str_arr = [
	"</a></li></ul>",
	"</span></h6>"
	];
	$up_str = $up_str_arr[$temp_index];

	$down_str = $down_str_arr[$temp_index];

	return $up_str.$contect.$down_str;
}

//if you want to add new title and new link in side bar, create a variable and add it into $sidebar_str
//Staff Page
$link_dashboard = selectTemp($list_name_Dashboard[$lang], 0, "dashboard.php"); 

$title_checkinFunction = selectTemp($list_name_CheckinFunction[$lang], 1); 
$link_fillinBookingInfo = selectTemp($list_name_FillinBookingInfo[$lang], 0, "fillinBookingInfo.php");
$link_manageCheckinCheckout = selectTemp($list_name_CheckinAndCheckout[$lang], 0, "manageCheckinCheckout.php");
$link_viewRoomStatus = selectTemp($list_name_ViewRoomStatus[$lang], 0, "viewRoomStatus.php"); 
$link_completePayment = selectTemp($list_name_link_CompletePayment[$lang], 0, "#"); //later

$title_inventoryFunction = selectTemp($list_name_InventoryFunction[$lang], 1); 
$link_borrow = selectTemp($list_name_BorrowItem[$lang], 0, "borrow.php"); 
$link_return = selectTemp($list_name_ReturnItem[$lang], 0, "return.php"); 
$link_viewRentalRecord = selectTemp($list_name_ViewRentalRecord[$lang], 0, "viewRentalRecord.php"); 
$link_manageSmartLocker = selectTemp($list_name_link_ManageSmartLocker[$lang], 0, "manageSmartLocker.php"); 

$title_salesFunction = selectTemp($list_name_SalesFunction[$lang], 1); 
$link_salesDrinks = selectTemp($list_name_SellDrinks[$lang], 0, "sellDrinks.php"); 

$sidebar_str = <<<EOD

	<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block $sidebar_bg_color sidebar collapse">
		<div class="sidebar-sticky pt-3">
	    
		$link_dashboard
		
		$title_checkinFunction
		$link_fillinBookingInfo
		$link_manageCheckinCheckout
		$link_viewRoomStatus
		
		$title_inventoryFunction
		$link_borrow
		$link_return
		$link_viewRentalRecord
		
		
		$title_salesFunction
		$link_salesDrinks
		</div>
	</nav>

EOD;

//Admin Page
$link_adminDashboard = selectTemp($list_name_Dashboard[$lang], 0, "controlpanel.php"); 

$title_roomBookingFunction = selectTemp($list_name_RoomBookingFunction[$lang], 1); 
$link_modifyRoom = selectTemp($list_name_ModifyRoom[$lang], 0, "modifyRoom.php");
$link_manageBooking = selectTemp($list_name_ManageBooking[$lang], 0, "manageBooking.php");

$link_modifyItemCategory = selectTemp($list_name_ModifyItemCategory[$lang], 0, "modifyItemCategory.php");
$link_modifyItemInventory = selectTemp($list_name_ModifyItemInventory[$lang], 0, "modifyInventory.php");
$link_generateQRcode = selectTemp($list_name_GenerateQRcode[$lang], 0, "generateQRCode.php");

$link_modifyDrinksCategory = selectTemp($list_name_ModifyDrinksCategory[$lang], 0, "modifyDrinksCategory.php");
$link_modifyDrinksInventory = selectTemp($list_name_ModifyDrinksInventory[$lang], 0, "modifyDrinksInventory.php");

$title_adminFunction = selectTemp($list_name_AdminFunction[$lang], 1); 
$link_modifyStaff = selectTemp($list_name_ModifyStaff[$lang], 0, "modifyStaff.php");

$title_dataStatisticFunction = selectTemp($list_name_DataStatisticFunction[$lang], 1); 
$link_dataAnalysis = selectTemp($list_name_DataAnalysis[$lang], 0, "dataAnalysis.php");
$link_costRevenueAnalysis = selectTemp($list_name_CostRevenueAnalysis[$lang], 0, "costRevenueAnalysis.php");
$link_exportData = selectTemp($list_name_ExportData[$lang], 0, "exportData.php");


$title_otherFunction = selectTemp($list_name_OtherFunction[$lang], 1); //this function may not in the scope of project
$link_gallery = selectTemp($list_name_Gallery[$lang], 0, "#"); //this function may not in the scope of project

$title_systemFunction = selectTemp($list_name_SystemFunction[$lang], 1); //this function may not in the scope of project
$link_setNewsFeed = selectTemp($list_name_SetNewsFeed[$lang], 0, "setNewsFeed.php"); //this function may not in the scope of project
$link_systemSetting = selectTemp($list_name_SystemSetting[$lang], 0, "#"); //this function may not in the scope of project

$sidebar_admin_str = <<<EOD

	<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block $sidebar_bg_color sidebar collapse">
		<div class="sidebar-sticky pt-3">
	    
		$link_adminDashboard
		
		$title_roomBookingFunction
		$link_modifyRoom
		$link_manageBooking
		
		$title_inventoryFunction
		$link_modifyItemCategory
		$link_modifyItemInventory
		$link_generateQRcode
		
		$title_salesFunction
		$link_modifyDrinksCategory
		$link_modifyDrinksInventory
		
		$title_adminFunction
		$link_modifyStaff
		
		$title_dataStatisticFunction
		$link_dataAnalysis
		$link_costRevenueAnalysis
		$link_exportData

		
		
		</div>
	</nav>

EOD;
?>