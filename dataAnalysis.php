<?php
include('permissionA.php');
include('timeout.php');
include('connection.php');
include('getDataAnalysis.php');
?>
<?php
include_once("./language/main_string.php");
include_once("./language/dataAnalysis_string.php");
include_once("./config/config.php");
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Admin Control Panel - Data Analysis</title>
	<link rel="icon" type="image/x-icon" href="./favicon/<?=$admin_favicon?>/favicon.ico">
	<link rel="canonical" href="https://getbootstrap.com/docs/4.6/examples/dashboard/">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- Bootstrap core CSS -->
	<link href="dashboard/css/bootstrap.min.css" rel="stylesheet">
	<!--Font Awesome-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="js/jquery.min.js"></script>

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
	$card_bg_color = "bg-light";
	if($_SESSION['themeColorIndex'] == 0){ //Day mode
		$card_bg_color = "bg-light";
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}else if($_SESSION['themeColorIndex'] == 1){ //Night mode
		$card_bg_color = "bg-dark";
		echo "<link href=\"dashboard/css/dashboard_dark.css\" rel=\"stylesheet\">";
	}else{
		$card_bg_color = "bg-light";
		echo "<link href=\"dashboard/css/dashboard_light.css\" rel=\"stylesheet\">";
	}
	?>

	<!-- Javascript -->
	<script src="./js/sidebar.js"></script>
	<script src="./js/showTime.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
	<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
</head>

<body>

	<?php
	include_once("./template/top_nav.php");
	echo $top_nav_admin_str;
	?>

	<?php if ($_SESSION['permission'] == "Admin" || $_SESSION['permission'] == "Manager") { ?>
		<a class="nav-link" style="display:inline;" href="dashboard.php">
			<?php echo $list_name_staffPage[$_SESSION["language_index"]] ?>
		</a>
		&emsp;
	<?php } ?>
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
			echo $sidebar_admin_str;
			?>

			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
				<h2 class="rh2"><?php echo $list_name_title[$lang]; ?></h2>
				<hr class="<?php if($_SESSION['themeColorIndex'] == 1){ echo "border-light"; }else{ echo "border-dark";} ?>">
				<form method="POST">
					<?php echo $searchCritiria1[$lang]; ?>
					<select id="period" name="period" class="custom-select" onchange="this.form.submit();">
						<option value="today" selected><?php echo $time1[$lang]; ?></option>
						<option value="yesterday"><?php echo $time2[$lang]; ?></option>
						<option value="last30days"><?php echo $time3[$lang]; ?></option>
					</select>
				</form>
				<form method="POST" class="my-3">
					<?php echo $searchCritiria2[$lang]; ?>
					<input type="month" id="selectMonth" name="selectMonth" class="form-control" onchange="this.form.submit();"> 
				</form>
				<form method="POST" class="my-3">
					<?php echo $searchCritiria3[$lang]; ?>
					<input type="date" id="selectDate" name="selectDate" class="form-control" onchange="this.form.submit();"> 
				</form>
				
				<br><br>

				<div id="drinks_data">
					<div class="card-columns mx-1 px-2">
						<div class="card shadow <?php echo $card_bg_color; ?>">
							<div class="card-header h4"><?php echo $saleVol[$lang]; ?> <i class='fas fa-mug-hot'></i></div>

							<div class="card-body text-center display-3"><?php if (isset($today_qty)) {
																				echo $today_qty;
																			} ?></div>
						</div>
						<div class="card shadow <?php echo $card_bg_color; ?>">
							<div class="card-header h4"><?php echo $saleRev[$lang]; ?> <i class='fas fa-search-dollar'></i></div>
							<div class="card-body text-center display-3"><?php if (isset($today_qty)) {
																				echo "$", $today_amount;
																			} ?></div>
						</div>
						<div class="card shadow <?php echo $card_bg_color; ?>">
							<div class="card-header h4"><?php echo $bestSal[$lang]; ?> <i class='fas fa-crown'></i></div>
							<div class="card-body text-center display-3"><?php if (isset($today_qty)) {
																				echo $today_drink;
																			} ?></div>
							<!--<div class="card-footer">Footer</div>-->
						</div>
					</div>

					<div style="display: flex; justify-content: space-around" >
					<select name="searchBy" id="searchBy" class="mr-2">
						<option value="orderid"><?php echo $table_Title1[$lang]; ?></option>
						<option value="drinksid"><?php echo $table_Title2[$lang]; ?></option>
						<option value="drinksname"><?php echo $table_Title3[$lang]; ?></option>
						<option value="qty"><?php echo $table_Title4[$lang]; ?></option>
						<option value="price"><?php echo $table_Title5[$lang]; ?></option>
						<option value="date"><?php echo $table_Title6[$lang]; ?></option>
						<option value="time"><?php echo $table_Title7[$lang]; ?></option>
						<option value="staffid"><?php echo $table_Title8[$lang]; ?></option>
					</select>
					<input type="text" style="width: 83%;" id="searchKeyword" onkeyup="searchTable()" placeholder="Keyword" title="Type in a keyword">
					<button class="btn btn-outline-primary btn-sm ml-2" onclick="copyTable()">Copy Table <i class="fa-solid fa-copy"></i></button>
					</div>

					<div class="table-responsive rounded mt-2">
								<table class="table table-striped table-hover table-sm rounded <?php if($_SESSION['themeColorIndex'] == 1){ echo "table-dark"; }else{ echo "table-light";} ?>" id="myTable">
								  <thead>
									<tr>
										<th onclick="sortTable(0)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title1[$lang]; ?></th>
										<th onclick="sortTable(1)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title2[$lang]; ?></th>
										<th onclick="sortTable(2)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title3[$lang]; ?></th>
										<th onclick="sortTable(3)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title4[$lang]; ?></th>
										<th onclick="sortTable(4)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title5[$lang]; ?></th>
										<th onclick="sortTable(5)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title6[$lang]; ?></th>
										<th onclick="sortTable(6)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title7[$lang]; ?></th>
										<th onclick="sortTable(7)" title="click to sort" style="cursor: pointer;"><?php echo $table_Title8[$lang]; ?></th>

									</tr>
								  </thead>
								  <tbody id="target_table">

									<?php
									if (isset($today_qty)) {
										echo $table_data;
									} 
									?>
							
								  </tbody>
								</table>
					</div>

					<div class="row row-cols-1 row-cols-md-1 row-cols-lg-2">
						<div class="col mb-4">
							<div class="card shadow <?php echo $card_bg_color; ?>">
								<div class="card-header text-center h5"><?php echo $saleVolCom[$lang]; ?> </div>
								<div class="card-body">
									<canvas id="myChart1" style="width:100%;max-width:600px"></canvas>
								</div>
							</div>
						</div>
						<div class="col mb-4">
							<div class="card shadow <?php echo $card_bg_color; ?>">
								<div class="card-header text-center h5"><?php echo $saleRevCom[$lang]; ?></div>
								<div class="card-body">
									<canvas id="myChart2" style="width:100%;max-width:600px"></canvas>
								</div>
							</div>
						</div>
					</div>

					<div class="row row-cols-1 row-cols-md-1 row-cols-lg-2">
						<div class="col mb-4">

							<div class="card shadow <?php echo $card_bg_color; ?>">
								<div class="card-header text-center h5"><?php echo $volDis[$lang]; ?></div>
								<div class="card-body">
									<canvas id="myChart3" style="width:100%;max-width:600px"></canvas>
								</div>
								<!--<div class="card-footer">Footer</div>-->
							</div>
						</div>
						<div class="col mb-4">
							<div class="card shadow <?php echo $card_bg_color; ?>">
								<div class="card-header text-center h5"><?php echo $revDis[$lang]; ?></div>
								<div class="card-body">
									<canvas id="myChart4" style="width:100%;max-width:600px"></canvas>
								</div>
								<!--<div class="card-footer">Footer</div>-->
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
	<?php $site = str_replace($directory, '', $_SERVER['PHP_SELF']); ?>

	window.addEventListener("load", function() {
		var aTag = document.getElementsByTagName("a");
		//alert(aTag.length);
		for (let i = 0; i < aTag.length; i++) {
			var activelink = aTag[i].getAttribute("href");
			if (activelink == "<?php echo $site ?>") {
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

	function copyTable(){
		var n = document.getElementById("myTable");
		var copyText = n.innerText;
		
		navigator.clipboard.writeText(copyText);
		alert("Copied");
	}



	<?php
	if (isset($_SESSION['period'])) {
	?>
		document.getElementById('period').value = "<?php echo $_SESSION['period']; ?>"
	<?php
	} ?>;
</script>

<script>
	const barColors = [];
	const array1 = [];
	const barColors2 = [];
	var h1;
	var s1 = 50;
	var l1 = 50;
	const x2Values = <?php if (isset($n2)) {
							echo json_encode($n2);
						} else {
							return null;
						} ?>;
	const x3Values = <?php if (isset($n3)) {
							echo json_encode($n3);
						} else {
							return null;
						} ?>;
	var y2Values = <?php if (isset($q2)) {
						echo json_encode($q2);
					} else {
						return null;
					} ?>;
	var num1 = <?php if (isset($x2)) {
					echo json_encode($x2);
				} else {
					return null;
				} ?>;
	var total = <?php if (isset($t2)) {
					echo json_encode($t2);
				} else {
					return null;
				} ?>;


	function hslToHex(hsl) {
		hsl = hsl.match(/^hsla?\(\s?(\d+)(?:deg)?,?\s(\d+)%,?\s(\d+)%,?\s?(?:\/\s?\d+%|\s+[\d+]?\.?\d+)?\)$/i);
		if (!hsl) {
			return null;
		}
		let h = hsl[1];
		let s = hsl[2];
		let l = hsl[3];
		h /= 360;
		s /= 100;
		l /= 100;
		let r, g, b;
		if (s === 0) {
			r = g = b = l;
		} else {
			const hue2rgb = function(p, q, t) {
				if (t < 0) t += 1;
				if (t > 1) t -= 1;
				if (t < 1 / 6) return p + (q - p) * 6 * t;
				if (t < 1 / 2) return q;
				if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6;
				return p;
			};
			const q = l < 0.5 ? l * (1 + s) : l + s - l * s;
			const p = 2 * l - q;
			r = hue2rgb(p, q, h + 1 / 3);
			g = hue2rgb(p, q, h);
			b = hue2rgb(p, q, h - 1 / 3);
		}
		const toHex = function(x) {
			const hex = Math.round(x * 255).toString(16);
			return hex.length === 1 ? '0' + hex : hex;
		};
		return '#' + toHex(r) + toHex(g) + toHex(b);
	}

	if (typeof(num1) != "undefined" && num1 !== null) {
		for (let i = 0; i < num1.length; i++) {
			h1 = i * (360 / num1.length);
			let color = 'hsl(' + Math.floor(h1) + ', ' + Math.floor(s1) + '%, ' + Math.floor(l1) + '%)';
			barColors.push(hslToHex(color));
		}
	}
	array1.push({
		name: x2Values,
		color: barColors
	});


	for (let i = 0; i < array1[0].name.length; i++) {
		const index = x3Values.indexOf(array1[0].name[i]);

		if (index !== -1) {
			barColors2[index] = array1[0].color[i];
		}
	}


	new Chart("myChart1", {
		type: "horizontalBar",
		data: {
			labels: x2Values,
			datasets: [{
				backgroundColor: barColors,
				data: y2Values
			}]
		},
		options: {
			legend: {
				display: false
			},
			title: {
				display: true,
				text: "Drinks sold"
			},
			scales: {
				xAxes: [{
					ticks: {
						min: 0
					}
				}]
			}
		}
	});

	new Chart("myChart2", {
		type: "bar",
		data: {
			labels: x3Values,
			datasets: [{
				backgroundColor: barColors2,
				data: total
			}]
		},
		options: {
			legend: {
				display: false
			},
			title: {
				display: true,
				text: "Drinks sold"
			},
			scales: {
				yAxes: [{
					ticks: {
						min: 0
					}
				}]
			},
			plugins: {
				labels: {
					render: 'image'
				}
			},
		}
	});

	new Chart("myChart3", {
		type: 'pie',
		data: {
			labels: x2Values,
			datasets: [{
				data: y2Values,
				backgroundColor: barColors
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: true,
			title: {
				display: true,
				text: "Drinks sold"
			},
			plugins: {
				labels: {
					render: 'percentage',
					fontColor: 'white',
					precision: 0
				}
			},
		}
	});


	new Chart("myChart4", {
		type: 'doughnut',
		data: {
			labels: x3Values,
			datasets: [{
				data: total,
				backgroundColor: barColors2
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: true,
			title: {
				display: true,
				text: "Drinks sold"
			},
			plugins: {
				labels: {
					render: 'percentage',
					fontColor: 'white',
					precision: 0
				}
			},
		}
	});
</script>

