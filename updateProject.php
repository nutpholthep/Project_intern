<?php
require('dbconnect.php');
$id = $_POST['idedit']; //โปรเจคId
$pname = $_POST['project_Name']; //ชื่อโปรเจค
$fname =$_POST['project_Owner_fname']; //ชื่อเจ้าของโปรเจค
$lname= $_POST['project_Owner_lname']; //นามสกุลเจ้าของโปรเจค
$date = $_POST['dead_line']; //กำหนดเวลาของโปรเจค
$updateTime = $_POST['update_time']; //กำหนดเวลาของโปรเจค
// print_r($_POST);
// exit;
$sql = "UPDATE project_create
SET project_name='$pname',owner_fname='$fname',owner_lname='$lname',dead_line='$date',update_time='$updateTime'
WHERE project_id = $id";

$result = mysqli_query($con,$sql);
if($result){
    header('location:display.php');
    exit();

}else{
    mysqli_error($con);
}

?>