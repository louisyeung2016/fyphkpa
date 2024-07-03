<?php
    class returnProcessing{
        private $link;

        function __construct(){
			include('connection.php'); //only change variables in connection.php
            $this->link= new mysqli($db_host,$db_user,$db_password,$db_db);
            if(mysqli_connect_errno()){
                die ("connection failed".mysqli_connect_errno());
            }
        }

        function display(){
            if(isset($_POST['roomNum'])){
                $selected = $_POST['roomNum'];
                if(isset($_SESSION['getIDArray'])){
                    unset($_SESSION['getIDArray']);
                }
                $sql = $this->link->stmt_init();
                if($sql->prepare("SELECT rental_id, rental_record.item_id, item_name, room_number, organization_name, borrow_date, borrow_time, borrow_staff_id, staff.staff_name, rental_record.status, compensation_price
                FROM rental_record, rental_item_category, staff WHERE rental_record.item_id = rental_item_category.item_id AND rental_record.borrow_staff_id = staff.staff_id AND room_number = '$selected' AND rental_record.status = 'borrow'
                ORDER BY item_name, borrow_date, borrow_time ASC")){
                    $sql->bind_result($rental_id,$item_id,$item_name,$room_number,$apply_group,$borrow_date,$borrow_time,$staff,$staff_name, $status, $price);
                    if($sql->execute()){
                        while($sql->fetch()){   
                ?>
                    <tr>
                        <td><?php echo "<img src='image/" .  $item_id  . ".png' onerror=\"this.onerror=null; this.src='image/000.png'\" width=70 height=70/>"; ?></td>
                        <td><?php echo $rental_id;?></td>
                        <td><?php echo $item_name;?></td>
                        <td><?php echo $room_number;?></td>
                        <td><?php echo $apply_group;?></td>
                        <td><?php echo $borrow_date;?></td>
                        <td><?php echo $borrow_time;?></td>
                        <td><?php echo $staff_name;?></td>
                        <td class="text-center"><?php echo $price;?></td>
                        <td><p id="display_<?php echo $rental_id; ?>"><?php echo $status;?></p></td>
                        <td>
                            <select status-id="<?php echo $rental_id;?>" status-item="<?php echo $item_name;?>" status-item-id="<?php echo $item_id;?>" status-price="<?php echo $price;?>" 
                            class="selectstatus" id="selectstatus" onchange="myfunction(this.value, <?php echo $price ?>)">
                            <option value="borrow" >borrow</option>
                            <option value="return" >return</option>
                            <option value="brokenOrlost" >broken or lost</option>
                            </select>
                        </td>
                    </tr>
                <?php   
                        }
                    }
                }
            }else{
                if(!isset($selected)){
                    echo 'Please select the room.';
                }
            }
            if(isset($_GET['answer'])){
                    $_SESSION['answer'] = $_GET['answer'];
            } 

            /*foreach($_SESSION["getIDArray"] as $key => $value){
                echo $key;
                foreach($value as $x => $y){
                    //echo $x;
                    echo "<td>";
                    echo  $y;
                    echo "</td>";
                }
            }*/
        }

        function getdata($statusid,$id,$item,$itemid,$price){
            session_start();
            date_default_timezone_set("Asia/Hong_Kong");
            $time = date('H:i:s');
            $date = date('Y-m-d');
            $staff = $_SESSION['staffID'];
            $getID = array();
            $sql = $this->link->stmt_init();
            if(isset($_SESSION['answer'])){
                $answer = $_SESSION['answer'];
            }
            if($statusid == "return"){
                if($sql->prepare("UPDATE rental_record SET return_date = '$date', return_time = '$time', return_staff_id = '$staff', status = ? WHERE rental_id=? ")){
                    $sql->bind_param('ss',$statusid,$id);
                    if($sql->execute()){
                        echo $statusid;
                        array_push($getID, $id);
                    }else{
                        echo "Update Failed";
                    }
                    // when user selected return it will store the rental_id in the getIDArray
                    if(!isset($_SESSION["getIDArray"])){
                        $_SESSION["getIDArray"] = array();
                    }
                    array_push($_SESSION["getIDArray"], $getID);
                }
                if($sql->prepare("UPDATE rental_item_category SET qty = qty + 1 WHERE item_name=? ")){
                    $sql->bind_param('s',$item);
                    $sql->execute();
                }
            }elseif($statusid == "borrow"){
                if($sql->prepare("UPDATE rental_record SET return_date = NULL, return_time = NULL, return_staff_id = NULL, status = 'borrow' WHERE rental_id=? ")){
                    $sql->bind_param('s',$id);
                    if($sql->execute()){
                        echo $statusid;
                    }else{
                        echo "Update Failed";
                    }
                    if($sql->prepare("UPDATE rental_item_category SET qty = qty - 1 WHERE item_name=? ")){
                        $sql->bind_param('s',$item);
                        $sql->execute();
                    }
                    // if user selected borrow it will unset the getIDArray of rental id
                    foreach($_SESSION["getIDArray"] as $key => $value){
                        foreach($value as $x => $y){
                            if($y == $id){
                                unset($_SESSION["getIDArray"][$key]);
                            }
                        }
                    }
                }
            }else{
                $check = checkID($id);
                if($check == $id && $statusid == "brokenOrlost"){
                    if($answer == "yes"){
                        if($sql->prepare("UPDATE rental_record SET return_date = '$date', return_time = '$time', return_staff_id = '$staff', status = ? WHERE rental_id=? ")){
                            $sql->bind_param('ss',$statusid,$id);
                            if($sql->execute()){
                                echo $statusid;
                                unset($_SESSION['getIDArray']);
                            }else{
                                echo "Update Failed";
                            }
                            if($sql->prepare("INSERT INTO compensation (rental_id, item_id, compensation_price) VALUES (?,?,?)")){
                                $sql->bind_param('ssi',$id,$itemid,$price);
                                $sql->execute();
                            }
                            if($sql->prepare("UPDATE rental_item_category SET qty = qty - 1 WHERE item_name=? ")){
                                $sql->bind_param('s',$item);
                                $sql->execute();
                            }
                        }
                    }else{
                        // do nothing
                    }
                }else{
                    if($statusid == "brokenOrlost"){
                        if($answer == "yes"){
                            if($sql->prepare("UPDATE rental_record SET return_date = '$date', return_time = '$time', return_staff_id = '$staff', status = ? WHERE rental_id=? ")){
                                $sql->bind_param('ss',$statusid,$id);
                                if($sql->execute()){
                                    echo $statusid;
                                    unset($_SESSION['getIDArray']);
                                }else{
                                    echo "Update Failed";
                                }
                                if($sql->prepare("INSERT INTO compensation (rental_id, item_id, compensation_price) VALUES (?, ?, ?)")){
                                    $sql->bind_param('ssi',$id,$itemid,$price);
                                    $sql->execute();
                                }
                            }
                        }else{
                            // do nothing
                        }
                    }
                }
            }      
        }
    }
    // for check getIDArray is equal selected row of rental id or not
    function checkID($id){
        session_start();
        $t = $_SESSION['getIDArray'];
        $c = "";
        foreach($t as $value){
            if($value[0] == $id){
                $c = $id;
            }
        }
        return $c;
    }
    
?>

<script>
    function myfunction(value, price){
        if(value == "brokenOrlost"){
            var message = confirm("Are you sure the item is broken or lost?");
            if(message){
                var answer = "yes";
            }else{
                var answer = "no";
            }

            if(answer == "yes"){
                alert("The Compensation Price is : " + "$" + price);
            }

            window.location.href = "return.php?answer=" + answer; 
        }
    }
</script>