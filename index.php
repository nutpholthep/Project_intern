
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">


</head>

<body>

    <div class="container-fulid">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top ">
            <!-- Content -->
            <div class="container-fluid">
                <!-- Brand -->
                <a href="index.php" class="navbar-brand">Project Tracking</a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#Nav_bar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Menu -->
                <div class="collapse navbar-collapse" id="Nav_bar">
                    <ul class="navbar-nav ">
                        <li class="nav-item active">
                            <a href="index.php" class="nav-link">Create Project</a>
                        </li>
                        <li class="nav-item">
                            <a href="task.php" class="nav-link">Task</a>
                        </li>
                        <li class="nav-item">
                            <a href="display.php" class="nav-link">Display</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

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
                <div class="input-group mt-3 row-12">
                    <div class="input-group-prepend">
                        <label for="employeesid" class=" input-group-text custom-select custom-select-sm">เจ้าของโปรเจค</label>
                    </div>
                    <input class="form-control" list="emp" id="employeesid" placeholder="ใส่รหัสพนักงานเพื่อค้นหา" name="idemp" autocomplete="off">
                    <div class="invalid-feedback">
                        กรุณากรอกรหัสพนักงานเพื่อค้นหา
                    </div>

                    <template id="resultstemplate">
                        <?php foreach ($result as $id) { ?>

                            <option value="<?php echo $id['emp_id'] ?>">
                                <?php echo $id['emp_id'] . " " . $id['emp_fname'] . " " . $id['emp_lname'] ?></option>

                        <?php   } ?>

                    </template>
                    <datalist id="emp"> </datalist>

                </div>

                <!-- เลือกลูกทีม -->
                <div class="input-group mt-3">
                    <label class="input-group-text" for="inputGroupSelect02">เลือกสมาชิกทีม</label>
                    <select id="team" class="form-select" size="3" multiple  name="team[]">
                        <?php foreach ($result as $id) { ?>

                            <option value="<?php echo $id['emp_id'] ?>">
                                <?php echo $id['emp_id'] . " " . $id['emp_fname'] . " " . $id['emp_lname'] ?></option>

                        <?php   } ?>
                    </select>
                </div>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
</svg> กดต้องการเลือกหลายคนให้กด<strong>CTRLหรือSHIFT แล้วคลิ๊กเลือก</strong>
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