<!DOCTYPE html>
<html lang="en">
<?php
require('dbconnect.php');
$order = 1;
$actN = 1;
$sql = "SELECT * FROM project_create";
$sql2 = " SELECT project_create.project_name,task.task_name,task.task_id
FROM task
RIGHT JOIN  project_create ON project_create.project_id = task.project_id 
ORDER BY project_create.project_id";


$task_query = mysqli_query($con, $sql2);
$result = mysqli_query($con, $sql);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <!-- datatable -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>




    <script>
        $(document).ready(function() {
            // modal หน้าactivityNew
            $(".open_activity").click(function() {

                var idx = $(this).attr('idx');

                $.post("activityNew.php", {
                        id: idx
                    },
                    function(result) {
                        $("#modal_act").html(result);
                    }
                );
                // modal หน้าactivityNew end

            });

            $('#taskTable').DataTable();



        });
    </script>
</head>

<body>
    <div class="container-fluid">
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
            <div class="  mt-3">
                <h2 class="text-center">สร้างงาน</h2>
                <form action="taskquery.php" method="post">

                    <select name="taskID" class="form-control" required>
                        <option value="">-เลือกหัวข้อโปรเจค-</option>
                        <?php foreach ($result as $results) { ?>
                            <option value="<?php echo $results["project_id"]; ?>">
                                <?php echo $results["project_name"]; ?>
                            </option>
                        <?php } ?>
                    </select>
                    <div class="input-group mt-3 mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                Task
                            </span>
                        </div>
                        <input type="text" name="addTask" class="form-control" placeholder="ป้อนชื่องาน" autocomplete="off">
                        <button class="btn btn-success">เพิ่มงาน</button>
                    </div>
                    <table class="table table-striped mt-3 " id="taskTable">
                        <thead class="thead-dark">
                            <th>ลำดับที่</th>
                            <th>ชื่อโปรเจค</th>
                            <th>ชื่องาน</th>
                            <th>กิจกรรมย่อย</th>
                            <th>ลบงาน</th>
                        </thead>
                        <tbody>
                            <?php while ($task = mysqli_fetch_assoc($task_query)) { ?>
                                <tr>
                                    <td><?php echo $order++ ?></td>
                                    <td><?php echo $task['project_name']; ?></td>
                                    <td><?php echo $task['task_name']; ?></td>
                                    <td>

                                        <!--START ถ้ายังไม่เพิ่มTaskปุ่มเพิ่มActivity จะไม่สามารถเพิ่มข้อมูลได้ -->
                                        <?php
                                        if ($task['task_name'] == '') { ?>
                                            <button href="" class="btn btn-info open_activity" disabled>
                                                <i class="bi bi-plus-circle-fill"></i>
                                                เพิ่มกิจกรรมย่อย
                                            </button>
                                        <?php   } else { ?>

                                            <a href="" class="btn btn-info open_activity" data-bs-target="#add_act" data-bs-toggle="modal" idx="<?php echo $task['task_id']; ?>">
                                                <i class="bi bi-plus-circle-fill"></i>
                                                เพิ่มกิจกรรมย่อย
                                            </a>
                                        <?php   } ?>
                                        <!-- ถ้ายังไม่เพิ่มTaskปุ่มเพิ่มActivity จะไม่สามารถเพิ่มข้อมูลได้ END-->
                                    </td>

                                    <td>
                                        <a href="deletetask.php?idtask=<?php echo $task['task_id']; ?>" class="btn btn-danger" onclick=" return confirm('ต้องการลบข้อมูลหรือไม่??')"><i class="bi bi-trash"></i>ลบงาน</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>


        <!-- modal activity -->
        <div class="modal fade modal-xl" id="add_act">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่มกิจกรรมย่อยใน </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modal_act"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>

</html>