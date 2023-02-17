<?php
require ('dbconnect.php');
$task_id =$_POST['task_id'];
$act_id = $_POST['act_id'];
$eAct_id =$_POST['edit_act'];
$proj_id =$_POST['pro_id'];
$sql = "UPDATE activity 
SET activity_name = '$eAct_id'
WHERE activity_id =$act_id and task_id = $task_id";
// print_r($_POST);
// exit;
$result =mysqli_query($con,$sql);


if($result){
  
    header("location:mainpage.php?idp=".$proj_id);
 }else{
     mysqli_error($con);
 }





?>