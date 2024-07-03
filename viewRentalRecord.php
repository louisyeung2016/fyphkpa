<?php 
include('permissionS.php');
include('timeout.php');

require_once("connection.php"); //require_once() = used to embed PHP code from another file
    $sql = "SELECT rental_id, item_name, rental_item_category.item_id, room_number, organization_name, representative_name, contact_number,  borrow_date, borrow_time, borrow_staff_id, status 
            FROM rental_record, rental_item_category WHERE rental_record.item_id = rental_item_category.item_id AND status = 'borrow' ORDER BY borrow_date, borrow_time"; //SELECT * to show in Product List
    $rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
          or die(mysqli_error($conn));
    //$rs : stands for $result


	$rc = mysqli_fetch_assoc($rs);
	$num_of_row = mysqli_num_rows($rs);

?>
<?php 
include_once("./language/main_string.php"); 
include_once("./language/viewRentalRecord_string.php"); 
include_once("./config/config.php"); 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>View Rental Record</title>
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
	  
	  /*search function*/
	  
	  #searchKeyword {
		  width: 50%;
		  font-size: 16px;
		  padding: 12px 20px 12px 20px;
		  border: 1px solid #ddd;
		  margin-bottom: 12px;
		}
	
	  #searchBy {
		  font-size: 16px;
		  padding: 12px 20px 12px 10px;
		  border: 1px solid #ddd;
		  margin-bottom: 12px;
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
	  <span class="return-alarm" title="item return alarm"><i class="fa-regular fa-bell"></i> 2</span>
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
		<br>
		<select name="searchBy" id="searchBy" >
			<option value="rentalid"><?php echo $table_Title1[$lang]; ?></option>
			<option value="itemname"><?php echo $table_Title2[$lang]; ?></option>
			<option value="room"><?php echo $table_Title3[$lang]; ?></option>
			<option value="group"><?php echo $table_Title4[$lang]; ?></option>
			<option value="group"><?php echo $table_Title5[$lang]; ?></option>
			<option value="group"><?php echo $table_Title6[$lang]; ?></option>
			<option value="borrowdate"><?php echo $table_Title7[$lang]; ?></option>
			<option value="borrowtime"><?php echo $table_Title8[$lang]; ?></option>
			<option value="staff"><?php echo $table_Title9[$lang]; ?></option>
		</select>
		<input type="text" id="searchKeyword" onkeyup="searchTable()" placeholder="Keyword" title="Type in a keyword">
		
		
		
		<div class="table-responsive">
			<table class="table table-striped table-sm rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo "table-light";} ?>" id="myTable">
			  <thead>
				<tr class="header">
				  
				  <th onclick="sortTable(0)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title1[$lang]; ?></th>
				  <th onclick="sortTable(1)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title2[$lang]; ?></th>
				  <th onclick="sortTable(2)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title3[$lang]; ?></th>
				  <th onclick="sortTable(3)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title4[$lang]; ?></th>
				  <th onclick="sortTable(3)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title5[$lang]; ?></th>
				  <th onclick="sortTable(3)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title6[$lang]; ?></th>
				  <th onclick="sortTable(4)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title7[$lang]; ?></th>
				  <th onclick="sortTable(5)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title8[$lang]; ?></th>
				  <th onclick="sortTable(6)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title9[$lang]; ?></th>
				  
				</tr>
			  </thead>
			  <tbody>
				<?php
				
					echo "Number of record found : <b>".$num_of_row."</b>";
					
					if($num_of_row>0){
					do { 
						$rentalID = $rc['rental_id'];
						$item_name = $rc['item_name'];
						$item_id = $rc['item_id']; //no need to use here
						$room_number = $rc['room_number'];
						$apply_group = $rc['organization_name'];
						$representative = $rc['representative_name'];
						$contact_number = $rc['contact_number'];
						$borrow_date = $rc['borrow_date'];
						$borrow_time = $rc['borrow_time'];
						$staff = $rc['borrow_staff_id'];
						$status = $rc['status']; //no need to use here
						
						?>
						
						<tr>
							<td><?php echo $rentalID;?></td>
							<td><?php echo $item_name;?></td>
							<td><?php echo $room_number;?></td>
							<td><?php echo $apply_group;?></td>
							<td><?php echo $representative;?></td>
							<td><?php echo $contact_number;?></td>
							<td><?php echo $borrow_date;?></td>
							<td><?php echo $borrow_time;?></td>
							<td><?php echo $staff;?></td>
							
							
						</tr>
						
						
						
						
						<?php
						
						
					}while($rc = mysqli_fetch_assoc($rs)); 
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