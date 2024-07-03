<?php 
include('permissionS.php');
include('timeout.php');
include('connection.php');
?>
<?php 
include_once("./language/main_string.php"); 
include_once("./language/manageCheckinCheckout_string.php"); 
include_once("./config/config.php"); 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Check in & Check out</title>
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
	  
	  
	  details > summary{

	  }
	  
	  
	  .toggle{
		display: none;
	  }
	  

	  .shrink2 {
		transition: background 1s;
	  }

	  .shrink2:hover {
		background: pink;
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
	//control the theme color css 
	if($_SESSION['themeColorIndex'] == 0){ //Day mode
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}else if($_SESSION['themeColorIndex'] == 1){ //Night mode
		echo "<link href=\"dashboard/css/dashboard_dark.css\" rel=\"stylesheet\">";
	}else{
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}
	?>

	<!-- Javascript -->
	
	<script src="./js/sidebar.js"></script>
	<script src="./js/showTime.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	
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
		
		<a class="text-primary" style="cursor: pointer;" onclick="openDetails(0);"><?php echo $list1[$lang]; ?></a>
		&nbsp;|&nbsp;
		<a class="text-primary" style="cursor: pointer;" onclick="openDetails(1);"><?php echo $list2[$lang]; ?></a> 
		&nbsp;|&nbsp; 
		<a class="text-primary" style="cursor: pointer;" onclick="openDetails(2);"><?php echo $list3[$lang]; ?></a>
		<hr>
		
		<div class="table-responsive-xl">
		
		<details open>
		<summary><?php echo $list1[$lang]; ?> </summary>
		<table class="table table-striped rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo " ";} ?>">
		  <thead>
			<tr>
			  <th ></th>
			  <th><?php echo $table_Title1[$lang]; ?></th>
			  <th><?php echo $table_Title2[$lang]; ?></th>
			  <th><?php echo $table_Title3[$lang]; ?></th>
			  <th><?php echo $table_Title4[$lang]; ?></th>
			  <th><?php echo $table_Title5[$lang]; ?></th>
			  <th><?php echo $table_Title8[$lang]; ?></th>
			  <th><?php echo $table_Title9[$lang]; ?></th>
			  <th class="text-center"><?php echo $table_Title10[$lang]; ?></th>
			  <th ></th>
			</tr>
		  </thead>
		  <tbody>
			<?php
			$query = "SELECT DISTINCT booking_info.* FROM `booking_info` INNER JOIN room_booking ON booking_info.booking_id = room_booking.booking_id WHERE booking_info.booking_status = 'Effective' AND room_booking.status = 'Occupying' ORDER BY booking_info.booking_id ASC, room_booking.room_number ASC;";
			
			$query_run = mysqli_query($conn, $query);
			$row = mysqli_num_rows($query_run);
			$rc = mysqli_fetch_assoc($query_run);
			if (mysqli_num_rows($query_run) > 0){
				do{
					$booking_id = $rc['booking_id'];
					echo "<tr>";
					echo "<td>";
					echo "<div title='click to show rooms' class='border border-dark rounded text-center shrink2 showRoomInfoToggle' style='cursor: pointer; width:20px;' onmouseover='' onclick='showRoomInfoToggle(this);'>";
					echo "";
					echo "<b>-</b>";
					echo "</div>";
					echo "</td>";
					echo "<td>".$booking_id."</td>";
					echo "<td>".$rc['organization_name']."</td>";
					echo "<td>".$rc['representative_name']."</td>";
					echo "<td>".$rc['contact_number']."</td>";
					echo "<td>".$rc['payment_status']."</td>";
					echo "<td>".$rc['checkout_date']."</td>";
					echo "<td>".$rc['checkout_time']."</td>";
					
					$query1 = "SELECT COUNT(room_number) FROM `rental_record` WHERE booking_id='$booking_id' AND status = 'borrow'";
					$query_run1 = mysqli_query($conn, $query1);
					$row1 = mysqli_num_rows($query_run1);
					$rc1 = mysqli_fetch_assoc($query_run1);
					$booking_borrowing_Qty = $rc1['COUNT(room_number)'];
					
					echo "<td class='text-center'>".$booking_borrowing_Qty."</td>";
					
					echo "<td align='right'>";
					if($rc['payment_status'] != "Full Paid"){
						echo "<button type='submit' class='btn btn-outline-primary btn-sm' id='".$booking_id."' onclick='completeBookingPayment(this.id);'>Complete Payment</button> &nbsp; ";
					}
					echo "<button type='submit' class='btn btn-outline-info btn-sm' id='".$booking_id."' onclick='checkoutBooking(this.id);'>Check Out</button>";
					echo "</td>";
					echo "</tr>";
					
					
					
					//
					echo "<tr class='toggle'>";
					echo "<td colspan='10' class='p-3'>";
					echo "<!--nest table-->";
					echo "<h5 style='text-align:left;'>$checkin_table0[$lang]</h5>";
					
					if($booking_borrowing_Qty != 0){
					
						echo "<table class='table table-hover table-striped rounded";
						if($_SESSION['themeColorIndex'] == 1){ echo " table-dark "; }else{ echo " ";}
						
						echo "' style='text-align:left;'>";
						echo "<tr>";
						echo "<th scope='col'>$checkin_table1[$lang]</th>";
						echo "<th scope='col' class='text-center'>$checkin_table2[$lang]</th>";
						echo "<th scope='col'>$checkin_table3[$lang]</th>";
						echo "</tr>";
						
						
						
						//get the all rooms of this booking
						$query2 = "SELECT * FROM `room_booking` WHERE booking_id='$booking_id' AND status = 'Occupying'";
						$query_run2 = mysqli_query($conn, $query2);
						$row2 = mysqli_num_rows($query_run2);
						$rc2 = mysqli_fetch_assoc($query_run2);
						
						//$Room_Borrowing_Qty = $rc2['COUNT(room_number)'];
						
						do {
							$room_Number = $rc2['room_number'];
							//$selected_item_id = $rc2['item_id'];
							//get all items borrowed by the room
							$query3 = "SELECT * FROM `rental_record` WHERE booking_id='$booking_id' AND room_number='$room_Number' AND status='borrow'";
							$query_run3 = mysqli_query($conn, $query3);
							$row3 = mysqli_num_rows($query_run3);
							$rc3 = mysqli_fetch_assoc($query_run3);
							
							if (mysqli_num_rows($query_run3) > 0){
							
								//get how many items the room borrowing
								$query4 = "SELECT COUNT(room_number) FROM `rental_record` WHERE booking_id='$booking_id' AND room_number='$room_Number' AND status = 'borrow'";
								$query_run4 = mysqli_query($conn, $query4);
								$row4 = mysqli_num_rows($query_run4);
								$rc4 = mysqli_fetch_assoc($query_run4);
								$room_borrowing_Qty = $rc4['COUNT(room_number)'];
								
								$borrowed_item_array = array();
								//get the item name by item id and put into an array
								do {
									$selected_item_id = $rc3['item_id'];
									$query5 = "SELECT * FROM `rental_item_category` WHERE item_id='$selected_item_id'";
									$query_run5 = mysqli_query($conn, $query5);
									$row5 = mysqli_num_rows($query_run5);
									$rc5 = mysqli_fetch_assoc($query_run5);
									array_push($borrowed_item_array, $rc5['item_name']);
								} while ($rc3 = mysqli_fetch_assoc($query_run3));
								sort($borrowed_item_array);
								$borrowed_item_array_string = implode(", ", $borrowed_item_array);
								
								echo " <tr><td> $room_Number </td><td class='text-center'> $room_borrowing_Qty </td><td> $borrowed_item_array_string </td>";
								echo "</tr>";
							}else{
								//this room has no items borrowed
							}
						} while ($rc2 = mysqli_fetch_assoc($query_run2));
						
						echo "</tr>";
						echo "</table>";
						echo "<!--button to reserve-->";
						echo "<button type='button' class='btn btn-sm btn-outline-success' onclick='toReturnPage();'>Return items</button>";
					
					}else{
						echo "no items borrowed";
					}
					
					echo "</td>";
					echo "</tr>";
					
				}while ($rc = mysqli_fetch_assoc($query_run));
			}
			
			
			?>
			<!--
		    <tr>
				<td>
					<div  
					title="click to show rooms" 
					class="border border-dark rounded text-center shrink2 showRoomInfoToggle" 
					style="cursor: pointer; width:20px;"
					onmouseover=""
					onclick="showRoomInfoToggle(this);"
					>
						<b>-</b>
					</div>
				</td>
				<td>20221211B0001</td>
				<td>IVE</td>
				<td>Sam</td>
				<td>98765432</td>
				<td>Full Paid</td>
				<td>19/12/2022</td>
				<td>12:00</td>
				<td class="text-center">3</td>
				<td>
					<button type="submit" class="btn btn-outline-info btn-sm" onclick="return confirm('Please return all items before check out ! \nAre you sure to Check out ?');">Check Out</button>
				</td>
			</tr>
						<tr class="toggle">
							<td colspan="10" class="p-3">
							
							<h5 style="text-align:left;">Room info</h5>
							<table class="table table-hover table-striped" style="text-align:left;">
							  <tr>
								<th scope="col">Room</th>
								<th scope="col" class="text-center">Number of Borrowed item</th>
								<th scope="col">Borrowed item(s)</th>
							  </tr>
							  <tr>
								<td>A01</td>
								<td class="text-center">1</td>
								<td>Basketball</td>
							  </tr>
							  <tr>
								<td>C01</td>
								<td class="text-center">2</td>
								<td>Football, Head Dryer</td>
							  </tr>
							  
							</table>
							
							<button type="button" class="btn-sm btn-outline-success" onclick="toReturnPage();">Return items</button>
							</td>
						</tr>
			<tr>
				<td>
					<div  
					title="click to show rooms" 
					class="border border-dark rounded text-center shrink2 showRoomInfoToggle" 
					style="cursor: pointer; width:20px;"
					onmouseover=""
					onclick="showRoomInfoToggle(this);"
					>
						<b>-</b>
					</div>
				</td>
				<td>20221211B0001</td>
				<td>IVE</td>
				<td>Sam</td>
				<td>98765432</td>
				<td>Full Paid</td>
				<td>19/12/2022</td>
				<td>12:00</td>
				<td class="text-center">3</td>
				<td>
					<button type="submit" class="btn btn-outline-info btn-sm" onclick="return confirm('Please return all items before check out ! \nAre you sure to Check out ?');">Check Out</button>
				</td>
			</tr>
						<tr class="toggle">
							<td colspan="10" class="p-3">
							
							<h5 style="text-align:left;">Room info</h5>
							<table class="table table-hover table-striped" style="text-align:left;">
							  <tr>
								<th scope="col">Room</th>
								<th scope="col" class="text-center">Number of Borrowed item</th>
								<th scope="col">Borrowed item(s)</th>
							  </tr>
							  <tr>
								<td>A01</td>
								<td class="text-center">1</td>
								<td>Basketball</td>
							  </tr>
							  <tr>
								<td>C01</td>
								<td class="text-center">2</td>
								<td>Football, Head Dryer</td>
							  </tr>
							  
							</table>
							
							<button type="button" class="btn-sm btn-outline-success" onclick="toReturnPage();">Return items</button>
							</td>
						</tr>
			
			-->


		  </tbody>
		</table>
		</details>
		
		<details open>
		<summary><?php echo $list2[$lang]; ?>  </summary>
		<table class="table table-striped table-hover rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo " ";} ?>">
		  <thead>
			<tr>
			  <th><?php echo $table_Title1[$lang]; ?></th>
			  <th><?php echo $table_Title2[$lang]; ?></th>
			  <th><?php echo $table_Title3[$lang]; ?></th>
			  <th><?php echo $table_Title4[$lang]; ?></th>
			  <th><?php echo $table_Title12[$lang]; ?></th>
			  <th><?php echo $table_Title5[$lang]; ?></th>
			  <th><?php echo $table_Title6[$lang]; ?></th>
			  <th><?php echo $table_Title7[$lang]; ?></th>
			  <th><?php echo $table_Title8[$lang]; ?></th>
			  <th><?php echo $table_Title9[$lang]; ?></th>
			  <th class="text-center"><?php echo $table_Title11[$lang]; ?></th>
			  <th ></th>
			</tr>
		  </thead>
		  <tbody>
			<?php
			$query6 = "SELECT DISTINCT booking_info.* FROM `booking_info` INNER JOIN room_booking ON booking_info.booking_id = room_booking.booking_id WHERE booking_info.booking_status = 'Effective' AND room_booking.status = 'Reserved' ORDER BY booking_info.booking_id ASC;";
			
			$query_run6 = mysqli_query($conn, $query6);
			$row6 = mysqli_num_rows($query_run6);
			$rc6 = mysqli_fetch_assoc($query_run6);
			if (mysqli_num_rows($query_run6) > 0){
				do{
					$booking_id = $rc6['booking_id'];
					echo "<tr>";
					echo "<td>".$booking_id."</td>";
					echo "<td>".$rc6['organization_name']."</td>";
					echo "<td>".$rc6['representative_name']."</td>";
					echo "<td>".$rc6['contact_number']."</td>";
					echo "<td>".$rc6['camp_type']."</td>";
					echo "<td>".$rc6['payment_status']."</td>";
					echo "<td>".$rc6['checkin_date']."</td>";
					echo "<td>".$rc6['checkin_time']."</td>";
					echo "<td>".$rc6['checkout_date']."</td>";
					echo "<td>".$rc6['checkout_time']."</td>";

					
					echo "<td class='text-center'>".$rc6['total_number_of_room']."</td>";
					
					echo "<td>";
					echo "<button type='submit' class='btn btn-outline-primary btn-sm'  id='".$booking_id."' onclick='checkinBooking(this.id);'>Check-in</button>";
					echo "</td>";
					echo "</tr>";
			
				}while ($rc6 = mysqli_fetch_assoc($query_run6));
			}
			?>
			<!--
			<tr>
				<td>20221123B0001</td>
				<td>HKU</td>
				<td>Peter</td>
				<td>98765432</td>
				<td>團體營</td>
				<td>Not Paid</td>
				<td>24/12/2022</td>
				<td>15:00</td>
				<td>29/12/2022</td>
				<td>12:00</td>
				<td class="text-center">5</td>
				<td>
					<button type="submit" class="btn btn-outline-primary btn-sm" onclick="return confirm('Are you sure to Check-in this Booking ?');">Check-in</button>
				</td>
			</tr>
			<tr>
				<td>20221123B0001</td>
				<td>HKU</td>
				<td>Peter</td>
				<td>98765432</td>
				<td>團體營</td>
				<td>Not Paid</td>
				<td>24/12/2022</td>
				<td>15:00</td>
				<td>29/12/2022</td>
				<td>12:00</td>
				<td class="text-center">5</td>
				<td>
					<button type="submit" class="btn btn-outline-primary btn-sm" onclick="return confirm('Are you sure to Check-in this Booking ?');">Check-in</button>
				</td>
			</tr>
			-->
		  </tbody>
		</table>
		</details>
		
		<details open>
		<summary><?php echo $list3[$lang]; ?> </summary>
		<table class="table table-striped table-hover rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo " ";} ?>">
		  <thead>
			<tr>
			  <th><?php echo $table_Title1[$lang]; ?></th>
			  <th><?php echo $table_Title2[$lang]; ?></th>
			  <th><?php echo $table_Title3[$lang]; ?></th>
			  <th><?php echo $table_Title4[$lang]; ?></th>
			  <th><?php echo $table_Title12[$lang]; ?></th>
			  <th><?php echo $table_Title8[$lang]; ?></th>
			  <th><?php echo $table_Title9[$lang]; ?></th>
			</tr>
		  </thead>
		  <tbody>
			<?php
			$query7 = "SELECT DISTINCT booking_info.* FROM `booking_info` INNER JOIN room_booking ON booking_info.booking_id = room_booking.booking_id WHERE booking_info.booking_status = 'Effective' AND room_booking.status = 'Checkedout' ORDER BY booking_info.checkout_date DESC, booking_info.checkout_time DESC LIMIT 5;";
			
			$query_run7 = mysqli_query($conn, $query7);
			$row7 = mysqli_num_rows($query_run7);
			$rc7 = mysqli_fetch_assoc($query_run7);
			if (mysqli_num_rows($query_run7) > 0){
				do{
					$booking_id = $rc7['booking_id'];
					echo "<tr>";
					echo "<td>".$booking_id."</td>";
					echo "<td>".$rc7['organization_name']."</td>";
					echo "<td>".$rc7['representative_name']."</td>";
					echo "<td>".$rc7['contact_number']."</td>";
					echo "<td>".$rc7['camp_type']."</td>";
					//echo "<td>".$rc7['payment_status']."</td>";
					//echo "<td>".$rc7['checkin_date']."</td>";
					//echo "<td>".$rc7['checkin_time']."</td>";
					echo "<td>".$rc7['checkout_date']."</td>";
					echo "<td>".$rc7['checkout_time']."</td>";
					
					echo "</tr>";
			
				}while ($rc7 = mysqli_fetch_assoc($query_run7));
			}
			?>
			<!--
			<tr>
				<td>20220913B0001</td>
				<td>Chan's Family</td>
				<td>Mary Chan</td>
				<td>98765432</td>
				<td>家庭營</td>
				<td>20/09/2022</td>
				<td>12:00</td>
				
			</tr>
			-->

		  </tbody>
		</table>
		</details>
		
		</div>
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

	function checkReturnAll(x){
		
		if(x.elements[1].value >0){
			alert("Please return all items first !!");
			return false;
		}else{
			return true;
		}
		
	}
	
	function toReturnPage(){
		window.location.href = "./return.php";
	}
	
	
	function showRoomInfoToggle(x){
		//$(this).closest("tr").next().toggle();
		//console.log(x.parentNode.nextElementSibling.innerHTML);
		//console.log(x.parentNode.nextElementSibling);
		//console.log(x.parentNode.nextSibling);
		//console.log(x.parentNode.parentNode.nextElementSibling.innerHTML);
		//$("#haha").toggle();
	}
	
	$(".showRoomInfoToggle").click(function(){
		$(this).parent().parent().next().slideToggle();
	});
	
	
	function openDetails(x){
		var details = document.querySelectorAll("details");
		for (let i = 0; i < details.length; i++){
			details[i].open = false;
		}
		details[x].open = true;
	}
	
	function checkoutBooking(bookingID){
		//alert(bookingID);
		$.post(
			"./checkOutBooking.php", 
			{booking_id: bookingID}, 
			function(result){
				//console.log(result);
				if(result==0){
					alert("Please return all borrowed items before checkout");
				}else if(result==1){
					alert("Please complete payment before checkout");
				}else{
					alert("Check-out successful");
					window.location.href = "./manageCheckinCheckout.php";
				}
			}
		);
	}
	
	function checkinBooking(bookingID){
		//alert(bookingID);
		$.post(
			"./checkInBooking.php", 
			{booking_id: bookingID}, 
			function(result){
				//console.log(result);
				
				const result_obj = JSON.parse(result);
				
				if(result_obj[0]==0){ //團體營/家庭營 has problem
					alert(result_obj[1]);
				}else if(result_obj[0]==-1){ //inactive rooms
					var err_msg = "Some rooms are inactive: \n";
					for (let x in result_obj[1]) {
						err_msg += result_obj[1][x] + "\n";
					}
					alert(err_msg);
				}else if(result_obj[0]==1){ //successful
					alert(result_obj[1]);
					window.location.href = "./manageCheckinCheckout.php";
				}else if(result_obj[0]==2){ //日營/黃昏營/露營 has problem
					alert(result_obj[1]);
				}else{ //other unknown problems
					console.log(JSON.parse(result)[0]);
					console.log(JSON.parse(result)[1]);
				}
				
			}
		);
	}

	function completeBookingPayment(bookingID){
		//alert(bookingID);
		$.post(
			"./completeBookingPayment.php", 
			{booking_id: bookingID}, 
			function(result){
				if(result==0){
					alert("Payment Error");
				}else{
					alert("Payment Completed successful");
					window.location.href = "./manageCheckinCheckout.php";
				}
			}
		);
	}
</script>