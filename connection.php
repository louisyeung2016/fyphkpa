<?php      
  $db_host = 'localhost:3306';
  $db_user = 'root';
  $db_password = '';
  $db_db = 'hkpa_db2';
      
    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_db);  
    if(mysqli_connect_errno()) {  
        die("Failed to connect with MySQL: ". mysqli_connect_error());  
    }  
    
?>  