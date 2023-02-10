<?php
require('dbconnect.php');
$sql = "SELECT * FROM project_create
WHERE project_id =".$_POST['id'];
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

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
        <form action="updateProject.php" method="post">
            <!-- <input type="hidden" name="idedit" value="<?php echo $row['project_id']; ?>"> -->
            <h1 class="text-center">รายละเอียดโปรเจค <?php echo $row['project_name'] ?></h1>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">ชื่อโปรเจค</span>
                </div>
                <input type="text" name="project_Name" class="form-control" placeholder="ป้อนชื่อโปรเจค" value="<?php echo $row['project_name'] ?>">
            </div>
            <div class="input-group mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">ชื่อเจ้าของโปรเจค</span>
                </div>
                <input type="text" name="project_Owner_fname" class="form-control" placeholder="ป้อนชื่อ" value="<?php echo $row['owner_fname'] ?>">
                <input type="text" name="project_Owner_lname" class="form-control" placeholder="ป้อนนามสกุล" value="<?php echo $row['owner_lname'] ?>">
            </div>


            <div class="input-group mt-3 row-12">
                <div class="input-group-prepend">
                    <span class="input-group-text ">วันที่โปรเจคต้องเสร็จ</span>
                </div>
                <input type="date" name="dead_line" id="" class="form-control col-lg-4" value="<?php echo $row['dead_line'] ?>" min="<?php echo date('Y-m-d'); ?>">
                <div class="input-group-prepend">
                    <span class="input-group-text ">วันที่สร้างโปรเจค</span>
                </div>
                <input type="timestam" name="c-time" id="" class="form-control col-lg-4" readonly value="<?php echo date("d-m-Y ", strtotime($row['create_time'])) ?>">
                <div class="input-group-prepend">
                    <span class="input-group-text ">วันที่อัพเดทโปรเจค</span>
                </div>
                <input type="date" name="update_time" id="" class="form-control col-lg-4" value="<?php echo $row['update_time'] ?>" min="<?php echo date('Y-m-d'); ?>">
            </div>


    </div>


    <div class="modal-footer">
        <button class="btn btn-danger" data-bs-dismiss="modal">ยกเลิก</button>
        <button class="btn btn-success">บันทึกข้อมูล</button>
    </div>
    </form>
    </div>
    </div>
    </div>
</body>

</html>