
<?php
require_once('dbconnect.php');
$id = $_GET['iddel'];//รับไอดีจากหน้าDisplay

$sql = "UPDATE project_create
left JOIN task
SET project_create.status = 0 , task.status = 0
WHERE project_create.project_id = $id AND task.project_id  =$id ";



$result = mysqli_query($con,$sql);

if($result){
  
   header("location:display.php");
}else{
    mysqli_error($con);
}

?>