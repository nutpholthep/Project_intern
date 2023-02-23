<?php
require('dbconnect.php');
$pro =$_POST['idp'];
$i = $_POST['act_id'];
$act_name = $_POST['act_name'];
$idupdate = $_POST['act_update'];
$update_by = $_POST['update_by'];
print_r($_POST);
exit;
    $sql= "UPDATE activity SET activity_progress ='$idupdate'
    WHERE activity_id = '$i'";
    // echo $sql;
    $result = mysqli_query($con,$sql);
    if($result){
        // รับค่าที่ส่งจากหน้าupprogress
        $history ="INSERT INTO history_activity (update_by,activity_id,activity_name) 
        VALUES('$update_by','$i','$act_name')";
        $hisQuery = mysqli_query($con,$history);

        if($hisQuery){
            header("location:mainpage.php?idp=".$_POST['idp']);

        }
    }else{
        mysqli_error($con);
    }


?>