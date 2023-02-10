<?php
require('dbconnect.php');
$sql2 = "SELECT task.task_id,activity.activity_id,activity.activity_name
FROM task
left JOIN activity ON task.task_id = activity.task_id
WHERE  activity.activity_id= ".$_POST['id'];
echo $sql2;
$act_query = mysqli_query($con,$sql2);
$actN =1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update</title>
</head>
<body>
<div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
          <form action="upProgess.php" method="post">
              <h1>อัพเดตกิจกรรมย่อย</h1>
              <input type="hidden" name="idp" value="<?php echo $_POST['idp'];?>">
                <table class="table table-striped mt-2 ">
                    <thead class="thead-dark">
                        <th>ลำดับที่</th>
                        <th>ชื่อกิจกรรมย่อย</th>
                        <th>อัพเดทความคืบหน้า</th>
                    </thead>
                    <tbody >
                        <?php while($lact=mysqli_fetch_assoc($act_query)){ ?>
                            <input type="hidden" name="act_id" value="<?php echo $lact['activity_id']?>">
                            <tr>
                        <td><?php echo $actN++ ?></td>
                        <td><?php echo $lact['activity_name']?></td>
                        <td> <input type="number" name="act_update" class="form-control" placeholder="ป้อนตัวเลข" min="0"></td>
                       </tr> 

<?php } ?>
      </div>
    </table>
    <div class="modal-footer">
      <button type="summit" class="btn btn-success">บันทึกข้อมูล</button>
    </div>
      </form>
    </div> 
</body>
</html>