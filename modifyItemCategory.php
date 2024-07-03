<?php 
include('permissionA.php');
include('timeout.php');
include('connection.php');
?>
<?php
include_once("./language/main_string.php");
include_once("./language/modifyItemCategory_string.php");
include_once("./config/config.php"); 
?>

<?php 

if(isset($_POST["showAllItems"])){
	$sql = "SELECT * FROM rental_item_category ORDER BY item_id DESC "; //write the SQL statement
}else if(isset($_POST["showOnlyActiveItems"])){
	$sql = "SELECT * FROM rental_item_category WHERE item_status = 'Active' ORDER BY item_id DESC "; //write the SQL statement
}else if(isset($_POST["showOnlyInactiveItems"])){
	$sql = "SELECT * FROM rental_item_category WHERE item_status = 'inActive' ORDER BY item_id DESC "; //write the SQL statement
}else{
	$sql = "SELECT * FROM rental_item_category ORDER BY item_id DESC "; //write the SQL statement
}


//$sql = "SELECT * FROM rental_item_category ORDER BY item_id DESC "; //write the SQL statement
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Control Panel - Modify Item Category</title>
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
	  from {top: 0; opacity: 0;} 
	  to {top: 80px; opacity: 1;}
	}

	@keyframes fadein {
	  from {top: 0; opacity: 0;}
	  to {top: 80px; opacity: 1;}
	}

	@-webkit-keyframes fadeout {
	  from {top: 80px; opacity: 1;} 
	  to {top: 0; opacity: 0;}
	}

	@keyframes fadeout {
	  from {top: 80px; opacity: 1;}
	  to {top: 0; opacity: 0;}
	}
	
	
	/* image upload function*/
	
	form ol {
      padding-left: 0;
    }
	
	form li, div > p {
      background: #eee;
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      list-style-type: none;
      border: 1px solid black;
	  width: 300px;
    }
	
	form img {
      height: 64px;
      order: 1;
    }

    form p {
      line-height: 42px;
      padding-left: 10px;
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
		  <button class="tablinks" onclick="openTab(event, 'Add')" id="defaultOpen"><?php echo $add[$lang]; ?></button>
		  <button class="tablinks" onclick="openTab(event, 'Remove')"><?php echo $remove[$lang]; ?></button>
		  <button class="tablinks" onclick="openTab(event, 'Edit')"><?php echo $edit[$lang]; ?></button>
		</div>

		<div id="Add" class="tabcontent">
		  <h3><?php echo $add[$lang]; ?></h3>
		  <br>
		  <form action="addNewItem.php" method="post" enctype="multipart/form-data" onsubmit="return varifyItemInfo()">
		  	  <?php echo $name[$lang]; ?>:  &emsp;
			  <input type="text" id="itemName" name="itemName" placeholder="item name" required >
			  </br></br>
			  <?php echo $qty[$lang]; ?>:  &emsp;
			  <input type="number" id="itemQty" name="itemQty" min="0" max="9999" value="0" title="please use purchase function to add Quantity" readonly required >
			  </br></br>
			  <?php echo $comPrice[$lang]; ?>:  &emsp;
			  <input type="number" id="compensation" name="compensation" min="0.00" step="0.01" placeholder="amount HKD$" required >
			  </br></br>
			    
			  <label class="btn btn-info">
				<input type="file" name="fileToUpload" id="fileToUpload" accept="image/png, .png"  style="display:none;">
				<i class="fa fa-photo"></i> <?php echo $uploadImg[$lang]; ?>
			  </label>
			  <div style="color:red;">*<?php echo $hint[$lang]; ?></div>

			  <div class="preview">
				<p class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?>"><?php echo $noImg[$lang]; ?></p>
			  </div>
				
			  </br>
			  <button type="submit" name="submitToAdd" class="btn btn-primary"><?php echo $button[$lang]; ?></button>
			  </br></br>
		  </form>
		</div>

		<div id="Remove" class="tabcontent">
		  <h3><?php echo $remove[$lang]; ?></h3>
		  <br>
		    <form>
				<?php echo $search[$lang]; ?>:  &emsp;
				
				
				<input list="itemIDs" name="itemID" id="itemID" placeholder="item ID" onkeyup="showItem(this.value)" required />
					<datalist id="itemIDs">
						<?php
						$sql2 = "SELECT item_name, item_id FROM rental_item_category WHERE item_status = 'Active'";
						$rs2 = mysqli_query($conn,$sql2);
						while($rowt = mysqli_fetch_array($rs2)){
						?>
						
						<option  label="<?php echo $rowt['item_name']?>"><?php echo $rowt['item_id']?></option>
						<?php
						} 
						?>
					</datalist>
				
			</form>
			
		  <br>
		  <div id="txtHint"><b><?php echo $itemInfo[$lang]; ?></b></div>
		  
		 
		  
		</div>
		
		<div id="Edit" class="tabcontent">
		  <h3><?php echo $edit[$lang]; ?></h3>
		  <br>
		    <form>
				<?php echo $search[$lang]; ?>:  &emsp;
				<input list="itemIDs" name="itemID" id="itemID" placeholder="item ID" onkeyup="showItem2(this.value)" required />
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
			<option value="price"><?php echo $table_Title4[$lang]; ?></option>
			<option value="barcode"><?php echo $table_Title5[$lang]; ?></option>
			<option value="status"><?php echo $table_Title6[$lang]; ?></option>
		</select>
		<input type="text" id="searchKeyword" onkeyup="searchTable()" placeholder="Keyword" title="Type in a keyword">

		<br>
		<!--Select show staff-->
		<form  method="POST" style="display: inline">
			<input type="hidden" name="showAllItems">
			<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showAllItems[$lang]; ?></a>
		</form>
			&nbsp;|&nbsp;
		<form  method="POST" style="display: inline">
			<input type="hidden" name="showOnlyActiveItems">
			<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showOnlyActiveItems[$lang]; ?></a> 
		</form>
		&nbsp;|&nbsp; 
		<form  method="POST" style="display: inline">
			<input type="hidden" name="showOnlyInactiveItems">
			<a class="text-primary" style="cursor: pointer;" onclick="this.closest('form').submit();"><?php echo $showOnlyInactiveItems[$lang]; ?></a>
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
							<th onclick="sortTable(4)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title5[$lang]; ?></th>
							<th onclick="sortTable(5)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title6[$lang]; ?></th>
						</tr>
					  </thead>
					  <tbody>
						<?php
						if(mysqli_num_rows($rs) > 0){
							do { 
								$itemID = $rc['item_id'];
								$itemName = $rc['item_name'];
								$inventoryQty = $rc['qty'];
								$compensationPrice = $rc['compensation_price'];
								$qrCode = $rc['QRcode'];
								$itemStatus = $rc['item_status'];
								
								
								echo " <tr><td> $itemID </td><td> $itemName </td><td> $inventoryQty </td><td> $compensationPrice </td>
								<td> <b id=\"myInput\" onclick=\"copyTextToClipboard(this);showSnackbar(this)\" title=\"Copy to clipboard\" style=\"cursor: pointer;\">$qrCode</b> <a class=\"nav-link\" href=\"saveQRcodeToSession.php?copied_qrcode=$qrCode\" style=\"display: inline;\" title=\"Generate QRcode : $qrCode\"><i class=\"fa fa-qrcode\"></i></a> </td>
								<td> $itemStatus </td>";
								
								echo "</tr>";
								
								
							}while($rc = mysqli_fetch_assoc($rs)); 
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
		xmlhttp.open("GET","getitem.php?q1="+str,true);
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
		xmlhttp.open("GET","getitem.php?q2="+str,true);
		xmlhttp.send();
	  }
	}
	
	
	//Click QR code to copy and show snackbar
	function showSnackbar(m) {
		var copyText = m.innerHTML;
		document.getElementById("snackbar").innerHTML = "Copied : " + copyText;
	  var x = document.getElementById("snackbar");
	  x.className = "show";
	  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 1000);
	}

	function copyTextToClipboard(n) {
	  var copyText = n.innerHTML;
		//alert(copyText);
	  navigator.clipboard.writeText(copyText);
	}

	//upload image
	const input = document.querySelector('#fileToUpload');
    const preview = document.querySelector('.preview');
	
	input.style.opacity = 0;
	
	//input_edit.style.opacity = 0;

    input.addEventListener('change', updateImageDisplay);
	//input_edit.addEventListener('change', updateImageDisplay2);

    function updateImageDisplay() {
      while(preview.firstChild) {
        preview.removeChild(preview.firstChild);
      }

      const curFiles = input.files;
      if(curFiles.length === 0) {
        const para = document.createElement('p');
        para.textContent = 'No files currently selected for upload';
        preview.appendChild(para);
      } else {
        const list = document.createElement('ol');
        preview.appendChild(list);

        for(const file of curFiles) {
          const listItem = document.createElement('li');
          const para = document.createElement('p');
		  para.classList.add("<?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?>");
		  listItem.classList.add("<?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?>");
		  
          if(validFileType(file)) {
            para.textContent = `File name ${file.name}, file size ${returnFileSize(file.size)}.`;
            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);

            listItem.appendChild(image);
            listItem.appendChild(para);
          } else {
            para.textContent = `File name ${file.name}: Not a valid file type. Update your selection.`;
            listItem.appendChild(para);
          }

          list.appendChild(listItem);
        }
      }
    }
	
    function updateImageDisplay2() {
		
	  const input_edit = document.querySelector('#fileToUpload_edit');
	  const preview_edit = document.querySelector('.preview_edit');
	  
      while(preview_edit.firstChild) {
        preview_edit.removeChild(preview_edit.firstChild);
      }

      const curFiles = input_edit.files;
      if(curFiles.length === 0) {
        const para = document.createElement('p');
        para.textContent = 'No files currently selected for upload';
        preview_edit.appendChild(para);
      } else {
        const list = document.createElement('ol');
        preview_edit.appendChild(list);

        for(const file of curFiles) {
          const listItem = document.createElement('li');
          const para = document.createElement('p');
		  para.classList.add("<?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?>");
		  listItem.classList.add("<?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?>");

          if(validFileType(file)) {
            para.textContent = `File name ${file.name}, file size ${returnFileSize(file.size)}.`;
            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);

            listItem.appendChild(image);
            listItem.appendChild(para);
          } else {
            para.textContent = `File name ${file.name}: Not a valid file type. Update your selection.`;
            listItem.appendChild(para);
          }

          list.appendChild(listItem);
        }
      }
    }


    const fileTypes = [
        'image/png'
    ];

    function validFileType(file) {
      return fileTypes.includes(file.type);
    }

    function returnFileSize(number) {
      if(number < 1024) {
        return number + 'bytes';
      } else if(number > 1024 && number < 1048576) {
        return (number/1024).toFixed(1) + 'KB';
      } else if(number > 1048576) {
        return (number/1048576).toFixed(1) + 'MB';
      }
    }

	function varifyItemInfo(){ //itemName
		let original_itemName = $("#itemName").val();
		let clean_itemName = DOMPurify.sanitize($("#itemName").val());
		if(original_itemName.trim()==""){
			alert("invalid item name");
			return false;
		}else if(clean_itemName != original_itemName){
			alert("invalid item name");
			return false;
		}else{
			return true;
		}
	}
	
	function varifyEditItemInfo(){ //itemName
		let original_itemName = $("#itemName_edit").val();
		let clean_itemName = DOMPurify.sanitize($("#itemName_edit").val());
		if(original_itemName.trim()==""){
			alert("invalid item name");
			return false;
		}else if(clean_itemName != original_itemName){
			alert("invalid item name");
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