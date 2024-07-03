<?php
require_once("connection.php");
extract($_POST);
$staffName = $Spassword = "";
$adminName = $Apassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(isset($_POST['Spassword'])){
		$Spassword = $_POST['Spassword'];
	}else if(isset($_POST['Apassword'])){
		$Apassword = $_POST['Apassword'];
	}
	
	if(isset($_POST['staffName'])){
		$staffName = $_POST['staffName'];
	}else if(isset($_POST['adminName'])){
		$adminName = $_POST['adminName'];
	}
   
	//hash the password first
	$Spassword_Hash = hash('sha256', $Spassword);
	$Apassword_Hash = hash('sha256', $Apassword);
   
   // username and password sent from form 
   $staffName = mysqli_real_escape_string($conn, $staffName);
   $Spassword = mysqli_real_escape_string($conn, $Spassword_Hash);
   $adminName = mysqli_real_escape_string($conn, $adminName);
   $Apassword = mysqli_real_escape_string($conn, $Apassword_Hash);

   $sqlS = "SELECT * FROM staff WHERE staff_name = '$staffName' AND password = '$Spassword' AND status = 'Active'";
   $sqlA = "SELECT * FROM staff WHERE staff_name = '$adminName' AND password = '$Apassword' AND status = 'Active'";
   $Sresult = mysqli_query($conn, $sqlS);
   $Aresult = mysqli_query($conn, $sqlA);
   $Srow = mysqli_fetch_array($Sresult, MYSQLI_ASSOC);
   $Arow = mysqli_fetch_array($Aresult, MYSQLI_ASSOC);

   $countS = mysqli_num_rows($Sresult);
   $countA = mysqli_num_rows($Aresult);
   // If result matched $staffID and $password, table row must be 1 row

   if ($countS == 1) {
      $perS = $Srow['permission'];
      if ($perS == "Admin" || $perS == "Staff" || $perS == "Manager") {    // set the staff login permission
         session_start();
         $_SESSION["permission"] = $Srow['permission'];
         $_SESSION["staffName"] = $Srow['staff_name'];
         $_SESSION["staffID"]= $Srow['staff_id'];
		 //get preference index of the user from Database
		 $preference_index_S = $Srow['preference_index'];
		 //set language preference
		 $_SESSION["language_index"] = intval($preference_index_S[0]);
		 //set Font Size preference
		 $_SESSION["fontSizeIndex"] = intval($preference_index_S[1]);
		 //set Theme Color preference
		 $_SESSION["themeColorIndex"] = intval($preference_index_S[2]);
		 //-------new added: count remain time-----------
		 $EnableLoginTime = 60*60*3; //3 hours
		 $now_time = time(); //get now time in Unix timestamp format
		 $expected_logout_time = $now_time + $EnableLoginTime; //get (now time + 3 hours) in Unix timestamp format
		 $expected_logout_time_milliseconds = $expected_logout_time *1000;//in Unix timestamp format & in milliseconds
		 //echo $expected_logout_time_milliseconds;
		 $_SESSION["expected_logout_time_milliseconds"] = $expected_logout_time_milliseconds;
		 //-------^^^^^^^^^^^^^^^^^^^^^^^^^^^^-----------
         setcookie("permission", $_SESSION["permission"] , time()+60*60*3);
         header("location: dashboard.php");
      } else {
         echo "<SCRIPT>  alert('Login failed. You have no permission')
         window.location.replace('index.html');
         </SCRIPT>";
      }
   }else if($countA == 1){
      $perA = $Arow['permission'];
      if ($perA == "Admin" || $perA == "Manager") {       // set the admin login permission
         session_start();
         $_SESSION["permission"] = $Arow['permission'];
         $_SESSION["staffName"] = $Arow['staff_name'];
         $_SESSION["staffID"]= $Arow['staff_id'];
		 //get preference index of the user from Database
		 $preference_index_A = $Arow['preference_index'];
		 //set language preference
		 $_SESSION["language_index"] = intval($preference_index_A[0]);
		 //set Font Size preference
		 $_SESSION["fontSizeIndex"] = intval($preference_index_A[1]);
		 //set Theme Color preference
		 $_SESSION["themeColorIndex"] = intval($preference_index_A[2]);
		 //-------new added: count remain time-----------
		 $EnableLoginTime = 60*60*3; //3 hours
		 $now_time = time(); //get now time in Unix timestamp format
		 $expected_logout_time = $now_time + $EnableLoginTime; //get (now time + 3 hours) in Unix timestamp format
		 $expected_logout_time_milliseconds = $expected_logout_time *1000;//in Unix timestamp format & in milliseconds
		 //echo $expected_logout_time_milliseconds;
		 $_SESSION["expected_logout_time_milliseconds"] = $expected_logout_time_milliseconds;
		 //-------^^^^^^^^^^^^^^^^^^^^^^^^^^^^-----------
         setcookie("permission", $_SESSION["permission"] , time()+60*60*3);
         header("location: controlpanel.php");
      } else {
         echo "<SCRIPT>  alert('Login failed. You have no permission')
         window.location.replace('index.html');
         </SCRIPT>";
      }
   } else {
      echo "<SCRIPT>  alert('Login failed. Invalid StaffName or Password')
      window.location.replace('index.html');
      </SCRIPT>";
   }

}
