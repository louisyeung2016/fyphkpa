<?php
session_start();
include_once("./language/getStaff_string.php");

//get delete form
if(isset($_GET['s1'])){
	$s = htmlspecialchars($_GET['s1'], ENT_QUOTES);

	require_once("connection.php"); //require_once() = used to embed PHP code from another file


	mysqli_select_db($conn,$db_db);
	$sql="SELECT * FROM staff WHERE staff_id = '".$s."' AND status = 'Active' AND NOT permission ='Admin' ";
	$result = mysqli_query($conn,$sql);

	$row = mysqli_fetch_array($result);

	if(mysqli_num_rows($result) <= 0){
		echo "<b>$list_name_staffNotFound[$lang]</b>";
	}else{
		
		$staff_id = $row['staff_id'];
		$staff_name = $row['staff_name'];
		$permission = $row['permission'];
		
		$out_str = <<<EOD
			<hr>
			<br>
			<form action="removestaff.php" method="post">
			<input type='hidden' id='staffID' name='staffID' value='$staff_id' readonly >
			$list_name_staffName[$lang]:  &emsp;
			<input type='text' id='name' name='name' value='$staff_name' readonly>
			<br><br>
			$list_name_permission[$lang]:  &emsp;
			<input type="text" id="per" name="per" value='$permission' readonly>
			<br><br>
			<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?');"><i class="fa fa-exclamation-triangle"></i>  $list_name_confirmButton[$lang]</button>
			</form>
		EOD;
		
		
		echo $out_str;

	}

	mysqli_close($conn);
}


//get edit form
if(isset($_GET['s2'])){
	
	$s = htmlspecialchars($_GET['s2'], ENT_QUOTES);

	require_once("connection.php"); //require_once() = used to embed PHP code from another file


	mysqli_select_db($conn,$db_db);
	$sql="SELECT * FROM staff WHERE staff_id = '".$s."' AND status = 'Active'";
	$result = mysqli_query($conn,$sql);

	$row = mysqli_fetch_array($result);

	if(mysqli_num_rows($result) <= 0){
		echo "<b>$list_name_staffNotFound[$lang]</b>";
	}else{
		
		$staff_id = $row['staff_id'];
		$staff_name = $row['staff_name'];
		$permission = $row['permission'];
		
		$out_str = <<<EOD
			<hr>
			<br>
			<form action="editstaffInfo.php" method="post" onsubmit="return varifyEditStaffInfo()" >
			<input type="hidden" id="staffID" name="staffID" value='$staff_id' readonly >
			$list_name_staffName[$lang]:  &emsp;
			<input type="text" id="name_edit" name="name" value='$staff_name' required>
			<br><br>
			$list_name_password[$lang]:  &emsp;
			<input type="password" id="pw_edit" name="pw"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" value='' required>
			<i class="fa-solid fa-eye" id="eye2" onclick="showPassword2()" title="Show Password" style="cursor: pointer;"></i>
			<br><br>
			$list_name_permission[$lang]:  &emsp;
			<input type="hidden" id="perA" name="perA" value='$permission' readonly >
			<select id="per" name="per">
				<option value="Staff">$list_name_jobPos1[$lang]</option>
				<option value="Manager">$list_name_jobPos2[$lang]</option>
			</select>
			<br><br>
			<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?');"><i class="fa fa-edit"></i> $list_name_confirmButton[$lang]</button>
			</form>
		EOD;
		
		$out_str_admin = <<<EOD
			<hr>
			<br>
			<form action="editstaffInfo.php" method="post" onsubmit="return varifyEditStaffInfo()" >
			<input type="hidden" id="staffID" name="staffID" value='$staff_id' readonly >
			$list_name_staffName[$lang]:  &emsp;
			<input type="text" id="name_edit" name="name" value='$staff_name' required>
			<br><br>
			$list_name_password[$lang]:  &emsp;
			<input type="password" id="pw_edit" name="pw"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" value='' required>
			<i class="fa-solid fa-eye" id="eye2" onclick="showPassword2()" title="Show Password" style="cursor: pointer;"></i>
			<br><br>
			$list_name_permission[$lang]:  &emsp;
			<input type="hidden" id="perA" name="perA" value='$permission' readonly >
			<select id="per" name="per">
				<option value="Admin">$list_name_jobPos3[$lang]</option>
			</select>
			<br><br>
			<button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?');"><i class="fa fa-edit"></i> $list_name_confirmButton[$lang]</button>
			</form>
		EOD;
		
		if($staff_id == "1"){
			echo $out_str_admin;
		}else{
			echo $out_str;
		}
		
		
	}

	mysqli_close($conn);
	
}

?>