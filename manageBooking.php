<?php 
include('permissionA.php');
include('timeout.php');
include('connection.php');
?>
<?php
include_once("./language/main_string.php");
include_once("./language/manageBooking_string.php");
include_once("./config/config.php"); 
?>

<?php

$sql = "SELECT DISTINCT booking_info.* FROM `booking_info` INNER JOIN room_booking ON booking_info.booking_id = room_booking.booking_id WHERE booking_info.booking_status = 'Effective' AND room_booking.status = 'Reserved' ORDER BY booking_info.booking_id ASC;"; //write the SQL statement
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Control Panel - Manage Booking</title>
	<link rel="icon" type="image/x-icon" href="./favicon/<?=$admin_favicon?>/favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/dashboard/">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

    /* Style the tab */
    .tab {
      overflow: hidden;
      border: 1px solid #ccc;
      background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
      background-color: inherit;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      transition: 0.3s;
      font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
      background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
      background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
      display: none;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
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
	$info_box_bg_color = "bg-light";
	if($_SESSION['themeColorIndex'] == 0){ //Day mode
		$info_box_bg_color = "bg-light";
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}else if($_SESSION['themeColorIndex'] == 1){ //Night mode
		$info_box_bg_color = "bg-dark";
		echo "<link href=\"dashboard/css/dashboard_dark.css\" rel=\"stylesheet\">";
	}else{
		$info_box_bg_color = "bg-light";
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}
	?>

	<!-- Javascript -->
	<script src="./js/sidebar.js"></script>
	<script src="./js/showTime.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	
</head>

<body>

		  <?php
		  include_once ("./template/top_nav.php");
		  echo $top_nav_admin_str;
		  ?>
			  
		  <?php if($_SESSION['permission'] == "Admin" || $_SESSION['permission'] == "Manager"){?>
          <a class="nav-link" style="display:inline;" href="dashboard.php">
		  <?php echo $list_name_staffPage[$_SESSION["language_index"]] ?>
		  </a>
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
		include_once ("./template/sidebar.php");
		echo $sidebar_admin_str;
	?>	

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
        <h2 class="rh2"><?php echo $list_name_title[$lang]; ?></h2>
        <br>
        <div class="tab">
          <button class="tablinks" onclick="openTab(event, 'ViewBookingDetails')" id="defaultOpen"><?php echo $view_book[$lang]; ?></button>
        </div>
		
		
        <div id="ViewBookingDetails" class="tabcontent">
          <h3><?php echo $book_detail[$lang]; ?></h3>
          <br>
		  <form action="./cancelBooking.php" method="post" enctype="multipart/form-data">
			
			<!---->
			<div id="result">[<?php echo $show[$lang]; ?>]</div>
			<div id="cancelBtn_div"></div>
		  </form>
        </div>		
		
        <br><br>
		<h4><?php echo $table_head[$lang]; ?></h4>
        <div class="table-responsive">
          <table class="table table-striped table-hover table-sm rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo "table-light";} ?>">
            <thead>
              <tr>
                <th><?php echo $table_Title1[$lang]; ?></th>
                <th><?php echo $table_Title2[$lang]; ?></th>
                <th><?php echo $table_Title3[$lang]; ?></th>
                <th><?php echo $table_Title4[$lang]; ?></th>
				<th><?php echo $table_Title5[$lang]; ?></th>
				<th><?php echo $table_Title6[$lang]; ?></th>
				<th> </th>
              </tr>
            </thead>
            <tbody>
              <?php
				if (mysqli_num_rows($rs) > 0){
					do{
						$booking_id = $rc['booking_id'];
						echo "<tr>";
						echo "<td>".$booking_id."</td>";
						echo "<td>".$rc['organization_name']."</td>";
						echo "<td>".$rc['representative_name']."</td>";
						echo "<td>".$rc['contact_number']."</td>";
						//echo "<td>".$rc['camp_type']."</td>";
						//echo "<td>".$rc['payment_status']."</td>";
						echo "<td>".$rc['checkin_date']."</td>";
						echo "<td>".$rc['checkin_time']."</td>";
						//echo "<td>".$rc['checkout_date']."</td>";
						//echo "<td>".$rc['checkout_time']."</td>";

						
						//echo "<td class='text-center'>".$rc['total_number_of_room']."</td>";
						
						echo "<td>";
						echo "<button class='btn btn-outline-primary btn-sm'  id='".$booking_id."' onclick='viewDetails(this.id);'>Details</button>";
						echo "</td>";
						echo "</tr>";
				
					}while ($rc = mysqli_fetch_assoc($rs));
				}
              ?>
            </tbody>
          </table>
        </div>
		
		
		
		
		
		
      </main>
    </div>
  </div>



</body>

</html>

<script>
	<?php
	include_once ("./template/common_js.php");
	echo $common_js_str;
	?>
	
	
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

  function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();

	function viewDetails(bookingID){
		//alert(bookingID);
		$.post(
			"./getBookingDetails.php", 
			{booking_id: bookingID}, 
			function(result){
				if(result == 0){
					console.log("error");
				}else{
					console.log(result);
					const result_obj = JSON.parse(result);
					var temp = "<?php echo $bookID[$lang]; ?>: &emsp;<input type=\"text\" id=\"bookingID\" name=\"bookingID\" value=\"\" readonly><br><div class=\"row\">"
					+"<div class=\"m-1 col-sm col-md col-lg-3 col-xl-2 <?php echo $info_box_bg_color; ?>\">"
					+"團體名稱: <span id=\"organizationName\"></span> <br>"
					+"領隊姓名: <span id=\"representativeName\"></span> <br>"
					+"電話: <span id=\"phoneNumber\"></span> <br>"
					+"人數(男): <span id=\"manNumber\"></span> <br>"
					+"人數(女): <span id=\"womanNumber\"></span> <br>"
					+"</div>"
					+"<div class=\"m-1 col-sm col-md col-lg col-xl-4 <?php echo $info_box_bg_color; ?>\">"
					+"訂營類型: <span id=\"campType\"></span><br>"
					+"優惠團體: <span id=\"specialRate\"></span> <br>"
					+"房數:  <span id=\"totalNumberOfRoom\"></span> <br>"
					+"房號:  <span id=\"bookedRoom\"></span> <br>"
					+"</div>"
					+"<div class=\"m-1 col-sm col-md col-lg-3 col-xl-2 <?php echo $info_box_bg_color; ?>\">"
					+"入營日期: <span id=\"checkInDate\"></span> <br>"
					+"入營時間: <span id=\"checkInTime\"></span> <br>"
					+"出營日期: <span id=\"checkOutDate\"></span> <br>"
					+"出營時間: <span id=\"checkOutTime\"></span> <br>"
					+"總計(晚數): <span id=\"totalDays\"></span> <br>"
					+"</div>"
					+"<div class=\"m-1 col-sm col-md col-lg-3 col-xl-2 <?php echo $info_box_bg_color; ?>\">"
					+"總房租: $<span id=\"totalRoomPrice\"></span> <br>"
					+"其他費用: $<span id=\"otherPrice\"></span> <br>"
					+"總計: $<span id=\"totalPrice\"></span> <br>"
					+"付款狀態: <span id=\"paymentStatus\"></span><br>"
					+"已付金額: $<span id=\"paidAmount\"></span><br>"
					+"未付餘額: $<span id=\"outstandingBalance\"></span><br>"
					+"</div>"
					+"<div class=\"m-1 col-sm col-md col-lg-3 col-xl-2 <?php echo $info_box_bg_color; ?>\">"
					+"職員名稱: <span id=\"staffName\"></span> <br>"
					+"職員編號: <span id=\"staffNumber\"></span> <br>"
					+"</div>"
					+"</div>";
					
					$("#result").html(temp);
					$("#bookingID").val(bookingID);
					$("#organizationName").html(result_obj.organization_name);
					$("#representativeName").html(result_obj.representative_name);
					$("#phoneNumber").html(result_obj.contact_number);
					$("#manNumber").html(result_obj.no_of_male_camper);
					$("#womanNumber").html(result_obj.no_of_female_camper);
					
					$("#campType").html(result_obj.camp_type);
					$("#specialRate").html(result_obj.special_rate);
					$("#totalNumberOfRoom").html(result_obj.total_number_of_room);
					$("#bookedRoom").html(result_obj.booked_rooms);
					
					$("#checkInDate").html(result_obj.checkin_date);
					$("#checkInTime").html(result_obj.checkin_time);
					$("#checkOutDate").html(result_obj.checkout_date);
					$("#checkOutTime").html(result_obj.checkout_time);
					$("#totalDays").html(result_obj.no_of_nights);
					
					$("#totalRoomPrice").html(result_obj.total_room_charges);
					$("#otherPrice").html(result_obj.other_charges);
					$("#totalPrice").html(result_obj.total_payment);
					$("#paymentStatus").html(result_obj.payment_status);
					$("#paidAmount").html(result_obj.tenant_deposit_amount);
					$("#outstandingBalance").html(result_obj.outstanding_balance);
					
					$("#staffName").html(result_obj.staff_name);
					$("#staffNumber").html(result_obj.staff_id);
					
					$("#bookingID").addClass("mb-1");
					
					$("#result>table>tbody>tr>td").addClass("px-2 bg-light");
					$("#result>table>tbody>tr>td").css({"border": "3px solid #FFFFFF"});
					
					$("#cancelBtn_div").html("<button id='cancelBtn' class='btn btn-danger' onclick=\"return confirm('Are you sure?');\"><i class='fa fa-exclamation-triangle'></i> <?php echo $btn_cancel[$lang]; ?></button>");
					
					$("#cancelBtn").addClass("my-3");
				}
			}
		);
	}

</script>