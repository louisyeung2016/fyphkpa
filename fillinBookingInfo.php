<?php 
include('permissionS.php');
include('timeout.php');
include('connection.php');
?>
<?php 
include_once("./language/main_string.php"); 
include_once("./language/fillinBookingInfo_string.php"); 
include_once("./config/config.php"); 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Booking Information</title>
	<link rel="icon" type="image/x-icon" href="./favicon/<?=$staff_favicon?>/favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/dashboard/">

    

    <!-- Bootstrap core CSS -->
	<link href="dashboard/css/bootstrap.min.css" rel="stylesheet">
	<!--Font Awesome-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }



	  <!--css For fillinBookingInfo page-->
	  
		#progress {
		  position: relative;
		  margin-bottom: 30px;   
		}

		#progress-bar {
		  position: absolute;
		  background: <?php if($_SESSION['themeColorIndex'] == 1){ echo "MediumSlateBlue"; }else{ echo "lightseagreen";} ?>;
		  height: 5px;
		  width: 0%;
		  top: 63px;
		  
		}

		#progress-num {
		  margin: 0;
		  padding: 0;
		  list-style: none;
		  display: flex;
		  justify-content: space-between;
		}

		#progress-num::before {
		  content: "";
		  background-color: lightgray;
		  position: absolute;
		  top: 63px;
		  
		  height: 5px;
		  width: 100%;
		  
		  
		  z-index: -1;
		}

		#progress-num .step {
		  border: 3px solid lightgray;
		  border-radius: 100%;
		  width: 40px;
		  height: 40px;
		  line-height: 35px;
		  text-align: center;
		  background-color: #fff;
		  font-family: sans-serif;
		  font-size: 14px;    
		  position: relative;
		  z-index: 1;
		}

		#progress-num .step.active {
		  border-color: <?php if($_SESSION['themeColorIndex'] == 1){ echo "MediumSlateBlue"; }else{ echo "lightseagreen";} ?>;
		  background-color: <?php if($_SESSION['themeColorIndex'] == 1){ echo "MediumSlateBlue"; }else{ echo "lightseagreen";} ?>;
		  color: #fff;
		}


		table {

		  border-collapse: collapse;
		  width: 100%;
		}

		td, th {
		  border: 1px solid #dddddd;
		  text-align: left;
		  padding: 8px;
		}
		
		legend {
			display: block;
		  padding-left: 2px;
		  padding-right: 2px;
		  border: none;
		}

		fieldset {
			display: block;
		  margin-left: 2px;
		  margin-right: 2px;
		  padding-top: 0.35em;
		  padding-bottom: 0.625em;
		  padding-left: 0.75em;
		  padding-right: 0.75em;
		  border: 2px groove;
		}
		
		.funkyradio div {
		  clear: both;
		  overflow: hidden;
		}

		.funkyradio label {
		  width: 100%;
		  border-radius: 3px;
		  border: 1px solid #D1D3D4;
		  font-weight: normal;
		}

		.funkyradio input[type="radio"]:empty,
		.funkyradio input[type="checkbox"]:empty {
		  display: none;
		}

		.funkyradio input[type="radio"]:empty ~ label,
		.funkyradio input[type="checkbox"]:empty ~ label {
		  position: relative;
		  line-height: 2.5em;
		  text-indent: 3.25em;
		  margin-top: 2em;
		  cursor: pointer;
		  -webkit-user-select: none;
			 -moz-user-select: none;
			  -ms-user-select: none;
				  user-select: none;
		}

		.funkyradio input[type="radio"]:empty ~ label:before,
		.funkyradio input[type="checkbox"]:empty ~ label:before {
		  position: absolute;
		  display: block;
		  top: 0;
		  bottom: 0;
		  left: 0;
		  content: '';
		  width: 2.5em;
		  background: #D1D3D4;
		  border-radius: 3px 0 0 3px;
		}

		.funkyradio input[type="radio"]:hover:not(:checked) ~ label,
		.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label {
		  color: #888;
		}

		.funkyradio input[type="radio"]:hover:not(:checked) ~ label:before,
		.funkyradio input[type="checkbox"]:hover:not(:checked) ~ label:before {
		  content: '\2714';
		  text-indent: .9em;
		  color: #C2C2C2;
		}

		.funkyradio input[type="radio"]:checked ~ label,
		.funkyradio input[type="checkbox"]:checked ~ label {
		  color: #777;
		}

		.funkyradio input[type="radio"]:checked ~ label:before,
		.funkyradio input[type="checkbox"]:checked ~ label:before {
		  content: '\2714';
		  text-indent: .9em;
		  color: #333;
		  background-color: #ccc;
		}

		.funkyradio input[type="radio"]:focus ~ label:before,
		.funkyradio input[type="checkbox"]:focus ~ label:before {
		  box-shadow: 0 0 0 3px #999;
		}

		.funkyradio-default input[type="radio"]:checked ~ label:before,
		.funkyradio-default input[type="checkbox"]:checked ~ label:before {
		  color: #333;
		  background-color: #ccc;
		}

		.funkyradio-primary input[type="radio"]:checked ~ label:before,
		.funkyradio-primary input[type="checkbox"]:checked ~ label:before {
		  color: #fff;
		  background-color: #337ab7;
		}

		.funkyradio-success input[type="radio"]:checked ~ label:before,
		.funkyradio-success input[type="checkbox"]:checked ~ label:before {
		  color: #fff;
		  background-color: #5cb85c;
		}

		.funkyradio-danger input[type="radio"]:checked ~ label:before,
		.funkyradio-danger input[type="checkbox"]:checked ~ label:before {
		  color: #fff;
		  background-color: #d9534f;
		}

		.funkyradio-warning input[type="radio"]:checked ~ label:before,
		.funkyradio-warning input[type="checkbox"]:checked ~ label:before {
		  color: #fff;
		  background-color: #f0ad4e;
		}

		.funkyradio-info input[type="radio"]:checked ~ label:before,
		.funkyradio-info input[type="checkbox"]:checked ~ label:before {
		  color: #fff;
		  background-color: #5bc0de;
		}
    </style>

    <!-- Custom styles for this template -->
    <link href="dashboard/css/dashboard.css" rel="stylesheet">

	<?php
	//control the font size css 
	if($_SESSION['fontSizeIndex'] == 0){ //Normal Size
		echo "<link href=\"dashboard/css/dashboard_nm.css\" rel=\"stylesheet\">";
	}else if($_SESSION['fontSizeIndex'] == 1){ //Large Size
		echo "<link href=\"dashboard/css/dashboard_lg.css\" rel=\"stylesheet\">";
	}else{
		echo "<link href=\"dashboard/css/dashboard_nm.css\" rel=\"stylesheet\">";
	}
	?>
	
	<?php
	$field_bg_color = "WhiteSmoke"; 
	$circle_bg_color = ""; 
	//control the theme color css 
	if($_SESSION['themeColorIndex'] == 0){ //Day mode
		$field_bg_color = "WhiteSmoke"; 
		$circle_bg_color = ""; 
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}else if($_SESSION['themeColorIndex'] == 1){ //Night mode
		$field_bg_color = "DarkSlateBlue"; //MidnightBlue
		$circle_bg_color = "bg-dark"; 
		echo "<link href=\"dashboard/css/dashboard_dark.css\" rel=\"stylesheet\">";
	}else{
		$field_bg_color = "WhiteSmoke"; 
		$circle_bg_color = ""; 
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}
	?>

	<!-- Javascript -->
    

	<script src="./js/sidebar.js"></script>
	<script src="./js/showTime.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	
	<script type="text/javascript" src="js/DOMPurify-main/dist/purify.min.js"></script>
	
  </head>
  <body>
    
<?php 
include_once("./template/top_nav.php"); 
echo $top_nav_str;
 ?>
          <?php if($_SESSION['permission'] == "Admin" || $_SESSION['permission'] == "Manager"){?>
          <a class="nav-link" style="display:inline;" href="controlpanel.php"><?php echo $list_name_adminPage[$_SESSION["language_index"]] ?></a>
          &emsp;
          <?php }?>
	  <a class="nav-link" style="display:inline;" href="switchLanguage.php"><?php echo $list_name_0[$_SESSION["language_index"]] ?></a>
	  &emsp;
	  <span id="MyClockDisplay" class="nav-link" style="display:inline;" onload="showTime()"></span>
	  &emsp;
	  <span class="return-alarm" title="item return alarm"><i class="fa-regular fa-bell"></i> 0</span>
	  
	  &emsp;
	<?php
		include_once ("./template/top_nav_dropDownBox.php");
		echo $top_nav_dropDownBox_str;
	?>	
	&emsp;
	
<?php 

echo $top_nav_str2;
 ?>
<div class="container-fluid">
  <div class="row">
     <?php 
	include_once("./template/sidebar.php"); 
	echo $sidebar_str;
	 ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
		<h2 class="rh2"><?php echo $list_name_title[$lang]; ?></h2>
		
		
		
			<div id="progress">
			  <div id="progress-bar"></div>
			  <ul id="progress-num">
				<li id="stepOne" class=" <?=$circle_bg_color?> step active">1</li>
				<li id="stepTwo" class=" <?=$circle_bg_color?> step">2</li>
				<li id="stepThree" class=" <?=$circle_bg_color?> step">3</li>
				<li id="stepFour" class=" <?=$circle_bg_color?> step">4</li>
			  </ul>
			</div>

			<br>
			<div style="background-color: Silver ;">

			<table style="table-layout:fixed" class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo " ";} ?>">
			<col style="width:25%" span="4" />
			  <tr>
				<th><?php echo $top_table_title1[$lang]; ?></th>
				<th><?php echo $top_table_title2[$lang]; ?></th>
				<th><?php echo $top_table_title3[$lang]; ?></th>
				<th><?php echo $top_table_title4[$lang]; ?></th>
			  </tr>

			  <tr>
				<td>
					<?php echo $top_table_organization[$lang]; ?>: <span id="list_organizationName"></span> <br>
					<?php echo $top_table_representative[$lang]; ?>: <span id="list_representativeName"></span> <br>
					<?php echo $top_table_contact[$lang]; ?>: <span id="list_phoneNumber"></span> <br>
					<?php echo $top_table_numOfMale[$lang]; ?>: <span id="list_manNumber"></span> <br>
					<?php echo $top_table_numOfFemale[$lang]; ?>: <span id="list_womanNumber"></span> <br>
				</td>
				<td>
					<?php echo $top_table_campingType[$lang]; ?>: <span id="list_campType"></span><br>
					<?php echo $top_table_specialRate[$lang]; ?>: <span id="list_specialRate"></span> <br>
					<?php echo $top_table_totalRooms[$lang]; ?>: <br>
					<?php echo $top_table_8PersonRoom[$lang]; ?> x <span id="list_person_8_Dormitory"></span> <br>
					<?php echo $top_table_4PersonRoom[$lang]; ?> x <span id="list_person_4_Dormitory"></span> <br>
					<?php echo $top_table_2PersonRoom[$lang]; ?> x <span id="list_person_2_Dormitory"></span> <br>
				</td>
				<td>
					<?php echo $top_table_checkinDate[$lang]; ?>: <span id="list_checkInDate"></span> <br>
					<?php echo $top_table_checkinTime[$lang]; ?>: <span id="list_checkInTime"></span> <br>
					<?php echo $top_table_checkoutDate[$lang]; ?>: <span id="list_checkOutDate"></span> <br>
					<?php echo $top_table_checkoutTime[$lang]; ?>: <span id="list_checkOutTime"></span> <br>
					<?php echo $top_table_totalNight[$lang]; ?>: <span id="list_totalDays"></span> <br>
				</td>
				<td>
					<?php echo $top_table_totalRoomCharges[$lang]; ?>: $<span id="list_totalRoomPrice"></span> <br>
					<?php echo $top_table_otherCharges[$lang]; ?>: $<span id="list_otherPrice"></span> <br>
					<?php echo $top_table_totalAmount[$lang]; ?>: $<span id="list_totalPrice"></span> <br>
					<?php echo $top_table_paymentStatus[$lang]; ?>: <span id="list_paymentStatus"></span><br>
					<?php echo $top_table_tenantDepositAmount[$lang]; ?>: $<span id="list_paidAmount"></span><br>
					<?php echo $top_table_outstandingBalance[$lang]; ?>: $<span id="list_outstandingBalance"></span><br>
				</td>
			  </tr>
			</table>




			</div>
			<br>

			<form action="">

			  <fieldset id="formOne">
			  <legend class="w-auto px-2"><h2><?php echo $form1_title[$lang]; ?></h2></legend>
			  

			  <label for="organizationName"><?php echo $form1_label1[$lang]; ?>:</label><br>
			  <input type="text" id="organizationName" name="organizationName" value="" placeholder="Organization Name" required >
			  <div id="tips1" style="color: red;">require</div>
			  <br><br>
			  
			  <label for="representativeName"><?php echo $form1_label2[$lang]; ?>:</label><br>
			  <input type="text" id="representativeName" name="representativeName" value="" placeholder="Representative Name" required >
			  <div id="tips2" style="color: red;">require</div>
			  <br><br>
			  
			  <label for="contactPhoneNumber"><?php echo $form1_label3[$lang]; ?>:</label><br>
			  <input type="tel" id="contactPhoneNumber" name="contactPhoneNumber" placeholder="12345678" required>
			  <div id="tips3" style="color: red;">require</div>
			  <br><br>
			  
			  <label for="manNumber"><?php echo $form1_label4[$lang]; ?>:</label><br>
			  <input type="number" id="manNumber" name="manNumber" value="0" min="0" required>
			  <br><br>
			  
			  <label for="womanNumber"><?php echo $form1_label5[$lang]; ?>:</label><br>
			  <input type="number" id="womanNumber" name="womanNumber" value="0" min="0" required
			  ><div id="tips4" style="color: red;">total number cannot be 0</div>
			  <br><br>
			  
			  
			  <button type="button" class="btn btn-outline-danger btn-lg" onclick="resetFormOne();"> <?php echo $btn3[$_SESSION["language_index"]] ?> &#8635;</button>
			  <button type="button" class="btn btn-primary btn-lg" onclick="checkFormOne();" style="position:absolute;right:50px;"><?php echo $btn4[$_SESSION["language_index"]] ?> <i class="fa fa-arrow-circle-right"></i></button>

			  </fieldset>
			  
			  <fieldset id="formTwo">
			  <legend class="w-auto px-2"><h2><?php echo $form2_title[$lang]; ?></h2></legend>
			  
			  <?php echo $form2_label1[$lang]; ?>:<br>
			  <div class="input-group">
				
				  
				  <label for="Organizational_Booking" class="btn btn-info">
					<input type="radio" id="Organizational_Booking" name="campingType" value="<?php echo $form2_campingType1[$lang]; ?>" onclick="handleClick(this);">
					<?php echo $form2_campingType1[$lang]; ?>
				  </label> &emsp;
				
				  
				  <label for="individual_Booking" class="btn btn-info">
					<input type="radio" id="individual_Booking" name="campingType" value="<?php echo $form2_campingType2[$lang]; ?>" onclick="handleClick(this);">
					<?php echo $form2_campingType2[$lang]; ?>
				  </label> &emsp;
				
				  
				  <label for="Day_Camp" class="btn btn-info">
					<input type="radio" id="Day_Camp" name="campingType" value="<?php echo $form2_campingType3[$lang]; ?>" onclick="handleClick(this);">
					<?php echo $form2_campingType3[$lang]; ?>
				  </label> &emsp;
				  
				  
				  <label for="Evening_Camp" class="btn btn-info">
					<input type="radio" id="Evening_Camp" name="campingType" value="<?php echo $form2_campingType4[$lang]; ?>" onclick="handleClick(this);">
					<?php echo $form2_campingType4[$lang]; ?>
				  </label> &emsp;
				  
				  
				  <label for="Tent_Camp" class="btn btn-info">
					<input type="radio" id="Tent_Camp" name="campingType" value="<?php echo $form2_campingType5[$lang]; ?>" onclick="handleClick(this);">
					<?php echo $form2_campingType5[$lang]; ?>
				  </label>
				  <br>
				  
			  </div>
			  
			  <div id="tips_notSelectedCampingType" style="color: red;">
			  require
			  </div>
			  <br>
			  
			  <br>
			  <div id="tips_peopleNumInsufficiency" style="background-color: Silver ;color: red;">
			  check 人數<br>
			  <!--
			  (if user chooses  團體營 or 家庭營, and 人數少於??) <br>
			  人數不足, 必須多於??人<br>
			  -->
			  (if user chooses  <?php echo $form2_campingType3[$lang]; ?> or <?php echo $form2_campingType4[$lang]; ?>, and 人數少於20) <br>
			  人數不足, 必須多於19人<br>
			  (if user chooses  <?php echo $form2_campingType5[$lang]; ?>, and 人數少於8) <br>
			  人數不足, 必須多於7人<br>
			  </div>
			  <br>
			  

			  
			  
			  
			  <div id="is_OrganizationalOrIndividual" class="p-2 rounded" style="background-color: <?php echo $field_bg_color;?> ;">
			  
			  <div class="funkyradio">
				  <div id="specialRate_div" class="funkyradio-info">
					<input type="checkbox" id="is_SpecialRate" name="is_SpecialRate" value="specialRate">
					<label style='width:50%;' for="is_SpecialRate"><?php echo $form2_specialRate[$lang]; ?>?:&emsp;</label>
				  </div>
			  
			  
			  <br>
			  
				  <div id="fullCampBooking_div" class="funkyradio-danger">
					
					<!--(if 包營 is clicked, all rooms below will be checked)-->
					<input type="checkbox" id="fullCampBooking" name="fullCampBooking" value="fullCampBooking" onchange="clickedFullCampBooking();">
					<label style='width:50%;' for="fullCampBooking"><?php echo $form2_fullCampBooking[$lang]; ?>?:&emsp;</label>
				  </div>
			  </div>
			  <br><br>
			  
			  <div id="selectRoom_div">
			  
			  <?php echo $form2_8PersonRoom[$lang]; ?>: <br>
			  <!--
			  <input type="checkbox" name="person_8_Dormitory" value="A01" noOfBedUnit="8" onclick="countRoomChosen();"> A01 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A02" noOfBedUnit="8" onclick="countRoomChosen();"> A02 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A03" noOfBedUnit="8" onclick="countRoomChosen();"> A03 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A04" noOfBedUnit="8" onclick="countRoomChosen();"> A04 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A05" noOfBedUnit="8" onclick="countRoomChosen();"> A05<br>
			  <input type="checkbox" name="person_8_Dormitory" value="A06" noOfBedUnit="8" onclick="countRoomChosen();"> A06 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A07" noOfBedUnit="8" onclick="countRoomChosen();"> A07 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A08" noOfBedUnit="8" onclick="countRoomChosen();"> A08 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A09" noOfBedUnit="8" onclick="countRoomChosen();"> A09 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A10" noOfBedUnit="8" onclick="countRoomChosen();"> A10<br>
			  <input type="checkbox" name="person_8_Dormitory" value="A11" noOfBedUnit="8" onclick="countRoomChosen();"> A11 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A12" noOfBedUnit="8" onclick="countRoomChosen();"> A12 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A13" noOfBedUnit="8" onclick="countRoomChosen();"> A13 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A14" noOfBedUnit="8" onclick="countRoomChosen();"> A14 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A15" noOfBedUnit="8" onclick="countRoomChosen();"> A15<br>
			  <input type="checkbox" name="person_8_Dormitory" value="A16" noOfBedUnit="8" onclick="countRoomChosen();"> A16 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A17" noOfBedUnit="8" onclick="countRoomChosen();"> A17 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A18" noOfBedUnit="8" onclick="countRoomChosen();"> A18 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A19" noOfBedUnit="8" onclick="countRoomChosen();"> A19 &emsp;
			  <input type="checkbox" name="person_8_Dormitory" value="A20" noOfBedUnit="8" onclick="countRoomChosen();"> A20<br>
			  -->

			  <div class="funkyradio">
			  
			    <?php
				$list_RoomNumber = array();;
				$sqlA = "SELECT room_number FROM `room_category` WHERE room_type = '8-person Dormitory' ORDER BY room_number ASC "; //write the SQL statement
				$rsA = mysqli_query($conn, $sqlA) //mysqli_query() function performs a query against a database.
				  or die(mysqli_error($conn));
				$rcA = mysqli_fetch_assoc($rsA);
				do {
					$roomNum = $rcA['room_number'];
					array_push($list_RoomNumber, $roomNum);
				} while ($rcA = mysqli_fetch_assoc($rsA));
				//echo $list_RoomNumber;
				$num_items = count($list_RoomNumber);
				$num_divs = ceil($num_items / 5);

				for ($i = 0; $i < $num_divs; $i++) {
				  
				  for ($j = $i * 5; $j < min($i * 5 + 5, $num_items); $j++) {
					echo "<span class=\"funkyradio-success\"><input type=\"checkbox\" name=\"person_8_Dormitory\" id=\"".$list_RoomNumber[$j]."\" value=\"".$list_RoomNumber[$j]."\" noOfBedUnit=\"8\" onclick=\"countRoomChosen();\"><label style='width:80px;' for=\"".$list_RoomNumber[$j]."\"> ".$list_RoomNumber[$j]."</label></span> &emsp; ";
				  }
				  echo "<br>";
				}
				?>
			  
			  <!--use document.getElementById("XXX").getAttribute("noOfBedUnit") to get 8-->
			  <br>
			  
			  <?php echo $form2_4PersonRoom[$lang]; ?>: <br>
			  <?php
				$list_RoomNumber = array();;
				$sqlA = "SELECT room_number FROM `room_category` WHERE room_type = '4-person Dormitory' ORDER BY room_number ASC "; //write the SQL statement
				$rsA = mysqli_query($conn, $sqlA) //mysqli_query() function performs a query against a database.
				  or die(mysqli_error($conn));
				$rcA = mysqli_fetch_assoc($rsA);
				do {
					$roomNum = $rcA['room_number'];
					array_push($list_RoomNumber, $roomNum);
				} while ($rcA = mysqli_fetch_assoc($rsA));
				//echo $list_RoomNumber;
				$num_items = count($list_RoomNumber);
				$num_divs = ceil($num_items / 5);

				for ($i = 0; $i < $num_divs; $i++) {
				  
				  for ($j = $i * 5; $j < min($i * 5 + 5, $num_items); $j++) {
					echo "<span class=\"funkyradio-success\"><input type=\"checkbox\" name=\"person_4_Dormitory\" id=\"".$list_RoomNumber[$j]."\" value=\"".$list_RoomNumber[$j]."\" noOfBedUnit=\"4\" onclick=\"countRoomChosen();\"><label style='width:80px;' for=\"".$list_RoomNumber[$j]."\"> ".$list_RoomNumber[$j]."</label></span> &emsp; ";
				  }
				  echo "<br>";
				}
				?>
			  <br>
			  
			  <?php echo $form2_2PersonRoom[$lang]; ?>: <br>
			  <?php
				$list_RoomNumber = array();;
				$sqlA = "SELECT room_number FROM `room_category` WHERE room_type = '2-person Dormitory' ORDER BY room_number ASC "; //write the SQL statement
				$rsA = mysqli_query($conn, $sqlA) //mysqli_query() function performs a query against a database.
				  or die(mysqli_error($conn));
				$rcA = mysqli_fetch_assoc($rsA);
				do {
					$roomNum = $rcA['room_number'];
					array_push($list_RoomNumber, $roomNum);
				} while ($rcA = mysqli_fetch_assoc($rsA));
				//echo $list_RoomNumber;
				$num_items = count($list_RoomNumber);
				$num_divs = ceil($num_items / 5);

				for ($i = 0; $i < $num_divs; $i++) {
				  
				  for ($j = $i * 5; $j < min($i * 5 + 5, $num_items); $j++) {
					echo "<span class=\"funkyradio-success\"><input type=\"checkbox\" name=\"person_2_Dormitory\" id=\"".$list_RoomNumber[$j]."\" value=\"".$list_RoomNumber[$j]."\" noOfBedUnit=\"2\" onclick=\"countRoomChosen();\"><label style='width:80px;' for=\"".$list_RoomNumber[$j]."\"> ".$list_RoomNumber[$j]."</label></span> &emsp; ";
				  }
				  echo "<br>";
				}
				?>
				<br>
				
				<?php echo $form2_backupRoom[$lang]; ?>: <br>
				<?php
				$list_RoomNumber = array();;
				$sqlA = "SELECT room_number FROM `room_category` WHERE room_type = 'Backup Room' ORDER BY room_number ASC "; //write the SQL statement
				$rsA = mysqli_query($conn, $sqlA) //mysqli_query() function performs a query against a database.
				  or die(mysqli_error($conn));
				$rcA = mysqli_fetch_assoc($rsA);
				do {
					$roomNum = $rcA['room_number'];
					array_push($list_RoomNumber, $roomNum);
				} while ($rcA = mysqli_fetch_assoc($rsA));
				//echo $list_RoomNumber;
				$num_items = count($list_RoomNumber);
				$num_divs = ceil($num_items / 5);

				for ($i = 0; $i < $num_divs; $i++) {
				  
				  for ($j = $i * 5; $j < min($i * 5 + 5, $num_items); $j++) {
					echo "<span class=\"funkyradio-success\"><input type=\"checkbox\" name=\"person_2_Dormitory\" id=\"".$list_RoomNumber[$j]."\" value=\"".$list_RoomNumber[$j]."\" noOfBedUnit=\"2\" onclick=\"countRoomChosen();\"><label style='width:80px;' for=\"".$list_RoomNumber[$j]."\"> ".$list_RoomNumber[$j]."</label></span> &emsp; ";
				  }
				  echo "<br>";
				}
				?>
				<br>
				</div>
			  </div>
			  
			  </div>
			  <br>

			  <div id="tips_roomInsufficiency" style="color: red;">
				<div>Min. Dormitory Booking: 2 x 8-person dormitory for <?php echo $form2_campingType1[$lang]; ?></div> <!--放寬咗??-->
				<div>Min. Bed Unit for <?php echo $form2_campingType1[$lang]; ?>: 8 </div>
				<div>Min. Dormitory Booking: 2 x 4-person dormitory for <?php echo $form2_campingType2[$lang]; ?></div> <!--放寬咗??-->
				<div>Min. Bed Unit for <?php echo $form2_campingType2[$lang]; ?>: 8 </div>
				<!--
				<div>Min. Dormitory Booking: 1 x any dormitory for 日營 or 黃昏營</div>
				-->
			  </div>
			  
			  <br>
			  <div id="total_RoomChosen_fullCampBooking" class="p-2 rounded" style="background-color: <?php echo $field_bg_color;?> ;">
			  
			  <?php echo $form2_totalRooms[$lang]; ?>:<br>
			  <?php echo $form2_8PersonRoom[$lang]; ?> x <span id="numOf_person_8_Dormitory">0</span> <br>
			  <?php echo $form2_4PersonRoom[$lang]; ?> x <span id="numOf_person_4_Dormitory">0</span> <br>
			  <?php echo $form2_2PersonRoom[$lang]; ?> x <span id="numOf_person_2_Dormitory">0</span> <br>
			  </div>
			  <br>
			  
			  
			  <button type="button" class="btn btn-secondary btn-lg" onclick="backToFormOne();"><i class="fa fa-arrow-circle-left"></i> <?php echo $btn2[$_SESSION["language_index"]] ?></button>
			  <button type="button" class="btn btn-primary btn-lg" onclick="checkFormTwo();" style="position:absolute;right:50px;"><?php echo $btn4[$_SESSION["language_index"]] ?> <i class="fa fa-arrow-circle-right"></i></button>

			  </fieldset>
			  
			  <fieldset id="formThree">
			  <legend class="w-auto px-2"><h2><?php echo $form3_title[$lang]; ?></h2></legend>
			  

			  <label for="fname"><?php echo $form3_label1[$lang]; ?>:</label><br>
			  <input type="date" id="checkin_date" name="checkin_date" class="form-control" onchange="countDays();" required><br><br>
			  
			  <label for="lname"><?php echo $form3_label2[$lang]; ?>:</label><br>
			  <input type="time" id="checkin_time" name="checkin_time" class="form-control" value="15:00" list="popularHours" required><br><br>
			  
			  <label for="lname"><?php echo $form3_label3[$lang]; ?>:</label><br>
			  <input type="date" id="checkout_date" name="checkout_date" class="form-control" onchange="countDays();" required><br><br>
			  
			  <label for="lname"><?php echo $form3_label4[$lang]; ?>:</label><br>
			  <input type="time" id="checkout_time" name="checkout_time" class="form-control" value="12:00" list="popularHours" required><br><br>
			  
			  <datalist id="popularHours">
				<option value="09:00" label="morning"></option>
				<option value="12:00" label="noon"></option>
				<option value="15:00" label="afernoon"></option>
				<option value="18:00" label="evening"></option>
			  </datalist>
			  
			  <br>
			  <div class="p-2 rounded" style="background-color: <?php echo $field_bg_color;?> ;">
			  <?php echo $form3_totalNight[$lang]; ?>: <span id="total_numOfDays">0</span>
			  </div>
			  <br>
			  
			  <button type="button" class="btn btn-secondary btn-lg" onclick="backToFormTwo();"><i class="fa fa-arrow-circle-left"></i> <?php echo $btn2[$_SESSION["language_index"]] ?></button>
			  <button type="button" class="btn btn-primary btn-lg" onclick="checkFormThree();" style="position:absolute;right:50px;"><?php echo $btn4[$_SESSION["language_index"]] ?> <i class="fa fa-arrow-circle-right"></i></button>
			  </fieldset>
			  

			  
			  
			  <fieldset id="formFour">
			  <legend class="w-auto px-2"><h2><?php echo $form4_title[$lang]; ?></h2></legend>
			  

			  <?php echo $form4_label1[$lang]; ?>: <input type="number" id="totalRoomPrice" class="form-control" min="0.00"  step="0.01" value="7260.00" required readonly /><br><br>
			  
			  <?php echo $form4_label2[$lang]; ?>: <input type="number" id="otherPrice" class="form-control" min="0.00"  step="0.01" value="0.00" onchange="calculateTotalPrice();" required /><br><br>
			  
			  <?php echo $form4_label3[$lang]; ?>: <input type="number" id="totalPrice" class="form-control" min="0.00"  step="0.01" value="8260.00" required readonly /><br><br>
			  
			  <?php echo $form4_label4[$lang]; ?>: 
				<select class="form-control" id="payment_status" name="payment_status" onchange="select_paymentStatus();">
				  <option selected >Full Paid</option>
				  <option >Partial Paid</option>
				  <option >Not Paid</option>
				</select>
			  <br><br>
			  
			  <br>
			  <div class="p-2 rounded" style="background-color: <?php echo $field_bg_color;?> ;">
			  <?php echo $form4_label5[$lang]; ?>:
			  <input type="number" id="paid_amount" class="form-control" step="0.01" value="0.00" onchange="changeOutstandingBalance();" required /><br><br>
			  <?php echo $form4_label6[$lang]; ?>:
			  <input type="number" id="outstanding_balance" name="outstanding_balance" class="form-control" min="0.00"  step="0.01" value="0.00" readonly required /><br><br>
			  </div>
			  <br>
			  
			  <button type="button" class="btn btn-secondary btn-sm" onclick="backToFormThree();"><i class="fa fa-arrow-circle-left"></i> <?php echo $btn2[$_SESSION["language_index"]] ?></button>
			  <button type="button" class="btn btn-success btn-sm" onclick="checkFormFour();"><?php echo $btn1[$_SESSION["language_index"]] ?> <i class="fa fa-send-o"></i></button>
			  <button type="button" class="btn btn-outline-danger btn-sm" onclick="location.reload();" style="position:absolute;right:50px;"><?php echo $btn3[$_SESSION["language_index"]] ?> &#8635;</button>
			  <!--
			  <button type="button" onclick="toJson();">ToJSON</button>
			  -->
			  </fieldset>
			  
			  
			  
			  <br>
			  
			</form> 
		
		
		
		
    </main>

</div>
</div>


  </body>
</html>

<script>
	<?php 
	include_once("./template/common_js.php"); 
	echo $common_js_str;
	 ?>
	 
	 //highlight the link on sidebar
	<?php  
		$site = str_replace($directory,'',$_SERVER['PHP_SELF']);
	?>
	
	window.addEventListener("load", function() {
	  var aTag = document.getElementsByTagName("a");
	  //alert(aTag.length);
	  for (let i = 0; i < aTag.length; i++) {
		var activelink = aTag[i].getAttribute("href");
		if(activelink == "<?php echo $site?>"){
			//alert("yes");
			aTag[i].classList.add("active");
		}
	  }
	});

	

//only show the first form at beginning, hide form 2,3,4
$(document).ready(function(){
	$("#formTwo").hide(); //the Room Option Form
	$("#formThree").hide(); //the Camping Date Time Form
	$("#formFour").hide(); //the Payment Form
});

//the error messages were hidden at beginning
$(document).ready(function(){
	$("#tips1").hide();
	$("#tips2").hide();
	$("#tips3").hide();
	$("#tips4").hide();
	$("#tips_notSelectedCampingType").hide();
	$("#tips_peopleNumInsufficiency").hide();
	$("#tips_roomInsufficiency").hide();
});

//hide the room options for different camp type selection, show after user choose the corresponding radio button
$(document).ready(function(){
	$("#is_OrganizationalOrIndividual").hide();
	$("#is_DayOrEvening").hide();
	$("#is_TentCamp").hide();
	//$("#total_RoomChosen_fullCampBooking").hide();
	//$("#total_RoomChosen_notFullCampBooking").hide();
});

//=========================== Form 1 functions ========================================

//when user clicks "Next" button at Form 1, it will check user-input invalid or not
function checkFormOne(){
	var thisFromOK = false;
	var phoneNumberOK = false;
	
	var organizationName = DOMPurify.sanitize(document.getElementById("organizationName").value);
	var representativeName = DOMPurify.sanitize(document.getElementById("representativeName").value);
	var contactPhoneNumber= document.getElementById("contactPhoneNumber");
	var manNumber= document.getElementById("manNumber");
	var womanNumber= document.getElementById("womanNumber");
	
	
	
	
	if(organizationName ==""){
		$("#tips1").show();
	}else{
		$("#tips1").hide();
	}
	
	if(representativeName ==""){
		$("#tips2").show();
	}else{
		$("#tips2").hide();
	}
	
	if(contactPhoneNumber.value ==""){
		$("#tips3").show();
	}else{
		$("#tips3").hide();
	}
	
	if(checkPhoneNumberValid(contactPhoneNumber.value)){
		phoneNumberOK = true;
	}
	
	if(manNumber.value =="" || womanNumber.value ==""){
		$("#tips4").show();
	}else{
		$("#tips4").hide();
	}
	
	if((manNumber.value + womanNumber.value) <=0){
		$("#tips4").show();
	}else{
		$("#tips4").hide();
	}
	
	if(organizationName !="" && representativeName !="" && contactPhoneNumber.value !="" && manNumber.value !="" && womanNumber.value !="" && (manNumber.value + womanNumber.value) >0 && phoneNumberOK == true){
		thisFromOK = true;
	}
	
	if(thisFromOK == true){
		$("#stepTwo").addClass("active");
		$("#progress-bar").css("width", "33.3%");
		$("#formOne").fadeOut("fast", function(){
			$("#formTwo").fadeIn("slow");
		});
		
		//fill information into the top list table
		$("#list_organizationName").html(organizationName);
		$("#list_representativeName").html(representativeName);
		$("#list_phoneNumber").html(contactPhoneNumber.value);
		$("#list_manNumber").html(manNumber.value);
		$("#list_womanNumber").html(womanNumber.value);
	}
}

function checkPhoneNumberValid(inputtxt){ //check phone number valid with 8 digits or not
  var phoneno = /^\d{8}$/;
  if(inputtxt.match(phoneno)){
    return true;
  }else{
    alert("Please enter correct phone number with 8 digits\n請輸入正確的8位數字電話號碼");
    return false;
  }
}

//when user clicks "Reset" button at Form 1, it will reset all fields
function resetFormOne(){
	var organizationName= document.getElementById("organizationName");
	if (organizationName.value !="") {
		organizationName.value = "";
	}
	var representativeName= document.getElementById("representativeName");
	if (representativeName.value !="") {
		representativeName.value = "";
	}
	var contactPhoneNumber= document.getElementById("contactPhoneNumber");
	if (contactPhoneNumber.value !="") {
		contactPhoneNumber.value = "";
	}
	var manNumber= document.getElementById("manNumber");
	if (manNumber.value != 0) {
		manNumber.value = 0;
	}
	var womanNumber= document.getElementById("womanNumber");
	if (womanNumber.value != 0) {
		womanNumber.value = 0;
	}
	
	//clear information from the top list table
	$("#list_organizationName").empty();
	$("#list_representativeName").empty();
	$("#list_phoneNumber").empty();
	$("#list_manNumber").empty();
	$("#list_womanNumber").empty();
	
}

//=========================== Form 2 functions ========================================

//reactions when user chooses on of the radio button of camp type
function handleClick(myRadio) {
	if(myRadio.value == "<?php echo $form2_campingType1[$lang]; ?>" || myRadio.value == "<?php echo $form2_campingType2[$lang]; ?>"){
		$("#is_OrganizationalOrIndividual").show(); //show the div of Organizational Individual camping
		
		$("#specialRate_div").show(); //show a "special rate" check box
		$("#fullCampBooking_div").show(); //show a "full camp booking" check box
		$("#selectRoom_div").show(); //show all rooms for user to choose
	}else if(myRadio.value == "<?php echo $form2_campingType3[$lang]; ?>" || myRadio.value == "<?php echo $form2_campingType4[$lang]; ?>"){

		$("#is_OrganizationalOrIndividual").show();
		
		$("#specialRate_div").hide(); //hide a "special rate" check box, because 日營 and 黃昏營 do not have special rate
		$("#fullCampBooking_div").hide(); //hide a "full camp booking" check box, because 日營 and 黃昏營 do not have full camp booking option
		$("#selectRoom_div").hide(); //hide all rooms for user to choose, because 日營 and 黃昏營 do not need to choose rooms
		
		document.getElementById("is_SpecialRate").checked = false; //uncheck the "special rate" check box
		document.getElementById("fullCampBooking").checked = false; //uncheck the "full camp booking" check box
		
		//uncheck all selected rooms
		const collection = document.getElementsByName("person_8_Dormitory");
		const collection4 = document.getElementsByName("person_4_Dormitory");
		const collection2 = document.getElementsByName("person_2_Dormitory");
		for(let i = 0; i < collection.length; i++){
				collection[i].checked = false;
		}
		for(let i = 0; i < collection4.length; i++){
				collection4[i].checked = false;
		}
		for(let i = 0; i < collection2.length; i++){
				collection2[i].checked = false;
		}
		countRoomChosen(); //set the number of chosen room to 0, because 日營 and 黃昏營 do not need to choose rooms
	}else if(myRadio.value == "<?php echo $form2_campingType5[$lang]; ?>"){
		$("#is_OrganizationalOrIndividual").show();
		
		$("#specialRate_div").show();
		$("#fullCampBooking_div").hide();
		$("#selectRoom_div").hide();
		
		document.getElementById("fullCampBooking").checked = false;
		
		//uncheck all selected rooms
		const collection = document.getElementsByName("person_8_Dormitory");
		const collection4 = document.getElementsByName("person_4_Dormitory");
		const collection2 = document.getElementsByName("person_2_Dormitory");
		for(let i = 0; i < collection.length; i++){
				collection[i].checked = false;
		}
		for(let i = 0; i < collection4.length; i++){
				collection4[i].checked = false;
		}
		for(let i = 0; i < collection2.length; i++){
				collection2[i].checked = false;
		}
		countRoomChosen(); //set the number of chosen room to 0, because 露營 do not need to choose rooms
	}
	
}

//the reaction of user clicked "full camp booking" check box
function clickedFullCampBooking(){
	const collection = document.getElementsByName("person_8_Dormitory");
	const collection4 = document.getElementsByName("person_4_Dormitory");
	const collection2 = document.getElementsByName("person_2_Dormitory");
	if(document.getElementById("fullCampBooking").checked == true){ //if "full camp booking" check box is checked, all rooms will be selected
		for(let i = 0; i < collection.length; i++){
				collection[i].checked = true;
		}
		for(let i = 0; i < collection4.length; i++){
				collection4[i].checked = true;
		}
		for(let i = 0; i < collection2.length; i++){
				collection2[i].checked = true;
		}
		countRoomChosen(); //set all rooms have been chosen
	}else if(document.getElementById("fullCampBooking").checked == false){ //if "full camp booking" check box is unchecked, all rooms will be opt out
		for(let i = 0; i < collection.length; i++){
				collection[i].checked = false;
		}
		for(let i = 0; i < collection4.length; i++){
				collection4[i].checked = false;
		}
		for(let i = 0; i < collection2.length; i++){
				collection2[i].checked = false;
		}
		countRoomChosen(); //set all rooms have not been chosen
	}
	
}

//count how many rooms are chosen and show the number out
function countRoomChosen(){
	//count how many person_8_Dormitory rooms are chosen
	const collection = document.getElementsByName("person_8_Dormitory");
	var x = 0;

	for(let i = 0; i < collection.length; i++){
		if(collection[i].checked == true){
			x++;
		}
	}

	document.getElementById("numOf_person_8_Dormitory").innerHTML = x; //show the number out
	
	
	
	//count how many person_4_Dormitory rooms are chosen
	const collection4 = document.getElementsByName("person_4_Dormitory");
	var y = 0;
	for(let i = 0; i < collection4.length; i++){
		if(collection4[i].checked == true){
			y++;
		}
	}
	document.getElementById("numOf_person_4_Dormitory").innerHTML = y; //show the number out
	
	
	
	//count how many person_2_Dormitory rooms are chosen
	const collection2 = document.getElementsByName("person_2_Dormitory");
	var z = 0;
	for(let i = 0; i < collection2.length; i++){
		if(collection2[i].checked == true){
			z++;
		}
	}
	document.getElementById("numOf_person_2_Dormitory").innerHTML = z; //show the number out
	
	//if 包營 checked, but not all rooms selected (someone opt out some rooms)
	var isAllRoomsChosen = true;
	
	for(let i = 0; i < collection.length; i++){
		if(collection[i].checked == false){
			document.getElementById("fullCampBooking").checked = false;
			isAllRoomsChosen = false;
		}
	}
	for(let i = 0; i < collection4.length; i++){
		if(collection4[i].checked == false){
			document.getElementById("fullCampBooking").checked = false;
			isAllRoomsChosen = false;
		}
	}
	for(let i = 0; i < collection2.length; i++){
		if(collection2[i].checked == false){
			document.getElementById("fullCampBooking").checked = false;
			isAllRoomsChosen = false;
		}
	}
	
	//if all rooms selected, but 包營 is not checked
	if(isAllRoomsChosen == true){
		document.getElementById("fullCampBooking").checked = true;
	}
	
	console.log("已選床位數: "+getTotalNumberOfBedUnitChosen());
}

//get the Total Resident(camper) Number in Form 1
function getTotalResidentNumber(){
	var totalResidentNumber = parseInt(document.getElementById("womanNumber").value) + parseInt(document.getElementById("manNumber").value);
	return totalResidentNumber;
}

//get the number of total bed unit (床位)
function getTotalNumberOfBedUnitChosen(){
	var numberOfBedUnitChosen_person_8_Dormitory = 0;
	var numberOfBedUnitChosen_person_4_Dormitory = 0;
	var numberOfBedUnitChosen_person_2_Dormitory = 0;
	var totalNumberOfBedUnitChosen = 0;
	
	for(let i = 0; i < document.querySelectorAll('input[name="person_8_Dormitory"]:checked').length; i++){
		numberOfBedUnitChosen_person_8_Dormitory += parseInt(document.querySelectorAll('input[name="person_8_Dormitory"]:checked')[i].getAttribute("noOfBedUnit"));
	}
	
	for(let i = 0; i < document.querySelectorAll('input[name="person_4_Dormitory"]:checked').length; i++){
		numberOfBedUnitChosen_person_4_Dormitory += parseInt(document.querySelectorAll('input[name="person_4_Dormitory"]:checked')[i].getAttribute("noOfBedUnit"));
	}
	
	for(let i = 0; i < document.querySelectorAll('input[name="person_2_Dormitory"]:checked').length; i++){
		numberOfBedUnitChosen_person_2_Dormitory += parseInt(document.querySelectorAll('input[name="person_2_Dormitory"]:checked')[i].getAttribute("noOfBedUnit"));
	}
	
	totalNumberOfBedUnitChosen = numberOfBedUnitChosen_person_8_Dormitory + numberOfBedUnitChosen_person_4_Dormitory + numberOfBedUnitChosen_person_2_Dormitory;
	
	return totalNumberOfBedUnitChosen;
}

//when user clicks "Next" button at Form 2, it will check user-input invalid or not
function checkFormTwo(){
	let thisFromOK = false; //if this boolean is true, user can go to Form 3
	let isCampTypeSelected = false; //check one of radio button is selected or not
	
	var totalResidentNumber = getTotalResidentNumber(); //get the Total Resident Number
	console.log(totalResidentNumber);
	
	var totalNumberOfBedUnitChosen = getTotalNumberOfBedUnitChosen(); //get the number of total bed unit (床位)
	console.log(totalNumberOfBedUnitChosen);
	
	//check one of radio button is selected
	for(let i = 0; i < document.getElementsByName("campingType").length; i++){
		if(document.getElementsByName("campingType")[i].checked == true){ //travel all radio button, if one of it is checked, isCampTypeSelected = true
			isCampTypeSelected = true;
		}
	}
	if(isCampTypeSelected == false){
		$("#tips_notSelectedCampingType").show(); //hint the user that you must choose one of the camp type
	}else{ //if one of the camp type is chosen
		if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType1[$lang]; ?>"){ //if the chosen option is 團體營

			
			thisFromOK = true;
			
		}else if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType2[$lang]; ?>"){ //if the chosen option is 家庭營
			thisFromOK = true;
		}else if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType3[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType4[$lang]; ?>"){ //if the chosen option is 日營 or 黃昏營
			thisFromOK = true;
		}else if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType5[$lang]; ?>"){ //if the chosen option is 露營
			thisFromOK = true;
			
		}
		
	}
	
	
	if(thisFromOK == true){
		//prepare for the Form 3, because 日營 and 黃昏營 only one day, but 團體營 and 家庭營 and 露營 must more than one day
		if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType1[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType2[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType5[$lang]; ?>"){
			//nothing
			$("#checkout_date").show();
			document.getElementById("checkin_time").value = "15:00";
			document.getElementById("checkout_time").value = "12:00";
			$('#checkin_time').removeAttr('readonly');
			$('#checkout_time').removeAttr('readonly');
		}else if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType3[$lang]; ?>"){
			//only show 入營日期
			//$("#checkout_date").hide();
			document.getElementById("checkin_time").value = "10:00";
			document.getElementById("checkout_time").value = "16:00";
			$('#checkin_time').prop('readonly', true); //lock the time selection, because there is a fixed time for 日營
			$('#checkout_time').prop('readonly', true); //lock the time selection, because there is a fixed time for 日營
			
			//set入營日期 = 出營日期
			x = document.getElementById("checkin_date").value;
			document.getElementById("checkout_date").value = x;
			
			document.getElementById("total_numOfDays").innerHTML = 1; //set the total day(night) to 1
		}else if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType4[$lang]; ?>"){
			//only show 入營日期
			//$("#checkout_date").hide();
			document.getElementById("checkin_time").value = "16:00";
			document.getElementById("checkout_time").value = "22:00";
			$('#checkin_time').prop('readonly', true); //lock the time selection, because there is a fixed time for 黃昏營
			$('#checkout_time').prop('readonly', true);	//lock the time selection, because there is a fixed time for 黃昏營

			//set入營日期 = 出營日期
			x = document.getElementById("checkin_date").value;
			document.getElementById("checkout_date").value = x;
			
			document.getElementById("total_numOfDays").innerHTML = 1; //set the total day(night) to 1
		}
		
		$("#tips_notSelectedCampingType").hide();
		
		$("#stepThree").addClass("active");
		$("#progress-bar").css("width", "63%");
		$("#formTwo").fadeOut("fast", function(){
			$("#formThree").fadeIn("slow");
		});
		
		//fill information into the top list table
		$("#list_campType").html(document.querySelector('input[name="campingType"]:checked').value);
		if(document.getElementById("is_SpecialRate").checked == true){
			$("#list_specialRate").html("Yes");
		}else{
			$("#list_specialRate").html("No");
		}
		
		$("#list_person_8_Dormitory").html(document.getElementById("numOf_person_8_Dormitory").innerHTML);
		$("#list_person_4_Dormitory").html(document.getElementById("numOf_person_4_Dormitory").innerHTML);
		$("#list_person_2_Dormitory").html(document.getElementById("numOf_person_2_Dormitory").innerHTML);
	}
	
	
}

//reset the Form 2
function resetFormTwo(){
	$('input[name="campingType"]').prop('checked',false);
	document.getElementById("is_SpecialRate").checked = false;
	document.getElementById("fullCampBooking").checked = false;
	clickedFullCampBooking();
	
	$("#is_OrganizationalOrIndividual").hide();
		
	$("#specialRate_div").hide();
	$("#fullCampBooking_div").hide();
	$("#selectRoom_div").hide();
}

//back to Form 1
function backToFormOne(){
	$("#formTwo").fadeOut("fast", function(){
		$("#formOne").fadeIn("slow");
	});
	$("#stepTwo").removeClass("active");
	$("#progress-bar").css("width", "0%");
	
	//reset Form2
	resetFormTwo();
	
	//clear information from the top list table
	$("#list_campType").empty();
	$("#list_specialRate").empty();
	$("#list_person_8_Dormitory").empty();
	$("#list_person_4_Dormitory").empty();
	$("#list_person_2_Dormitory").empty();
}

//=========================== Form 3 functions ========================================

//get today's date
function getDate() { 
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();

  if(dd<10) {
      dd = '0'+dd
  } 

  if(mm<10) {
      mm = '0'+mm
  } 

  today = yyyy + '-' + mm + '-' + dd;
  console.log(today);
  document.getElementById("checkin_date").value = today;
}

//run the getDate() function when the page start
window.onload = function() { 
  getDate();
};

//count the days(nights) when user chooses the check-in date or check-out date
function countDays(){
	if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType1[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType2[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType5[$lang]; ?>"){
		x = new Date(document.getElementById("checkin_date").value).getTime();
		y = new Date(document.getElementById("checkout_date").value).getTime();
		
		if(x>=y){ //user does not choose a date where Check-out Date is earlier than or equal to Check-in Dat
			alert("出營日期 不得早於或等於 入營日期\nCheck-out Date cannot be earlier than or equal to Check-in Date");
			console.log(numOfDays);
			document.getElementById("total_numOfDays").innerHTML = "Invalid";
		}else{
			var numOfDays = (y - x)/(1000*60*60*24);
			console.log(numOfDays);
			if(Number.isNaN(numOfDays)||(x>y)){ //user does not choose a date

				document.getElementById("total_numOfDays").innerHTML = "NaN"; //user does not choose a date
			}else{

				document.getElementById("total_numOfDays").innerHTML = numOfDays;
			}
		}
	}else if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType3[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType4[$lang]; ?>"){ //日營 and 黃昏營 only one day, check-in date =check-out date
		x = document.getElementById("checkin_date").value;
		document.getElementById("checkout_date").value = x;
		
		document.getElementById("total_numOfDays").innerHTML = 1;
	}
	
	
	
}


//when user clicks "Next" button at Form 3, it will check user-input invalid or not
function checkFormThree(){
	
	//console.log(new Date(document.getElementById("checkin_date").value)); //Tue Dec 13 2022 08:00:00 GMT+0800 (香港標準時間)
	//console.log(new Date(document.getElementById("checkout_date").value)); //Invalid Date
	//console.log(typeof new Date(document.getElementById("checkout_date").value)); //object
	//console.log(typeof document.getElementById("checkout_date").value); //string
	
	x = new Date(document.getElementById("checkin_date").value).getTime();
	y = new Date(document.getElementById("checkout_date").value).getTime();
	
	if((x>=y)&&(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType1[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType2[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType5[$lang]; ?>")){
		//出營日期 不得早於或等於 入營日期\nCheck-out Date cannot be earlier than or equal to Check-in Date
		alert("出營日期 不得早於或等於 入營日期\nCheck-out Date cannot be earlier than or equal to Check-in Date");
	}else if((x>y)&&(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType3[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType4[$lang]; ?>")){
		alert("出營日期 不得早於 入營日期\nCheck-out Date cannot be earlier than Check-in Date");
	}else{
		console.log("checkFormThree();pass1");
		var numOfDays = (y - x)/(1000*60*60*24);
		//console.log(numOfDays);
		if(Number.isNaN(numOfDays)||(x>y)){
			//user does not choose a date
			alert("請選擇正確日期 \nPlease choose correct Date ");
		}else{ //valid
			//console.log("checkFormThree();pass2");
			$("#stepFour").addClass("active");
			$("#progress-bar").css("width", "100%");
			$("#formThree").fadeOut("fast", function(){
				$("#formFour").fadeIn("slow");
			});
			calculateTotalRoomPrice(); //calculate the total price of room for the Form 4
			
			$("#list_checkInDate").html(document.getElementById("checkin_date").value);
			$("#list_checkInTime").html(document.getElementById("checkin_time").value);
			$("#list_checkOutDate").html(document.getElementById("checkout_date").value);
			$("#list_checkOutTime").html(document.getElementById("checkout_time").value);
			
			$("#list_totalDays").html(document.getElementById("total_numOfDays").innerHTML);
			
		}
	}
	
}

function calculateTotalRoomPrice(){
	//團體營 and 家庭營
	//[(8人房房價 x 8人房房數)+(4人房房價 x 4人房房數)+(2人房房價 x 2人房房數)] x 晚數
	
	//日營 and 黃昏營
	//人數 x $30
	
	//露營
	//人數 x ($40 or $50) x 晚數
	var numOfDays = parseInt(document.getElementById("total_numOfDays").innerHTML); //晚數
	console.log("晚數: "+numOfDays);
	console.log(typeof numOfDays);
	
	var numOf8personDomo = parseInt(document.getElementById("numOf_person_8_Dormitory").innerHTML); //8人房房數
	console.log("8人房: "+numOf8personDomo);
	console.log(typeof numOf8personDomo);
	
	var numOf4personDomo = parseInt(document.getElementById("numOf_person_4_Dormitory").innerHTML); //4人房房數
	console.log("4人房: "+numOf4personDomo);
	console.log(typeof numOf4personDomo);
	
	var numOf2personDomo = parseInt(document.getElementById("numOf_person_2_Dormitory").innerHTML); //2人房房數
	console.log("2人房: "+numOf2personDomo);
	console.log(typeof numOf2personDomo);
	
	var priceOf8personDomo; //房價
	var priceOf4personDomo; //房價
	var priceOf2personDomo; //房價
	var priceOfTentCampPerOnePerson; //露營人頭價
	var priceOfFullCampBooking; //包營價
	
	var totalResidentNumber = getTotalResidentNumber(); //人數
	console.log("人數: "+totalResidentNumber);
	console.log(typeof totalResidentNumber);
	
	if(document.getElementById("is_SpecialRate").checked == true){ //if 優惠團體
		priceOf8personDomo = 800;
		priceOf4personDomo = 500;
		priceOf2personDomo = 320;
		priceOfTentCampPerOnePerson = 40;
		priceOfFullCampBooking = 24230;
	}else if(document.getElementById("is_SpecialRate").checked == false){ //if 一般團體
		priceOf8personDomo = 1040;
		priceOf4personDomo = 650;
		priceOf2personDomo = 420;
		priceOfTentCampPerOnePerson = 50;
		priceOfFullCampBooking = 31510;
	}
	
	console.log(priceOf8personDomo);
	console.log(priceOf4personDomo);
	console.log(priceOf2personDomo);
	
	if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType1[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType2[$lang]; ?>"){
		if(document.getElementById("fullCampBooking").checked == true){ //包營
			if(totalResidentNumber <= 180 ){ //人數不超過180
				var totalRoomPrice = priceOfFullCampBooking*numOfDays;
			}else{ //人數超過180, 每多一人, 多收$80/晚
				var numOfExtraResident = totalResidentNumber -180;
				var totalRoomPrice = ((priceOfFullCampBooking) + (numOfExtraResident*80))*numOfDays;
			}
			
		}else{ //not 包營
			var totalRoomPrice = ((priceOf8personDomo*numOf8personDomo)+(priceOf4personDomo*numOf4personDomo)+(priceOf2personDomo*numOf2personDomo))*numOfDays;
		}
		
	}else if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType5[$lang]; ?>"){
		var totalRoomPrice = totalResidentNumber*priceOfTentCampPerOnePerson*numOfDays;
	}else if(document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType4[$lang]; ?>" || document.querySelector('input[name="campingType"]:checked').value == "<?php echo $form2_campingType3[$lang]; ?>"){
		var totalRoomPrice = totalResidentNumber* 30;
	}
	
	
	console.log("totalRoomPrice: "+totalRoomPrice);
	document.getElementById("totalRoomPrice").value = parseFloat(totalRoomPrice).toFixed(2);
	
	calculateTotalPrice(); //calculate total price
	select_paymentStatus(); //place the total price into outstanding_balance and paid_amount
}

//calculate total price
function calculateTotalPrice(){
	//total price = total room price + other charges
	document.getElementById("totalPrice").value = (parseFloat(document.getElementById("totalRoomPrice").value) + parseFloat(document.getElementById("otherPrice").value)).toFixed(2);
	
	select_paymentStatus(); //place the total price into outstanding_balance and paid_amount
}

//place the total price into outstanding_balance and paid_amount
function select_paymentStatus(){
	var payment_status = document.getElementById("payment_status").value; //get the payment status form dropdown list
	console.log(payment_status);
	
	var totalPrice = parseFloat(document.getElementById("totalPrice").value); //get the total price
	console.log((totalPrice-1).toFixed(2));
	
	
	if(payment_status == "Full Paid"){
		document.getElementById("paid_amount").value = parseFloat(document.getElementById("totalPrice").value).toFixed(2); //because the payment is fully paid, thereby paid_amount equals to total price
		document.getElementById("outstanding_balance").value = (0).toFixed(2); //because the payment is fully paid, thereby the outstanding_balance is 0
		$('#paid_amount').prop('readonly', true); //user is no need to change any paid_amount, so lock paid_amount
	}else if(payment_status == "Partial Paid"){
		document.getElementById("paid_amount").value = (totalPrice-1).toFixed(2); //set the value of paid_amount to (totalPrice-1)
		document.getElementById("outstanding_balance").value = (1).toFixed(2); //set the value of outstanding_balance to 1
		$('#paid_amount').removeAttr('readonly'); //user is need to change paid_amount, so unlock paid_amount
		$("#paid_amount").attr({
		   "max" : (totalPrice-1).toFixed(2), //set the maximum value of paid_amount to (totalPrice-1)
		   "min" : 1.00 //set the minimum value of paid_amount to 1
		});
	}else if(payment_status == "Not Paid"){
		document.getElementById("paid_amount").value = (0).toFixed(2); //because the payment is not paid, thereby the paid_amount is 0
		document.getElementById("outstanding_balance").value = parseFloat(document.getElementById("totalPrice").value).toFixed(2); //because the payment is not paid, thereby outstanding_balance equals to total price
		$('#paid_amount').prop('readonly', true); //user is no need to change any paid_amount, so lock paid_amount
	}
}

//when user changes the amount in paid_amount, the outstanding_balance will also change
function changeOutstandingBalance(){
	var totalPrice = parseFloat(document.getElementById("totalPrice").value);
	console.log(document.getElementById("paid_amount").value);
	document.getElementById("outstanding_balance").value = (totalPrice - parseFloat(document.getElementById("paid_amount").value)).toFixed(2);
}

function backToFormTwo(){
	$("#formThree").fadeOut("fast", function(){
		$("#formTwo").fadeIn("slow");
	});
	$("#stepThree").removeClass("active");
	$("#progress-bar").css("width", "33.3%");
	
	//reset everything in Form2
	getDate(); //入營日期 to today
	document.getElementById("checkout_date").value = ""; //出營日期 to empty
	document.getElementById("total_numOfDays").innerHTML = 0; //number of Days --> 0
	
	//clear information from the top list table
	$("#list_checkInDate").empty();
	$("#list_checkInTime").empty();
	$("#list_checkOutDate").empty();
	$("#list_checkOutTime").empty();
	$("#list_totalDays").empty();
}

//=========================== Form 4 functions ========================================

function checkFormFour(){
	var thisFormOK = false;

	var otherPrice = document.getElementById("otherPrice");
	var totalPrice = document.getElementById("totalPrice");
	var paid_amount = document.getElementById("paid_amount");
	
	if((otherPrice.value) == '' || (totalPrice.value) == '' ||(paid_amount.value) == ''){
		alert("請輸入正確資料");
	}else if(parseFloat(otherPrice.value)<0 || parseFloat(paid_amount.value)<0){
		alert("請輸入正確金額");
	}else{

		thisFormOK = true;
	}
	
	if(thisFormOK == true){
		$("#list_totalRoomPrice").html(document.getElementById("totalRoomPrice").value);
		$("#list_otherPrice").html(document.getElementById("otherPrice").value);
		$("#list_totalPrice").html(document.getElementById("totalPrice").value);
		$("#list_paymentStatus").html(document.getElementById("payment_status").value);
		$("#list_paidAmount").html(document.getElementById("paid_amount").value);
		$("#list_outstandingBalance").html(document.getElementById("outstanding_balance").value);
		
		let text = "Confirm to submit?";
		if(confirm(text) == true){
			//toJson();
			var myJSON = toJson();
			//submit and unload the form to Database
			$.ajax({
				type: "POST",
				url: "uploadBookingToDB.php",
				data:{sth:myJSON}, 

				success: function(result, status, xhr){
					console.log("SUCCESS"+result);
					
					const dialog = document.createElement("dialog");

					dialog.setAttribute("id", "myDialog");
					dialog.setAttribute("class", "shadow-lg bg-dark");
					dialog.style.width = "300px";

					const txt = document.createElement("div");
					txt.innerText = "<?php echo $confim_str1[$_SESSION["language_index"]] ?>\n";
					txt.setAttribute("class", "h2 text-center text-white");

					const btn = document.createElement("button");
					btn.innerText = "<?php echo $confim_str2[$_SESSION["language_index"]] ?>";
					btn.setAttribute("class", "btn btn-primary btn-block ");
					btn.setAttribute("onclick", "location.href='./fillinBookingInfo.php';");

					const btn2 = document.createElement("button");
					btn2.innerText = "<?php echo $confim_str3[$_SESSION["language_index"]] ?>";
					btn2.setAttribute("class", "btn btn-primary btn-block ");
					btn2.setAttribute("onclick", "location.href='./manageCheckinCheckout.php';");

					document.body.appendChild(dialog);
					dialog.appendChild(txt);
					dialog.appendChild(btn);
					dialog.appendChild(btn2);
					
					document.getElementById("myDialog").showModal(); 
				},
				error: function (xhr, status, error){
					console.log("ERROR"+error);

				}
				});

			//window.location.href = "uploadBookingToDB.php";
		}else{
			//nothing
		}
	}
}

function backToFormThree(){
	$("#formFour").fadeOut("fast", function(){
		$("#formThree").fadeIn("slow");
	});
	$("#stepFour").removeClass("active");
	$("#progress-bar").css("width", "63%");
	
	document.getElementById("otherPrice").value = 0.00;
	document.getElementById("payment_status").value = "Full Paid";
	
	//clear information from the top list table
	$("#list_totalRoomPrice").empty();
	$("#list_otherPrice").empty();
	$("#list_totalPrice").empty();
	$("#list_paymentStatus").empty();
	$("#list_paidAmount").empty();
	$("#list_outstandingBalance").empty();
}

//put all information into an json
function toJson(){
	var list_organizationName = document.getElementById("list_organizationName").innerHTML;
	var list_representativeName = document.getElementById("list_representativeName").innerHTML;
	var list_phoneNumber = document.getElementById("list_phoneNumber").innerHTML;
	var list_manNumber = parseInt(document.getElementById("list_manNumber").innerHTML);
	var list_womanNumber = parseInt(document.getElementById("list_womanNumber").innerHTML);
	var list_campType = document.getElementById("list_campType").innerHTML;
	var list_specialRate = document.getElementById("list_specialRate").innerHTML;
	//put all selected person_8_Dormitory into an array
	const person_8_Dormitory_array = new Array();
	for(let i = 0; i < document.querySelectorAll('input[name="person_8_Dormitory"]:checked').length; i++){
		person_8_Dormitory_array.push(document.querySelectorAll('input[name="person_8_Dormitory"]:checked')[i].value);
	}
	//put all selected person_4_Dormitory into an array
	const person_4_Dormitory_array = new Array();
	for(let i = 0; i < document.querySelectorAll('input[name="person_4_Dormitory"]:checked').length; i++){
		person_4_Dormitory_array.push(document.querySelectorAll('input[name="person_4_Dormitory"]:checked')[i].value);
	}
	//put all selected person_2_Dormitory into an array
	const person_2_Dormitory_array = new Array();
	for(let i = 0; i < document.querySelectorAll('input[name="person_2_Dormitory"]:checked').length; i++){
		person_2_Dormitory_array.push(document.querySelectorAll('input[name="person_2_Dormitory"]:checked')[i].value);
	}
	var list_checkInDate = document.getElementById("list_checkInDate").innerHTML;
	var list_checkInTime = document.getElementById("list_checkInTime").innerHTML;
	var list_checkOutDate = document.getElementById("list_checkOutDate").innerHTML;
	var list_checkOutTime = document.getElementById("list_checkOutTime").innerHTML;
	var list_totalDays = parseInt(document.getElementById("list_totalDays").innerHTML);
	var list_totalRoomPrice = parseFloat(document.getElementById("list_totalRoomPrice").innerHTML);
	var list_otherPrice = parseFloat(document.getElementById("list_otherPrice").innerHTML);
	var list_totalPrice = parseFloat(document.getElementById("list_totalPrice").innerHTML);
	var list_paymentStatus = document.getElementById("list_paymentStatus").innerHTML;
	var list_paidAmount = parseFloat(document.getElementById("list_paidAmount").innerHTML);
	var list_outstandingBalance = parseFloat(document.getElementById("list_outstandingBalance").innerHTML);
	
	data = {
	list_organizationName:list_organizationName,
	list_representativeName:list_representativeName,
	list_phoneNumber:list_phoneNumber,
	list_manNumber:list_manNumber,
	list_womanNumber:list_womanNumber,
	list_campType:list_campType,
	list_specialRate:list_specialRate,
	person_8_Dormitory_array:person_8_Dormitory_array,
	person_4_Dormitory_array:person_4_Dormitory_array,
	person_2_Dormitory_array:person_2_Dormitory_array,
	list_checkInDate:list_checkInDate,
	list_checkInTime:list_checkInTime,
	list_checkOutDate:list_checkOutDate,
	list_checkOutTime:list_checkOutTime,
	list_totalDays:list_totalDays,
	list_totalRoomPrice:list_totalRoomPrice,
	list_otherPrice:list_otherPrice,
	list_totalPrice:list_totalPrice,
	list_paymentStatus:list_paymentStatus,
	list_paidAmount:list_paidAmount,
	list_outstandingBalance:list_outstandingBalance
	};
	
	/*
	console.log(data.list_organizationName);
	console.log(data.list_representativeName);
	console.log(data.list_phoneNumber);
	console.log(data.list_manNumber);
	console.log(data.list_womanNumber);
	console.log(data.list_campType);
	console.log(data.list_specialRate);
	console.log(data.person_8_Dormitory_array);
	console.log(data.person_4_Dormitory_array);
	console.log(data.person_2_Dormitory_array);
	console.log(data.list_checkInDate);
	console.log(data.list_checkInTime);
	console.log(data.list_checkOutDate);
	console.log(data.list_checkOutTime);
	console.log(data.list_totalDays);
	console.log(data.list_totalRoomPrice);
	console.log(data.list_otherPrice);
	console.log(data.list_totalPrice);
	console.log(data.list_paymentStatus);
	console.log(data.list_paidAmount);
	console.log(data.list_outstandingBalance);
	*/
	const myJSON2 = JSON.stringify(data); //json obj to text
	//console.log(myJSON2);
	
	return myJSON2;
	
}



</script>