
<?php
require('dbconnect.php');
$id = $_GET['iddel'];//รับไอดีจากหน้าDisplay
$idt = $_GET['idtask'];
$sql ="DELETE project_create , task  FROM project_create  INNER JOIN task  
WHERE project_create.project_id= task.project_id and project_create.project_id = $id";

$result = mysqli_query($con,$sql);

if($result){
  
   header("location:display.php");
}else{
    mysqli_error($con);
}

?>