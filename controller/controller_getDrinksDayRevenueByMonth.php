<?php

//include ('../connection.php');

/*function*/
function HSVaToRGBa($hsv) {
	// Extract the HSL values from the input string
	preg_match('/hsva\((\d+),\s*([\d.]+)%,\s*([\d.]+)%,\s*([\d.]+)\)/', $hsv, $matches);
    $hue = $matches[1];
    $saturation = $matches[2] / 100;
    $value = $matches[3] / 100;
    $alpha = $matches[4];
	
	$r = 0;
	$g = 0;
	$b = 0;


	if ($saturation == 0)
	{
		$r = $value;
		$g = $value;
		$b = $value;
	}
	else
	{
		if ($hue == 360)
			$hue = 0;
		else
			$hue = $hue / 60;

		$i = (int)floor($hue);
		$f = $hue - $i;

		$p = $value * (1.0 - $saturation);
		$q = $value * (1.0 - ($saturation * $f));
		$t = $value * (1.0 - ($saturation * (1.0 - $f)));

		switch ($i)
		{
		case 0:
			$r = $value;
			$g = $t;
			$b = $p;
			break;

		case 1:
			$r = $q;
			$g = $value;
			$b = $p;
			break;

		case 2:
			$r = $p;
			$g = $value;
			$b = $t;
			break;

		case 3:
			$r = $p;
			$g = $q;
			$b = $value;
			break;

		case 4:
			$r = $t;
			$g = $p;
			$b = $value;
			break;

		default:
			$r = $value;
			$g = $p;
			$b = $q;
			break;
		}

	}

	//$rgb = new RGB();
	$r = floor($r * 255);
	$g = floor($g * 255);
	$b = floor($b * 255);

	return "rgba(".$r.",".$g.",".$b.",".$alpha.")";
}

function getValueFromCircle($part, $totalParts) {
    $angle = (360 / $totalParts) * $part;
    return floor($angle);
}

function createDataSetForChart($label, $data, $backgroundColor="rgba(0, 0, 255, 0.5)", $borderColor="rgba(0, 255, 0, 1)"){
	$string_DataSet = "{label:'".$label."', fill: false, lineTension: 0.2, backgroundColor: '".$backgroundColor."', borderColor: '".$borderColor."', data:";
	$string_DataSet .= $data;
	$string_DataSet .= ", pointStyle: 'circle', pointRadius: 5, pointHoverRadius: 15}";
	return $string_DataSet;
}

$label_dataSet_arr = array(); //store 001, 002, or all
$data_dataSet_arr = array(); //store [0, 0, ..., 0]

/*get request from user*/
if(!isset($_POST["selectedMonth"]) || $_POST["selectedMonth"]==null){    
	$month = date("Y-m"); //today's month
}else{
	$month = $_POST["selectedMonth"];
}    
//echo $month;

if(isset($_POST["selectedDrinks"])){    
	$selected_drinks_id = $_POST["selectedDrinks"];    
}else{
	$selected_drinks_id = "all"; //today's month
}

//$selected_drinks_id = "001";

$date = new DateTime($month . '-01'); //make a new datetime object with yyyy-mm-dd
$daysInMonth = $date->format('t'); //number of days in the given month

$dateArray = array();
for($i = 1; $i <= $daysInMonth; $i++){
	$day = str_pad($i, 2, '0', STR_PAD_LEFT);
	$dateArray[] = $month . '-' . $day;
}

//print_r($dateArray);

//number of days in given month and year
$numOfDays = cal_days_in_month(CAL_GREGORIAN, substr($month, 5, 2), substr($month, 0, 4));
//echo "Number of Days in ".$month." is ".$numOfDays."<br>";

$sql_getDrinksDayRevenueByMonth = "SELECT drinks_sold_record.order_date AS Date, SUM(drinks_order.qty*drinks_order.price) AS TotalRevenue FROM drinks_sold_record CROSS JOIN drinks_order WHERE drinks_order.order_id = drinks_sold_record.order_id AND DATE_FORMAT(drinks_sold_record.order_date, '%Y-%m') = '$month' " ; 


if($selected_drinks_id != "all"){
	$sql_getDrinksDayRevenueByMonth .= "AND drinks_order.drinks_id = '$selected_drinks_id' GROUP BY DATE(drinks_sold_record.order_date)";
	
	$result = $conn->query($sql_getDrinksDayRevenueByMonth);

	//print_r($result);

	$amountArray = array();

	if($result->num_rows > 0){
		while($row = $result->fetch_assoc()){
			$temp_arr = array("date"=>$row["Date"], "amount"=>$row["TotalRevenue"]);
			//echo $row["Date"]." , ".$row["TotalRevenue"]."<br>";
			array_push($amountArray, $temp_arr);
		}
		//print_r($amountArray);
		

	}else{
		//echo 0;
	}

	// Create the new array
	$newArray = array();
	foreach ($dateArray as $date) {
		$found = false;
		foreach ($amountArray as $amount) {
			if ($amount["date"] == $date) {
				$newArray[] = $amount["amount"];
				$found = true;
				break;
			}
		}
		if (!$found) {
			$newArray[] = 0;
		}
	}
	
	$out_string = "";
	$out_string .= createDataSetForChart($selected_drinks_id, json_encode($newArray));
	$final_outcome = $out_string;
	
}else{ //all the drinks_id
	$drinksID_arr = array(); //to store all drinks ID
	//get all actvie drinks ID
	$sql_getAllDrinksID = "SELECT drinks_id, drinks_name FROM `drinks_category` WHERE drinks_status = 'Active'";
	$rs = $conn->query($sql_getAllDrinksID);
	
	if($rs->num_rows > 0){
		while($rc = $rs->fetch_assoc()){
			array_push($drinksID_arr, $rc["drinks_id"]);
			$temp_label = $rc["drinks_name"]."(".$rc["drinks_id"].")";
			array_push($label_dataSet_arr, $temp_label);
		}
	}else{
		//echo 0;
	}
	
	if(count($drinksID_arr)>0){
		for ($i = 0; $i < count($drinksID_arr); $i++) {
			//get each
			$sql_getDrinksDayRevenueByMonth = "SELECT drinks_sold_record.order_date AS Date, SUM(drinks_order.qty*drinks_order.price) AS TotalRevenue FROM drinks_sold_record CROSS JOIN drinks_order WHERE drinks_order.order_id = drinks_sold_record.order_id AND DATE_FORMAT(drinks_sold_record.order_date, '%Y-%m') = '$month' " ; 
			
			$drinksID = $drinksID_arr[$i];
			
			$sql_getDrinksDayRevenueByMonth .= "AND drinks_order.drinks_id = '$drinksID' GROUP BY DATE(drinks_sold_record.order_date)";
			
			$result = $conn->query($sql_getDrinksDayRevenueByMonth);
			
			$amountArray = array();

			if($result->num_rows > 0){
				while($row = $result->fetch_assoc()){
					$temp_arr = array("date"=>$row["Date"], "amount"=>$row["TotalRevenue"]);
					//echo $row["Date"]." , ".$row["TotalRevenue"]."<br>";
					array_push($amountArray, $temp_arr);
				}
				//print_r($amountArray);
				

			}else{
				//echo 0;
			}
			

			
			// Create the new array
			$newArray = array();
			foreach ($dateArray as $date) {
				$found = false;
				foreach ($amountArray as $amount) {
					if ($amount["date"] == $date) {
						$newArray[] = $amount["amount"];
						$found = true;
						break;
					}
				}
				if (!$found) {
					$newArray[] = 0;
				}
			}
			
			//store the [0, 0, ..., 0] into data_dataSet_arr
			array_push($data_dataSet_arr, json_encode($newArray));
			
		}
		
		//get sum of all
		$sql_getDrinksDayRevenueByMonth = "SELECT drinks_sold_record.order_date AS Date, SUM(drinks_order.qty*drinks_order.price) AS TotalRevenue FROM drinks_sold_record CROSS JOIN drinks_order WHERE drinks_order.order_id = drinks_sold_record.order_id AND DATE_FORMAT(drinks_sold_record.order_date, '%Y-%m') = '$month' " ; 
		
		
		
		$sql_getDrinksDayRevenueByMonth .= "GROUP BY DATE(drinks_sold_record.order_date)";
		
		$result = $conn->query($sql_getDrinksDayRevenueByMonth);
		
		$amountArray = array();

		if($result->num_rows > 0){
			while($row = $result->fetch_assoc()){
				$temp_arr = array("date"=>$row["Date"], "amount"=>$row["TotalRevenue"]);
				//echo $row["Date"]." , ".$row["TotalRevenue"]."<br>";
				array_push($amountArray, $temp_arr);
			}
			//print_r($amountArray);
			

		}else{
			//echo 0;
		}
		

		
		// Create the new array
		$newArray = array();
		foreach ($dateArray as $date) {
			$found = false;
			foreach ($amountArray as $amount) {
				if ($amount["date"] == $date) {
					$newArray[] = $amount["amount"];
					$found = true;
					break;
				}
			}
			if (!$found) {
				$newArray[] = 0;
			}
		}
		
		//store the [0, 0, ..., 0] into data_dataSet_arr
		array_push($data_dataSet_arr, json_encode($newArray));
		array_push($label_dataSet_arr, "Total Revenue");
		
		
		
		
		$out_string = "";
		//use function createDataSetForChart($label, $data)
		for ($i = 0; $i < count($data_dataSet_arr); $i++) {
			$bg_color = "hsva(".getValueFromCircle(($i+1), count($data_dataSet_arr)).", 100%, 100%, 0.5)";
			$border_color = "hsva(".getValueFromCircle(($i+1), count($data_dataSet_arr)).", 100%, 100%, 1)";
			$out_string .= createDataSetForChart($label_dataSet_arr[$i], $data_dataSet_arr[$i], HSVaToRGBa($bg_color), HSVaToRGBa($border_color));
			if ($i < count($data_dataSet_arr) - 1) {
				$out_string .= ',';
			}
		}
		
		
	}
	
	$final_outcome = $out_string;
	
}

echo $final_outcome;

// Print the new array
//print_r($newArray);

// Convert the new array to a string
//$newArrayString = str_replace(array('[', ']'), '', json_encode($newArray));

// Print the new array string


$conn->close();


?>