<?php
include('permissionS.php');
include('timeout.php');
include('connection.php');
include('returnProcessing.php');
$newobj = new returnProcessing();
?>
<?php 
include_once("./language/main_string.php"); 
include_once("./language/return_string.php"); 
include_once("./config/config.php"); 
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Return Item</title>
  <link rel="icon" type="image/x-icon" href="./favicon/<?=$staff_favicon?>/favicon.ico">
  <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/dashboard/">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;800&family=Rubik+Dirt&display=swap" rel="stylesheet">

  <!-- for return php Ajax -->
  <script src="js/jquery.min.js"></script>

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
      </main>
    </div>
  </div>

  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
    <form action="" method="POST" id="returnForm">
	  <input type="password" id="rfid" style="opacity: 0.3;width: 100px;height: 20px;" placeholder="Tap room key RFID here" pattern="^[0-9]{10}$" onchange="getRoomNumberFromRFID(this.value);" autofocus>
      </br>
      <?php echo $Room_Num[$lang]; ?>: &emsp;
      <select id="roomNum" name="roomNum">
        <option value="">Select</option>
        <?php 
        $sqlroom = "SELECT DISTINCT room_number FROM `rental_record` WHERE status = 'borrow';";
        $rsr = mysqli_query($conn,$sqlroom);
        while($rowRoom = mysqli_fetch_array($rsr)){
        ?>
        <option value="<?php echo $rowRoom['room_number'];?>"><?php echo $rowRoom['room_number'];?></option>
        <?php } ?>
      </select>
      <input type="submit" name="number" value="<?php echo $button3[$lang]; ?>" class="choose">
    </form>
    <?php
      if (isset($_POST['roomNum'])) {
        $_SESSION['roomNum'] = $_POST['roomNum'];
      }
      mysqli_close($conn);
    ?>
    </br></br></br>
    <table id="my_table" class="table table-striped table-sm rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo "table-light";} ?>" width="100%">
      <thead>
        <tr>
		  <th></th>
          <th><?php echo $table_Title1[$lang]; ?></th>
          <th><?php echo $table_Title2[$lang]; ?></th>
          <th><?php echo $table_Title3[$lang]; ?></th>
          <th><?php echo $table_Title4[$lang]; ?></th>
          <th><?php echo $table_Title5[$lang]; ?></th>
          <th><?php echo $table_Title6[$lang]; ?></th>
          <th><?php echo $table_Title7[$lang]; ?></th>
          <th><?php echo $table_Title8[$lang]; ?></th>
          <th><?php echo $table_Title9[$lang]; ?></th>
          <th><?php echo $table_Title10[$lang]; ?></th>
        </tr>
      </thead>
      <?php echo $newobj->display();?>
  </table>
  <script>
        $(document).ready(function(){
            $(".selectstatus").change(function(){
                var statusname = $(this).val();                  
                var getid = $(this).attr("status-id");  
                var item = $(this).attr("status-item");
				var itemid = $(this).attr("status-item-id");
                var price = $(this).attr("status-price");
                $.ajax({
                    type:'POST',
                    url:'returnAjax.php',
                    data:{statusname:statusname,getid
                    :getid,item:item,itemid:itemid,price:price},
                    success:function(result){
                        $("#display_" + getid).html(result);
                    }
                });
            });
        });
    </script>
  </main>
  </div>
  </div>
  </div>

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

  </script>
  <script>
    <?php 
	if(isset($_SESSION['roomNum'])){
    ?>
    document.getElementById('roomNum').value = "<?php echo $_SESSION['roomNum']; ?>"<?php 
    }?>;
  </script>
  
  <script>
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
					//$("#roomNum").val(result);
					//send result to 
					document.getElementById('roomNum').value = result;
					document.getElementById('returnForm').submit();
				}
			}
		);
		
	}
  </script>

</body>

</html>