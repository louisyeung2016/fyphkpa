<?php
$s = htmlspecialchars($_GET['s'], ENT_QUOTES);

require_once("connection.php"); //require_once() = used to embed PHP code from another file


mysqli_select_db($conn,$db_db);
$sql="SELECT * FROM staff WHERE staff_id = '".$s."' AND status = 'Active'";
$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_array($result);

if(mysqli_num_rows($result) <= 0){
	echo "<b>staff not found</b>";
}else{
	
	$staff_id = $row['staff_id'];
	$staff_name = $row['staff_name'];
	$permission = $row['permission'];
	
	$out_str = <<<EOD
		<hr>
		<br>
		<form action="removestaff.php" method="post">
		<input type='hidden' id='staffID' name='staffID' value='$staff_id' readonly >
		員工姓名:  &emsp;
		<input type='text' id='name' name='name' value='$staff_name' readonly>
		<br><br>
		職位:  &emsp;
		<input type="text" id="per" name="per" value='$permission' readonly>
		<br><br>
		<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');"><i class="fa fa-exclamation-triangle"></i> 確認</button>
		</form>
	EOD;
	
	echo $out_str;
}




mysqli_close($conn);
?>