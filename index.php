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
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link">Create Projecte</a>
                        </li>
                        <li class="nav-item">
                            <a href="task.php" class="nav-link">Task</a>
                        </li>
                        <li class="nav-item">
                            <a href="display.php" class="nav-link">Display</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Report</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">

            <form action="addProject.php" method="post">
                <h1 class="text-center">Create Project</h1>
                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">ชื่อโปรเจค</span>
                </div>
                <input type="text" name="project_Name" class="form-control" placeholder="ป้อนชื่อโปรเจค">
        </div>
        <!-- DropDownเจ้าของโปรเจค -->
        <div class="input-group mt-3">
            <div class="input-group-prepend">
                    <span class="input-group-text">เจ้าของโปรเจค</span>
                </div>
            <select name="idemp" class="form-select" >
                <option selected>เลือกรหัสพนักงาน</option>
                <?php foreach($result as $id){ ?>

                    <option value="<?php echo $id['emp_id'] ?>">
                    <?php echo $id['emp_fname']." ".$id['emp_lname'] ?></option>
    
             <?php   } ?>
            </select>
        </div>
        <!-- รายละเอียดงาน -->
        <div class="form-floating mt-3">
            <textarea class="form-control" placeholder="รายละเอียดงานโปรเจค" id="floatingTextarea" name="detail"></textarea>
            <label for="floatingTextarea">รายละเอียดงานโปรเจค</label>
        </div>
        <div class="input-group mt-3 row-12">
            <div class="input-group-prepend">
                <span class="input-group-text ">วันที่โปรเจคต้องเสร็จ</span>
            </div>
            <input type="date" name="dead_line" min="<?php echo date('Y-m-d');?>" class="form-control col-lg-4" >
        </div>

        <div class="d-flex justify-content-end ">
            <button class="btn btn-success mt-3">Submit</button>

        </div>
        </form>

        <!-- <div class=" border-top mt-3">
                    <h2 class="text-center">Add Task</h2>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Task
                            </span>
                        </div>
                        <input type="text" name="addTask" class="form-control" placeholder="ป้อนTask">
                    </div>
                    <ul class="list-group m-3 g-gap2">
                        <li class="list-group-item shadow p-3 mb-2 bg-body-tertiary rounded ">Task 1</li>
                        <li class="list-group-item shadow p-3 mb-2 bg-body-tertiary rounded ">Task 2</li>
                        <li class="list-group-item shadow p-3 mb-2 bg-body-tertiary rounded ">Task 3</li>
                        <li class="list-group-item shadow p-3 mb-2 bg-body-tertiary rounded ">Task 4</li>

                    </ul>
                </div> -->

    </div>

    </div>
    </div>
    </div>

</body>

</html>