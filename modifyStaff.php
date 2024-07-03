<?php 
include('permissionA.php');
include('timeout.php');
include('connection.php');
?>
<?php
include_once("./language/main_string.php");
include_once("./language/modifyStaff_string.php");
include_once("./config/config.php"); 
?>

<?php

if(isset($_POST["showAllStaff"])){
	$sql = "SELECT * FROM staff WHERE permission != 'admin' ORDER BY staff_id DESC "; //write the SQL statement
}else if(isset($_POST["showOnlyActiveStaff"])){
	$sql = "SELECT * FROM staff WHERE permission != 'admin' AND status = 'Active' ORDER BY staff_id DESC "; //write the SQL statement
}else if(isset($_POST["showOnlyInactiveStaff"])){
	$sql = "SELECT * FROM staff WHERE permission != 'admin' AND status = 'inActive' ORDER BY staff_id DESC "; //write the SQL statement
}else{
	$sql = "SELECT * FROM staff WHERE permission != 'admin' ORDER BY staff_id DESC "; //write the SQL statement
}


$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Control Panel - Modify Staff</title>
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


    /* Copytext function - snackbar*/
    #snackbar {
      visibility: hidden;
      min-width: 250px;
      margin-left: -125px;
      background-color: #333;
      color: #fff;
      text-align: center;
      border-radius: 2px;
      padding: 16px;
      position: fixed;
      z-index: 1;
      left: 50%;
      top: 80px;
      font-size: 17px;
    }

    #snackbar.show {
      visibility: visible;
      -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
      animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @-webkit-keyframes fadein {
      from {
        top: 0;
        opacity: 0;
      }

      to {
        top: 80px;
        opacity: 1;
      }
    }

    @keyframes fadein {
      from {
        top: 0;
        opacity: 0;
      }

      to {
        top: 80px;
        opacity: 1;
      }
    }

    @-webkit-keyframes fadeout {
      from {
        top: 80px;
        opacity: 1;
      }

      to {
        top: 0;
        opacity: 0;
      }
    }

    @keyframes fadeout {
      from {
        top: 80px;
        opacity: 1;
      }

      to {
        top: 0;
        opacity: 0;
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
          <button class="tablinks" onclick="openTab(event, 'AddS')" id="defaultOpen"><?php echo $add[$lang]; ?></button>
          <button class="tablinks" onclick="openTab(event, 'RemoveS')"><?php echo $remove[$lang]; ?></button>
          <button class="tablinks" onclick="openTab(event, 'EditS')"><?php echo $edit[$lang]; ?></button>
        </div>

        <div id="AddS" class="tabcontent">
          <h3><?php echo $add[$lang]; ?></h3>
          <br>
          <form action="addNewStaff.php" method="post" enctype="multipart/form-data" onsubmit="return varifyStaffInfo()">
            <?php echo $staffName_list[$lang]; ?>: &emsp;
            <input type="text" id="Sname" name="Sname" required>
            </br></br>
            <?php echo $password_list[$lang]; ?>: &emsp;
            <input type="password" id="Spw" name="Spw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
			<i class="fa-solid fa-eye" id="eye" onclick="showPassword1()" title="Show Password" style="cursor: pointer;"></i>
			
            </br></br>
            <?php echo $permission_list[$lang]; ?>: &emsp;
            <select id="Sper" name="Sper">
              <option value="Staff"><?php echo $jobPos1[$lang]; ?></option>
              <option value="Manager"><?php echo $jobPos2[$lang]; ?></option>
            </select>
            </br></br>
            <input type="submit" class="btn btn-primary" value="<?php echo $btn_con[$lang]; ?>">
          </form>
        </div>

        <div id="RemoveS" class="tabcontent">
          <h3><?php echo $remove[$lang]; ?></h3>
          <br>
          <form>
          <?php echo $search[$lang]; ?>: &emsp;
            <input type="text" id="staff_ID" name="staff_ID" placeholder="Staff ID" onkeyup="showStaff(this.value)">
          </form>
          <br>
          <div id="txtHint"><b><?php echo $hint[$lang]; ?></b></div>
        </div>

        <div id="EditS" class="tabcontent">
          <h3><?php echo $edit[$lang]; ?></h3>
          <br>
          <form>
            <?php echo $search[$lang]; ?>: &emsp;
            <input type="text" id="staff_ID" name="staff_ID" placeholder="Staff ID" onkeyup="showStaff2(this.value)">
          </form>
          <br>
          <div id="txtHint2"><b><?php echo $hint[$lang]; ?></b></div>
        </div>
        <br><br>

		<!--Table search bar-->

		<select name="searchBy" id="searchBy" >
			<option value="staffid"><?php echo $table_Title1[$lang]; ?></option>
			<option value="staffname"><?php echo $table_Title2[$lang]; ?></option>
			<option value="permission"><?php echo $table_Title3[$lang]; ?></option>
			<option value="status"><?php echo $table_Title4[$lang]; ?></option>
		</select>
		<input type="text" id="searchKeyword" onkeyup="searchTable()" placeholder="Keyword" title="Type in a keyword">

		<br>
		<!--Select show staff-->
		<form  method="POST" style="display: inline">
			<input type="hidden" name="showAllStaff">
			<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showAllStaff[$lang]; ?></a>
		</form>
			&nbsp;|&nbsp;
		<form  method="POST" style="display: inline">
			<input type="hidden" name="showOnlyActiveStaff">
			<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showOnlyActiveStaff[$lang]; ?></a> 
		</form>
		&nbsp;|&nbsp; 
		<form  method="POST" style="display: inline">
			<input type="hidden" name="showOnlyInactiveStaff">
			<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showOnlyInactiveStaff[$lang]; ?></a>
		</form>
		<hr class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "border-light"; }else{ echo "border-dark";} ?>">

		<br>
		<!--Table-->

        <div class="table-responsive">
          <table class="table table-striped table-hover table-sm rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo "table-light";} ?>" id="myTable">
            <thead>
              <tr>
				<th onclick="sortTable(0)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title1[$lang]; ?></th>
				<th onclick="sortTable(1)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title2[$lang]; ?></th>
				<th onclick="sortTable(2)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title3[$lang]; ?></th>
				<th onclick="sortTable(3)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title4[$lang]; ?></th>
              </tr>
            </thead>
            <tbody>
              <?php

			  if(mysqli_num_rows($rs) > 0){
				  do {
					$staffID = $rc['staff_id'];
					$staffName = $rc['staff_name'];
					$permission = $rc['permission'];
					$status = $rc['status'];

					echo " <tr><td> $staffID </td><td> $staffName </td><td> $permission </td><td> $status </td>";
					echo "</tr>";
				  } while ($rc = mysqli_fetch_assoc($rs)); 
			  }else{
				  //show nothing
				  echo "no staff";
			  }
              
              ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>


  <div id="snackbar">Some text some message..</div>
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

  //AJAX
  function showStaff(str) {
    if (str == "") {
      document.getElementById("txtHint").innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("txtHint").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "getStaff.php?s1=" + str, true);
      xmlhttp.send();
    }
  }

  function showStaff2(str) {
    if (str == "") {
      document.getElementById("txtHint2").innerHTML = "";
      return;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("txtHint2").innerHTML = this.responseText;
        }
      };
      xmlhttp.open("GET", "getStaff.php?s2=" + str, true);
      xmlhttp.send();
    }
  }
  
  function showPassword1() {
	  var x = document.getElementById("Spw");
	  
	  if (x.type === "password") {
		document.getElementById("eye").className = "fa-solid fa-eye-slash";
		x.type = "text";
	  } else {
		document.getElementById("eye").className = "fa-solid fa-eye";
		x.type = "password";
	  }
	  
	}
	
	function showPassword2() {
	  var x = document.getElementById("pw_edit");
	  
	  if (x.type === "password") {
		document.getElementById("eye2").className = "fa-solid fa-eye-slash";
		x.type = "text";
	  } else {
		document.getElementById("eye2").className = "fa-solid fa-eye";
		x.type = "password";
	  }
	  
	}
	
	function varifyStaffInfo(){ //Staff Name
		let original_Sname = $("#Sname").val();
		let clean_Sname = DOMPurify.sanitize($("#Sname").val());
		if(original_Sname.trim()==""){
			alert("invalid staff name");
			return false;
		}else if(clean_Sname != original_Sname){
			alert("invalid staff name");
			return false;
		}else{
			return true;
		}
	}
	
	function varifyEditStaffInfo(){ //Staff Name
		let original_Sname = $("#name_edit").val();
		let clean_Sname = DOMPurify.sanitize($("#name_edit").val());
		if(original_Sname.trim()==""){
			alert("invalid staff name");
			return false;
		}else if(clean_Sname != original_Sname){
			alert("invalid staff name");
			return false;
		}else{
			return true;
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
</script>