<?php 
include('permissionA.php');
include('timeout.php');
include('connection.php');
?>
<?php
include_once("./language/main_string.php");
include_once("./language/modifyRoom_string.php");
include_once("./config/config.php"); 
?>

<?php

if(isset($_POST["showAllRooms"])){
	$sql = "SELECT * FROM `room_category` WHERE room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
}else if(isset($_POST["showOnlyActiveRooms"])){
	$sql = "SELECT * FROM `room_category` WHERE room_status = 'Activate' AND room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
}else if(isset($_POST["showOnlyInactiveRooms"])){
	$sql = "SELECT * FROM `room_category` WHERE room_status = 'inActivate' AND room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
}else{
	$sql = "SELECT * FROM `room_category` WHERE room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
}

//$sql = "SELECT * FROM `room_category` WHERE room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

$dropdownList_RoomNumber = "";

//8-person
$dropdownList_RoomNumber .= "<optgroup label=\"8-person Dormitory\">";
$sqlA = "SELECT room_number FROM `room_category` WHERE room_type = '8-person Dormitory' ORDER BY room_number ASC "; //write the SQL statement
$rsA = mysqli_query($conn, $sqlA) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));
$rcA = mysqli_fetch_assoc($rsA);
do {
	$roomNum = $rcA['room_number'];
	$dropdownList_RoomNumber .= "<option value=\"$roomNum\">$roomNum</option>";
} while ($rcA = mysqli_fetch_assoc($rsA));
$dropdownList_RoomNumber .= "</optgroup>";

//4-person
$dropdownList_RoomNumber .= "<optgroup label=\"4-person Dormitory\">";
$sqlB = "SELECT room_number FROM `room_category` WHERE room_type = '4-person Dormitory' ORDER BY room_number ASC "; //write the SQL statement
$rsB = mysqli_query($conn, $sqlB) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));
$rcB = mysqli_fetch_assoc($rsB);
do {
	$roomNum = $rcB['room_number'];
	$dropdownList_RoomNumber .= "<option value=\"$roomNum\">$roomNum</option>";
} while ($rcB = mysqli_fetch_assoc($rsB));
$dropdownList_RoomNumber .= "</optgroup>";

//2-person
$dropdownList_RoomNumber .= "<optgroup label=\"2-person Dormitory\">";
$sqlC = "SELECT room_number FROM `room_category` WHERE room_type = '2-person Dormitory' ORDER BY room_number ASC "; //write the SQL statement
$rsC = mysqli_query($conn, $sqlC) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));
$rcC = mysqli_fetch_assoc($rsC);
do {
	$roomNum = $rcC['room_number'];
	$dropdownList_RoomNumber .= "<option value=\"$roomNum\">$roomNum</option>";
} while ($rcC = mysqli_fetch_assoc($rsC));
$dropdownList_RoomNumber .= "</optgroup>";

//backup room
$dropdownList_RoomNumber .= "<optgroup label=\"Backup Room\">";
$sqlBackup = "SELECT room_number FROM `room_category` WHERE room_type = 'Backup Room' ORDER BY room_number ASC "; //write the SQL statement
$rsBackup = mysqli_query($conn, $sqlBackup) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));
$rcBackup = mysqli_fetch_assoc($rsBackup);
do {
	$roomNum = $rcBackup['room_number'];
	$dropdownList_RoomNumber .= "<option value=\"$roomNum\">$roomNum</option>";
} while ($rcBackup = mysqli_fetch_assoc($rsBackup));
$dropdownList_RoomNumber .= "</optgroup>";


//Day
$dropdownList_RoomNumber .= "<optgroup label=\"Day Camping\">";
$sqlD = "SELECT room_number FROM `room_category` WHERE room_type = 'Day Camping' AND room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
$rsD = mysqli_query($conn, $sqlD) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));
$rcD = mysqli_fetch_assoc($rsD);
do {
	$roomNum = $rcD['room_number'];
	$dropdownList_RoomNumber .= "<option value=\"$roomNum\">$roomNum</option>";
} while ($rcD = mysqli_fetch_assoc($rsD));
$dropdownList_RoomNumber .= "</optgroup>";

//Evening
$dropdownList_RoomNumber .= "<optgroup label=\"Evening Camping\">";
$sqlE = "SELECT room_number FROM `room_category` WHERE room_type = 'Evening Camping' AND room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
$rsE = mysqli_query($conn, $sqlE) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));
$rcE = mysqli_fetch_assoc($rsE);
do {
	$roomNum = $rcE['room_number'];
	$dropdownList_RoomNumber .= "<option value=\"$roomNum\">$roomNum</option>";
} while ($rcE = mysqli_fetch_assoc($rsE));
$dropdownList_RoomNumber .= "</optgroup>";

//Tent
$dropdownList_RoomNumber .= "<optgroup label=\"Tent Camping\">";
$sqlZ = "SELECT room_number FROM `room_category` WHERE room_type = 'Tent Camping' AND room_number NOT LIKE '%00' ORDER BY room_number ASC "; //write the SQL statement
$rsZ = mysqli_query($conn, $sqlZ) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));
$rcZ = mysqli_fetch_assoc($rsZ);
do {
	$roomNum = $rcZ['room_number'];
	$dropdownList_RoomNumber .= "<option value=\"$roomNum\">$roomNum</option>";
} while ($rcZ = mysqli_fetch_assoc($rsZ));
$dropdownList_RoomNumber .= "</optgroup>";



?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Control Panel - Modify Room</title>
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
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	
	<script type="text/javascript" src="js/DOMPurify-main/dist/purify.min.js"></script>
	
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
          <button class="tablinks" onclick="openTab(event, 'ActivateInactivateRoom')" id="defaultOpen"><?php echo $subtitle1[$lang]; ?></button>
          <button class="tablinks" onclick="openTab(event, 'EditRoomKeyRFID')"><?php echo $subtitle2[$lang]; ?></button>
		  <button class="tablinks" onclick="openTab(event, 'EditRoomRemarks')"><?php echo $subtitle3[$lang]; ?></button>
        </div>

        <div id="ActivateInactivateRoom" class="tabcontent">
          <h3><?php echo $subtitle1[$lang]; ?></h3>
          <br>
          <form action="./activateRoom.php" method="post" enctype="multipart/form-data">
          <?php echo $room_num[$lang]; ?>: &emsp;
            <input type="text" list="roomNumList" name="roomNum" id="roomNum" required>
			<datalist id="roomNumList">
				<?php
				$rs1 = mysqli_query($conn, $sql)
				  or die(mysqli_error($conn));

				$rc1 = mysqli_fetch_assoc($rs1);
				do {
					$roomNum = $rc1['room_number'];
					$roomType = $rc1['room_type'];
					
					echo "<option value='$roomNum'> $roomType </option>";
					
				} while ($rc1 = mysqli_fetch_assoc($rs1));
				?>
			</datalist>
            </br></br>

            <?php echo $status[$lang]; ?>: &emsp;
            <select id="roomStatus" name="roomStatus">
              <option value="Activate"><?php echo $status_act[$lang]; ?></option>
              <option value="InActivate"><?php echo $status_inact[$lang]; ?></option>
            </select>
            </br></br>
            <button type="submit" class="btn btn-primary"><?php echo $button[$lang]; ?></button>
          </form>
        </div>

        <div id="EditRoomKeyRFID" class="tabcontent">
          <h3><?php echo $subtitle2[$lang]; ?></h3>
          <br>
		  <form action="./editRoomRFID.php" method="post" enctype="multipart/form-data">
			<?php echo $room_num[$lang]; ?>: &emsp;
			
			<select name="roomNum" id="roomNum" onchange="">
			<?php
			 echo $dropdownList_RoomNumber;
			?>
			</select>
			
			</br></br>
			<?php echo $rfid[$lang]; ?>:  &emsp;
			<input type="text" id="rfidCode" name="rfidCode" placeholder="10-digit number" pattern="^[0-9]{10}$" title="RFID requires 10 digits numbers only" required >
			
			</br></br>
            <button type="submit" class="btn btn-warning"><i class="fa fa-edit"></i> <?php echo $button[$lang]; ?></button>
		  </form>
        </div>

		<div id="EditRoomRemarks" class="tabcontent">
          <h3><?php echo $subtitle3[$lang]; ?></h3>
          <br>
		  <form action="./editRoomRemarks.php" method="post" enctype="multipart/form-data" onsubmit="return varifyRoomRemarks()">
			<?php echo $room_num[$lang]; ?>: &emsp;
			
			<select name="roomNum" id="roomNum" onchange="">
			<?php
			 echo $dropdownList_RoomNumber;
			?>
			</select>
			
			</br></br>
			<?php echo $room_remarks[$lang]; ?>:  &emsp;
			<input type="text" style="width:80%; max-width:400px;" id="roomRemarks" name="roomRemarks" placeholder="<?php echo $room_remarks_placeholder[$lang]; ?>" onkeyup="countChar_1(this.value)" >
			<div class="text-danger"><?php echo $room_remarks_hints[$lang]; ?></div>
			<div>word count: <span id="countedChar_1">0</span></div>
			</br></br>
            <button type="submit" class="btn btn-info"><i class="fa fa-edit"></i> <?php echo $button[$lang]; ?></button>
		  </form>
        </div>

        <br><br>
		<details open>
			  <summary><h5 style="display:inline;"><?php echo $list_name_title1[$lang]; ?></h5></summary>
			  <br>
		
				<!--Table search bar-->

				<select name="searchBy" id="searchBy" >
					<option value="room_number"><?php echo $table_Title1[$lang]; ?></option>
					<option value="room_type"><?php echo $table_Title2[$lang]; ?></option>
					<option value="room_rfid"><?php echo $table_Title3[$lang]; ?></option>
					<option value="room_status"><?php echo $table_Title4[$lang]; ?></option>
					<option value="room_remarks"><?php echo $table_Title5[$lang]; ?></option>
				</select>
				<input type="text" id="searchKeyword" onkeyup="searchTable()" placeholder="Keyword" title="Type in a keyword">

				<br>
				<!--Select show rooms-->
				<form  method="POST" style="display: inline">
					<input type="hidden" name="showAllRooms">
					<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showAllRooms[$lang]; ?></a>
				</form>
					&nbsp;|&nbsp;
				<form  method="POST" style="display: inline">
					<input type="hidden" name="showOnlyActiveRooms">
					<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showOnlyActiveRooms[$lang]; ?></a> 
				</form>
				&nbsp;|&nbsp; 
				<form  method="POST" style="display: inline">
					<input type="hidden" name="showOnlyInactiveRooms">
					<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showOnlyInactiveRooms[$lang]; ?></a>
				</form>
				<hr class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "border-light"; }else{ echo "border-dark";} ?>">

				<br>
				<!--Table-->
				<div class="table-responsive">
				  <table class="table table-striped table-hover table-sm rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo "table-light";} ?>" id="myTable"> <!--table-dark-->
					<thead>
					  <tr>
						<th onclick="sortTable(0)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title1[$lang]; ?></th>
						<th onclick="sortTable(1)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title2[$lang]; ?></th>
						<th onclick="sortTable(2)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title3[$lang]; ?></th>
						<th onclick="sortTable(3)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title4[$lang]; ?></th>
						<th onclick="sortTable(4)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title5[$lang]; ?></th>
					  </tr>
					</thead>
					<tbody>
					  <?php
					  if(mysqli_num_rows($rs) > 0){
						  do {
							$roomNum = $rc['room_number'];
							$roomType = $rc['room_type'];
							$roomRFID = $rc['room_RFID'];
							$status = $rc['room_status'];
							$remarks = $rc['remarks'];

							echo " <tr><td> $roomNum </td><td> $roomType </td><td> $roomRFID </td><td> $status </td><td> $remarks </td>";
							echo "</tr>";
						  } while ($rc = mysqli_fetch_assoc($rs));
					  }else{
						//show nothing
						echo "no records";
					  }
					  ?>
					</tbody>
				  </table>
				</div>
		</details>
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

	function varifyRoomRemarks(){ //itemName
		let original_roomRemarks = $("#roomRemarks").val();
		let clean_roomRemarks = DOMPurify.sanitize($("#roomRemarks").val());
		if(original_roomRemarks.trim()==""){ //if nothing enter and submited
			alert("clear remarks");
			return true;
		}else if(clean_roomRemarks != original_roomRemarks){
			alert("invalid room remarks");
			return false;
		}else{
			var str_len  = clean_roomRemarks.length;
			if(str_len > 100){
				alert("invalid room remarks: over 100 characters");
				return false;
			}else{
				return true;	
			}
		}
	}  

  
	function searchTable() {
	  var input, filter, table, tr, td, i, txtValue, index;
	  input = document.getElementById("searchKeyword");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("myTable");
	  tr = table.getElementsByTagName("tr");
	  index = document.getElementById('searchBy').selectedIndex;
	  for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[index];
		if (td) {
		  txtValue = td.textContent || td.innerText;
		  if (txtValue.toUpperCase().indexOf(filter) > -1) {
			tr[i].style.display = "";
		  } else {
			tr[i].style.display = "none";
		  }
		}       
	  }
	}

	function sortTable(n) {
	  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	  table = document.getElementById("myTable");
	  switching = true;
	  //Set the sorting direction to ascending:
	  dir = "asc"; 
	  /*Make a loop that will continue until
	  no switching has been done:*/
	  while (switching) {
		//start by saying: no switching is done:
		switching = false;
		rows = table.rows;
		/*Loop through all table rows (except the
		first, which contains table headers):*/
		for (i = 1; i < (rows.length - 1); i++) {
		  //start by saying there should be no switching:
		  shouldSwitch = false;
		  /*Get the two elements you want to compare,
		  one from current row and one from the next:*/
		  x = rows[i].getElementsByTagName("TD")[n];
		  y = rows[i + 1].getElementsByTagName("TD")[n];
		  /*check if the two rows should switch place,
		  based on the direction, asc or desc:*/
		  if (dir == "asc") {
			if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
			  //if so, mark as a switch and break the loop:
			  shouldSwitch= true;
			  break;
			}
		  } else if (dir == "desc") {
			if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
			  //if so, mark as a switch and break the loop:
			  shouldSwitch = true;
			  break;
			}
		  }
		}
		if (shouldSwitch) {
		  /*If a switch has been marked, make the switch
		  and mark that a switch has been done:*/
		  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
		  switching = true;
		  //Each time a switch is done, increase this count by 1:
		  switchcount ++;      
		} else {
		  /*If no switching has been done AND the direction is "asc",
		  set the direction to "desc" and run the while loop again.*/
		  if (switchcount == 0 && dir == "asc") {
			dir = "desc";
			switching = true;
		  }
		}
	  }
	}
	
	function countChar_1(x){
		//var str = document.getElementById("remarks").value;
		document.getElementById("countedChar_1").innerHTML = x.length;
		if(x.length > 100){
			document.getElementById("countedChar_1").style.color = "red";
		}else{
			document.getElementById("countedChar_1").style.color = null;
		}
	}
</script>
