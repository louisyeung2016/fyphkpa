<?php 
include('permissionS.php');
include('timeout.php');
include('connection.php');
?>
<?php 
include_once("./language/main_string.php"); 
include_once("./language/viewRoomStatus_string.php");
include_once("./config/config.php"); 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Current Room Status</title>
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
		
		  .room {
			display: inline-block;
			width: 70px;
			height: 70px;
			margin: 6px;
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
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	
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
	include_once("./template/sidebar.php"); 
	echo $sidebar_str;
	?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
		<h2 class="rh2"><?php echo $list_name_title[$lang]; ?> </h2>
		

		<span class="badge <?php if($_SESSION['themeColorIndex'] == 1){ echo "badge-dark"; }else{ echo "badge-light";} ?>">
			<i class="fa fa-square text-secondary" ></i> <?php echo $gray[$lang]; ?>
		</span>
		
		<span class="badge <?php if($_SESSION['themeColorIndex'] == 1){ echo "badge-dark"; }else{ echo "badge-light";} ?>">
			<i class="fa fa-square text-success" ></i> <?php echo $green[$lang]; ?>
		</span>
		
		<span class="badge <?php if($_SESSION['themeColorIndex'] == 1){ echo "badge-dark"; }else{ echo "badge-light";} ?>">
			<i class="fa fa-square text-danger" ></i> <?php echo $red[$lang]; ?>
		</span>
		
		<hr class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "border-light"; }else{ echo "border-dark";} ?>">
		
		<div class="container rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?> mx-md-0 mx-sm-3 py-2 my-2" >


			<details open>
			  <summary><?php echo $roomType1[$lang]; ?></summary>
			  
				<fieldset>
				<legend class="w-auto px-2"><?php echo $roomType1[$lang]; ?></legend>
					<!--
					<div class="row m-2">
					<span id="A01" class="room bg-success text-light rounded-sm">A01</span>
					<span id="A02" class="room bg-success text-light rounded-sm">A02</span>
					<span id="A03" class="room bg-success text-light rounded-sm">A03</span>
					<span id="A04" class="room bg-success text-light rounded-sm">A04</span>
					<span id="A05" class="room bg-success text-light rounded-sm">A05</span>

					<span id="A06" class="room bg-success text-light rounded-sm">A06</span>
					<span id="A07" class="room bg-success text-light rounded-sm">A07</span>
					<span id="A08" class="room bg-success text-light rounded-sm">A08</span>
					<span id="A09" class="room bg-success text-light rounded-sm">A09</span>
					<span id="A10" class="room bg-success text-light rounded-sm">A10</span>
					</div>
					<div class="row m-2">
					<span id="A11" class="room bg-success text-light rounded-sm">A11</span>
					<span id="A12" class="room bg-success text-light rounded-sm">A12</span>
					<span id="A13" class="room bg-success text-light rounded-sm">A13</span>
					<span id="A14" class="room bg-success text-light rounded-sm">A14</span>
					<span id="A15" class="room bg-success text-light rounded-sm">A15</span>

					<span id="A16" class="room bg-success text-light rounded-sm">A16</span>
					<span id="A17" class="room bg-success text-light rounded-sm">A17</span>
					<span id="A18" class="room bg-success text-light rounded-sm">A18</span>
					<span id="A19" class="room bg-success text-light rounded-sm">A19</span>
					<span id="A20" class="room bg-success text-light rounded-sm">A20</span>
					</div>
					-->
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
					$num_divs = ceil($num_items / 10);

					for ($i = 0; $i < $num_divs; $i++) {
					  echo "<div class=\"row m-2\">";
					  for ($j = $i * 10; $j < min($i * 10 + 10, $num_items); $j++) {
						echo "<span id=\"".$list_RoomNumber[$j]."\" class=\"room bg-success text-light rounded-sm\">".$list_RoomNumber[$j]."</span>";
					  }
					  echo "</div>";
					}
					?>
					
					
				  
				  
				</fieldset>
			</details>
			
			<hr class="border <?php if($_SESSION['themeColorIndex'] == 1){ echo "border-warning"; }else{ echo "border-dark";} ?>">

			  <div class="row">
				<div class="col-sm-6">
				  
							<details open>
							  <summary><?php echo $roomType2[$lang]; ?></summary>
							  
								<fieldset>
								<legend class="w-auto px-2"><?php echo $roomType2[$lang]; ?></legend>
								  
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
									$num_divs = ceil($num_items / 10);

									for ($i = 0; $i < $num_divs; $i++) {
									  echo "<div class=\"row m-2\">";
									  for ($j = $i * 10; $j < min($i * 10 + 10, $num_items); $j++) {
										echo "<span id=\"".$list_RoomNumber[$j]."\" class=\"room bg-success text-light rounded-sm\">".$list_RoomNumber[$j]."</span>";
									  }
									  echo "</div>";
									}
									?>
								  
								  
								</fieldset>
							</details>	  
				  
				</div>
				<div class="col-sm-6">
				  
							<details open >
							  <summary><?php echo $roomType3[$lang]; ?></summary>
							  
								<fieldset>
								<legend class="w-auto px-2"><?php echo $roomType3[$lang]; ?></legend>
								  
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
									$num_divs = ceil($num_items / 10);

									for ($i = 0; $i < $num_divs; $i++) {
									  echo "<div class=\"row m-2\">";
									  for ($j = $i * 10; $j < min($i * 10 + 10, $num_items); $j++) {
										echo "<span id=\"".$list_RoomNumber[$j]."\" class=\"room bg-success text-light rounded-sm\">".$list_RoomNumber[$j]."</span>";
									  }
									  echo "</div>";
									}
									?>

								</fieldset>
							</details>	  
				  
				</div>
				
			  </div>	
			  <details open >
				  <summary><?php echo $roomType7[$lang]; ?></summary>
				  
					<fieldset>
					<legend class="w-auto px-2"><?php echo $roomType7[$lang]; ?></legend>
					  
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
						$num_divs = ceil($num_items / 10);

						for ($i = 0; $i < $num_divs; $i++) {
						  echo "<div class=\"row m-2\">";
						  for ($j = $i * 10; $j < min($i * 10 + 10, $num_items); $j++) {
							echo "<span id=\"".$list_RoomNumber[$j]."\" class=\"room bg-success text-light rounded-sm\">".$list_RoomNumber[$j]."</span>";
						  }
						  echo "</div>";
						}
						?>

					</fieldset>
				</details>	 

			<hr class="border <?php if($_SESSION['themeColorIndex'] == 1){ echo "border-warning"; }else{ echo "border-dark";} ?>">

			<details open>
			  <summary><?php echo $roomType4[$lang]; ?> / <?php echo $roomType5[$lang]; ?></summary>
				<div class="row">
				<div class="col-sm-6">
				<fieldset>
				<legend class="w-auto px-2"><?php echo $roomType4[$lang]; ?></legend>
				  
					<?php
					$list_RoomNumber = array();;
					$sqlA = "SELECT room_number FROM `room_category` WHERE room_type = 'Day Camping' AND room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
					$rsA = mysqli_query($conn, $sqlA) //mysqli_query() function performs a query against a database.
					  or die(mysqli_error($conn));
					$rcA = mysqli_fetch_assoc($rsA);
					do {
						$roomNum = $rcA['room_number'];
						array_push($list_RoomNumber, $roomNum);
					} while ($rcA = mysqli_fetch_assoc($rsA));
					//echo $list_RoomNumber;
					$num_items = count($list_RoomNumber);
					$num_divs = ceil($num_items / 10);

					for ($i = 0; $i < $num_divs; $i++) {
					  echo "<div class=\"row m-2\">";
					  for ($j = $i * 10; $j < min($i * 10 + 10, $num_items); $j++) {
						echo "<span id=\"".$list_RoomNumber[$j]."\" class=\"room bg-success text-light rounded-sm\">".$list_RoomNumber[$j]."</span>";
					  }
					  echo "</div>";
					}
					?>

				  
				  
				</fieldset>
				</div>
				<div class="col-sm-6">
				<fieldset>
				<legend class="w-auto px-2"><?php echo $roomType5[$lang]; ?></legend>
				  
					<?php
					$list_RoomNumber = array();;
					$sqlA = "SELECT room_number FROM `room_category` WHERE room_type = 'Evening Camping' AND room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
					$rsA = mysqli_query($conn, $sqlA) //mysqli_query() function performs a query against a database.
					  or die(mysqli_error($conn));
					$rcA = mysqli_fetch_assoc($rsA);
					do {
						$roomNum = $rcA['room_number'];
						array_push($list_RoomNumber, $roomNum);
					} while ($rcA = mysqli_fetch_assoc($rsA));
					//echo $list_RoomNumber;
					$num_items = count($list_RoomNumber);
					$num_divs = ceil($num_items / 10);

					for ($i = 0; $i < $num_divs; $i++) {
					  echo "<div class=\"row m-2\">";
					  for ($j = $i * 10; $j < min($i * 10 + 10, $num_items); $j++) {
						echo "<span id=\"".$list_RoomNumber[$j]."\" class=\"room bg-success text-light rounded-sm\">".$list_RoomNumber[$j]."</span>";
					  }
					  echo "</div>";
					}
					?>

				  
				  
				</fieldset>
				</div>
				</div>
				
			</details>
			  
			<hr class="border <?php if($_SESSION['themeColorIndex'] == 1){ echo "border-warning"; }else{ echo "border-dark";} ?>">
			  
			<details open>
			  <summary><?php echo $roomType6[$lang]; ?></summary>
			  
				<fieldset>
				<legend class="w-auto px-2"><?php echo $roomType6[$lang]; ?></legend>
				<!--
				<div class="d-flex">

					<span id="Z01" class="room bg-success text-light rounded-sm flex-fill">Z01</span>
					<span id="Z02" class="room bg-success text-light rounded-sm flex-fill">Z02</span>
					<span id="Z03" class="room bg-success text-light rounded-sm flex-fill">Z03</span>
					<span id="Z04" class="room bg-success text-light rounded-sm flex-fill">Z04</span>

				</div>
				 -->
					<?php
					$list_RoomNumber = array();;
					$sqlA = "SELECT room_number FROM `room_category` WHERE room_type = 'Tent Camping' AND room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
					$rsA = mysqli_query($conn, $sqlA) //mysqli_query() function performs a query against a database.
					  or die(mysqli_error($conn));
					$rcA = mysqli_fetch_assoc($rsA);
					do {
						$roomNum = $rcA['room_number'];
						array_push($list_RoomNumber, $roomNum);
					} while ($rcA = mysqli_fetch_assoc($rsA));
					//echo $list_RoomNumber;
					$num_items = count($list_RoomNumber);
					$num_divs = ceil($num_items / 10);

					for ($i = 0; $i < $num_divs; $i++) {
					  echo "<div class=\"d-flex\">";
					  for ($j = $i * 10; $j < min($i * 10 + 10, $num_items); $j++) {
						echo "<span id=\"".$list_RoomNumber[$j]."\" class=\"room bg-success text-light rounded-sm flex-fill\">".$list_RoomNumber[$j]."</span>";
					  }
					  echo "</div>";
					}
					?>
				</fieldset>
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

	$(document).ready(function(){
		/*
		const cars = ["#B01", "#B03", "#C01"];
		for (let i = 0; i < cars.length; i++) {
			$(cars[i]).removeClass("bg-secondary").addClass("bg-danger");
		}
		$("#Z01").removeClass("bg-secondary").addClass("bg-danger");
		*/
		 $.getJSON("./controller/controller_getRoomStatus.php", function(result){
			//console.log(result.occupyingRooms.length);
			for (let i = 0; i < result.occupyingRooms.length; i++) {
				$(result.occupyingRooms[i]).removeClass("bg-success").addClass("bg-secondary");
			}
			for (let i = 0; i < result.inactivateRooms.length; i++) {
				$(result.inactivateRooms[i]).removeClass("bg-success").addClass("bg-danger");
			}
		 });
		
	});
	
</script>