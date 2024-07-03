<?php
include ('permissionS.php');
include ('timeout.php');
include ('connection.php');
?>
<?php
include_once ("./language/main_string.php");
include_once ("./language/dashboard_string.php");
include_once("./config/config.php"); 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
	<link rel="icon" type="image/x-icon" href="./favicon/<?=$staff_favicon?>/favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/dashboard/">

    <!-- Bootstrap core CSS -->
	<link href="dashboard/css/bootstrap.min.css" rel="stylesheet">
	<!--Font Awesome-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


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
	$dynamic_text_color = "#000000"; //black
	//control the theme color css 
	if($_SESSION['themeColorIndex'] == 0){ //Day mode
		$dynamic_text_color = "#000000"; //black
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}else if($_SESSION['themeColorIndex'] == 1){ //Night mode
		$dynamic_text_color = "#FFFFFF"; //white
		echo "<link href=\"dashboard/css/dashboard_dark.css\" rel=\"stylesheet\">";
	}else{
		$dynamic_text_color = "#000000"; //black
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}
	?>
    
	<!-- <link href="dashboard/css/alert_message.css" rel="stylesheet"> -->
	<script src="./js/sidebar.js"></script>
	<script src="./js/showTime.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	
  </head>
  <body>
    
			  <?php
			  include_once ("./template/top_nav.php");
			  echo $top_nav_str;
			  ?>

			  <?php if ($_SESSION['permission'] == "Admin" || $_SESSION['permission'] == "Manager") { ?>
			  <a class="nav-link" style="display:inline;" href="controlpanel.php">
			  <?php echo $list_name_adminPage[$_SESSION["language_index"]] ?>
			  </a>
			  &emsp;
			  <?php } ?>
		  <a class="nav-link" style="display:inline;" href="switchLanguage.php"><?php echo $list_name_0[$_SESSION["language_index"]] ?></a>
		  &emsp;
		  <span id="MyClockDisplay" class="nav-link" style="display:inline;" onload="showTime()"></span>
		  &emsp;
		  <span class="return-alarm" title="item return alarm"></span>
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
			include_once ("./template/sidebar.php");
			echo $sidebar_str;
		?>

		<main role="main" style="min-height: 100%;" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 <?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-main-dark"; }else{ echo " ";} ?>">
			  
			<h2 class = "h2"><?php echo $list_name_title[$lang] ?></h2>
			<?php
			//echo $_SESSION["language_index"];
			?>
			<br><br>
			
			<!--alert message here-->
			
			<span id="alarm_message">

			
			
			</span>
			
			<!--
			<div class="callout">...</div>
			-->

			
			<br><br>

			<!--box here-->

			<?php 
			include_once("./template/dashboard_box.php"); 
			?>
			
			<details open>
				<summary><span class="h6"><?php echo $list_name_subtitle1[$lang]; ?></span></summary>
				<div class="row">
			 
				<?php echo $dashboard_box_rentalItem_str; ?>
				
				</div>
			</details>
			
			<details open>
				<summary><span class="h6"><?php echo $list_name_subtitle2[$lang]; ?></span></summary>
				<div class="row">
			 
				<?php echo $dashboard_box_bookings_str; ?>
				
				</div>
			</details>
			
			<details open>
				<summary><span class="h6"><?php echo $list_name_subtitle3[$lang]; ?></span></summary>
				<span id="alarm_message2">
					<div class="alert alert-danger" role="alert">
					  <b><?php echo $lowAlert[$lang]; ?>!</b><br>
					  <span id="outOfStockDrinks_message"></span>
					</div>
				</span>
				<div class="row">
				<?php echo $dashboard_box_salesDrinks_str; ?>
				</div>
			</details>
			
			<br><br><br>
			
			<!--Current Room-Borrowing Situation List here-->
			
			<div>

				<h3><?php echo $room_situation[$lang]; ?></h3>

				<div class="table-responsive">
					<table class="table table-striped table-sm <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo " ";} ?> ">
					  <thead>
						<tr>
						  <th><?php echo $table_Title1[$lang]; ?></th>
						  <th><?php echo $table_Title2[$lang]; ?></th>
						  <th><?php echo $table_Title3[$lang]; ?></th>
						</tr>
					  </thead>
					  <tbody>
					  
						<?php
						$query = "SELECT DISTINCT room_number FROM rental_record WHERE status = 'borrow'";
						$query_run = mysqli_query($conn, $query);
						$row = mysqli_num_rows($query_run);
						$rc = mysqli_fetch_assoc($query_run);
						if (mysqli_num_rows($query_run) > 0) {
							do {
								$room_Number = $rc['room_number'];
								//$itemName = $rc['item_name'];
								$query3 = "SELECT COUNT(room_number) FROM `rental_record` WHERE room_number='$room_Number' AND status = 'borrow'";
								$query_run3 = mysqli_query($conn, $query3);
								$row3 = mysqli_num_rows($query_run3);
								$rc3 = mysqli_fetch_assoc($query_run3);
								$Room_Borrowing_Qty = $rc3['COUNT(room_number)'];
								//get the all itemsborrowed by the room
								$query4 = "SELECT * FROM `rental_record` WHERE room_number='$room_Number' AND status = 'borrow'";
								$query_run4 = mysqli_query($conn, $query4);
								$row4 = mysqli_num_rows($query_run4);
								$rc4 = mysqli_fetch_assoc($query_run4);
								$borrowed_item_array = array();
								do {
									$selected_item_id = $rc4['item_id'];
									$query5 = "SELECT * FROM `rental_item_category` WHERE item_id='$selected_item_id'";
									$query_run5 = mysqli_query($conn, $query5);
									$row5 = mysqli_num_rows($query_run5);
									$rc5 = mysqli_fetch_assoc($query_run5);
									array_push($borrowed_item_array, $rc5['item_name']);
								} while ($rc4 = mysqli_fetch_assoc($query_run4));
								sort($borrowed_item_array);
								$borrowed_item_array_string = implode(", ", $borrowed_item_array);
								echo " <tr><td> $room_Number </td><td> $Room_Borrowing_Qty </td><td> $borrowed_item_array_string </td>";
								echo "</tr>";
							}
							while ($rc = mysqli_fetch_assoc($query_run));
						} else {
						}
						?>			

					  </tbody>
					</table>
				</div>

			</div>

		</main>

	</div>
	</div>


  </body>
</html>

<script type="module">

	<?php
	include_once ("./template/common_js.php");
	echo $common_js_str;
	?>
	
	var close = document.getElementsByClassName("close");
	var i;

	for (i = 0; i < close.length; i++) {
	  close[i].onclick = function(){
		var div = this.parentElement;
		div.style.opacity = "0";
		setTimeout(function(){ div.style.display = "none"; }, 600);
	  }
	}
	
	//highlight the link on sidebar
	<?php $site = str_replace($directory, '', $_SERVER['PHP_SELF']); ?>
	
	window.addEventListener("load", function() {
	  var aTag = document.getElementsByTagName("a");
	  //alert(aTag.length);
	  for (let i = 0; i < aTag.length; i++) {
		var activelink = aTag[i].getAttribute("href");
		if(activelink == "<?php echo $site ?>"){
			//alert("yes");
			aTag[i].classList.add("active");
		}
	  }
	});
	
	import {ProgressCircle} from "./js/progress_circle.js";
	var pc = new ProgressCircle("box2_number");
	pc.drawCircle();
	
	setInterval(myTimer, 1000);

	function myTimer(){
		
		$(document).ready(function(){
			var box1_number1 = document.getElementById('box1_number1').innerHTML;
			var box1_number2 = document.getElementById('box1_number2').innerHTML;
			var box2_number = document.getElementById('box2_number').innerHTML;
			var box3_number = document.getElementById('box3_number').innerHTML;
			var box4_number = document.getElementById('box4_number').innerHTML;
			var box5_number1 = document.getElementById('box5_number1').innerHTML;
			var box5_number2 = document.getElementById('box5_number2').innerHTML;
			var box5_number3 = document.getElementById('box5_number3').innerHTML;
			var box6_number = document.getElementById('box6_number').innerHTML;
			var box7_number = document.getElementById('box7_number').innerHTML;
			var box8_number = document.getElementById('box8_number').innerHTML;
			var box9_number = document.getElementById('box9_number').innerHTML;
			var box10_number = document.getElementById('box10_number').innerHTML;
			
			var room_progress_bar = document.getElementById('room-progress-bar').value;
			//var tentcamp_meter = document.getElementById('tentcamp-meter').value;
			//var daycamp_meter = document.getElementById('daycamp-meter').value;
			//var eveningcamp_meter = document.getElementById('eveningcamp-meter').value;

			$.ajax({url: "./controller/controller_dashboard_data.php", success: function(result){
			  
				var obj = JSON.parse(result);
				//console.log(obj);
				//console.log(obj.box2_number);
				if(box1_number1 != obj.box1_number1){
					$("#box1_number1").hide().html(obj.box1_number1).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box1_number1").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
				}
			  
				if(box1_number2 != obj.box1_number2){
					$("#box1_number2").hide().html(obj.box1_number2).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box1_number2").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
				}
				
				if(box2_number != obj.box2_number){
					pc.makeChange(obj.box2_number, 0);
					$("#box2_number").html(obj.box1_number2);
				}
				
				if(box3_number != obj.box3_number){
					$("#box3_number").hide().html(obj.box3_number).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box3_number").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
				}
				
				if(box4_number != obj.box4_number){
					$("#box4_number").hide().html(obj.box4_number).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box4_number").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
				}
				
				if(box5_number1 != obj.box5_number1){
					$("#box5_number1").hide().html(obj.box5_number1).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box5_number1").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
				}
				
				if(box5_number2 != obj.box5_number2){
					$("#box5_number2").hide().html(obj.box5_number2).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box5_number2").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
				}
				
				if(box5_number3 != obj.box5_number3){
					$("#box5_number3").hide().html(obj.box5_number3).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box5_number3").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
				}
				
				//progress bar
				if(room_progress_bar != (obj.box5_number1+obj.box5_number2+obj.box5_number3)){
					var progress_value = obj.box5_number1+obj.box5_number2+obj.box5_number3;
					$("#room-progress-bar").animate({value: progress_value}, {duration: 1500, easing: "swing"});
				}
				
				if(box6_number != obj.box6_number){
					$("#box6_number").hide().html(obj.box6_number).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box6_number").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
					$("#tentcamp-meter").animate({value: obj.box6_number}, {duration: 1500, easing: "swing"});
				}
				
				
				
				if(box7_number != obj.box7_number){
					$("#box7_number").hide().html(obj.box7_number).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box7_number").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
					$("#daycamp-meter").animate({value: obj.box7_number}, {duration: 1500, easing: "swing"});
				}
				
				if(box8_number != obj.box8_number){
					$("#box8_number").hide().html(obj.box8_number).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box8_number").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
					$("#eveningcamp-meter").animate({value: obj.box8_number}, {duration: 1500, easing: "swing"});
				}
				
				if(box9_number != obj.box9_number){
					$("#box9_number").hide().html(obj.box9_number).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box9_number").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
				}
				
				if(box10_number != obj.box10_number){
					$("#box10_number").hide().html(obj.box10_number).css("color", "red").fadeTo(4000, 1);
					setTimeout(function() { 
						$("#box10_number").animate({color: "<?php echo $dynamic_text_color;?>"}, 3000);
					}, 4000);
				}
				
			}});

		});
	}
	
	//return message
	$(document).ready(function(){
		$.post(
			"./controller/controller_item_return_alarm.php", 
			{index: 1}, 
			function(result){
				//console.log(result);
				if(result==0){
					//$("#alarm_message").remove();
					$("#alarm_message").empty();
				}else{
					
					var temp = "<?php include_once ("./template/dashboard_return_alarm_message.php"); echo selectTempMessageBox("", 0, "./return.php"); ?>" ;
					
					$("#alarm_message").html(temp);
					//Parsing JSON
					const result_obj = JSON.parse(result);
					var message_text = "";
					
					for(var key in result_obj.room_number){
						message_text += "Room "+result_obj.room_number[key]+" has not yet returned "+result_obj.num_of_borrowed_item[key]+" items before 1 hour of Check-out"+"<br>"
						//console.log(result_obj.room_number[key]);
					}
					
					$("#core_message").html(message_text);
					}	
			}	
		);	
		$.post(	
			"./controller/controller_out_of_stock_alarm.php", 	
			{index: 1}, 	
			function(result){	
				//console.log(result);	
				if(result==0){	
					$("#alarm_message2").empty();	
				}else{	
					//console.log(result);	
					const result_obj = JSON.parse(result);	
					//console.log(typeof result_obj);	
					let outOfStockDrinks_message_text = "";	
					for (let x in result_obj) {	
						outOfStockDrinks_message_text += result_obj[x] + " is out of stock" +"<br>";	
					}	
					//console.log(outOfStockDrinks_message_text);	
					$("#outOfStockDrinks_message").html(outOfStockDrinks_message_text);	
				}	
			}	
		);	
	});	
	
	
</script>