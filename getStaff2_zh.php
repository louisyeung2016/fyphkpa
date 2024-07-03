<!DOCTYPE html>
<html>
<head>

</head>
<body>

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
	echo "<hr>";
	echo "<br>";
	echo "<form action=\"editstaffInfo.php\" method=\"post\" onsubmit=\"return varifyEditStaffInfo()\" >";
	echo "<input type=\"hidden\" id=\"staffID\" name=\"staffID\" value='". $row['staff_id'] ."' readonly >";
	echo "員工姓名:  &emsp;";
	echo "<input type=\"text\" id=\"name_edit\" name=\"name\" value='". $row['staff_name'] ."' required>";
	echo "<br><br>";
	echo "密碼:  &emsp;";
	echo "<input type=\"password\" id=\"pw_edit\" name=\"pw\"  pattern=\"(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\" title=\"Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters\" value='"."' required>";
	echo " <i class=\"fa-solid fa-eye\" id=\"eye2\" onclick=\"showPassword2()\" title=\"Show Password\" style=\"cursor: pointer;\"></i>";
	echo "<br><br>";
	echo "職位:  &emsp;";
	echo "<input type=\"hidden\" id=\"perA\" name=\"perA\" value='". $row['permission'] ."' readonly >";
	echo "<select id=\"per\" name=\"per\">
		<option value=\"Staff\">員工</option>
		<option value=\"Manager\">經理</option>
		</select>";
	echo "<br><br>";
	echo "<button type=\"submit\" class=\"btn btn-primary\" onclick=\"return confirm('Are you sure?');\"><i class=\"fa fa-edit\"></i> 確認</button>";
	echo "</form>";
}






mysqli_close($conn);
?>
</body>
</html>
