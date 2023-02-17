<?php
require('dbconnect.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    #t{
        background-color: green;
        height: 10rem;
        width: 20rem;
        color: white;
       
        border: 3px solid black;
    }
    #con{
        background-color: grey;
        font-size: 3rem;
       

    }
    #footer{
        background-color: yellowgreen;
       margin-top: 70px;
        font-size: 2rem;
        text-align: center;
    }
    #footer:hover{
        background-color: red;
    }
</style>

<body>
    <?php $cout = 'SELECT COUNT(activity_progress),activity_progress
                                           FROM activity 
                                       WHERE activity_progress NOT IN (0) and task_id =55';
    $respon = mysqli_query($con, $cout);
    $data = mysqli_fetch_assoc($respon);
    // echo  $data['activity_progress'];
    ?>
    <div id="t">
        <div id="con">
            <?php
            echo ($data['COUNT(activity_progress)'] * $data['activity_progress'] / 100) *
                ($data['COUNT(activity_progress)'] * 100); ?>
    
    </div>
    <div id="footer">
        <p>more info</p>
    </div>
    </div>


</body>

</html>