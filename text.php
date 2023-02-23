<?php
require('dbconnect.php');
$id = $_GET['idp'];

$sql = "SELECT p.project_id,p.project_name,p.create_time,p.dead_line,p.update_time,p.create_by,p.update_by,p.detail,p.owner,
emp.emp_id,emp.emp_fname,emp.emp_lname
FROM project_create AS p 
right join employees AS emp on emp.emp_id = p.owner
WHERE p.project_id = $id";
$result = mysqli_query($con, $sql);
// $row = mysqli_fetch_assoc($result);
$order = 1;
// echo $sql ."<br>";

// $sql2 = "SELECT project_create.project_name,task.task_name,task.task_id,project_create.owner_fname
// FROM task
// RIGHT JOIN  project_create ON project_create.project_id = task.project_id
// WHERE project_create.project_id = $id";

$sql2 = "SELECT DISTINCT project_create.project_name,task.task_name,task.task_id,activity.activity_name,activity.activity_progress,project_create.detail,activity.activity_id,task.project_id,project_create.project_id
FROM task
RIGHT JOIN  project_create ON project_create.project_id = task.project_id
RIGHT JOIN  activity ON task.task_id = activity.task_id 
WHERE project_create.project_id =$id ";
// echo $sql2;


$result_task = mysqli_query($con, $sql2);
// $task_query = mysqli_fetch_assoc($result_task);

$IdTask;
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- start datatable  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>

    <!-- end datatable  -->




    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- select2 -->

    <!-- responsive datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <!-- responsive datatable -->

    <!-- font-awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font-awsome -->

</head>

<body>
    <script>
        $(document).ready(function() {
            $(".open_update").click(function() {

                let idx = $(this).attr('idx');
                let idp = "<?php echo $_GET['idp']; ?>"; //รับค่าจากurl (ที่เป็นตัวอักษรมาเก็บในตัวแปร)
                $.post("modalupdate.php", {
                        id: idx,
                        idp: idp //กำหนดArttr เพื่อส่งค่าไปหน้าอื่น
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
            $(".open_edit_activity").click(function() {

                let idx = $(this).attr('idx');

                $.post("modalEditActivity.php", {
                        id: idx
                    },
                    function(result) {
                        $("#modal_edit_activity").html(result);
                    }
                );
                // modal หน้าmodal edit

            });
            // var groupColumn = 2;
            // สร้างProgress_Bar
            var table = $('#progress').DataTable({
                responsive: true,
                "columnDefs": [{
                        "targets": [3, 4],
                        "render": function(data, type, row, meta) {
                            return '<div class="progress">' +
                                '<div class="progress-bar bg-success" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%' +
                                '</div>' +
                                '</div>';
                        }

                    }
                    // ColumnDefs คือคำสั่งที่เก็บการตกแต่งตารางในรูปแบบของ ArryObj
                    // , {
                    //     "targets": 1,
                    //     "data": null,
                    //     "defaultContent": "<a class='btn btn-info rounded-circle'><taskID class='bi bi-pencil-square'></taskID></a>"
                    // }

                ],

            });


            // $('#progress tbody').on('click', 'a', function() {
            //     var tr = $(this).closest('tr');
            //     var row = table.row(tr);

            //     if (row.child.isShown()) {
            //         row.child.hide();
            //         tr.removeClass('shown');
            //     } else {
            //         row.child(format(row.data())).show();
            //         tr.addClass('shown');
            //     }
            // });
            //สร้างตารางย่อยที่ซ่อนไว้
            // function format(d) {
            //     // `d` is the original data object for the row
            //     return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
            //         '<tr>' +
            //         '<td>ชื่องาน:</td>' +
            //         '<td>' + d[2] + '</td>' +
            //         '</tr>' +
            //         '<tr>' +
            //         '<td>ชื่องาน:</td>' +
            //         '<td>' + d[3] + '</td>' +
            //         '</tr>' +

            //         '<td>ความคืบหน้า:</td>' +
            //         '<td>' + d[4] + '%' + '</td>' +
            //         '<td>' + '<a href="' + 'idx=' + d[3] +
            //         ' "class="btn btn-success bg-subtle ><taskID class="bi bi-arrow-repeat"></ห> อัพเดทความคืบหน้า</a>' +
            //         '</td>'


            //     '</table>';
            // };

            // สร้างตารางย่อยที่ซ่อนไว้

        });
    </script>

    <?php
    include 'nav.php';

    ?>
    <div class="container-fluid">

        <div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">


            <form action="edit_mainPage.php" method="post">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
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
                        <input type="text" name="project_Owner_fname" class="form-control" placeholder="ป้อนชื่อ" readonly value="<?php echo $row['owner'] . "" . $row['emp_fname'] . "" . $row['emp_lname'] ?>">

                    </div>
                    <div class="input-group mt-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">คนที่สร้างโปรเจค</span>
                        </div>
                        <?php foreach ($result as $em) { ?>

                            <input type="text" name="project_Owner_fname" class="form-control" placeholder="ป้อนชื่อ" readonly value="<?php echo $em['create_by'] . "" . $em['emp_fname'] ?>">
                        <?php   } ?>

                    </div>


                    <section class="row">
                        <div class="col-md-6 ">
                            <div class="input-group mt-3  ">
                                <div class="input-group-prepend col-12  col-md-4">
                                    <span class="input-group-text ">วันที่โปรเจคต้องเสร็จ</span>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input type="date" name="dead_line" id="" class="form-control " readonly value="<?php echo $row['dead_line'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group mt-3 ">
                                <div class="input-group-prepend col-12 col-md-4">
                                    <span class="input-group-text ">วันที่สร้างโปรเจค</span>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input type="timestam" name="c-time" id="" class="form-control " readonly value="<?php echo date("d-m-Y ", strtotime($row['create_time'])) ?>">

                                </div>
                            </div>
                        </div>

                    </section>



                    <div class="row">
                        <div class="col-md-6">

                            <div class="input-group mt-3 ">
                                <div class="input-group-prepend col-12 col-md-4 ">
                                    <span class="input-group-text ">วันที่อัพเดทโปรเจค</span>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input type="date" name="u_time" id="" class="form-control" readonly value="<?php echo $row['update_time'] ?>">
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="input-group mt-3">
                                <div class="input-group-prepend col-12 col-md-4">
                                    <span class="input-group-text ">คนที่อัพเดทโปรเจคล่าสุด</span>
                                </div>
                                <div class="col-12 col-md-8">
                                    <input type="text" name="update_by" id="" class="form-control" readonly value="<?php echo $row['update_by'] . "" . $row['emp_fname'] . "" . $row['emp_lname'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mt-3">
                        <textarea class="form-control" placeholder="รายละเอียดงานโปรเจค" id="floatingTextarea" name="detail" readonly><?php echo $row['detail'] ?></textarea>
                        <label for="floatingTextarea">รายละเอียดงานโปรเจค</label>
                    </div>

                    <div class="mt-3">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>รหัสพนักงาน</th>
                                    <th>ชื่อสมาชิก</th>
                                    <th>งานที่รับผิดชอบ</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>

                                    <?php if ($row['owner'] == "") { ?>
                                        <td colspan="3">
                                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                                <svg class="bi flex-shrink-0 me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-octagon" viewBox="0 0 16 16">
                                                    <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z" />
                                                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z" />
                                                </svg>
                                                <use xlink:href="#exclamation-triangle-fill" />
                                                </svg>
                                                <div>
                                                    ยังไม่มีการเพิ่มสมาชิก
                                                    <button class="btn btn-info">เพิ่มสมาชิก</button>
                                                </div>
                                            </div>
                                        </td>

                                    <?php } else { ?>
                                        <td><?= $row['emp_id'] ?></td>
                                        <td><?= $row['owner'] ?></td>
                                        <td rowspan="3">
                                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="flush-headingOne">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                            งานที่ได้รับมอบหมาย
                                                        </button>
                                                    </h2>
                                                    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <ul>
                                                                <li><?= $row['project_name'] ?></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                </tr>
                            <?php } ?>

                            </tbody>


                        </table>
                    </div>

            </form>
            <div class="d-flex justify-content-end mb-3 ">
                <button class="btn btn-warning mt-3 open_edit" data-bs-target="#edit_page" data-bs-toggle="modal" idx="<?php echo $row['project_id'] ?>">แก้ไขรายละเอียด <i class="bi bi-pencil-square"></i></button>

            </div>
            <div class="d-flex justify-content-end">
                <a href="deleteProject.php?iddel=<?php echo $row['project_id'] ?>" class="btn btn-danger" onclick="return confirm('ต้องการลบโปรเจคนี้จริงหรือไม่')">ลบโปรเจค<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                    </svg></a>

            </div>



        <?php } ?>
        <div class=" border-top mt-3">
            <h2 class="text-center">รายละเอียดงาน</h2>
            <form action="" method="post">
                <table class=" table table-dark table-striped mt-2 display responsive nowrap" id="progress">
                    <thead class="thead-dark">
                        <th>ลำดับที่</th>
                        <th>ชื่องาน</th>
                        <th>กิจกรรมย่อย</th>
                        <th>ความคืบหน้ากิจกรรมย่อย</th>
                        <th>ความคืบหน้าทั้งหมด</th>


                    </thead>
                    <tbody>
                        <?php while ($task = mysqli_fetch_assoc($result_task)) { ?>
                            <tr>
                                <td><?php echo $order++ ?></td>

                                <td><?php echo $task['task_name']; ?></td>

                                <td>

                                    <?php echo $task['activity_name']; ?> <button  class=" btn text-primary open_update" data-bs-toggle="modal" idx="<?php echo $task['activity_id'] ?>" data-bs-target="#add_update"> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z" />
                                        </svg>
                                        <?php $IdTask = $task['task_id'] ?>
                                    </button> 
                                    <a href="#" class="open_edit_activity" data-bs-target="#edit_activity" data-bs-toggle="modal" idx="<?php echo $task['activity_id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="yellow" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg></i></a>

                                </td>
                                <td><?php echo $task['activity_progress'] ?></td>

                                <!-- Query คำนวณ ProgressBar -->
                                <?php $cout = "SELECT COUNT(activity_progress),activity_progress,SUM(activity_progress)
                                           FROM activity 
                                       WHERE  task_id = $IdTask";
                                $respon = mysqli_query($con, $cout);
                                $data = mysqli_fetch_assoc($respon);
                                // echo  $data['activity_progress'];

                                // echo ($data['SUM(activity_progress)']*100)/($data['COUNT(activity_progress)']*100);
                                // Query คำนวณ ProgressBar End
                                ?>


                                <!-- <td>< ?php echo ($data['SUM(activity_progress)']*100)/($data['COUNT(activity_progress)']*100); ?></td> -->
                                <?php
                                if (!$data['activity_progress'] == " ") { ?>
                                    <td>0</td>

                                <?php } else { ?>
                                    <td><?php echo $sum = round(($data['SUM(activity_progress)'] * 100) / ($data['COUNT(activity_progress)'] * 100), 2); ?></td>
                                <?php    } ?>





                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </form>
        </div>
        <?php echo $sum; ?>
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

        <!-- modal edit activity -->
        <div class="modal fade  modal-lg" id="edit_activity">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">อัพเดทความคืบหน้าของกิจกรรมย่อย</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modal_edit_activity"></div>
                    </div>

                </div>
            </div>
        </div>

        </div>

    </div>

    <?php
    // echo $row['project_id'];
    // $arr = ['1', '2', '3'];

    // $new = implode(",", $arr);

    // echo $new;
    ?>
</body>

</html>