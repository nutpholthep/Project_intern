
<?php
require("dbconnect.php");
$task = $_GET["idtask"]; ///เอามาจากปุ่มลบในหน้าTask
// print_r($_GET);
// exit;
/* A SQL query that is deleting the task from the database. */
// $sql ="DELETE FROM task
// WHERE task_id=$task";
$sql = "UPDATE task SET status =0
WHERE task_id =$task ";
$result = mysqli_query($con,$sql);

if($result){
    header("location:task.php");
 
}
else{
    echo "เกิดข้อผิดพลาด";
}

?>