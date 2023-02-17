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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="style.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

    <!-- Selecet2 -->
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        });
    </script>
    <div class="container-fulid">
    <?php
include 'nav.php';

?>
        <div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">

            <form action="addProject.php" method="post" class="needs-validation">
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
                                <?php foreach ($result as $id) { ?>

                        <option value="<?php echo $id['emp_id'] ?>">
                            <?php echo $id['emp_id'] . " " . $id['emp_fname'] . " " . $id['emp_lname'] ?>
                        </option>

                    <?php } ?>
                    </select>
                </div>

                <!-- เลือกลูกทีม -->
                <div class="input-group mt-3">
                    <label class="input-group-text" for="team">เลือกสมาชิกทีม</label>
                    <select id="team" class="team form-select" multiple="multiple" name="team[]">
                        <?php foreach ($result as $id) { ?>

                            <option value="<?php echo $id['emp_id'] ?>">
                                <?php echo $id['emp_id'] . " " . $id['emp_fname'] . " " . $id['emp_lname'] ?></option>

                        <?php   } ?>
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
                    <input type="date" name="dead_line" id="deadline" min="<?php echo date('Y-m-d'); ?>" class="form-control col-lg-4">
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