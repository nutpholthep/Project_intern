<?php

require("dbconnect.php");
// print_r($_POST);
// exit;
$task_name = $_POST["addTask"];
$project_id = $_POST["taskID"];
// $pid = $_POST['project_id'];
// echo $idt;

$sql = "INSERT INTO task (task_name,project_id) VALUES ('$task_name','$project_id')";
$result = mysqli_query($con,$sql);
if($result){
    header("location:task.php");
  exit(0);
}
else{
    echo "เกิดข้อผิดพลาด";
}

?>