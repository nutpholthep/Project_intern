<?php
require('dbconnect.php');
$pname = $_POST['project_Name']; //ชื่อโปรเจค
// $fname =$_POST['project_Owner_fname']; //ชื่อเจ้าของโปรเจค
// $lname= $_POST['project_Owner_lname']; //นามสกุลเจ้าของโปรเจค

$ownerId = $_POST['idemp'];
$detail= $_POST['detail'];
$date = $_POST['dead_line']; //กำหนดเวลาของโปรเจค
// print_r($_POST);
// exit;
$sql = "INSERT INTO project_create (project_name,create_by,detail,dead_line) VALUE ('$pname','$owner','$detail','$date')" ;

$result = mysqli_query($con,$sql);


if($result){
    header('location:task.php');
    exit();

}else{
    mysqli_error($con);
}

?>