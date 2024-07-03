<?php 
include('permissionS.php');
include('timeout.php');
include('connection.php');
?>
<?php 
include_once("./language/main_string.php"); 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Resident Infomation</title>

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
	  
	  .hidden{
		  display: none;
	  }
	  .show{
		  display: block;
	  }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="dashboard/css/dashboard.css" rel="stylesheet">
	<script src="./js/sidebar.js"></script>
	<script src="./js/showTime.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	
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
	  <span class="nav-link" style="display:inline;"><?php echo $_SESSION["staffName"]; ?></span>
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
		<h2 class="rh2">Fill in Resident Information</h2>
		
		<div class="bg-light min-vw-50 p-3 m-2 border  border-0 rounded" style="width: 550px;">
			<form action="uploadResidentInfoToDB.php" method="post" onsubmit="return checkDate();">
			 <fieldset class="form-group border p-3">
			  <legend class="w-auto px-2">Room</legend>
			  <label>Room Number :   &emsp;</label>
				  <select name="roomNum" class="form-control" >
					<?php 
					$sql6 = "SELECT room_key.room_number FROM `room_key` LEFT JOIN `resident_info` ON room_key.room_number = resident_info.room_number AND resident_info.checkin_status = 'occupying' WHERE resident_info.room_number IS NULL"; //only show non-occupied room number
					$rs = mysqli_query($conn,$sql6);
					while($rowR = mysqli_fetch_array($rs)){
					?>
					<option value="<?php echo $rowR['room_number'];?>"><?php echo $rowR['room_number'];?></option>
					<?php } ?>
				  </select>
			  <br><br>
			  <label for="organization">Organization :   &emsp;</label>
			  <input type="text" id="organization" name="organization" class="form-control" required ><br><br>
			  
			 </fieldset>
			 
			 <fieldset class="form-group border p-3">
			  <legend class="w-auto px-2">Date & Time</legend>
			  
			  <label for="checkin_date">Check-in Date :   &emsp;</label>
			  <input type="date" id="checkin_date" name="checkin_date" class="form-control" required><br><br>
			  
			  <label for="checkin_time">Check-in Time :   &emsp;</label>
			  <input type="time" id="checkin_time" name="checkin_time" class="form-control" required><br><br>
			  
			  <label for="checkout_date">Check-out Date :   &emsp;</label>
			  <span id="tips"></span>
			  <input type="date" id="checkout_date" name="checkout_date" class="form-control" required><br><br>
			  
			  
			  <label for="checkout_time">Check-out Time :   &emsp;</label>
			  <input type="time" id="checkout_time" name="checkout_time" class="form-control" required><br><br>
			  
			 </fieldset>
			 <fieldset class="form-group border p-3">
			  <legend class="w-auto px-2">Payment</legend>
			  
			  <label for="payment_status">Payment Status :   &emsp;</label>
			    <select class="form-control" id="payment_status" name="payment_status">
				  <option selected >Full Paid</option>
				  <option >Partial Paid</option>
				  <option >Not Paid</option>
				</select>
			  <br><br>
			  
			  <div class="" id="pOutstandingBalance">
			  <label for="outstanding_balance">Outstanding Balance (HKD$) :   &emsp;</label>
				<input type="number" id="outstanding_balance" name="outstanding_balance" class="form-control" min="0.00" max="10000.00" step="0.01" value="0.00" required /><br><br>
			  </div>
			 </fieldset>
			 
			 <input type="submit" class="btn btn-primary" value="Submit">
			 &emsp;
			 <input type="reset" class="btn btn-secondary" value="Re-set">
			 
			</form>
			
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
		$site = str_replace('/project/','',$_SERVER['PHP_SELF']);
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

	
	//compare date
	function checkDate(){
		var checkin_date = document.getElementById("checkin_date").value;
		var checkout_date = document.getElementById("checkout_date").value;
		var d1 = new Date(checkin_date);
		var d2 = new Date(checkout_date);
		
		if(d1 >= d2){
			//alert("wrong");
			document.getElementById("tips").innerHTML = "<span style=\"color:red\">check-out date cannot set before check-in date</span>";
			return false;
		}else{
			//alert("right");
			return true;
		}
		//alert(d2);
		
	}
	
	$(document).ready(function(){
		$('#pOutstandingBalance').addClass("hidden");
		$('#payment_status').change(function(){
			var status = $(this).val();
			if(status =="Full Paid"){
				$('#pOutstandingBalance').removeClass("show");
				$('#pOutstandingBalance').addClass("hidden");
				$("#outstanding_balance").val(0.00);
				console.log($("#outstanding_balance").val());
			}else{
				$('#pOutstandingBalance').removeClass("hidden");
				$('#pOutstandingBalance').addClass("show");
			}
		});
	});
	
</script>