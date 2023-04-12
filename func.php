<?php

function progress_Bar($id)
{
    include('dbconnect.php');
    $sql = "SELECT  COUNT(activity_progress),activity_progress,SUM(activity_progress) as bar
    FROM activity 
    WHERE  task_id = $id";
    $result=$con->query($sql);
    foreach($result as $val){
        
        // $val['COUNT(activity_progress)'];
        return  $val = intval(($val['bar'] * 100) / ($val['COUNT(activity_progress)'] * 100));
    }
}
function Total_progress($id)
{
    include('dbconnect.php');
   
        $sql = "SELECT p.project_name,t.project_id,t.task_id,a.activity_id,a.activity_progress,SUM(a.activity_progress) as bar,COUNT(a.activity_id)
        FROM project_create AS p
        LEFT JOIN task as t on t.project_id = p.project_id
        LEFT JOIN activity AS a on a.task_id = t.task_id
        WHERE p.project_id= $id";
        $result=$con->query($sql);

        foreach($result as $val){
            // $val = round(($val['bar'] * 100) / ($val['COUNT(activity_progress)'] * 100));
            // $val['COUNT(activity_progress)'];
            return    $val = round(($val['bar'] * 100) / ($val['COUNT(a.activity_id)'] * 100),2);
        }
    
  
    
}

// echo $showdata =Total_progress(33,46);
// echo $showme = progress_Bar(55);