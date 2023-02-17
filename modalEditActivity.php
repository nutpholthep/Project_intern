<?php
require('dbconnect.php');
$act = "SELECT task.task_id,activity.activity_id,activity.activity_name,task.project_id
FROM task
left JOIN activity ON task.task_id = activity.task_id
WHERE activity.activity_id = ".$_POST['id'];

$act_query = mysqli_query($con,$act);
$actN =1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
          <form action="editActivity.php" method="post">
              <h1>แก้ไขรายละเอียดกิจกรรมย่อย</h1>              
                <table class="table table-striped table-warning mt-2 ">
                    <thead class="thead-dark">
                        <th>ลำดับที่</th>
                        <th>ชื่อกิจกรรมย่อย</th>
                        <th>ลบงาน</th>
                    </thead>
                    <tbody >
                        <?php while($lact=mysqli_fetch_assoc($act_query)){ ?>
                            <input type="้hidden" name="act_id" value="<?php echo $lact['activity_id']?>">
                            <input type="hidden" name="task_id" value="<?php echo $lact['task_id']?>">
                            <input type="hidden" name="pro_id" value="<?php echo $lact['project_id']?>">
                           
                            <tr>
                        <td><?php echo $actN++ ?></td>
                        <td><input type="text" value="<?php echo $lact['activity_name']?>" name="edit_act"></td>
                        <td> <a href="deletetask.php?idtask=<?php echo $task['activity_id']; ?>" class="btn btn-danger" onclick=" return confirm('ต้องการลบข้อมูลหรือไม่??')">
                                            <i class="bi bi-trash"></i>ลบงาน</a></td>
                       </tr> 

<?php } ?>
</table>
   
      <div class="modal-footer">
        <button type="summit" class="btn btn-success">บันทึกข้อมูล</button>
      </div>
      </form>
    </div> 
</body>
</html>