<?php 
include('connection.php');
?>

<?php 
/*==============================input data in Here==============================*/
if(!isset($_POST["selectedMonth"]) || $_POST["selectedMonth"]==null){    
	$month = date("Y-m"); //today's month
}else{
	$month = $_POST["selectedMonth"];
}   
//$month = "2023-05";

if(isset($_POST["selectedDrinks"])){    
	$selected_drinks_id = $_POST["selectedDrinks"];    
}else{
	$selected_drinks_id = "all"; //today's month
}   


/*==============================variables Here==============================*/
$out_arr = array();

/*==============================Here is the functions==============================*/
// Define a function to format each row
function format_row($row) { //discarded
    return "<tr><td>" . implode("</td><td>", $row) . "</td></tr>";
}

// Define functions to extract the date and time columns from each row
function get_date($row) {
    return $row[0];
}

function get_time($row) {
    return $row[1];
}

function format_table($out_arr, $themeColor=""){
	$table = "<div class=\"table-responsive rounded mt-2\">";
	$table .= "<table id=\"myTable\" class=\"table table-striped table-hover table-sm rounded ".$themeColor."\">";
	$table .= "<thead>";
	$table .= "<tr><th>Date</th><th>Time</th><th>drinks ID</th><th>Action</th><th>Price</th><th>Quantity</th><th>Total</th></tr>";
	$table .= "</thead>";
	$table .= "<tbody>";
	foreach ($out_arr as $row) {
		$table .= "<tr>";
		for ($j = 0; $j < count($row); $j++) {
			if($j==6 || $j==4){ //price or total
				$table .= "<td> $" . number_format($row[$j], 2) . "</td>";
			}else{
				
				if($row[$j] == "sale"){
					$table .= "<td style='color: LimeGreen'>" . $row[$j] . "</td>";
				}else if($row[$j] == "purchase"){
					$table .= "<td style='color: Tomato'>" . $row[$j] . "</td>";
				}else{
					$table .= "<td>" . $row[$j] . "</td>";
				}
			}
			
		}
		$table .= "</tr>";
	}
	$table .= "</tbody>";
	$table .= "</table></div>";
	
	return $table;
}

/*==============================SQL Here==============================*/
$sql_querySalesRecord = "SELECT drinks_sold_record.*, drinks_order.drinks_id, drinks_order.qty, drinks_order.price FROM drinks_sold_record CROSS JOIN drinks_order WHERE drinks_order.order_id = drinks_sold_record.order_id AND (drinks_sold_record.order_date LIKE '$month%') ";

if($selected_drinks_id != "all"){
	$sql_querySalesRecord .= " AND drinks_order.drinks_id = '$selected_drinks_id'";
}

$query = $conn->query($sql_querySalesRecord); 

if($query->num_rows > 0){
	//echo "Yes<br>";
	while($row = $query->fetch_assoc()){
		$in_arr = array();
		array_push($in_arr, $row["order_date"], $row["order_time"], $row["drinks_id"], "sale", $row["price"], $row["qty"], ($row["price"]*$row["qty"]));
		array_push($out_arr, $in_arr);
	}
}else{
	echo "No Sale Records";
}




$sql = "SELECT * FROM `drinks_stock_record` WHERE stock_date LIKE '$month%' "; //write the SQL statement
if($selected_drinks_id != "all"){
	$sql .= " AND drinks_id = '$selected_drinks_id'";
}
$rs = mysqli_query($conn, $sql) //mysqli_query() function performs a query against a database.
	  or die(mysqli_error($conn));

$rc = mysqli_fetch_assoc($rs);



if(mysqli_num_rows($rs) > 0){
	do{
		$in_arr = array();
		//echo "stock_remarks: ".$rc['stock_remarks']."<br>";
		array_push($in_arr, $rc['stock_date'], $rc['stock_time'], $rc['drinks_id'], $rc['stock_action'], $rc['unit_cost'], $rc['stock_qty'], ($rc['unit_cost']*$rc['stock_qty']));
		array_push($out_arr, $in_arr);
	}while($rc = mysqli_fetch_assoc($rs));
}else{
	//show nothing
	echo "no purchase or reduction records";
}

/*==============================sort by date and time==============================*/
// Use array_map to apply the get_date and get_time functions to each row in the array
$dates = array_map('get_date', $out_arr);
$times = array_map('get_time', $out_arr);

// Use array_multisort to sort the original array based on the dates and times
array_multisort($dates, SORT_ASC, $times, SORT_ASC, $out_arr);

// Initialize variables
$sales = 0;
$purchases = 0;

// Loop through the array and conditionally sum the seventh column
foreach ($out_arr as $row) {
    if ($row[3] == 'sale') {
        $sales += $row[6];
    } elseif ($row[3] == 'purchase') {
        $purchases += $row[6];
    }
}

/*==============================print out==============================*/
// Use array_map to apply the format_row function to each row in the array
$formatted_data = array_map('format_row', $out_arr); //discarded



//echo gettype($out_arr[0][6]);
?>