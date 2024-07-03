<?php 
include('permissionS.php');
include('timeout.php');
include('connection.php');
?>
<?php 
include_once("./language/main_string.php");
include_once("./language/sellDrink_string.php");
include_once("./config/config.php"); 
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sell Drinks</title>
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
	  
	.pointer {cursor: pointer;}
	.not-allowed {cursor: not-allowed;}

	#closeX:hover {
	  color: red;
	}

	.shrink div {
		transition: 1s ease;
	}

	.shrink div:hover{
		-webkit-transform: scale(0.9);
		-ms-transform: scale(0.9);
		transform: scale(0.9);
		transition: 1s ease;
	}

	.overlay {
	  position: absolute;
		
	  height: 100%;
	  width: 100%;
	  opacity: 0.5;
	  color: white;
	  background-color: #000000;
	  text-align: center;
	  font-size: 30px;
	  line-height: 200px;
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
	$pic_bg_color = "bg-light";
	if($_SESSION['themeColorIndex'] == 0){ //Day mode
		$pic_bg_color = "bg-light";
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}else if($_SESSION['themeColorIndex'] == 1){ //Night mode
		$pic_bg_color = "bg-sidebar-dark";
		echo "<link href=\"dashboard/css/dashboard_dark.css\" rel=\"stylesheet\">";
	}else{
		$pic_bg_color = "bg-light";
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}
	?>

	<!-- Javascript -->

	<script src="./js/sidebar.js"></script>
	<script src="./js/showTime.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js" integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.4.1/socket.io.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body onload="testShowCart()">
    
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

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4 pb-4">
		<h2 class="rh2 "><?php echo $list_name_title[$lang]; ?></h2>
		
		
		<div class="container bg-info mx-md-0 mx-sm-3" >
		  
		  <div class="row ">
		  <div class="col-lg-auto col-md <?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?> m-1 py-1">
			  <div class="h5"><?php echo $cart[$lang]; ?> </div>
				<!--
				<div>
				   <button onclick="startCamera()" class="btn btn-success">Start Camera</button>
				   <button onclick="stopCamera()" class="btn btn-danger">Stop Camera</button><br><br>
				   <img id="video-feed" src="http://localhost:5050/video_feed" width="420" height="200"/>
				</div><br>
				-->
				<div id="reader" class="bg-warning text-center" style="width: 420px;"></div>
				
				<input type="text" id="barcodeHere" style="width: 100%;" onkeyup="" placeholder="barcode..." title="Scan drinks barcode" onchange="myFunction2(this.value)" autofocus>
			    <table class="table table-hover <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo "table-light";} ?>">
				  <thead>
					<tr class="bg-dark text-white">
					  <th scope="col"></th>
					  <th scope="col"><?php echo $table_Title1[$lang]; ?></th>
					  <th scope="col"><?php echo $table_Title2[$lang]; ?></th>
					  <th scope="col"><?php echo $table_Title3[$lang]; ?></th>
					  <th scope="col"><?php echo $table_Title4[$lang]; ?></th>
					</tr>
				  </thead>
				  <tbody id="t_body">
					<!--
					<tr>
					  <th scope="row"><a href="">x</a></th>
					  <td>Lemon Tea</td>
					  <td>$<span>8.00</span></td>
					  <td><input type="number" style="width: 40px;" min="1" value ="1" onchange="calSubAmount(this);"></td>
					  <td><b>$<span>8.00</span></b></td>
					</tr>
					<tr>
					  <th scope="row"><a href="">x</a></th>
					  <td>Water</td>
					  <td>$<span>8.00</span></td>
					  <td><input type="number" style="width: 40px;" min="1" value ="1" onchange="calSubAmount(this)"></td>
					  <td><b>$<span>10.00</span></b></td>
					</tr>
					-->
				  </tbody>
				</table>
			  
			    <table class="table table-hover">
				  <thead id="totalAmount">
					<tr class="bg-secondary text-white">
					  <th scope="col"></th>
					  <th scope="col"><?php echo $tol_price[$lang]; ?> : </th>
					  <th scope="col"> </th>
					  <th scope="col"> </th>
					  <th scope="col">$ 0.00</th>
					</tr>
				  </thead>
				</table>
				
				
				<button id="submitToPhp" class="btn btn-primary" ><?php echo $button1[$lang]; ?></button>
				&emsp;
				<button id="resetShoppingCart" class="btn btn-secondary" onclick="clearShoppingCart()"><?php echo $button2[$lang]; ?></button>
				
				<!-- <button onclick="testShowCart()">Show Shopping Cart (for testing)</button> -->
				
			</div>
			<div class="col-lg col-sm-12 <?php if($_SESSION['themeColorIndex'] == 1){ echo "bg-dark"; }else{ echo "bg-light";} ?> m-lg-1 m-md-0">
			  <?php echo $pic[$lang]; ?>
			  <div class="row">
			  
				
				<!--
				<div id="btn1" onclick="myFunction(this.childNodes)">
				<div class="card m-2" style="width: 10rem;">
				  <img class="card-img-top" src="./imgDrinks/008.png" alt="Card image cap">
				  <div class="card-body">
				    <p class="card-text"><b>Coca Cola-test</b></p>
					<p class="card-text">Price: $<span>8.00</span></p>
					<p class="card-text">in Stock: <span>5</span> pcs</p>
				  </div>
				</div>
				</div>
				
				<div id="btn1" onclick="myFunction(this.childNodes)">
				<div class="card m-2" style="width: 10rem;">
				  <img class="card-img-top" src="./imgDrinks/007.png" alt="Card image cap">
				  <div class="card-body">
				    <p class="card-text"><b>水</b></p>
					<p class="card-text">Price: $<span>10.00</span></p>
					<p class="card-text">in Stock: <span>5</span> pcs</p>
				  </div>
				</div>
				</div>
				-->
				<?php
					$query = "SELECT * FROM `drinks_category` WHERE drinks_status = 'Active' ORDER BY drinks_id";  
					$query_run = mysqli_query($conn, $query);
					$row = mysqli_num_rows($query_run);
					$rc = mysqli_fetch_assoc($query_run);
					
					if(mysqli_num_rows($query_run) > 0){
						do { 
							$drinks_id = $rc['drinks_id'];
							$drinks_name = $rc['drinks_name'];
							$stock_qty = $rc['stock_qty'];
							$price = $rc['price'];
							$barcode = $rc['barcode'];
							
							if($stock_qty <= 0){
								$txt = <<<EOD
								
								<div class="not-allowed">
								<div class="card m-2 $pic_bg_color" style="width: 10rem;">
								  <img class="card-img-top" src="./imgDrinks/$drinks_id.png" onerror="this.onerror=null; this.src='image/000.png'" alt="Card image cap">
								  <div class="overlay">
									<div >Sold out</div>
								  </div>
								  <div class="card-body">
									<p class="card-text"><b>$drinks_name</b></p>
									<p class="card-text">$table_Title2[$lang]: $ $price</p>
									<p class="card-text">$drk_qty[$lang]: $stock_qty pcs</p>
								  </div>
								</div>
								</div>

								EOD;
							}else{
								$txt = <<<EOD
								
								<div id="btn1" class="pointer shrink" barcode="$barcode" ai_name="$drinks_name" onclick="myFunction(this.childNodes);testShowCart();">
								<div class="card m-2 $pic_bg_color" style="width: 10rem;">
								  <img class="card-img-top" src="./imgDrinks/$drinks_id.png" onerror="this.onerror=null; this.src='image/000.png'" alt="Card image cap">
								  <div class="card-body">
									<p class="card-text"><b>$drinks_name</b></p>
									<p class="card-text">$table_Title2[$lang]: $<span>$price</span></p>
									<p class="card-text">$drk_qty[$lang]: <span>$stock_qty</span> pcs</p>
								  </div>
								</div>
								</div>

								EOD;
							}
								
							echo $txt;
							
							
							
						}while($rc = mysqli_fetch_assoc($query_run)); 
					}else{
						
					}
					
				?>		
				


				
				
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
	
	/*
	$(document).ready(function(){

	  $("#btn1").click(function(){
		$("tbody").append("<tr><th scope=\"row\"><a href=\"\">x</a></th><td>Coca Cola</td><td>$8.00</td><td><input type=\"number\" style=\"width: 40px;\"></td><td><b>$24.00</b></td></tr>");
	  });
	});
	*/
	
	var shopping_cart = [];
	
	function myClick(){
		$("tbody").append("<tr><th scope=\"row\"><a href=\"\">x</a></th><td>Coca Cola</td><td>$8.00</td><td><input type=\"number\" style=\"width: 40px;\"></td><td><b>$24.00</b></td></tr>");
	}
	
	function myFunction(x){
		var name = x[1].childNodes[3].childNodes[1].childNodes[0].innerHTML;
		var price = x[1].childNodes[3].childNodes[3].childNodes[1].innerHTML;
		var piece = x[1].childNodes[3].childNodes[5].childNodes[1].innerHTML;
		//alert(name+" "+price+" "+piece);
		const one_order = new Array(name, price);
		
		var inCart = 0;
		
		for (let i = 0; i < shopping_cart.length; i++) {
			if (shopping_cart[i][0] === one_order[0]) {
				inCart += 1;
			}
		}
		
		if(inCart == piece){ //meet limit, not add into shopping_cart array
			alert("not enough stock1");
		}else{
			shopping_cart.push(one_order);
		}
		
		
		//alert(shopping_cart);
		
		//check the shopping_cart array if one_order is first time in shopping_cart, then append it
		//if one_order is not first time in shopping_cart, then loop through <tbody> and check same name and add one Qty
		
		if(inCart == 0){
			var txt = "<tr><th scope=\"row\"><div id=\"closeX\" class=\"pointer\" onclick=\"removeSingle(this)\">x</div></th><td>" + name + "</td><td>$<span>" + price + "</span></td><td><input type=\"number\" value=\"1\" min=\"1\" max='" + piece + "' style=\"width: 45px;\" onchange=\"calSubAmount(this)\"></td><td><b>$<span>"+price+"</span></b></td></tr>";
			$("tbody").append(txt);
			//calTotalAmount();
		}else{
			var table = document.getElementById("t_body");
			for (var i = 0, row; row = table.rows[i]; i++) {
			   //iterate through rows
			   //rows would be accessed using the "row" variable assigned in the for loop
			   for (var j = 0, col; col = row.cells[j]; j++) {
				 //iterate through columns
				 //columns would be accessed using the "col" variable assigned in the for loop
				 
				 if(row.cells[j].innerHTML == name){
					//alert(row.cells[j+2].children[0].value);
					if(parseInt(row.cells[j+2].children[0].value) >= parseInt(piece)){
						//alert(row.cells[j+2].children[0].value);
						//alert(piece);
						
						alert("not enough stock2");
					}else{
						row.cells[j+2].children[0].value = parseInt(row.cells[j+2].children[0].value)+1;
						var subTotal = row.cells[j+2].children[0].value * price;
						row.cells[j+3].children[0].innerHTML = "$<span>"+parseFloat(subTotal).toFixed(2) +"</span>";
						//calTotalAmount();
					}
					
				 }
				 
			   }  
			}
			//calTotalAmount();
		}
		calTotalAmount();
	}
	
	function calTotalAmount(){
		var xxx = 0;
		var table = document.getElementById("t_body");
		for (var i = 0, row; row = table.rows[i]; i++) {
		   //iterate through rows
		   //rows would be accessed using the "row" variable assigned in the for loop
		   
		   xxx += parseFloat(row.cells[4].children[0].children[0].innerHTML);
		   //alert(row.cells[4].children[0].children[0].innerHTML);
		   for (var j = 0, col; col = row.cells[j]; j++) {
			 //iterate through columns
			 //columns would be accessed using the "col" variable assigned in the for loop
			 
			 //xxx += parseFloat(row.cells[j].children[0].innerHTML).toFixed(2);
		   }  
		}
		//alert(typeof xxx);
		document.getElementById("totalAmount").children[0].children[4].innerHTML = "$"+parseFloat(xxx).toFixed(2);
	}
	
	calTotalAmount();
	
	
	function calSubAmount(x){
		var name = x.parentNode.previousElementSibling.previousElementSibling.innerHTML;
		var price = x.parentNode.previousElementSibling.children[0].innerHTML;
		var newQty = x.value;
		var max = x.getAttribute("max");
		//alert(max);
		if(parseInt(newQty) > parseInt(max)){
			x.value = 1; //set back to one
			
			var subTotal = price * x.value; //re-calculate the sub-total price
			//alert(subTotal);
			var zz = x.parentNode.nextElementSibling.children[0].children[0].innerHTML;
			//alert(zz);
			x.parentNode.nextElementSibling.children[0].children[0].innerHTML = parseFloat(subTotal).toFixed(2);
			calTotalAmount(); //re-calculate the total price
			
			//modify the shopping cart
			
			var temp_shopping_cart_length = shopping_cart.length;
			console.log("temp_shopping_cart_length: "+temp_shopping_cart_length);
			for (let i = 0; i < temp_shopping_cart_length; i++) {
				//console.log("shopping_cart.length: "+temp_shopping_cart_length);
				console.log("i: "+i);
				
					if (shopping_cart[i][0] === name) {
						//shopping_cart.splice(i, 1); //error here
						delete shopping_cart[i]; //to undefined
						
					}
				
				console.log(shopping_cart);
			}
			shopping_cart = shopping_cart.filter(function( element ) { //remove undefined in array
			   return element !== undefined;
			});
			
			shopping_cart.push(new Array(name, price));
			
			return;
		}
		//alert(name +" "+ price + " " + newQty);
		
		var numInCart = 0;
		
		for (let i = 0; i < shopping_cart.length; i++) {
			if (shopping_cart[i][0] === name) {
				numInCart += 1;
			}
		}
		
		if(parseInt(numInCart) > parseInt(newQty)){ //reduce number in Cart //error!!!!!!!
			var differnece = parseInt(numInCart-newQty);
			//alert("differnece1: " + differnece);
			var temp_shopping_cart_length = shopping_cart.length;
			console.log("temp_shopping_cart_length: "+temp_shopping_cart_length);
			for (let i = 0; i < temp_shopping_cart_length; i++) {
				//console.log("shopping_cart.length: "+temp_shopping_cart_length);
				console.log("i: "+i);
				console.log("differnece2: "+differnece);
				if(differnece === 0){
					break;
				}else{
					if (shopping_cart[i][0] === name) {
						//shopping_cart.splice(i, 1); //error here
						delete shopping_cart[i]; //to undefined
						differnece--;
					}
				}
				console.log(shopping_cart);
			}
			//alert(shopping_cart[0]);
			shopping_cart = shopping_cart.filter(function( element ) { //remove undefined in array
			   return element !== undefined;
			});
			
		}else if(parseInt(numInCart) < parseInt(newQty)){ //add number in Cart
			var differnece = parseInt(newQty-numInCart);
			for (let i = 0; i < differnece; i++) {
				shopping_cart.push(new Array(name, price));
			}
			console.log(shopping_cart);
		}
		
		
		//alert(shopping_cart);
		
		var subTotal = price * newQty;
		//alert(subTotal);
		var zz = x.parentNode.nextElementSibling.children[0].children[0].innerHTML;
		//alert(zz);
		x.parentNode.nextElementSibling.children[0].children[0].innerHTML = parseFloat(subTotal).toFixed(2);
		
		calTotalAmount();
	}
	

	
	function clearShoppingCart(){
		//document.getElementById("t_body").innerHTML = ""
		$("#t_body").empty();
		calTotalAmount();
		shopping_cart = [];
	}
	
	function removeSingle(x){
		console.log(x.parentNode.nextElementSibling.innerHTML);
		var name = x.parentNode.nextElementSibling.innerHTML;
		
		var temp_shopping_cart_length = shopping_cart.length;
		console.log("temp_shopping_cart_length: "+temp_shopping_cart_length);
		for (let i = 0; i < temp_shopping_cart_length; i++) {
			//console.log("shopping_cart.length: "+temp_shopping_cart_length);
			
			if (shopping_cart[i][0] === name) {
				//shopping_cart.splice(i, 1); //error here
				delete shopping_cart[i]; //to undefined
				
			}
			console.log(shopping_cart);
		}
		//alert(shopping_cart[0]);
		shopping_cart = shopping_cart.filter(function( element ) { //remove undefined in array
		   return element !== undefined;
		});
		
		x.parentNode.parentNode.remove();
		calTotalAmount();
	}
	
	$(document).ready(function(){
	  $("#submitToPhp").click(function(){
		//alert(shopping_cart);
		if (typeof shopping_cart !== 'undefined' && shopping_cart.length > 0) {
			const obj = arrToObject(shopping_cart);
			const myJSON = JSON.stringify(obj);
			//alert(myJSON);
			//alert(typeof myJSON);
			$.ajax({
				type: "POST",
				url: "uploadDrinksToDB.php",
				data:{sth:myJSON}, 
				//dataType: 'json',
				success: function(result, status, xhr){
					console.log("SUCCESS"+result);
					alert("SUCCESS"); //show success massage
					//$(location).attr('href', 'uploadDrinksToDB.php');
					window.location.href = "sellDrinks.php";
				},
				error: function (xhr, status, error){
					console.log("ERROR"+error);
					alert("FAIL");
					//$(location).attr('href', 'uploadDrinksToDB.php')
				}
				});
			//$.post('uploadDrinksToDB.php', {shopping_cart: shopping_cart});
			//$(location).attr('href', 'sellDrinks.php'); //refresh the page
			
		}else{ //empty shopping Cart!!
			alert("Please select drinks before Check out");
		}
		
		
	  });
	});
	
	function testShowCart(){ //for testing
		//alert(shopping_cart);
		console.log (arrToObject(shopping_cart));
	}
	
	
	

//create JSON object from 2 dimensional Array
function arrToObject (arr){
	//assuming header
	var keys = new Array(1, 2);
	//vacate keys from main array
	var newArr = arr.slice(0, arr.length);

	var formatted = [],
    data = newArr,
    cols = keys,
    l = cols.length;
	for (var i=0; i<data.length; i++) {
			var d = data[i],
					o = {};
			for (var j=0; j<l; j++)
					o[cols[j]] = d[j];
			formatted.push(o);
	}
	return formatted;
}


//Html5QrcodeScanner

  const scanner = new Html5QrcodeScanner('reader', {
	qrbox: { // Optional, if you want bounded box UI
	  width: 250,
	  height: 250,
	},
	fps: 10, // Optional, frame per seconds for qr code scanning
  });
  scanner.render(success);

  function success(result, result2) {
	console.log("Code: "+result);
	console.log("Code2: "+result2); //????
	document.getElementById('barcodeHere').value = result;
	//document.getElementById('result').innerHTML = result;
	//scanner.clear();
	//document.getElementById('reader').remove();
	var barcode_value = document.getElementById('barcodeHere').value;
	
	var ddd = document.querySelector('[barcode="'+barcode_value+'"]');
	if(ddd === null){
		alert("drinks not found");
	}else{
		myFunction(ddd.childNodes);
	}

  }

  function error(err) {
	//console.error(err);
  }
  
  /*
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
*/


function myFunction2(xxx){

	var ddd = document.querySelector('[barcode="'+ xxx +'"]');
	if(ddd === null){
		alert("drinks not found");
		$("#barcodeHere").val("");
	}else{
		myFunction(ddd.childNodes);
		$("#barcodeHere").val("");
	}

}
	/*
	function myFunction3(xxx) {

		var ddd = document.querySelector('[ai_name="' + xxx + '"]');
		if (ddd === null) {
			alert("drinks not found");
		} else {
			myFunction(ddd.childNodes);
		}

	}
	*/
</script>

<script>
/*
	function fetchDetectedObjects() {
		$.ajax({
			url: "http://localhost:5050/detected_objects",
			type: "GET",
			dataType: "json",
			success: function(data) {
				console.log("Detected objects:", data);
				// Process the data here, e.g., update the UI
				for (let i = 0; i < data.length; i++) {
					myFunction3(data[i]);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.error("Failed to fetch detected objects:", errorThrown);
			},
		});
	}

	// Fetch detected objects every 3 seconds (adjust the interval as needed)
	setInterval(fetchDetectedObjects, 3000);

	// Connect to the Flask app's SocketIO server
	const socket = io.connect("http://localhost:5050");

	function startCamera() {
		socket.emit('start_camera');
	}

	function stopCamera() {
		socket.emit('stop_camera');
	}
*/
</script>