
<?php
require_once('dbconnect.php');
$id = $_GET['iddel'];//รับไอดีจากหน้าDisplay

$sql ="DELETE FROM project_create 
WHERE project_id = $id";

$result = mysqli_query($con,$sql);

if($result){
  
   header("location:display.php");
}else{
    mysqli_error($con);
}

?>