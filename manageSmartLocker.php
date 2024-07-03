<?php 
include('permissionA.php');
include('timeout.php');
include('connection.php');
?>
<?php
include_once("./language/main_string.php");
include_once("./language/manageSmartLocker_string.php");
include_once("./config/config.php"); 
?>

<?php
//get all borrowable items from Database
$sql = "SELECT item_name, item_id FROM rental_item_category WHERE item_status = 'Active' AND NOT item_name LIKE '%Key'";
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

//get items which being in Locker now from Database
$sql1 = "SELECT locker_record.item_id, rental_item_category.item_name FROM `locker_record` INNER JOIN `rental_item_category` ON locker_record.item_id = rental_item_category.item_id WHERE locker_record.status = 'placed' AND locker_record.locker_number = 1 LIMIT 1 ";
$rs1 = mysqli_query($conn, $sql1) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc1 = mysqli_fetch_assoc($rs1);

$lockerOne_itemID = "000";
$lockerOne_itemName = "No item Placed";

if(mysqli_num_rows($rs1) > 0){
	$lockerOne_itemID = $rc1['item_id'];
	$lockerOne_itemName = $rc1['item_name'];
}

$sql2 = "SELECT locker_record.item_id, rental_item_category.item_name FROM `locker_record` INNER JOIN `rental_item_category` ON locker_record.item_id = rental_item_category.item_id WHERE locker_record.status = 'placed' AND locker_record.locker_number = 2 LIMIT 1 ";
$rs2 = mysqli_query($conn, $sql2) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc2 = mysqli_fetch_assoc($rs2);

$lockerTwo_itemID = "000";
$lockerTwo_itemName = "No item Placed";

if(mysqli_num_rows($rs2) > 0){
	$lockerTwo_itemID = $rc2['item_id'];
	$lockerTwo_itemName = $rc2['item_name'];
}

$sql3 = "SELECT locker_record.item_id, rental_item_category.item_name FROM `locker_record` INNER JOIN `rental_item_category` ON locker_record.item_id = rental_item_category.item_id WHERE locker_record.status = 'placed' AND locker_record.locker_number = 3 LIMIT 1 ";
$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc3 = mysqli_fetch_assoc($rs3);

$lockerThree_itemID = "000";
$lockerThree_itemName = "No item Placed";

if(mysqli_num_rows($rs3) > 0){
	$lockerThree_itemID = $rc3['item_id'];
	$lockerThree_itemName = $rc3['item_name'];
}



$sql4 = "SELECT locker_record.item_id, rental_item_category.item_name FROM `locker_record` INNER JOIN `rental_item_category` ON locker_record.item_id = rental_item_category.item_id WHERE locker_record.status = 'placed' AND locker_record.locker_number = 4 LIMIT 1 ";
$rs4 = mysqli_query($conn, $sql4) //mysqli_query() function performs a query against a database.
  or die(mysqli_error($conn));

$rc4 = mysqli_fetch_assoc($rs4);

$lockerFour_itemID = "000";
$lockerFour_itemName = "No item Placed";

if(mysqli_num_rows($rs4) > 0){
	$lockerFour_itemID = $rc4['item_id'];
	$lockerFour_itemName = $rc4['item_name'];
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Manage Smart Locker</title>
	<link rel="icon" type="image/x-icon" href="./favicon/<?=$staff_favicon?>/favicon.ico">
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
		include_once ("./template/sidebar.php");
		echo $sidebar_str;
	?>	

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
		<h2 class="rh2"><?php echo $list_name_title[$lang]; ?> </h2>
		
		<div class="container bg-secondary mx-md-0 mx-sm-3" >
		  
		  <div class="row ">
		    <!--Fill in and submit form-->
		    <div class="col-lg-auto col-md <?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?> m-1 py-1">
					<div class="tab <?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?>" style="min-width: 420px;">
					  <button class="tablinks" onclick="openTab(event, 'PlaceItemInLocker')" id="defaultOpen"><?php echo $placeItemInLocker[$lang]; ?></button>
					</div>
					
					
					<div id="PlaceItemInLocker" class="tabcontent" style="min-width: 420px;">
					  
					  <form action="./updateSmartLocker.php" method="post" enctype="multipart/form-data">
						
						<?php echo $lockerNumber[$lang]; ?>: &emsp;
						<select id="lockerNum" name="lockerNum">
						  <option value="1"> No.1 </option>
						  <option value="2"> No.2 </option>
						  <option value="3"> No.3 </option>
						  <option value="4"> No.4 </option>
						</select>
						</br></br>
						
						<?php echo $selectItem[$lang]; ?>: &emsp;
						<input type="hidden" id="hidden_input" name="hidden_input">
						<input list="itemNames" name="itemName" id="itemName" class="form-control" required />
						<datalist id="itemNames">
							<?php
							if(mysqli_num_rows($rs) > 0){
							//$rs = mysqli_query($conn,$sql);
							do{
							?>
							
							<option data-value="<?php echo $rc['item_id']?>" label="<?php echo $rc['item_id']?>"><?php echo $rc['item_name']?></option>
							<?php 
							}while($rc = mysqli_fetch_array($rs));
							}else{
								//nothing
							}
							?>
						</datalist>
						</br></br>
						
						<span id="select_message"></span>
						<br>
						<img id="item_pic" src="image/000.png" onerror="this.onerror=null; this.src='image/000.png'" alt="item picture is not yet be uploaded" title="this is the image" class="img-thumbnail rounded mx-auto d-block">
						<br>
						
						<input type="submit" class="btn btn-primary" value="<?php echo $btn_confirm[$lang]; ?>">

					  </form>
					</div>	
			</div>
			
			<!--Image of Smart Locker-->
			<div class="col-lg col-sm-12 <?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?> m-lg-1 m-md-0">
					<?php //echo $pic[$lang]; ?>
					<div class="row m-3">
						<table class="table">
						
							<tbody>
								<tr>
									<td class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "text-light"; }else{ echo "text-dark";} ?>">
										<?php echo $lockerNumber1[$lang]; ?> : <?php echo $lockerOne_itemName; ?> (<?php echo $lockerOne_itemID; ?>)
										<img id="item_pic" src="image/<?php echo $lockerOne_itemID; ?>.png" onerror="this.onerror=null; this.src='image/000.png'" alt="item picture is not yet be uploaded" title="this is the image" class="img-thumbnail rounded mx-auto d-block">
									</td>
									<td class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "text-light"; }else{ echo "text-dark";} ?>">
										<?php echo $lockerNumber2[$lang]; ?> : <?php echo $lockerTwo_itemName; ?> (<?php echo $lockerTwo_itemID; ?>)
										<img id="item_pic" src="image/<?php echo $lockerTwo_itemID; ?>.png" onerror="this.onerror=null; this.src='image/000.png'" alt="item picture is not yet be uploaded" title="this is the image" class="img-thumbnail rounded mx-auto d-block">
									</td>
								</tr>
								<tr>
									<td class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "text-light"; }else{ echo "text-dark";} ?>">
										<?php echo $lockerNumber3[$lang]; ?> : <?php echo $lockerThree_itemName; ?> (<?php echo $lockerThree_itemID; ?>)
										<img id="item_pic" src="image/<?php echo $lockerThree_itemID; ?>.png" onerror="this.onerror=null; this.src='image/000.png'" alt="item picture is not yet be uploaded" title="this is the image" class="img-thumbnail rounded mx-auto d-block">
									</td>
									<td class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "text-light"; }else{ echo "text-dark";} ?>">
										<?php echo $lockerNumber4[$lang]; ?> : <?php echo $lockerFour_itemName; ?> (<?php echo $lockerFour_itemID; ?>)
										<img id="item_pic" src="image/<?php echo $lockerFour_itemID; ?>.png" onerror="this.onerror=null; this.src='image/000.png'" alt="item picture is not yet be uploaded" title="this is the image" class="img-thumbnail rounded mx-auto d-block">
									</td>
								</tr>
							</tbody>
						</table>
					
					</div>
			</div>
		  </div>
		  
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
  
	//datalist to show item picture
	$('#itemName').on("change keydown paste input",function(){
	  const val = verifiDatalist('itemName');
	  if(val!==false){
		$('#hidden_input').val(val);
		$('#select_message').css('color', '#328c32').text('Choose item：'+ $('#hidden_input').val());
		$('#item_pic').attr("src", "image/" + $('#hidden_input').val() + ".png");
	  }else{
		$('#hidden_input').val('');
		$('#select_message').css('color', 'red').text('item not found');
		$('#item_pic').attr("src", "image/000.png");
	  }
	});


	function verifiDatalist(inputId){
	  const $input = $('#'+inputId),
			$options = $('#' + $input.attr('list') + ' option'),
			inputVal = $input.val();
	  let verification = false;
	  for(let i = 0; i < $options.length; i++) {
		const $option = $options.eq(i),
			  dataVal = $option.data('value'),
			  showWord = $option.text(),
			  val =  $option.val();
		if(showWord == inputVal){
		  verification = dataVal;
		}
	  }
	  return verification;
	}
</script>
<?php

mysqli_free_result($rs); 
mysqli_free_result($rs1); 
mysqli_free_result($rs2); 
mysqli_free_result($rs3); 
mysqli_free_result($rs4); 
mysqli_close($conn);

?>