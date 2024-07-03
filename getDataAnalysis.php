<?php
include('connection.php');
date_default_timezone_set("Asia/Hong_Kong");
//print_r($_POST);

if (isset($_POST['period'])) {
    $tt = $_POST['period'];
    $_SESSION['period'] = $_POST['period'];

    if ($tt == "today") {
        $today = date("Y-m-d");
        $sql = "SELECT SUM(qty), SUM(price * qty) FROM drinks_order, drinks_sold_record WHERE drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$today'";
        $sql2 = "SELECT drinks_name, SUM(qty) FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id  = drinks_category.drinks_id 
        AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$today' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC LIMIT 1";
        $result = $conn->query($sql);
        $result2 = $conn->query($sql2);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

        if (isset($row['SUM(qty)'])) {
            $today_qty = $row['SUM(qty)'];
        }
        if (isset($row['SUM(price * qty)'])) {
            $today_amount = $row['SUM(price * qty)'];
        }
        if (isset($row2['drinks_name'])) {
            $today_drink = $row2['drinks_name'];
        }

		//table data
		$sql3 = "SELECT DISTINCT `drinks_order`.`order_id`, `drinks_order`.`drinks_id`, `drinks_category`.`drinks_name`, `drinks_order`.`qty`, `drinks_order`.`price`, `drinks_sold_record`.`order_date`, `drinks_sold_record`.`order_time`, `drinks_sold_record`.`staff_id` FROM `drinks_order`, `drinks_sold_record`, `drinks_category` WHERE `drinks_order`.`order_id` = `drinks_sold_record`.`order_id` AND `drinks_order`.`drinks_id` = `drinks_category`.`drinks_id` AND `drinks_sold_record`.`order_date` = '$today';";
		$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
		or die(mysqli_error($conn));

		$rc3 = mysqli_fetch_assoc($rs3);
		
		$table_data = "";
		
		if(mysqli_num_rows($rs3) > 0){
			do { 
				$order_id = $rc3['order_id'];
				$drinks_id = $rc3['drinks_id'];
				$drinks_name = $rc3['drinks_name'];
				$qty = $rc3['qty'];
				$price = $rc3['price'];
				$order_date = $rc3['order_date'];
				$order_time = $rc3['order_time'];
				$staff_id = $rc3['staff_id'];
				
				
				$table_data .= " <tr><td> $order_id </td><td> $drinks_id </td><td> $drinks_name </td><td> $qty </td><td> $price </td><td> $order_date </td><td> $order_time </td><td> $staff_id </td></tr>";
				
				
			}while($rc3 = mysqli_fetch_assoc($rs3)); 
		}else{
			//show nothing
			$table_data = "no record found";
		}

        //Data transfer to chart
        $query2 = sprintf("SELECT SUM(drinks_order.price * qty) AS Total, COUNT(drinks_order.drinks_id) AS ID, drinks_name AS Name, SUM(qty) AS Quantity FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id 
        AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$today' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC");

        $query3 = sprintf("SELECT SUM(drinks_order.price * qty) AS Total, drinks_name AS Name FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id 
        AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$today' GROUP BY drinks_order.drinks_id ORDER BY SUM(drinks_order.price * qty) DESC");

        $result3 = $conn->query($query2);
        $result4 = $conn->query($query3);

        foreach ($result3 as $d) {
            $x2[] = $d['ID'];
            $n2[] = $d['Name'];
            $q2[] = $d['Quantity'];
        }

        foreach ($result4 as $d) {
            $t2[] = $d['Total'];
            $n3[] = $d['Name'];
        }
    } else if ($tt == "yesterday") {
        $today = date("Y-m-d", strtotime("-1 days"));
        $t = $today;
        $sql = "SELECT SUM(qty), SUM(price * qty) FROM drinks_order, drinks_sold_record WHERE drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$t'";
        $sql2 = "SELECT drinks_name, SUM(qty) FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id  = drinks_category.drinks_id 
        AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$t' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC LIMIT 1";
        $result = $conn->query($sql);
        $result2 = $conn->query($sql2);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

        if (isset($row['SUM(qty)'])) {
            $today_qty = $row['SUM(qty)'];
        }
        if (isset($row['SUM(price * qty)'])) {
            $today_amount = $row['SUM(price * qty)'];
        }
        if (isset($row2['drinks_name'])) {
            $today_drink = $row2['drinks_name'];
        }

		//table data
		$sql3 = "SELECT DISTINCT `drinks_order`.`order_id`, `drinks_order`.`drinks_id`, `drinks_category`.`drinks_name`, `drinks_order`.`qty`, `drinks_order`.`price`, `drinks_sold_record`.`order_date`, `drinks_sold_record`.`order_time`, `drinks_sold_record`.`staff_id` FROM `drinks_order`, `drinks_sold_record`, `drinks_category` WHERE `drinks_order`.`order_id` = `drinks_sold_record`.`order_id` AND `drinks_order`.`drinks_id` = `drinks_category`.`drinks_id` AND `drinks_sold_record`.`order_date` = '$t';";
		$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
		or die(mysqli_error($conn));

		$rc3 = mysqli_fetch_assoc($rs3);
		
		$table_data = "";
		
		if(mysqli_num_rows($rs3) > 0){
			do { 
				$order_id = $rc3['order_id'];
				$drinks_id = $rc3['drinks_id'];
				$drinks_name = $rc3['drinks_name'];
				$qty = $rc3['qty'];
				$price = $rc3['price'];
				$order_date = $rc3['order_date'];
				$order_time = $rc3['order_time'];
				$staff_id = $rc3['staff_id'];
				
				
				$table_data .= " <tr><td> $order_id </td><td> $drinks_id </td><td> $drinks_name </td><td> $qty </td><td> $price </td><td> $order_date </td><td> $order_time </td><td> $staff_id </td></tr>";
				
				
			}while($rc3 = mysqli_fetch_assoc($rs3)); 
		}else{
			//show nothing
			$table_data = "no record found";
		}

        //Data transfer to chart
        $query2 = sprintf("SELECT SUM(drinks_order.price * qty) AS Total, COUNT(drinks_order.drinks_id) AS ID, drinks_name AS Name, SUM(qty) AS Quantity FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id 
        AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$t' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC");

        $query3 = sprintf("SELECT SUM(drinks_order.price * qty) AS Total, drinks_name AS Name FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id 
        AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$t' GROUP BY drinks_order.drinks_id ORDER BY SUM(drinks_order.price * qty) DESC");

        $result3 = $conn->query($query2);
        $result4 = $conn->query($query3);

        foreach ($result3 as $d) {
            $x2[] = $d['ID'];
            $n2[] = $d['Name'];
            $q2[] = $d['Quantity'];
        }

        foreach ($result4 as $d) {
            $t2[] = $d['Total'];
            $n3[] = $d['Name'];
        }
    } else {
        $today = date("Y-m-d", strtotime("-1 days"));
        $tt = date("Y-m-d", strtotime("-30 days"));
        $t = $tt;
        $sql = "SELECT SUM(qty), SUM(price * qty) FROM drinks_order, drinks_sold_record WHERE drinks_order.order_id = drinks_sold_record.order_id AND order_date <= '$today' AND order_date >= '$t'";
        $sql2 = "SELECT drinks_name, SUM(qty) FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id  = drinks_category.drinks_id 
        AND drinks_order.order_id = drinks_sold_record.order_id AND order_date <= '$today' AND order_date >= '$t' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC LIMIT 1";
        $result = $conn->query($sql);
        $result2 = $conn->query($sql2);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

        if (isset($row['SUM(qty)'])) {
            $today_qty = $row['SUM(qty)'];
        }
        if (isset($row['SUM(price * qty)'])) {
            $today_amount = $row['SUM(price * qty)'];
        }
        if (isset($row2['drinks_name'])) {
            $today_drink = $row2['drinks_name'];
        }

		//table data
		$sql3 = "SELECT DISTINCT `drinks_order`.`order_id`, `drinks_order`.`drinks_id`, `drinks_category`.`drinks_name`, `drinks_order`.`qty`, `drinks_order`.`price`, `drinks_sold_record`.`order_date`, `drinks_sold_record`.`order_time`, `drinks_sold_record`.`staff_id` FROM `drinks_order`, `drinks_sold_record`, `drinks_category` WHERE `drinks_order`.`order_id` = `drinks_sold_record`.`order_id` AND `drinks_order`.`drinks_id` = `drinks_category`.`drinks_id` AND `drinks_sold_record`.`order_date` <= '$today' AND `drinks_sold_record`.`order_date` >= '$t' ;";
		$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
		or die(mysqli_error($conn));

		$rc3 = mysqli_fetch_assoc($rs3);
		
		$table_data = "";
		
		if(mysqli_num_rows($rs3) > 0){
			do { 
				$order_id = $rc3['order_id'];
				$drinks_id = $rc3['drinks_id'];
				$drinks_name = $rc3['drinks_name'];
				$qty = $rc3['qty'];
				$price = $rc3['price'];
				$order_date = $rc3['order_date'];
				$order_time = $rc3['order_time'];
				$staff_id = $rc3['staff_id'];
				
				
				$table_data .= " <tr><td> $order_id </td><td> $drinks_id </td><td> $drinks_name </td><td> $qty </td><td> $price </td><td> $order_date </td><td> $order_time </td><td> $staff_id </td></tr>";
				
				
			}while($rc3 = mysqli_fetch_assoc($rs3)); 
		}else{
			//show nothing
			$table_data = "no record found";
		}

        //Data transfer to chart
        $query2 = sprintf("SELECT SUM(drinks_order.price * qty) AS Total, COUNT(drinks_order.drinks_id) AS ID, drinks_name AS Name, SUM(qty) AS Quantity FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id 
        AND drinks_order.order_id = drinks_sold_record.order_id AND order_date <= '$today' AND order_date >= $t GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC");

        $query3 = sprintf("SELECT SUM(drinks_order.price * qty) AS Total, drinks_name AS Name FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id 
        AND drinks_order.order_id = drinks_sold_record.order_id AND order_date <= '$today' AND order_date >= $t GROUP BY drinks_order.drinks_id ORDER BY SUM(drinks_order.price * qty) DESC");


        $result3 = $conn->query($query2);
        $result4 = $conn->query($query3);

        foreach ($result3 as $d) {
            $x2[] = $d['ID'];
            $n2[] = $d['Name'];
            $q2[] = $d['Quantity'];
        }

        foreach ($result4 as $d) {
            $t2[] = $d['Total'];
            $n3[] = $d['Name'];
        }
    }
	
	unset($_POST['period']);
} else if(isset($_POST['selectMonth'])){
	$inputMonth = $_POST['selectMonth'];
    $sql = "SELECT SUM(qty), SUM(price * qty) FROM drinks_order, drinks_sold_record WHERE drinks_order.order_id = drinks_sold_record.order_id AND order_date LIKE '$inputMonth%'";
    $sql2 = "SELECT drinks_name, SUM(qty) FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id  = drinks_category.drinks_id 
    AND drinks_order.order_id = drinks_sold_record.order_id AND order_date LIKE '$inputMonth%' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC LIMIT 1";
    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);


	if (isset($row['SUM(qty)'])) {
		$today_qty = $row['SUM(qty)'];
	}
	if (isset($row['SUM(price * qty)'])) {
		$today_amount = $row['SUM(price * qty)'];
	}
	if (isset($row2['drinks_name'])) {
		$today_drink = $row2['drinks_name'];
	}


	//table data
	$sql3 = "SELECT DISTINCT `drinks_order`.`order_id`, `drinks_order`.`drinks_id`, `drinks_category`.`drinks_name`, `drinks_order`.`qty`, `drinks_order`.`price`, `drinks_sold_record`.`order_date`, `drinks_sold_record`.`order_time`, `drinks_sold_record`.`staff_id` FROM `drinks_order`, `drinks_sold_record`, `drinks_category` WHERE `drinks_order`.`order_id` = `drinks_sold_record`.`order_id` AND `drinks_order`.`drinks_id` = `drinks_category`.`drinks_id` AND `drinks_sold_record`.`order_date` LIKE '$inputMonth%';";
	$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));

	$rc3 = mysqli_fetch_assoc($rs3);
	
	$table_data = "";
	
	if(mysqli_num_rows($rs3) > 0){
		do { 
			$order_id = $rc3['order_id'];
			$drinks_id = $rc3['drinks_id'];
			$drinks_name = $rc3['drinks_name'];
			$qty = $rc3['qty'];
			$price = $rc3['price'];
			$order_date = $rc3['order_date'];
			$order_time = $rc3['order_time'];
			$staff_id = $rc3['staff_id'];
			
			
			$table_data .= " <tr><td> $order_id </td><td> $drinks_id </td><td> $drinks_name </td><td> $qty </td><td> $price </td><td> $order_date </td><td> $order_time </td><td> $staff_id </td></tr>";
			
			
		}while($rc3 = mysqli_fetch_assoc($rs3)); 
	}else{
		//show nothing
		$table_data = "no record found";
	}

    //Data transfer to chart
    $query2 = "SELECT SUM(drinks_order.price * qty) AS Total, COUNT(drinks_order.drinks_id) AS ID, drinks_name AS Name, SUM(qty) AS Quantity FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id AND drinks_order.order_id = drinks_sold_record.order_id AND order_date LIKE '$inputMonth%' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC";

    $query3 = "SELECT SUM(drinks_order.price * qty) AS Total, drinks_name AS Name FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id AND drinks_order.order_id = drinks_sold_record.order_id AND order_date LIKE '$inputMonth%' GROUP BY drinks_order.drinks_id ORDER BY SUM(drinks_order.price * qty) DESC";

    $result3 = $conn->query($query2);
    $result4 = $conn->query($query3);

    foreach ($result3 as $d) {
        $x2[] = $d['ID'];
        $n2[] = $d['Name'];
        $q2[] = $d['Quantity'];
    }

    foreach ($result4 as $d) {
        $t2[] = $d['Total'];
        $n3[] = $d['Name'];
    }
	
	unset($_POST['selectMonth']);
} else if(isset($_POST['selectDate'])){
	$selectDate = $_POST['selectDate'];
    $sql = "SELECT SUM(qty), SUM(price * qty) FROM drinks_order, drinks_sold_record WHERE drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$selectDate'";
    $sql2 = "SELECT drinks_name, SUM(qty) FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id  = drinks_category.drinks_id 
    AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$selectDate' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC LIMIT 1";
    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);


	if (isset($row['SUM(qty)'])) {
		$today_qty = $row['SUM(qty)'];
	}
	if (isset($row['SUM(price * qty)'])) {
		$today_amount = $row['SUM(price * qty)'];
	}
	if (isset($row2['drinks_name'])) {
		$today_drink = $row2['drinks_name'];
	}


	//table data
	$sql3 = "SELECT DISTINCT `drinks_order`.`order_id`, `drinks_order`.`drinks_id`, `drinks_category`.`drinks_name`, `drinks_order`.`qty`, `drinks_order`.`price`, `drinks_sold_record`.`order_date`, `drinks_sold_record`.`order_time`, `drinks_sold_record`.`staff_id` FROM `drinks_order`, `drinks_sold_record`, `drinks_category` WHERE `drinks_order`.`order_id` = `drinks_sold_record`.`order_id` AND `drinks_order`.`drinks_id` = `drinks_category`.`drinks_id` AND `drinks_sold_record`.`order_date` = '$selectDate';";
	$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));

	$rc3 = mysqli_fetch_assoc($rs3);
	
	$table_data = "";
	
	if(mysqli_num_rows($rs3) > 0){
		do { 
			$order_id = $rc3['order_id'];
			$drinks_id = $rc3['drinks_id'];
			$drinks_name = $rc3['drinks_name'];
			$qty = $rc3['qty'];
			$price = $rc3['price'];
			$order_date = $rc3['order_date'];
			$order_time = $rc3['order_time'];
			$staff_id = $rc3['staff_id'];
			
			
			$table_data .= " <tr><td> $order_id </td><td> $drinks_id </td><td> $drinks_name </td><td> $qty </td><td> $price </td><td> $order_date </td><td> $order_time </td><td> $staff_id </td></tr>";
			
			
		}while($rc3 = mysqli_fetch_assoc($rs3)); 
	}else{
		//show nothing
		$table_data = "no record found";
	}

    //Data transfer to chart
    $query2 = "SELECT SUM(drinks_order.price * qty) AS Total, COUNT(drinks_order.drinks_id) AS ID, drinks_name AS Name, SUM(qty) AS Quantity FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$selectDate' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC";

    $query3 = "SELECT SUM(drinks_order.price * qty) AS Total, drinks_name AS Name FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$selectDate' GROUP BY drinks_order.drinks_id ORDER BY SUM(drinks_order.price * qty) DESC";

    $result3 = $conn->query($query2);
    $result4 = $conn->query($query3);

    foreach ($result3 as $d) {
        $x2[] = $d['ID'];
        $n2[] = $d['Name'];
        $q2[] = $d['Quantity'];
    }

    foreach ($result4 as $d) {
        $t2[] = $d['Total'];
        $n3[] = $d['Name'];
    }
	
	unset($_POST['selectDate']);
} else {

    $today = date("Y-m-d");
    $sql = "SELECT SUM(qty), SUM(price * qty) FROM drinks_order, drinks_sold_record WHERE drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$today'";
    $sql2 = "SELECT drinks_name, SUM(qty) FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id  = drinks_category.drinks_id 
    AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$today' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC LIMIT 1";
    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

    if (isset($row['SUM(qty)'])) {
        $today_qty = $row['SUM(qty)'];
    }
    if (isset($row['SUM(price * qty)'])) {
        $today_amount = $row['SUM(price * qty)'];
    }
    if (isset($row2['drinks_name'])) {
        $today_drink = $row2['drinks_name'];
    }

	//table data
	$sql3 = "SELECT DISTINCT `drinks_order`.`order_id`, `drinks_order`.`drinks_id`, `drinks_category`.`drinks_name`, `drinks_order`.`qty`, `drinks_order`.`price`, `drinks_sold_record`.`order_date`, `drinks_sold_record`.`order_time`, `drinks_sold_record`.`staff_id` FROM `drinks_order`, `drinks_sold_record`, `drinks_category` WHERE `drinks_order`.`order_id` = `drinks_sold_record`.`order_id` AND `drinks_order`.`drinks_id` = `drinks_category`.`drinks_id` AND `drinks_sold_record`.`order_date` = '$today';";
	$rs3 = mysqli_query($conn, $sql3) //mysqli_query() function performs a query against a database.
	or die(mysqli_error($conn));

	$rc3 = mysqli_fetch_assoc($rs3);
	
	$table_data = "";
	
	if(mysqli_num_rows($rs3) > 0){
		do { 
			$order_id = $rc3['order_id'];
			$drinks_id = $rc3['drinks_id'];
			$drinks_name = $rc3['drinks_name'];
			$qty = $rc3['qty'];
			$price = $rc3['price'];
			$order_date = $rc3['order_date'];
			$order_time = $rc3['order_time'];
			$staff_id = $rc3['staff_id'];
			
			
			$table_data .= " <tr><td> $order_id </td><td> $drinks_id </td><td> $drinks_name </td><td> $qty </td><td> $price </td><td> $order_date </td><td> $order_time </td><td> $staff_id </td></tr>";
			
			
		}while($rc3 = mysqli_fetch_assoc($rs3)); 
	}else{
		//show nothing
		$table_data = "no record found";
	}

    //Data transfer to chart
    $query2 = sprintf("SELECT SUM(drinks_order.price * qty) AS Total, COUNT(drinks_order.drinks_id) AS ID, drinks_name AS Name, SUM(qty) AS Quantity FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id 
    AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$today' GROUP BY drinks_order.drinks_id ORDER BY SUM(qty) DESC");

    $query3 = sprintf("SELECT SUM(drinks_order.price * qty) AS Total, drinks_name AS Name FROM drinks_order, drinks_category, drinks_sold_record WHERE drinks_order.drinks_id = drinks_category.drinks_id 
    AND drinks_order.order_id = drinks_sold_record.order_id AND order_date = '$today' GROUP BY drinks_order.drinks_id ORDER BY SUM(drinks_order.price * qty) DESC");

    $result3 = $conn->query($query2);
    $result4 = $conn->query($query3);

    foreach ($result3 as $d) {
        $x2[] = $d['ID'];
        $n2[] = $d['Name'];
        $q2[] = $d['Quantity'];
    }

    foreach ($result4 as $d) {
        $t2[] = $d['Total'];
        $n3[] = $d['Name'];
    }
	
	//unset($_POST['period']);

}


//print_r($_POST);
?>