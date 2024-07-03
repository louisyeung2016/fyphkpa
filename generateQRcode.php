<?php 
include('permissionA.php');
include('timeout.php');
include('connection.php');
?>
<?php
include_once("./language/main_string.php");
include_once("./language/generateQRcode_string.php");
include_once("./config/config.php"); 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Control Panel - Generate QRcode</title>
	<link rel="icon" type="image/x-icon" href="./favicon/<?=$admin_favicon?>/favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/dashboard/">

    <script src="js/qrcode.js"></script>
	<script src="js/html5-qrcode.js"></script>

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

    .image-container {
      position: relative;
      display: inline-block;
    }
    .overlay {
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
    }
    .overlay-text {
      color: white;
      font-size: 24px;
    }
    .image-container:hover .overlay {
      opacity: 1;
      cursor: pointer;
    }

	/* Print-only styles */
    @media print {
      body * {
        visibility: hidden;
      }
      #qrcodeCart, #qrcodeCart * {
        visibility: visible;
      }
      #qrcodeCart {
        position: fixed;
        left: 0;
        top: 0;
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
	
  </head>
  <body onload="updateQRCode(document.getElementById('textField').value)">
    
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
		    <form name="QRform" id="QRform">
			<?php 
			if(isset($_SESSION['copied_qrcode'])){
				$copied_qrcode = $_SESSION['copied_qrcode'];
			}else{
				$copied_qrcode = "";
			}
			
			?>
			<?php echo $code[$lang]; ?> :  &emsp;
			<input type="text" id="textField" name="textField" value="<?php echo $copied_qrcode ?>" onkeyup='updateQRCode(this.value)' onclick="this.focus();this.select();">
			<br><br>
			<?php echo $size[$lang]; ?> :  &emsp;
			<input type="number" id="dotsize" name="dotsize" min="1" max="10" value="5" onchange="updateQRCode(document.getElementById('textField').value)" >
			<br><br>
			<?php echo $codeVer[$lang]; ?><span style="color:red;">*</span> :  &emsp;
			<input type="number" id="QRCodeVersion" name="QRCodeVersion" min="1" max="40" value="5" onchange="updateQRCode(document.getElementById('textField').value)">
			
			<br><br>
			<?php echo $errorCorr[$lang]; ?><span style="color:red;">*</span> :  &emsp;
			<select id="ECL" onchange="updateQRCode(document.getElementById('textField').value)">
			  <option value="1">5%</option>
			  <option value="0">15%</option>
			  <option value="3">25%</option>
			  <option value="2" selected="selected">30%</option>
			</select>
			<br><br>
			<p style="color:red;">*<?php echo $hint[$lang]; ?></p>
			</form>
			
			<hr class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "border-light"; }else{ echo "border-dark";} ?>">
			
			<p><?php echo $howPrint[$lang]; ?></p>
			1) <p style="color:red;"><?php echo $printStep1[$lang]; ?></p>
			
			
			<br><br>
			<!-- This is where our QRCode will appear in. -->
			<table style="border:1px solid ;"><tbody><tr><td>
			<div id="qrcode"></div>
			<button class="btn btn-primary" style="width: 100%;" onclick="appendText()"><?php echo $addToQRcodeCart[$lang]; ?></button>
			</td></tr></tbody></table>
			
			<br>
			
			<details open>
			  <summary>
				<h5 style="display:inline;"><?php echo $QRcodeCart[$lang]; ?> </h5> &emsp; 
				<button class="btn btn-info btn-sm" onclick="window.print()">
					<?php echo $printStep2[$lang]; ?> <i class="fa-solid fa-print"></i>
				</button>
			  </summary>
			  <div id="qrcodeCart" class="rounded p-3 m-2" style="border-style: solid; border-width: 1px;"></div>
			</details>
    </main>
  </div>
</div>

<?php 
unset($_SESSION["copied_qrcode"]);
?>

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
	
	function updateQRCode(text) {

		var element = document.getElementById("qrcode");

		var bodyElement = document.body;
		if(element.lastChild)
			element.replaceChild(showQRCode(text), element.lastChild);
		else
			element.appendChild(showQRCode(text));
    }

    updateQRCode('');

	function appendText() {
		var element = document.getElementById("qrcode");
		//element.attr('onclick', 'FunctionName(this);');
		//function myfunction(){alert("HAHA")};
		let str = element.innerHTML;
		/*
		let result = str.substring(str.indexOf("<img") + 4);
		console.log("before: "+result); 
		//console.log(element.innerHTML);
		result = "<img onclick='deleteQRcode(this)' " + result;
		console.log("after: "+result); 
		*/
		result = "<div onclick='deleteQRcode(this)' class=\"image-container\">" + str + "<div class=\"overlay\">"+"<div class=\"overlay-text\">&times;</div>"+"</div>"+"</div>";
		$("#qrcodeCart").append(result);
	}
	
	function sayHello(){
		alert("Hello");
	}
	
	function deleteQRcode(x){
		$(x).hide("slow", function(){ $(this).remove(); });
	}
</script>