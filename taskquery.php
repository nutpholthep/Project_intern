<?php

require("dbconnect.php");
$task_name = $_POST["addTask"];
$project_id = $_POST["taskID"];
$task_emp =$_POST['task_emp'];
$datetask =$_POST['datetask'];
// $pid = $_POST['project_id'];
// echo $idt;
// print_r($_POST);
// exit;

$sql = "INSERT INTO task (task_name,project_id,task_assignment,dead_line) 
VALUES ('$task_name','$project_id','$task_emp','$datetask')";
$result = mysqli_query($con,$sql);
if($result){
    header("location:task.php");

}
else{
    echo "เกิดข้อผิดพลาด";
}

?>