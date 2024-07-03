<?php 
include('permissionA.php');
include('timeout.php');
include('connection.php');
?>
<?php
include_once("./language/main_string.php");
include_once("./language/modifyDrinksInventory_string.php");
include_once("./config/config.php"); 
?>

<?php 

if(isset($_POST["showAllDrinks"])){
	$sql = "SELECT * FROM drinks_category ORDER BY drinks_id DESC "; //write the SQL statement
}else if(isset($_POST["showOnlyActiveDrinks"])){
	$sql = "SELECT * FROM drinks_category WHERE drinks_status = 'Active' ORDER BY drinks_id DESC "; //write the SQL statement
}else if(isset($_POST["showOnlyInactiveDrinks"])){
	$sql = "SELECT * FROM drinks_category WHERE drinks_status = 'inActive' ORDER BY drinks_id DESC "; //write the SQL statement
}else{
	$sql = "SELECT * FROM drinks_category ORDER BY drinks_id DESC "; //write the SQL statement
}


$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);
/*
$sql1 = "SELECT * FROM `drinks_stock_record` ORDER BY record_id DESC";
$rs1 = mysqli_query($conn, $sql1) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn));

$rc1 = mysqli_fetch_assoc($rs1);
*/
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Control Panel - Modify Inventory</title>
	<link rel="icon" type="image/x-icon" href="./favicon/<?=$admin_favicon?>/favicon.ico">
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
  <body onload="onloadGetCurrentMonthStockRecord()">
    
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
		  
		  <button class="tablinks" onclick="openTab(event, 'purchase')" id="defaultOpen"><?php echo $purchase[$lang]; ?></button>
		  <button class="tablinks" onclick="openTab(event, 'reduction')"><?php echo $reduction[$lang]; ?></button>
		</div>

		

		<div id="purchase" class="tabcontent">
		  <h3><?php echo $purchase[$lang]; ?></h3>
		  <br>
		    <form>
			<?php echo $search[$lang]; ?>:  &emsp;
				
				<input list="drinksIDs" name="drinksID" id="drinksID" placeholder="drinks ID" onkeyup="showItem(this.value)" required />
					<datalist id="drinksIDs">
						<?php
						$sql2 = "SELECT drinks_name, drinks_id FROM drinks_category WHERE drinks_status = 'Active'";
						$rs2 = mysqli_query($conn,$sql2);
						while($rowt = mysqli_fetch_array($rs2)){
						?>
						
						<option  label="<?php echo $rowt['drinks_name']?>"><?php echo $rowt['drinks_id']?></option>
						<?php
						} 
						?>
					</datalist>
			</form>
			
		  <br>
		  <div id="txtHint"><b><?php echo $itemInfo[$lang]; ?></b></div>
		  
		 
		  
		</div>
		
		<div id="reduction" class="tabcontent">
		  <h3><?php echo $reduction[$lang]; ?></h3>
		  <br>
		    <form>
			<?php echo $search[$lang]; ?>:  &emsp;
				
				<input list="drinksIDs" name="drinksID" id="drinksID" placeholder="drinks ID" onkeyup="showItem2(this.value)" required />
			</form>
		  <br>
		  <div id="txtHint2"><b><?php echo $itemInfo[$lang]; ?></b></div>
		  
		  
		</div>
		
		<br><br>
		<details open>
			  <summary><h5 style="display:inline;"><?php echo $list_name_title1[$lang]; ?></h5></summary>
			  <br>
				<!--Table search bar-->

				<select name="searchBy" id="searchBy" >
					<option value="drinksid"><?php echo $table_Title1[$lang]; ?></option>
					<option value="drinksname"><?php echo $table_Title2[$lang]; ?></option>
					<option value="qty"><?php echo $table_Title3[$lang]; ?></option>
					<option value="outofstockqty"><?php echo $table_Title3a[$lang]; ?></option>
					<option value="price"><?php echo $table_Title4[$lang]; ?></option>
					<option value="barcode"><?php echo $table_Title5[$lang]; ?></option>
					<option value="status"><?php echo $table_Title6[$lang]; ?></option>
				</select>
				<input type="text" id="searchKeyword" onkeyup="searchTable()" placeholder="Keyword" title="Type in a keyword">

				<br>
				<!--Select show staff-->
				<form  method="POST" style="display: inline">
					<input type="hidden" name="showAllDrinks">
					<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showAllDrinks[$lang]; ?></a>
				</form>
					&nbsp;|&nbsp;
				<form  method="POST" style="display: inline">
					<input type="hidden" name="showOnlyActiveDrinks">
					<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showOnlyActiveDrinks[$lang]; ?></a> 
				</form>
				&nbsp;|&nbsp; 
				<form  method="POST" style="display: inline">
					<input type="hidden" name="showOnlyInactiveDrinks">
					<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showOnlyInactiveDrinks[$lang]; ?></a>
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
								<th onclick="sortTable(3)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title3a[$lang]; ?></th>
								<th onclick="sortTable(4)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title4[$lang]; ?></th>
								<th onclick="sortTable(5)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title5[$lang]; ?></th>
								<th onclick="sortTable(6)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title6[$lang]; ?></th>
							</tr>
						  </thead>
						  <tbody>
							<?php
							if(mysqli_num_rows($rs) > 0){
								do { 
									$drinksID = $rc['drinks_id'];
									$drinksName = $rc['drinks_name'];
									$stockQty = $rc['stock_qty'];
									$shortageLevel = $rc['shortage_level'];
									$drinksPrice = $rc['price'];
									$barCode = $rc['barcode'];
									$drinksStatus = $rc['drinks_status'];
									
									
									echo " <tr><td> $drinksID </td><td> $drinksName </td><td> $stockQty </td><td> $shortageLevel </td><td> $drinksPrice </td>
									<td> <b id=\"myInput\" onclick=\"copyTextToClipboard(this);showSnackbar(this)\" title=\"Copy to clipboard\" style=\"cursor: pointer;\">$barCode</b></td>
									<td> $drinksStatus </td>";
									
									echo "</tr>";
									
									
								}while($rc = mysqli_fetch_assoc($rs)); 
							}else{
								//show nothing
								echo "no drinks";
							}
							?>
									
					
						  </tbody>
						</table>
				</div>
		</details>
		<hr class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "border-light"; }else{ echo "border-dark";} ?>">
		<details open>
		<!--Stock Record-->
		<summary><h5 style="display:inline;"><?php echo $list_name_title2[$lang]; ?></h5></summary>
		<input type="month" id="selectMonth" name="selectMonth" class="form-control my-3" style="width:420px" onchange="getStockRecord()"> 
		<div id="search_hints" class="text-danger" style="display: none;"> no record found</div>
		<div class="table-responsive rounded">
					<table class="table table-striped table-hover table-sm rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo "table-light";} ?>" id="myTable2">
					  <thead>
					    <tr>
							<th onclick="sortTable2(0)" title="click to sort" style="cursor: pointer;"><?php echo $table2_Title1[$lang]; ?></th>
							<th onclick="sortTable2(1)" title="click to sort" style="cursor: pointer;"><?php echo $table2_Title2[$lang]; ?></th>
							<th onclick="sortTable2(2)" title="click to sort" style="cursor: pointer;"><?php echo $table2_Title3[$lang]; ?></th>
							<th onclick="sortTable2(3)" title="click to sort" style="cursor: pointer;"><?php echo $table2_Title4[$lang]; ?></th>
							<th onclick="sortTable2(4)" title="click to sort" style="cursor: pointer;"><?php echo $table2_Title5[$lang]; ?></th>
							<th onclick="sortTable2(5)" title="click to sort" style="cursor: pointer;"><?php echo $table2_Title6[$lang]; ?></th>
							<th onclick="sortTable2(6)" title="click to sort" style="cursor: pointer;"><?php echo $table2_Title7[$lang]; ?></th>
							<th onclick="sortTable2(7)" title="click to sort" style="cursor: pointer;"><?php echo $table2_Title8[$lang]; ?></th>
							<th onclick="sortTable2(8)" title="click to sort" style="cursor: pointer;"><?php echo $table2_Title9[$lang]; ?></th>
						</tr>
					  </thead>
					  <tbody id="target_table">

								
				
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

	//AJAX
	function showItem(str) {
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
		xmlhttp.open("GET","getdrinksInventory.php?q1="+str,true);
		xmlhttp.send();
	  }
	}
	
	function showItem2(str) {
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
		xmlhttp.open("GET","getdrinksInventory.php?q2="+str,true);
		xmlhttp.send();
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
	
	function searchTable2() {
	  var input, filter, table, tr, td, i, txtValue, index;
	  input = document.getElementById("searchKeyword");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("myTable2");
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

	function sortTable2(n) {
	  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
	  table = document.getElementById("myTable2");
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
	
	function getStockRecord(){
		var inputMonth = document.getElementById("selectMonth").value;
		//document.getElementById("output").value = input;
		
		//console.log(input);
		$("#target_table").empty();
		
		$.ajax({
			type: "POST",
			url: "./controller/controller_getStockData.php",
			data:{drinksStockRequest:inputMonth}, 

			success: function(result, status, xhr){
				if(result == 0){
					$('#search_hints').show('slow');
				}else{
					$('#search_hints').hide();
					//console.log(result);
					const result_obj = JSON.parse(result);
					
					
					//console.log(result_obj);
					
					$('#target_table').hide();
					$.each(result_obj, function (i, item1) {
						
						
						var trHTML = '';
						trHTML += '<tr><td>' + result_obj[i][0] + '</td><td>'+ result_obj[i][1] + '</td><td>' + result_obj[i][2] + '</td><td>' + result_obj[i][3] + '</td><td>' + result_obj[i][4] + '</td><td>' + result_obj[i][6] + '</td><td>' + result_obj[i][7] + '</td><td>' + result_obj[i][8] + '</td><td>' + result_obj[i][5] + '</td></tr>';
						$('#target_table').append(trHTML);
						
						
					});
					$('#target_table').show('slow');
				}
				
				
			},
			error: function (xhr, status, error){
				console.log("ERROR: "+error);

			}
		});
	}

	function onloadGetCurrentMonthStockRecord(){
		var date = new Date();
		var months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
		var currentYearMonth = date.getFullYear()+"-"+months[date.getMonth()];
		//alert(currentYearMonth);
		document.getElementById("selectMonth").value = currentYearMonth;
		getStockRecord();
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
	
	function countChar_2(x){
		//var str = document.getElementById("remarks").value;
		document.getElementById("countedChar_2").innerHTML = x.length;
		if(x.length > 100){
			document.getElementById("countedChar_2").style.color = "red";
		}else{
			document.getElementById("countedChar_2").style.color = null;
		}
	}
	
	function checkRemarkNum_1(){
		var str = document.getElementById("remarks_1").value;
		if(str.length > 100){
			alert("Remarks over 100 characters");
			return false;
		}else{
			return true;
		}
	}
	
	function checkRemarkNum_2(){
		var str = document.getElementById("remarks_2").value;
		if(str.length > 100){
			alert("Remarks over 100 characters");
			return false;
		}else{
			return true;
		}
	}
	
	function varifyPurchaseRemarks(){ //Staff Name
		let original_remarks_1 = $("#remarks_1").val();
		let clean_remarks_1 = DOMPurify.sanitize($("#remarks_1").val());
		if(original_remarks_1.trim()==""){
			alert("invalid remarks");
			return false;
		}else if(clean_remarks_1 != original_remarks_1){
			alert("invalid remarks");
			return false;
		}else{
			return true;
		}
	}
	
	function varifReductionRemarks(){ //Staff Name
		let original_remarks_2 = $("#remarks_2").val();
		let clean_remarks_2 = DOMPurify.sanitize($("#remarks_2").val());
		if(original_remarks_2.trim()==""){
			alert("invalid remarks");
			return false;
		}else if(clean_remarks_2 != original_remarks_2){
			alert("invalid remarks");
			return false;
		}else{
			return true;
		}
	}
</script>