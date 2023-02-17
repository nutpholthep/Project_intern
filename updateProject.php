<?php
require('dbconnect.php');
$id = $_POST['idedit']; //โปรเจคId
$pname = $_POST['project_Name']; //ชื่อโปรเจค
$fname =$_POST['project_Owner_fname']; //ชื่อเจ้าของโปรเจค
$lname= $_POST['project_Owner_lname']; //นามสกุลเจ้าของโปรเจค
$date = $_POST['dead_line']; //กำหนดเวลาของโปรเจค
$updateTime = $_POST['update_time']; //กำหนดเวลาของโปรเจค
$eTask = $_POST['edit_task']; //กำหนดเวลาของโปรเจค
$eAct = $_POST['edit_act']; //กำหนดเวลาของโปรเจค
// print_r($_POST);
// exit;
$sql = "UPDATE project_create
inner join employees
SET project_create.project_name='$pname',employees.emp_fname='$fname',employees.emp_lname='$lname',project_create.dead_line='$date',project_create.update_time='$updateTime'
WHERE project_create.project_id = $id ";


$result = mysqli_query($con,$sql);
if($result){
    header('location:mainpage.php?idp='.$_POST['idedit']);
    exit();

}else{
    mysqli_error($con);
}

?>