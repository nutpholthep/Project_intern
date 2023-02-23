<?php
require('dbconnect.php');
$id = $_POST['idedit']; //โปรเจคId
$pname = $_POST['project_Name']; //ชื่อโปรเจค
$fname =$_POST['project_Owner_fname']; //ชื่อเจ้าของโปรเจค
$date = $_POST['dead_line']; //กำหนดเวลาของโปรเจค
$updateTime = $_POST['update_time']; //กำหนดเวลาของโปรเจค
$update_By = $_POST['update_by'];//ชื่อคนที่อัปเดต
// print_r($_POST);
// exit;
$sql = "UPDATE project_create

SET project_name='$pname',create_by='$fname',dead_line='$date',update_time='$updateTime',update_by='$update_By'
WHERE project_id = $id ";


$result = mysqli_query($con,$sql);
if($result){
    header('location:mainpage.php?idp='.$_POST['idedit']);
   

}else{
    mysqli_error($con);
}

?>