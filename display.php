<?php
require('dbconnect.php');

// Queryแสดงผลตาราง
$sql2 = " SELECT project_create.project_name,task.task_name,task.task_id,project_create.create_time,project_create.dead_line,project_create.detail,employees.emp_fname,employees.emp_lname,project_create.create_by,project_create.project_id,project_create.owner
FROM task
right JOIN  project_create ON project_create.project_id = task.project_id
right JOIN  employees ON project_create.owner = employees.emp_id 
WHERE project_create.detail IS null OR project_create.status NOT IN(0)
GROUP BY project_create.project_id";
$result_task = mysqli_query($con, $sql2);
$order = 1;




// $total_bar = "SELECT p.project_name,t.project_id,t.task_id,a.activity_id
// FROM project_create AS p
// LEFT JOIN task as t on t.project_id = p.project_id
// LEFT JOIN activity AS a on a.task_id = t.task_id";

  




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <!-- <script src="jquery-3.3.1.min.js"></script> -->


    <!-- new datatale -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>


    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>


</head>

<body>
    <script>
        // สร้างDataTable
        $(document).ready(function() {
            var table = $('#myTable').DataTable({
                responsive: true,
                "columnDefs": [{
                        // progress_Bar
                        "targets": 7,
                        "render": function(data, type, row, meta) {
                            return '<div class="progress mt-3">' +
                                '<div class="progress-bar bg-success" role="progressbar" style="width: ' + data + '%;" aria-valuenow="' + data + '" aria-valuemin="0" aria-valuemax="100">' + data + '%' +
                                '</div>' +
                                '</div>';
                        }
                    },
                    {
                        // ช่องคำอธิบายมีตัวอักษรไม่เกิน 20 ตัว
                        "targets": 4,
                        "data": "description",

                        "render":

                            function(data, type, row, meta) {
                                return type === 'display' && data.length > 20 ?
                                    '<span title="' + data + '">' + data.substr(0, 20) + '...</span>' :
                                    data;
                            }

                    }
                ]
            });


        });
    </script>
    <?php
    include 'nav.php';

    ?>
    <div class="container-fulid">
        <!-- //สร้างการ์ด -->
        <div class="container-fluid mt-5 p-4  ">

            <table id="myTable" class="table table-striped table-bordered display responsive nowrap  ">
                <thead class="table-dark text-center">
                    <tr class="text-center">
                        <th class="text-center">ลำดับที่</th>
                        <th class="text-center">ชื่อโปรเจค</th>
                        <th class="text-center" >ดูรายละเอียดโปรเจค</th>
                        <th class="text-center">เจ้าของโปรเจค</th>
                        <th class="text-center text-break">คำอธิบายโปรเจค</th>
                        <th class="text-center">วันที่เริ่มโปรเจค</th>
                        <th class="text-center">วันที่สิ้นสุดโปรเจค</th>
                        <th class="text-center">ความคืบหน้าโดยรวม</th>

                 
                    </tr>

                </thead>
                <tbody class="text-break">
                    <?php
                    //แสดงผลข้อมูลในฐานข้อมูล
                    while ($task = mysqli_fetch_assoc($result_task)) {  
                        $id =$task['project_id'];?>
                        <tr>
                            
                            <td class="text-end"><?php echo $order++ ?></td>
                            <td class=""><?php echo $task['project_name'] ?></td>
                            <td class="text-center"> <a href="mainpage.php?idp=<?php echo $task['project_id'] ?>" class="btn btn-info"><i class="bi bi-info-circle-fill"></i> ดูรายละเอียด</a>
                            
                            </td>
                            <td><?php echo $task['emp_fname'] . " " . $task['emp_lname'] ?></td>
                            <td><?php echo $task['detail'] ?></td>
                            <td class="text-success fw-bold"><?php echo date("d-m-Y ", strtotime($task['create_time'])) ?></td>
                            <td class="text-danger fw-bold"><?php echo date("d-m-Y ", strtotime($task['dead_line'])) ?></td>
                           
                           
                           <?php 
                        //    ส่วนของการคำนวณProgress_bar
                            $total_bar = "SELECT p.project_name,t.project_id,t.task_id,a.activity_id,a.activity_progress,SUM(a.activity_progress),COUNT(a.activity_id)
                            FROM project_create AS p
                            LEFT JOIN task as t on t.project_id = p.project_id
                            LEFT JOIN activity AS a on a.task_id = t.task_id
                            WHERE p.project_id= $id ";
                            $total=mysqli_query($con,$total_bar);

                            foreach($total as $totalSum){
                                if($totalSum['COUNT(a.activity_id)']==0){ ?>
                                        <td>0</td>
                                      <?php } else {?>
                                        <td><?= round(($totalSum['SUM(a.activity_progress)']*100)/($totalSum['COUNT(a.activity_id)']*100),2); ?></td>
                           <?php  } ?> <!--ปีกกาElse -->
                            <?php } ?> <!--ปีกกาForeach -->

                            <?php } ?><!--ปีกกา While -->

                            </tr>
                </tbody>
            </table>

        </div>
    </div>