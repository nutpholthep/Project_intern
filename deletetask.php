<?php
require("dbconnect.php");
$task = $_GET["idtask"]; ///เอามาจากปุ่มลบในหน้าTask

$sql ="DELETE FROM task
WHERE task_id=$task";
$result = mysqli_query($con,$sql);

if($result){
    header("location:task.php");
  exit(0);
}
else{
    echo "เกิดข้อผิดพลาด";
}

?>