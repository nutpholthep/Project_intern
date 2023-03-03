<?php
require('dbconnect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <!-- bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    <!-- bootstrap end -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>

<body>

    <?php
    require 'nav.php';
    // $sql = "SELECT *,(activity_progress *100)
    // FROM activity
    // WHERE activity_id =20";
    // $query = mysqli_query($con, $sql);
$sql = "SELECT * FROM project_create";
$result =mysqli_query($con,$sql);


    while ($task = mysqli_fetch_assoc($result)) {  
     echo   $id =$task['project_id'];
$sql2="SELECT p.project_name,t.project_id,t.task_id,a.activity_id,a.activity_progress,a.activity_name,SUM(a.activity_progress),COUNT(a.activity_id),((SUM(a.activity_progress)*100)/(COUNT(a.activity_id)*100))
FROM project_create AS p
LEFT JOIN task as t on t.project_id = p.project_id
LEFT JOIN activity AS a on a.task_id = t.task_id
WHERE p.project_id= $id";
    
    $query = mysqli_query($con, $sql2);
    foreach ($query as $value) {
        $label[] = $value['project_name'];
        $data[] = $value['((SUM(a.activity_progress)*100)/(COUNT(a.activity_id)*100))'];
    }

}
//     $sum = 100;
//  foreach($data as $f){
//     $sum = $f * $sum;
//  }

//  print_r($sum);
 
    ?>
    <div class="container">

        <div class="card mt-3">
            <h5 class="card-header ">
                <div class="text-center">
                    <p>ภาพรวมโปรเจค</p>
                    <button id="pie"class="btn btn-primary">ChangePie</button>
                    <button id="bar" class="btn ">ChangeBar</button>
                </div>
            </h5>
            <div class="card-body">
                <div>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </div>




    <script>
        //setup ข้อมูลกราฟ
        const data = {
            labels: <?php echo json_encode($label) ?>,
            datasets: [{
                label: 'ความคืบหน้า',
                data: <?php echo json_encode($data) ?>,
                borderWidth: 2,
                // borderColor:"black",
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                ],
                hoverOffset: 4,
                hoverBorderColor:"black"
            }]
        };

        //config รูปแบบกราฟ
        const config = {
            type: 'pie',
            data,
            options: {
                plugins: {
                    colors: {
      enabled: true,
      forceOverride: true,
    },
            subtitle: {
                display: true,
                text: 'Custom Chart Subtitle'
            }
        },
                aspectRatio:2,
                responsive:true,
                maintainAspectRatio:true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
            }
        };
        window.addEventListener('load', () => {
            // const ctx = document.getElementById('myChart').getContext('2d');
            const bar = document.getElementById('bar');
            const pie = document.getElementById('pie');

            bar.addEventListener('click', changeBar);
            pie.addEventListener('click', changePie);

            let mychart = new Chart( 
                document.getElementById('myChart'),
                config
            );

            function changeBar() {
                console.log(mychart.config.type);
                let updateChart = "bar";
                mychart.config.type = updateChart;
                mychart.update()
                bar.classList.add('btn-primary')
                pie.classList.remove('btn-primary')

            }

            function changePie() {
                let updateChart = "pie";
                mychart.config.type = updateChart;
                mychart.update();
                pie.classList.add('btn-primary')
                bar.classList.remove('btn-primary')
            }
        })
    </script>

</body>

</html>