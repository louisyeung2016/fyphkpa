<?php 
include('permissionS.php');
include('timeout.php');
include('connection.php');
?>
<?php 
include_once("./language/main_string.php"); 
include_once("./language/borrow_string.php"); 
include_once("./config/config.php"); 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Borrow Item</title>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
	<script type="text/javascript" src="js/DOMPurify-main/dist/purify.min.js"></script>
	
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
		
		
		
		
		

	  
	  <hr>
	  <!--user must fill in the above information about room number first to unlock the below borrow function-->
	  
	  <?php
	  if(isset($_SESSION['room_Num'])){
		  ?>
			<table style="width:100%">
			  <tr>
				<th style="width:10%"><?php echo $Room_Num[$lang]; ?> : </th>
				<td><?php echo $_SESSION["room_Num"] ?></td>
			  </tr>
			  <tr>
				<th><?php echo $Organization[$lang]; ?> : </th>
				<td><?php echo $_SESSION["organization"] ?></td>
			  </tr>
			  <tr>
				<th><?php echo $Representative[$lang]; ?> : </th>
				<td><?php echo $_SESSION["representative"] ?></td>
			  </tr>
			  <tr>
				<th><?php echo $list_name_title[$lang]; ?> : </th>
				<td><?php echo $_SESSION["contact_number"] ?></td>
			  </tr>
			  <tr style="height:70px">
				<th>
					<form action="clearRoomNumToSession.php" method="post" style="display:inline;">
						<input type="submit" value="&#8635; <?php echo $button5[$lang]; ?>" class="btn btn-outline-danger"> <!--also clear session['room_Num']-->
					</form>
				</th>
				<td></td>
			  </tr>
			</table>
		  
		  
		  
		  <br><br>
			<div class="row">
			<div class="col-md-12 col-lg-6 rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?> border-right py-2" >
			<!--Manual input item-->
				<h5><?php echo $man_input[$lang]; ?></h5>
				  <form action="borrow.php" method="post" onsubmit="varifyItem()">
					  </br>
					  <?php echo $item_name[$lang]; ?>:  &emsp;
					  <input type="hidden" id="hidden_input">
					  <input list="itemNames" name="itemName" id="itemName" class="form-control" required />
						<datalist id="itemNames">
							<?php
							$sql3 = "SELECT item_name, item_id FROM rental_item_category WHERE item_status = 'Active' AND NOT item_name LIKE '%Key'";
							$rs9 = mysqli_query($conn,$sql3);
							while($rowt = mysqli_fetch_array($rs9)){
							?>
							
							<option data-value="<?php echo $rowt['item_id']?>" label="<?php echo $rowt['item_id']?>"><?php echo $rowt['item_name']?></option>
							<?php } ?>
						</datalist>
						
					  <input type="submit" value="ADD" class="btn btn-outline-success btn-lg btn-block btn-sm">
				  </form>
				  <br>
				  
				  <span id="select_message"></span>
				  <br>
				  <img id="item_pic" src="image/000.png" onerror="this.onerror=null; this.src='image/000.png'" alt="item picture is not yet be uploaded" title="this is the image" class="img-thumbnail rounded mx-auto d-block">
				  <br>
			</div>
			<div class="col-md-12 col-lg-6 rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?> border-left py-2" id="QRcodeFunction">
			<!--Scan QRcode input item-->
				<h5><?php echo $QRcode[$lang]; ?>:</h5>
				
				<div id="reader" class="bg-warning text-center" style="width: 380px;"></div>
				<form action="borrow.php" method="post" id="scanQRcodeForm">
					
					<input type="text" name="itemCode" id="itemCode"  placeholder="scan qrcode" class="form-control" style="width:380px;" autofocus>
				</form>
			</div>
			</div>
			  <!--run the code after user click ADD button-->
			  <!--select the item ID from database first, to check the itemID exist or not-->
			  <?php
			  
			  if(isset($_POST['itemName'])){
				//run SQL to SELECT * FROM rental_item WHERE item_id = $_GET['itemid']
						
				$itemName = $_POST['itemName'];
				
					
				$sql = "SELECT * FROM rental_item_category WHERE item_name = '$itemName' AND item_status = 'Active'"; //write the SQL statement
				$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
					  or die(mysqli_error($conn));
				
				$rc = mysqli_fetch_assoc($rs);
				
				if(mysqli_num_rows($rs) > 0){ //item exists
					//echo "HEHE" ;
					
					$item_name = $rc['item_name'];
					$item_qty = $rc['qty'];
					$itemID = $rc['item_id'];
					
					//add to item cart
					
					$itemArray = array();
					array_push($itemArray, $itemID, $item_name, $item_qty);
					
					//check whether $_SESSION["itemArray"] exist or not, if no-->create it; if yes, do nothing
					if(isset($_SESSION["itemArray"])){
						
					}else{
						$_SESSION["itemArray"] = array();
					}
					
					array_push($_SESSION["itemArray"], $itemArray);
					
					//print_r($_SESSION["itemArray"]);
					//unset($_SESSION["itemArray"]);
					
				}else{ //item not found
					echo "<script>alert(\"not found\")</script>" ;
				}
				
				//free the memory
				//mysqli_free_result($rs3); 
				mysqli_close($conn);
				
			  }
			  //print_r($_SESSION["itemArray"]);
			  ?>
			  
			  <?php
			  if(isset($_POST['itemCode'])){
				  $itemCode =$_POST['itemCode'];
				  
				  $sql2 = "SELECT * FROM rental_item_category WHERE QRcode = '$itemCode' AND item_status = 'Active'"; //write the SQL statement
				  $rs2 = mysqli_query($conn, $sql2) //mysqli_query() function performs a query against a database.
						or die(mysqli_error($conn));
					
				  $rc2 = mysqli_fetch_assoc($rs2);
				  
					if(mysqli_num_rows($rs2) > 0){ //item exists
						//echo "HEHE" ;
						
						$item_name = $rc2['item_name'];
						$item_qty = $rc2['qty'];
						$itemID = $rc2['item_id'];
						
						//add to item cart
						
						$itemArray = array();
						array_push($itemArray, $itemID, $item_name, $item_qty);
						
						//check whether $_SESSION["itemArray"] exist or not, if no-->create it; if yes, do nothing
						if(isset($_SESSION["itemArray"])){
							
						}else{
							$_SESSION["itemArray"] = array();
						}
						
						array_push($_SESSION["itemArray"], $itemArray);
						
						//print_r($_SESSION["itemArray"]);
						//unset($_SESSION["itemArray"]);
						
					}else{ //item not found
						echo "<script>alert(\"not found\")</script>" ;
					}
					
					//free the memory
					//mysqli_free_result($rs3); 
					mysqli_close($conn);
			  }
			  
			  ?>
			  
			  </br></br>
			  
			  
				  <h2><?php echo $table_name[$lang]; ?></h2>
				  <div class="table-responsive">
					<table class="table table-striped table-sm <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo "table-light";} ?>">
					  <thead>
						<tr>
						  <th><?php echo $table_Title1[$lang]; ?></th>
						  <th><?php echo $table_Title2[$lang]; ?></th>
						  <th><?php echo $table_Title3[$lang]; ?></th>
						  <th><?php echo $table_Title4[$lang]; ?></th>
						</tr>
					  </thead>
					  <tbody>
					  
						<?php
						if(isset($_SESSION["itemArray"])){
							foreach($_SESSION["itemArray"] AS $key => $value) {
								//echo $key;
								//echo $value;
								echo "<tr>";
								foreach($value AS $x => $y) {
									//echo $x;
									echo "<td>";
									echo  $y;
									echo "</td>";
								}
								?>
								<td>
								<form action="clearItem.php" method="post">
									<input type="hidden" id="code" name="code" value="<?php echo $key ?>">
									<button type="submit" class="btn btn-sm btn-dark">DELETE <i class="fa fa-trash-o"></i></button>
								</form>
								</td></tr>
								<?php
							}
						}else{
							
						}
						
						
						?>			
				
					  </tbody>
					</table>
				  </div>
				  <div class="form-row">
					<div class="col">
					  <form method="post" action="uploadBorrowItemToDB.php" style="display:inline;"> <!--send to a php file to handle uploading record to DB-->
						<button type="submit" class="btn btn-primary"/> <?php echo $button1[$lang]; ?> <i class="fa fa-send-o"></i></button>
					  </form>
					</div>
					<div class="col">
					  <form method="post" action="clearItemListSession.php" style="display:inline;">
						<button type="submit" class="btn btn-danger" style="position:absolute;right:20px;"/><?php echo $button2[$lang]; ?>  <i class="fa fa-refresh"></i></button>
					  </form>
					</div>
					
				  </div>
				  
				  &emsp; 
				  
		  <?php
	  }else{
		  //echo "please choose room number first";
		  ?>
		  
		<form action="saveRoomNumToSession.php" method="post" style="display:inline;" onsubmit="varifyBorrowerInfo()">
			  </br>
			  <?php echo $Room_Num[$lang]; ?> : &emsp;
				<input type="password" id="rfid" style="opacity: 0.3;width: 100px;height: 20px;" placeholder="Tap room key RFID here" pattern="^[0-9]{10}$" onchange="getRoomNumberFromRFID(this.value);" autofocus>
				<input type="text" placeholder="Please select room number" class="form-control" list="roomNumList" name="roomNum" id="roomNum" pattern="[ABCDEZ][0-2][0-9]" title="Please enter correct Room Number" onblur="getResidentInfo(this.value);" required>
				<datalist id="roomNumList">
					<?php
					$sql6 = "SELECT room_number FROM `room_booking` WHERE status = 'occupying'"; //only show the occupied room
					$rs = mysqli_query($conn,$sql6);
					if (mysqli_num_rows($rs) > 0) {
						while($rowR = mysqli_fetch_array($rs)){
							$roomNum = $rowR['room_number'];
							$sql7 = "SELECT room_RFID FROM `room_category` WHERE room_number = '$roomNum'";
							$rs7 = mysqli_query($conn,$sql7);
							while($rc7 = mysqli_fetch_array($rs7)){
								$roomRFID = $rc7['room_RFID'];
							}
							
							echo "<option value='$roomNum'> $roomRFID </option>";
						}
					}else{
						//no rooms
					}
					?>
				</datalist>
				
			  </br></br>
			  <?php echo $Organization[$lang]; ?>  :   &emsp;
			  <input type="text" class="form-control" id="organization" name="organization" placeholder="organization name" required >
			  </br></br>
			  <?php echo $Representative[$lang]; ?>  :   &emsp;
			  <input type="text" class="form-control" id="representative" name="representative" placeholder="representative name" required >
			  </br></br>
			  <?php echo $Contact_num[$lang]; ?>  :   &emsp;
			  <input type="tel" class="form-control" id="contact_number" name="contact_number" placeholder="12345678" pattern="[0-9]{8}" title="Must 8 digits" required >
			  </br>
			  <br>
			  <button type="submit" class="btn btn-primary"> <?php echo $button3[$lang]; ?> <i class="fa fa-arrow-circle-right"></i> </button>
			  
		</form>
	  
		
		<form action="clearRoomNumToSession.php" method="post" style="display:inline;">
			<input type="submit" value="<?php echo $button4[$lang]; ?> &#8635;" class="btn btn-danger" style="position:absolute;right:20px;"> <!--also clear session['room_Num']-->
		</form>
		  
		  <?php
	  }
	  ?>
	  
	  
		  
		  
    </main>
  </div>
</div>

<br>

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

//QRcode scanner





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

/*
function testFunction(){
	alert(document.getElementById('itemName').value);
}
*/


//Hide the QRcode Scanner while using iPad
/*
$(window).on('resize', function(){
    var win = $(this); //this = window
    if (win.width() > 767) { 
		$("#QRcodeFunction").show();
	}else{
		$("#QRcodeFunction").hide();
	}
});
*/

function getRoomNumberFromRFID(rfid){
	//sanitize the RFID first
	$.post(
		"./controller/controller_getRoomNumberFromRFID.php", 
		{RFID: rfid}, 
		function(result){
			if(result==0){ //fail
				console.log("invalid RFID: "+rfid);
				$("#rfid").val("");
			}else{ //success
				result = result.trim();
				//alert(result);
				console.log(result);
				$("#rfid").val("");
				$("#roomNum").val(result);
			}
		}
	);
	
}



function getResidentInfo(roomNum){
	//sanitize the roomNum first
	
	$.post(
		"./controller/controller_getResidentInfo.php", 
		{roomNumber: roomNum}, 
		function(result){
			if(result==0){ //fail
				alert("Invalid room number");
				$("#roomNum").val("");
			}else{ //success
				//alert(result);
				console.log(result);
				const result_obj = JSON.parse(result);
				$("#organization").val(result_obj.organization_name);
				$("#representative").val(result_obj.representative_name);
				$("#contact_number").val(result_obj.contact_number);
			}
		}
	);
}

$(document).ready(function(){
	$("#rfid").focus(function(){
		$("#roomNum").val("");
	});
});


function varifyBorrowerInfo(){
	
	let clean_organization = DOMPurify.sanitize($("#organization").val());
	if(clean_organization == ""){
		$("#organization").val("N/A");
	}else{
		$("#organization").val(clean_organization);
	}
	
	let clean_representative = DOMPurify.sanitize($("#representative").val());
	if(clean_representative == ""){
		$("#representative").val("N/A");
	}else{
		$("#representative").val(clean_representative);
	}
	
}

function varifyItem(){ //itemName
	let clean_itemName = DOMPurify.sanitize($("#itemName").val());
	if(clean_itemName == ""){
		$("#itemName").val("N/A");
	}else{
		$("#itemName").val(clean_itemName);
	}
}


//Html5QrcodeScanner

  const scanner = new Html5QrcodeScanner('reader', {
	qrbox: {
	  width: 250,
	  height: 250,
	},
	fps: 5,
  });
  scanner.render(success, error);

  function success(result) {
	console.log("Code: "+result);
	let clean_QRCode_result = DOMPurify.sanitize(result);
	document.getElementById('itemCode').value = clean_QRCode_result;
	//document.getElementById('result').innerHTML = result;
	//scanner.clear();
	//document.getElementById('reader').remove();
	document.getElementById("scanQRcodeForm").submit();
  }

  function error(err) {
	//console.error(err);
  }

</script>