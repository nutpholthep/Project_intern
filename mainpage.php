<?php
require('dbconnect.php');
$id = $_GET['idp'];
$total = 0;
$numTask = 0;
$total_progress = 0;

$sql = "SELECT p.project_id,p.project_name,p.create_time,p.dead_line,p.update_time,p.create_by,p.detail,
p.update_by,p.owner,
emp.emp_id,emp.emp_fname,emp.emp_lname,t.team_member
FROM project_create AS p 
LEFT join employees AS emp on emp.emp_id = p.owner
LEFT JOIN team AS t on t.project_id = p.project_id 
WHERE p.project_id = $id";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$order = 1;

$sql2 = "SELECT DISTINCT project_create.project_name,task.task_name,task.task_id,activity.activity_name,activity.activity_progress,project_create.detail,activity.activity_id,task.project_id,project_create.project_id
FROM task
RIGHT JOIN  project_create ON project_create.project_id = task.project_id
RIGHT JOIN  activity ON task.task_id = activity.task_id 
WHERE project_create.project_id =$id 
ORDER BY task.task_id ";
// echo $sql2;

$result_task = mysqli_query($con, $sql2);
// $task_query = mysqli_fetch_assoc($result_task);

$IdTask;
$taskName = "";

$emp = "SELECT t.team_member,t.project_id,emp.emp_fname,emp.emp_lname,task.task_id,task.task_name
FROM team AS t
LEFT JOIN employees AS emp ON emp.emp_id = t.team_member
LEFT JOIN team_task AS ta ON ta.team_member =emp.emp_id
LEFT JOIN task on task.task_id = ta.task_id
WHERE t.project_id=$id
ORDER BY t.team_member ASC";

$result_emp = mysqli_query($con, $emp);
// echo $emp;
$a = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project_Page</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <!-- start datatable  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>

    <!-- end datatable  -->

    <!-- select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <!-- select2 -->

    <!-- responsive datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <!-- responsive datatable -->

    <!-- font-awsome -->

    <!-- font-awsome -->

</head>

<body>
    <script>
        $(document).ready(function() {
            // modal หน้าแก้ไขรายละเอียดทั้งหมด
            $("#open_edit").click(function() {

                let idx = $(this).attr('idx');

                $.post("modaledit.php", {
                        id: idx
                    },
                    function(result) {
                        $("#modal_edit").html(result);
                    }
                );


            });
            // modal หน้าแก้ไขActivity
            $(".open_Edact").click(function() {

                let idx = $(this).attr('idx');

                $.post("modalEditActivity.php", {
                        id: idx
                    },
                    function(result) {
                        $("#modal_edit_activity").html(result);
                    }
                );


            });
            // modal update
            $(".open_update").click(function() {

                let idx = $(this).attr('idx');
                let idp = "<?php echo $_GET['idp'] ?>"; //รับค่าจากurl (ที่เป็นตัวอักษรมาเก็บในตัวแปร)
                $.post("modalupdate.php", {
                        id: idx,
                        idp: idp //กำหนดArttr เพื่อส่งค่าไปหน้าอื่น
                    },
                    function(result) {
                        $("#modal_update").html(result);
                    }
                );


            });
            $(".open_memberTask").click(function() {

                let idx = $(this).attr('idx');
                let idp = "<?php echo $_GET['idp'] ?>"; //รับค่าจากurl (ที่เป็นตัวอักษรมาเก็บในตัวแปร)
                $.post("modalmember.php", {
                        id: idx,
                        idp: idp //กำหนดArttr เพื่อส่งค่าไปหน้าอื่น
                    },
                    function(result) {
                        $("#modal_add_memberTask").html(result);
                    }
                );


            });
            // var groupColumn = 2;
            // สร้างProgress_Bar
            var table = $('#progress').DataTable({

                responsive: true,
                "processing": true,
                "autoWidth": true,
                "columnDefs": [{
                        "targets": 3,
                        "render": function(data, type, row, meta) {
                            if (data <= 99) {
                                return '<div class="progress">' +
                                    '<div class=" progress-bar progress-bar-striped progress-bar-animated bg-warning text-dark fw-bold" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%' +
                                    '</div>' +
                                    '</div>';
                            } else {
                                return '<div class="progress">' +
                                    '<div class=" progress-bar progress-bar-striped progress-bar-animated bg-success  fw-bold" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%' +
                                    '</div>' +
                                    '</div>';
                            }
                        }

                    }, {
                        "targets": 4,
                        "render": function(data, type, row, meta) {
                            return '<div class="progress">' +
                                '<div class="progress-bar bg-success" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        responsivePriority: 1,
                        targets: 2
                    },
                    {
                        responsivePriority: 2,
                        targets: -1
                    },



                ],

            });

            var teammem = $('#teammem').DataTable({
                scrollY: '40vh',
                scrollCollapse: true,
                paging: false,
            });
        });
    </script>

    <?php
    include 'nav.php';

    ?>
    <div class="container-fluid">

        <div class="container shadow p-3 mb-5 mt-5 bg-body-tertiary rounded">
            <section>
                <!-- < ?php  $row = mysqli_fetch_assoc($result)  ?> -->
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

                    <input type="text" name="project_Owner_fname" class="form-control" placeholder="ป้อนชื่อ" readonly value="<?php echo $row['create_by'] . "" . $row['emp_fname'] ?>">

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


            </section>
            <div class="text-end mt-3">
                <a href="#" class=" btn btn-info open_memberTask" data-bs-toggle="modal" idx="<?php echo $id ?>" data-bs-target="#add_memberTask">เพิ่มงานที่รับผิดชอบ</a>
            </div>

            <div class="d-flex justify-content-end mb-3 ">
                <a href="#" id="open_edit" class="btn btn-warning mt-3 " data-bs-target="#edit_page" data-bs-toggle="modal" idx="<?php echo $row['project_id'] ?>">แก้ไขรายละเอียด <i class="bi bi-pencil-square"></i></a>
            </div>

            <div class="d-flex justify-content-end">
                <a href="deleteProject.php?iddel=<?php echo $row['project_id'] ?>" class="btn btn-danger" onclick="return confirm('ต้องการลบโปรเจคนี้จริงหรือไม่')">ลบโปรเจค<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                    </svg></a>
            </div>


            <div class="mt-3">
                <table class="table table-bordered table-striped " id="teammem">
                    <thead>
                        <tr>
                            <th>รหัสพนักงาน</th>
                            <th>ชื่อสมาชิก</th>
                            <th>งานที่รับผิดชอบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result_emp as $tem) { ?>
                            <?php
                            // ซ่อนชื่อซ้ำ
                            if ($a == $tem['emp_fname'] . "" . $tem['emp_lname']) {
                                $b = "";
                            } else {
                                $b = $tem['emp_fname'] . "" . $tem['emp_lname'];
                            }
                            ?>
                            <tr>
                                <td><?php echo $tem['team_member'] ?></td>
                                <td><?php echo $b; ?></td>
                                <td>
                                    <ul>
                                        <li><?php echo $tem['task_name'] ?></li>
                                    </ul>
                                </td>
                            </tr>

                        <?php $a = $tem['emp_fname'] . "" . $tem['emp_lname'];
                        } ?>

                        </tr>


                    </tbody>
                </table>
            </div>


            <!-- ส่วนของการแสดงรายละเอียดงานและอัพความคืบหน้า -->
            <div class=" border-top mt-3">
                <h2 class="text-center">รายละเอียดงาน</h2>
                <div>
                    <table class=" table table-light table-striped mt-2 display responsive nowrap" id="progress">
                        <thead class="table-dark">
                            <tr>
                                <th>ลำดับที่</th>
                                <th>ชื่องาน</th>
                                <th>กิจกรรมย่อย</th>
                                <th>ความคืบหน้ากิจกรรมย่อย</th>
                                <th>ความคืบหน้าทั้งหมด</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($task = mysqli_fetch_assoc($result_task)) { ?>
                                <tr>
                                    <td class="text-end"><?php echo $order++ ?></td>
                                    <?php
                                    // เงื่อนไขคือ เก็บproject_nameไว้ในตัวแปร a ลูปแรกที่เจอ project_name
                                    // เมื่อเข้าลูปที่ 2 ถ้าเจอproject_name ชื่อเดิมจะมีค่าเป็นจะให้เป็นค่าว่าง
                                    if ($taskName == $task['task_name']) {
                                        $tasknew = "";
                                    } else {
                                        $tasknew = $task['task_name'];
                                    }
                                    ?>
                                    <td class="table-light">
                                        <h5><?php echo $tasknew ?></h5>
                                    </td>

                                    <td>

                                        <?php echo $task['activity_name']; ?> <a href="#" class=" btn text-info open_update " data-bs-toggle="modal" idx="<?php echo $task['activity_id'] ?>" data-bs-target="#add_update"> <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                                                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z" />
                                            </svg>
                                        </a>

                                        <a href="#" class="btn text-warning open_Edact" data-bs-target="#edit_activity" data-bs-toggle="modal" idx="<?php echo $task['activity_id']; ?>"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg></a>

                                    </td>
                                    <td><?php echo $task['activity_progress'] ?></td>

                                    <!-- Query คำนวณ ProgressBar -->
                                    <?php $cout = "SELECT  COUNT(activity_progress),activity_progress,SUM(activity_progress)
                                           FROM activity 
                                       WHERE  task_id = " . $task['task_id'];
                                    $respon = mysqli_query($con, $cout);
                                    while ($data = mysqli_fetch_assoc($respon)) { ?>
                                        <?php
                                        if ($data['activity_progress'] == " ") { ?>
                                            <td>0</td>
                                        <?php } else { ?>
                                            <?php
                                            $sum = intval(($data['SUM(activity_progress)'] * 100) / ($data['COUNT(activity_progress)'] * 100));

                                            if ($total_progress == $sum) {
                                                $b = " 0";
                                            } else {
                                                $b = $sum;
                                            } ?>

                                            <td><?php echo $b; ?></td>
                                    <?php
                                        }
                                        $total_progress = intval(($data['SUM(activity_progress)'] * 100) / ($data['COUNT(activity_progress)'] * 100));
                                    }

                                    ?>



                                </tr>

                                <?php
                                //   ความคืบหน้าโปรเจคทั้งหมด
                                $task_total = "SELECT  activity_progress,task_id,COUNT(activity_progress),SUM(activity_progress)
                         FROM activity 
                        WHERE  activity_id = " . $task['activity_id'];
                                $task_pro = mysqli_query($con, $task_total);
                                foreach ($task_pro as $sumt) {
                                    $num = $sumt['activity_progress']; //เก็บค่าActtivityทั้งหมด
                                    $numrow = $sumt['COUNT(activity_progress)']; //นับจำนวนแถวทั้งหมด
                                    //  echo$IdTask;
                                    $numTask += $numrow; //นับจำนวนแถวทั้งหมด
                                    $total += $num; //เก็บค่าActtivityทั้งหมดมารวมกัน
                                } ?>
                            <?php
                                $taskName = $task['task_name'];
                            } ?>

                            <?php
                            //ตัวแปรที่เก็บค่าสูตรคำนวณโดยวิธีคิด จำนวนActtivityทั้งหมด*100/จำนวนแถวทั้งหมด
                            if ($numTask == 0) { ?>

                                <div id="detailProgress">
                                    <h3 class="text-decoration-underline badge bg-secondary text-wrap">ความคืบหน้าของโปรเจคโดยรวม</h3>
                                    <div class="progress mb-3" role="progressbar" aria-label="Info example " aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 1.5rem;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated " style="width:0%">0
                                        </div>
                                    </div>
                                </div>
                            <?php  } else {
                                $result_progessBar =  round(($total * 100) / ($numTask * 100), 2);
                                //  คำสั่งQueryคำนวณ
                            ?>
                                <div id="detailProgress">
                                    <input type="hidden" name="result_progessBar" value="<?php echo $result_progessBar ?>">
                                    <h3 class="text-decoration-underline badge bg-secondary text-wrap">ความคืบหน้าของโปรเจคโดยรวม</h3>
                                    <div class="progress mb-3" role="progressbar" aria-label="Info example " aria-valuenow="<?php echo  $result_progessBar ?>" aria-valuemin="0" aria-valuemax="100" style="height: 1.5rem;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated " style="width:<?= $result_progessBar ?>%"><?php echo  $result_progessBar . '%'; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php  } ?>

                        </tbody>
                    </table>
                </div>
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
            <div class="modal fade modal-lg modal-sm" id="add_update">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title">อัพเดทความคืบหน้าของกิจกรรมย่อย</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal_update"></div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- modal edit activity -->
            <div class="modal fade modal-lg modal-sm" id="edit_activity">
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

            <!-- modal ระบุว่าใครเป็นรับผิดชอบงานไหน -->
            <div class="modal fade modal-lg" id="add_memberTask">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">เลือกงานที่รับผิดชอบ</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="modal_add_memberTask"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</body>

</html>