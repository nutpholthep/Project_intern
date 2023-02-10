<?php
require('dbconnect.php');

// $sql = "SELECT * FROM project_create";
// $result = mysqli_query($con, $sql);

$sql2 = " SELECT project_create.project_name,task.task_name,task.task_id,project_create.create_time,project_create.dead_line,project_create.detail,employees.emp_fname,employees.emp_lname,project_create.create_by
FROM task
right JOIN  project_create ON project_create.project_id = task.project_id
left JOIN  employees ON employees.emp_id = project_create.create_by
GROUP BY project_create.project_id";
$result_task = mysqli_query($con, $sql2);
// $task = mysqli_fetch_assoc($result_task);
$order = 1;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <script src="jquery-3.3.1.min.js"></script>

    <!-- datatable -->
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css"> -->

</head>

<body>
    <script>
        // สร้างDataTable
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                "columnDefs": [{
                    "targets": 1,
                    "data": null,
                    "defaultContent": "<button class='btn btn-warning rounded-circle'><i class='bi bi-pencil-square'></i></button>"
                }
            ,
            {
                "targets": 7,
                    "render": function(data, type, row, meta) {
                        return '<div class="progress mt-3">' +
                            '<div class="progress-bar bg-success" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%' +
                            '</div>' +
                            '</div>';
                    }
                }
            ]
            });

            //   สร้างปุ่มกดแสดงรายละเอียด
            $('#myTable tbody').on('click', 'button', function() {
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
                    '<td>ชื่อโปรเจค</td>' +
                    '<td>' + d[2] + '</td>' +
                    '<td>' + '<a href="mainpage.php?idp='+d[2]
                    + ' "class="btn btn-warning">ดูรายละเอียดโปรเจค</a>' 
                    + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td>ชื่องาน:</td>' +
                    '<td>' + d[3] + '</td>' +
                    '</tr>' +

                    '<td>คำอธิบายโปรเจค:</td>' +
                    '<td>' + d[4] + '</td>' +
                    '</tr>' +

                    '<td>วันที่เริ่มสร้างโปรเจค</td>' +
                    '<td>' + d[5] + '</td>' +
                    '</tr>' +
                    '<td>วันที่โปรเจคต้องเสร็จ</td>' +
                    '<td>' + d[6] + '</td>' +
                    '</tr>' +

                    '</table>';
            }


        });
    </script>
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
        <!-- //สร้างการ์ด -->
        <div class="container-fluid mt-5 p-4  ">

            <table id="myTable" class="table table-striped table-bordered text-center ">
                <thead class="table-dark text-center">
                    <tr class="text-center">
                        <th rowspan="2" class="text-center">ลำดับที่</th>
                        <th rowspan="2" class="text-center">แก้ไข</th>
                        <th colspan="3" class="text-center">รายละเอียดโปรเจค</th>
                        <th rowspan="2" class="text-center">วันที่เริ่มโปรเจค</th>
                        <th rowspan="2" class="text-center">วันที่สิ้นสุดโปรเจค</th>
                        <th rowspan="2" class="text-center">ความคืบหน้าโดยรวม</th>


                    </tr>
                    <tr class="table table-warning">
                        <th class="text-center">ชื่อโปรเจค</th>
                        <th class="text-center">เจ้าของโปรเจค</th>
                        <th class="text-center">คำอธิบายโปรเจค</th>


                    </tr>

                </thead>
                <tbody >
                    <?php
                    //แสดงผลข้อมูลในฐานข้อมูล
                    while ($task = mysqli_fetch_assoc($result_task)) {  ?>
                        <tr>
                            <td><?php echo $order++ ?></td>
                            <td></td>
                            <td><?php echo $task['project_name'] ?></td>
                            <td><?php echo $task['emp_fname']." ".$task['emp_lname'] ?></td>

                            <td><?php echo $task['detail'] ?></td>


                            <td class="text-success fw-bold"><?php echo date("d-M-Y ", strtotime($task['create_time'])) ?></td>
                            <td class="text-danger fw-bold"><?php echo date("d-M-Y ", strtotime($task['dead_line'])) ?></td>
                            <td>100</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>