<?php
require('dbconnect.php');
$pname = $_POST['project_Name']; //ชื่อโปรเจค
// $fname =$_POST['project_Owner_fname']; //ชื่อเจ้าของโปรเจค
// $lname= $_POST['project_Owner_lname']; //นามสกุลเจ้าของโปรเจค

$ownerId = $_POST['idemp']; //ชื่อเจ้าของโปรเจค
$detail= $_POST['detail'];
$date = $_POST['dead_line']; //กำหนดเวลาของโปรเจค
$t = $_POST['team'];
$team = implode(",",$t); //เลือกลูกทีม
// print_r($_POST);
// exit;
$sql = "INSERT INTO project_create (project_name,create_by,detail,dead_line,team_member) VALUE ('$pname','$ownerId','$detail','$date','$team')" ;

$result = mysqli_query($con,$sql);


if($result){
    header('location:task.php');
    exit();

}else{
    mysqli_error($con);
}

?>