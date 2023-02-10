<?php
require('dbconnect.php');
$id = $_GET['idp'];

$sql = "SELECT * FROM project_create
WHERE project_name = '$id'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$order = 1;

// $sql2 = "SELECT project_create.project_name,task.task_name,task.task_id,project_create.owner_fname
// FROM task
// RIGHT JOIN  project_create ON project_create.project_id = task.project_id
// WHERE project_create.project_id = $id";

$sql2 = "SELECT DISTINCT project_create.project_name,task.task_name,task.task_id,project_create.owner_fname,activity.activity_name,activity.activity_progress,project_create.detail,activity.activity_id,task.project_id
FROM task
RIGHT JOIN  project_create ON project_create.project_id = task.project_id
RIGHT JOIN  activity ON task.task_id = activity.task_id
WHERE project_create.project_name ='$id'";


$result_task = mysqli_query($con, $sql2);
// $task_query = mysqli_fetch_assoc($result_task);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project_Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
</head>

<body>
    <script>
        $(document).ready(function() {
            $(".open_update").click(function() {

                let idx = $(this).attr('idx');
                let idp = "<?php echo $_GET['idp']; ?>";
                $.post("modalupdate.php", {
                        id: idx,
                        idp: idp
                    },
                    function(result) {
                        $("#modal_update").html(result);
                    }
                );
                // modal หน้าmodal edit

            });
            $(".open_edit").click(function() {

                let idx = $(this).attr('idx');

                $.post("modaledit.php", {
                        id: idx
                    },
                    function(result) {
                        $("#modal_edit").html(result);
                    }
                );
                // modal หน้าmodal edit

            });

            var table = $('#progress').DataTable({
                "columnDefs": [{
                        "targets": [4, 5],
                        "render": function(data, type, row, meta) {
                            return '<div class="progress">' +
                                '<div class="progress-bar bg-success" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%' +
                                '</div>' +
                                '</div>';
                        }

                    }
                    // ColumnDefs คือคำสั่งที่เก็บการตกแต่งตารางในรูปแบบของ ArryObj
                    , {
                        "targets": 1,
                        "data": null,
                        "defaultContent": "<a class='btn btn-info rounded-circle'><i class='bi bi-pencil-square'></i></a>"
                    }

                ]

            });

            $('#progress tbody').on('click', 'a', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
            //สร้างตารางย่อยที่ซ่อนไว้
            function format(d) {
                // `d` is the original data object for the row
                return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                    '<tr>' +
                    '<td>ชื่องาน:</td>' +
                    '<td>' + d[2] + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>ชื่องาน:</td>' +
                    '<td>' + d[3] + '</td>' +
                    '</tr>' +

                    '<td>ความคืบหน้า:</td>' +
                    '<td>' + d[4] + '%' + '</td>' +
                    '<td>' + '<a href="' + 'idx=' + d[3] +
                    ' "class="btn btn-success bg-subtle ><i class="bi bi-arrow-repeat"></i> อัพเดทความคืบหน้า</a>' +
                    '</td>'


                '</table>';
            };

            // modal หน้าactivityNew

        });
    </script>

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


            <form action="edit_mainPage.php" method="post">
                <h1 class="text-center">รายละเอียดโปรเจค <?php echo $row['project_name'] ?></h1>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">ชื่อโปรเจค</span>
                    </div>
                    <input type="text" name="project_Name" class="form-control" placeholder="ป้อนชื่อโปรเจค" readonly value="<?php echo $row['project_name'] ?>">
                </div>
                <div class="input-group mt-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">ชื่อเจ้าของโปรเจค</span>
                    </div>
                    <input type="text" name="project_Owner_fname" class="form-control" placeholder="ป้อนชื่อ" readonly value="<?php echo $row['owner_fname'] ?>">
                    <input type="text" name="project_Owner_lname" class="form-control" placeholder="ป้อนนามสกุล" readonly value="<?php echo $row['owner_lname'] ?>">
                </div>




                <div class="input-group mt-3 row">
                    <div class="input-group-prepend col-auto">
                        <span class="input-group-text ">วันที่โปรเจคต้องเสร็จ</span>
                    </div>
                    <input type="date" name="dead_line" id="" class="form-control " readonly value="<?php echo $row['dead_line'] ?>">
                    <div class="input-group-prepend col-auto">
                        <span class="input-group-text ">วันที่สร้างโปรเจค</span>
                    </div>
                    <input type="timestam" name="c-time" id="" class="form-control " readonly value="<?php echo date("d-m-Y ", strtotime($row['create_time'])) ?>">
                </div>

                <div class="input-group mt-3 row">
                    <div class="input-group-prepend col-auto">
                        <span class="input-group-text ">วันที่อัพเดทโปรเจค</span>
                    </div>
                    <input type="date" name="u_time" id="" class="form-control" readonly value="<?php echo $row['update_time'] ?>">
                </div>

                <div class="form-floating mt-3">
                    <textarea class="form-control" placeholder="รายละเอียดงานโปรเจค" id="floatingTextarea" name="detail" readonly><?php echo $row['detail'] ?></textarea>
                    <label for="floatingTextarea">รายละเอียดงานโปรเจค</label>
                </div>
            </form>
            <div class="d-flex justify-content-end mb-3 ">
                <button class="btn btn-warning mt-3 open_edit" data-bs-target="#edit_page" data-bs-toggle="modal" idx="<?php echo $row['project_id'] ?>">แก้ไขรายละเอียดทั้งหมด</button>

            </div>
            <div class="d-flex justify-content-end">
                <a href="deleteProject.php?iddel=<?php echo $row['project_id'] ?>" class="btn btn-danger" onclick="return confirm('ต้องการลบโปรเจคนี้จริงหรือไม่')">ลบโปรเจค<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                    </svg></a>

            </div>


            <div class=" border-top mt-3">
                <h2 class="text-center">รายละเอียดงาน</h2>
                <form action="taskquery.php" method="post">
                    <table class=" table table-dark table-striped mt-2 " id="progress">
                        <thead class="thead-dark">
                            <th>ลำดับที่</th>
                            <th>อัปเดต</th>
                            <th>ชื่องาน</th>
                            <th>กิจกรรมย่อย</th>
                            <th>ความคืบหน้ากิจกรรมย่อย</th>
                            <th>ความคืบหน้าทั้งหมด</th>
                            <th>อัปเดตความคืบหน้า</th>
                        </thead>
                        <tbody>
                            <?php while ($task = mysqli_fetch_assoc($result_task)) { ?>
                                <tr>
                                    <td><?php echo $order++ ?></td>
                                    <td></td>
                                    <td><?php echo $task['task_name']; ?></td>
                                    <td><?php echo $task['activity_name']; ?></td>
                                    <td><?php echo $task['activity_progress'] ?></td>
                                    <td><?php echo $task['activity_progress'] ?></td>


                                    <td><button type="button" class="btn btn-success open_update" data-bs-toggle="modal" idx="<?php echo $task['activity_id'] ?>" data-bs-target="#add_update">
                                            อัปเดตความคืบหน้า
                                            <!-- < ?php echo $task['task_id'] ?> -->
                                        </button></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>

            <!-- modal -->
            <!-- แก้ไขข้อมูลในหน้าแสดงผลด้วย Modal -->
            <div class="modal fade modal-xl" id="edit_page">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title ">แก้ไขรายละเอียดทั้งหมด</h1>
                            <!-- ปุ่มปิดกากบาท -->
                            <button class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal_edit"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- modal update -->
            <div class="modal fade  modal-lg" id="add_update">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">อัพเดทความคืบหน้าของกิจกรรมย่อย</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal_update"></div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <?php
    echo $row['project_id'];
    // $arr = ['1', '2', '3'];

    // $new = implode(",", $arr);

    // echo $new;
    ?>
</body>

</html>