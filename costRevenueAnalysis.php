<?php 
include('permissionA.php');
include('timeout.php');
include('connection.php');
?>
<?php
include_once("./language/main_string.php");
include_once("./language/costRevenueAnalysis_string.php");
include_once("./config/config.php"); 
?>

<?php 
$sql = "SELECT drinks_id, drinks_name FROM `drinks_category` WHERE drinks_status = 'Active'"; //write the SQL statement
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Admin Control Panel - Cost & Revenue Analysis</title>
	<link rel="icon" type="image/x-icon" href="./favicon/<?=$admin_favicon?>/favicon.ico">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/dashboard/">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap core CSS -->
	<link href="dashboard/css/bootstrap.min.css" rel="stylesheet">
	<!--Font Awesome-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

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
	$tableColor = "table-light";
	if($_SESSION['themeColorIndex'] == 0){ //Day mode
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}else if($_SESSION['themeColorIndex'] == 1){ //Night mode
		$tableColor = "table-dark";
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
		
		<!--Page Context here-->
		
		<details open>
		  <summary>
			<h5 style="display:inline;"><?php echo $list_name_searchCriteria[$lang]; ?>:</h5> &emsp; 
		  </summary>
		  <?php echo $list_name_searchBySpecificMonth[$lang]; ?> :
		  <div style="display: flex; ">
			  <form method="POST" style="display: flex; justify-content: space-between; width: 100%;">
				  <input type="month" name="selectedMonth" class="form-control">
				  <select name="selectedDrinks" class="form-control mx-2">
					<option value="all"><?php echo $list_name_allDrinks[$lang]; ?></option>
					
					<?php
					if(mysqli_num_rows($rs) > 0){
						do{
							echo "<option value=\"".$rc['drinks_id']."\">".$rc['drinks_name']." (".$rc['drinks_id'].")"."</option>";
						}while($rc = mysqli_fetch_assoc($rs));
					}
					?>
				  </select>
				  <button type="submit" class="btn btn-primary" onclick="this.form.submit();" style="flex-shrink: 0"><?php echo $list_name_btnSearch[$lang]; ?></button>
				  
			  </form>
			  <button class="btn btn-outline-primary btn-sm ml-2" title="Copy Table" onclick="copyTable()"style="flex-shrink: 0"><?php echo $list_name_btnCopyTable[$lang]; ?> <i class="fa-solid fa-copy"></i></button>
		  </div>
		  
		</details>
		
		<?php
		include_once("./getCostRevenueAnalyzeData.php"); 
		
		
		// Print the formatted data
		// Output the data as an HTML table
		echo format_table($out_arr, $tableColor);

		// Print the total sales and purchases
		echo $list_name_selectedMonth[$lang].": ".$month."<br>";
		echo $list_name_selectedDrinksID[$lang].": ".$selected_drinks_id."<br>";
		echo "<br>";
		
		echo $list_name_totalSalesRevenue[$lang].": "."$".number_format($sales, 2)."<br>";
		echo $list_name_totalCostofPurchase[$lang].": "."$".number_format($purchases, 2)."<br>";
		echo $list_name_profit[$lang]." = "."<b>$<span class='text-primary' id='profit'>".number_format(($sales-$purchases), 2)."</span></b><br>";
		?>
		
		<hr class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "border-light"; }else{ echo "border-dark";} ?>">
		
		<details open>
		  <summary>
			<h5 style="display:inline;"><?php echo $list_name_graph[$lang]; ?> :</h5> &emsp; 
		  </summary>
		  <canvas id="revenueChart" style="width:100%;max-width:800px"></canvas>
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

	window.addEventListener("load", function() {
		var profitNum = parseFloat(document.getElementById("profit").innerHTML);
		//alert(typeof profitNum);
		//console.log(profitNum);
		if(profitNum == 0){ //balance, blue color
			//$("#profit").removeClass("text-primary");
		}else if(profitNum > 0){ //gain, green color
			$("#profit").removeClass("text-primary").addClass("text-success");
		}else{ //loss, red color
			$("#profit").removeClass("text-primary").addClass("text-danger");
		}
	  
	});

	function checkForm(){
		var today = new Date();
		var dd = String(today.getDate()).padStart(2, '0');
		var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
		var yyyy = today.getFullYear();

		today = yyyy+"-"+mm;
		
		var startMonth = document.getElementById("startMonth").value;
		var endMonth = document.getElementById("endMonth").value;
		
		//alert(startMonth);
		//alert(endMonth);
		//alert(today);
		
		var date_1 = new Date(startMonth);
		var date_2 = new Date(endMonth);
		var date_today = new Date(today);
		
		//alert(date_1.valueOf()); //1701388800000
		//alert(date_2); //Sun Dec 01 2024 08:00:00 GMT+0800 (香港標準時間)
		
		//alert(date_2 - date_1);
		if(date_1>date_today || date_2>date_today){ //startMonth or endMonth > today's month (you cannot get data in future!)
			$('#hints').show();
			return false;
		}else if(date_1>date_2){ //startMonth > endMonth 
			$('#hints').show();
			return false;
		}
		return true;
	}
	
	function copyTable(){
		var n = document.getElementById("myTable");
		var copyText = n.innerText;
		
		navigator.clipboard.writeText(copyText);
		alert("Copied");
	}
</script>

<script>

function getDaysInMonth(year, month){
	return new Date(year, month, 0).getDate();
}

console.log(getDaysInMonth(<?=substr($month, 0, 4).",".substr($month, 5, 2)?>));

function getArray(num){
	var arr = [];
	for(var i = 1; i <= num; i++){
		arr.push(i);
	}
	return arr;
}

const xValues = getArray(getDaysInMonth(<?=substr($month, 0, 4).",".substr($month, 5, 2)?>));


new Chart("revenueChart", {
  type: "line",
  data: {
    labels: xValues,
    datasets: [
	<?php
	include_once("./controller/controller_getDrinksDayRevenueByMonth.php"); 
	//echo json_encode($newArray);
	?>
	]
  },
  options: {
    legend: {display: true},
    scales: {
		yAxes: [
			{
				scaleLabel: {
					display: true,
					labelString: 'Sales Revenue (HKD)'
				}
			}
		],
		xAxes: [
			{
				scaleLabel: {
					display: true,
					labelString: 'Date'
				}
			}
		]
    },
	title:{
		display: true,
		text: 'Drinks Sales Analysis on <?=$month?>'
	}
  }
});
</script>