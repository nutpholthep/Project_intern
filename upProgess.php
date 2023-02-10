<?php
require('dbconnect.php');
$i = $_POST['act_id'];
$idupdate = $_POST['act_update'];

print_r($_POST);
exit;
$sql= "UPDATE activity SET activity_progress ='$idupdate'
WHERE activity_id = '$i'";
// echo $sql;
$result = mysqli_query($con,$sql);
header("location:mainpage.php?idp=".$_POST['idp']);
if($result){

}else{
    mysqli_error($con);
}

?>