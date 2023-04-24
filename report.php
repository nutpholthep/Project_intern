<?php
require('dbconnect.php');
require('func.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="bootstrap-5.2.3/dist/css/bootstrap.min.css">
    <script src="bootstrap-5.2.3/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="icons-1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script> -->
    <!-- bootstrap end -->
    <script src="chart.js/Chart.js-4.2.1/"></script>
    <script src="chart.js/chart.umd.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
</head>

<body>
<?php echo $inbar=inBar(15);
print_r($inbar);
// echo json_encode($data);?>
    <?php
    require 'nav.php';
    // $sql = "SELECT *,(activity_progress *100)
    // FROM activity
    // WHERE activity_id =20";
    // $query = mysqli_query($con, $sql);
$sql = "SELECT project_id FROM project_create";
$result =mysqli_query($con,$sql);


    while ($task = mysqli_fetch_assoc($result)) {  
       $id =$task['project_id'];

$query =barChart($id);
    foreach ($query as $value) {
        $label[] = $value['project_name'];
        $data[] = $value['total'];
    }

}
 
    ?>
    <div class="container">

        <div class="card mt-3">
            <h5 class="card-header ">
                <div class="text-center">
                    <p>ภาพรวมโปรเจค</p>
                    <button id="bar" class="btn btn-primary">ChangeBar</button>
                    <button id="pie"class="btn ">ChangePie</button>
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
            type: 'bar',
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
                // < ?php inBar(55) ?>
                // data.datasets.label('test')
                mychart.data.datasets[0].data = data;
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