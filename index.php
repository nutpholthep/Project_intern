<?php
require('dbconnect.php');


$sql = "SELECT DISTINCT * FROM project_create
right JOIN employees ON project_create.create_by = employees.emp_id
GROUP BY employees.emp_id";
$result = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create_Project</title>
   
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-5.2.3/dist/css/bootstrap.min.css">
    <script src="bootstrap-5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="icons-1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">

    <script src="jquery/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="select2-develop/dist/css/select2.min.css">
    <script src="select2-develop/dist/js/select2.min.js"></script>
    <script src="select2-develop/dist/js/boostrap.bundle.min.js"></script>
    <link rel="stylesheet" href="select2-develop/dist/css/select2-bootstrap-5-theme.min.css">

  
    <!-- Selecet2 -->

</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.owner').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกหัวหน้าโปรเจค",
            });
            $('.team').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกสมาชิกทีม",

            });
            $('.createBy').select2({
                theme: 'bootstrap-5',
                placeholder: "เลือกชื่อของคุณ",

            });
        });
    </script>
    <?php
    include 'nav.php';

    ?>
    <div class="container-fulid">
        <div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">

            <form action="addProject.php" method="post" class="needs-validation ">
                <h1 class="text-center">สร้างโปรเจค</h1>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">ชื่อโปรเจค</span>
                    </div>
                    <input type="text" name="project_Name" class="form-control" placeholder="ป้อนชื่อโปรเจค" id="projectname" require>
                    <div class="invalid-feedback">
                        กรุณากรอกชื่อโปรเจค
                    </div>
                </div>


                <!-- DropDownเจ้าของโปรเจค -->

                <div class="input-group mt-3 ">
                    <label for="employeesid" class="input-group-text">เจ้าของโปรเจค</label>
                    <select class="owner form-select " name="idemp">
                        <option value="" selected>>----เลือกเจ้าของโปรเจค----<< /option>
                                <?php foreach ($result as $id) : ?>

                        <option value="<?php echo $id['emp_id'] ?>">
                            <?php echo $id['emp_id'] . " " . $id['emp_fname'] . " " . $id['emp_lname'] ?>
                        </option>

                    <?php endforeach; ?>
                    </select>
                </div>

                <!-- Start คนที่สร้างโปรเจค -->
                <!-- <div class="input-group mt-3 ">
                    <label for="employeesid" class="input-group-text">คนที่สร้างโปรเจค</label>
                    <select class="createBy form-select " name="createBy">
                        <option value="" selected>>----เลือกคนที่สร้างโปรเจค----<</option>
                                < ?php foreach ($result as $id) { ?>

                        <option value="< ?php echo $id['emp_id'] ?>">
                            < ?php echo $id['emp_id'] . " " . $id['emp_fname'] . " " . $id['emp_lname'] ?>
                        </option>

                    < ?php } ?>
                    </select>
                </div> -->
                <!-- End คนที่สร้างโปรเจค -->

                
                <!-- เลือกลูกทีม -->
                <div class="input-group mt-3">
                    <label class="input-group-text" for="team">เลือกสมาชิกทีม</label>
                    <select id="team" class="team form-select" multiple="multiple" name="team[]">

                        <?php foreach ($result as $id) : ?>

                            <option value="<?php echo $id['emp_id'] ?>">
                                <?php echo $id['emp_id'] . " " . $id['emp_fname'] . " " . $id['emp_lname'] ?></option>

                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </svg> สามารถพิมพ์ค้นหาชื่อสมาชิกได้
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <!-- รายละเอียดงาน -->
                <div class="form-floating mt-3">
                    <textarea id="detail" class="form-control" placeholder="รายละเอียดงานโปรเจค" name="detail"></textarea>
                    <label for="detail">รายละเอียดงานโปรเจค</label>
                    <div class="invalid-feedback">
                        ใส่รายละเอียดของโปรเจค
                    </div>
                </div>

                <div class="input-group mt-3 row-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text ">วันที่โปรเจคต้องเสร็จ</span>
                    </div>
                    <input type="date" name="dead_line" id="deadline" min="<?php echo date('Y-m-d'); ?>" class="form-control col-lg-4" max="<?php echo Date('Y-m-d', strtotime("+6 Month "));?>" >
                    <div class="invalid-feedback">
                        กรุณาเลือกวันสิ้นสุดโปรเจค
                    </div>
                </div>

                <div class="d-flex justify-content-end ">
                    <button class="btn btn-success mt-3" type="submit">Submit</button>

                </div>
            </form>



        </div>

    </div>
    <script src="app.js"></script>
</body>

</html>