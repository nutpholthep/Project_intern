<?php
function perProgess($data,$dateNow,$deadLine){

    if($dateNow<=$deadLine){
        return  '<div class="progress">' .
        '<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: ' . $data . '%;" aria-valuenow="' . $data . '" aria-valuemin="0" aria-valuemax="100">' . $data . '%' .
        '</div>' .
        '</div>';
    }else{
        return  '<div class="progress">' .
        '<div class="progress-bar bg-danger" role="progressbar" style="width: ' . $data . '%;" aria-valuenow="' . $data . '" aria-valuemin="0" aria-valuemax="100">' . $data . '%' .
        '</div>' .
        '</div>';
    }
       
}

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
           
            if($val['COUNT(a.activity_id)']==0){
                return 0;
            }else{
                return    $val = intval(($val['bar'] * 100) / ($val['COUNT(a.activity_id)'] * 100));
            }
           
        }
    
  
    
}

function projectId(){
    include('dbconnect.php');
    $sql = "SELECT project_id,project_name
        FROM project_create";

        $result = $con->query($sql);
        $projectIds = array();
        foreach($result as $val){
            $projectIds[] = $val['project_id'];
        }
        return $projectIds;
}
//  echo $showdata = projectId();
//   print_r($showdata) ;
 
// echo $showme = progress_Bar(55);

function detail($id){
    include('dbconnect.php');
    $sql ="SELECT  p.project_name,p.dead_line,p.owner,p.detail,emp.emp_fname,emp.emp_lname
    FROM project_create AS p 
    LEFT JOIN employees AS emp on emp.emp_id = p.owner
    WHERE p.project_id =$id";


    $result= $con->query($sql);
    foreach($result as $val){
        return $val;
    }
}
function create_by($id){
    include('dbconnect.php');
    $sql ="SELECT  emp.emp_fname,emp.emp_lname,p.create_by,p.create_time
    FROM project_create AS p 
    LEFT JOIN employees AS emp on emp.emp_id = p.create_by
    WHERE p.project_id =$id";


    $result= $con->query($sql);
    foreach($result as $val){
        return $val;
    }
}
function update_by($id){
    include('dbconnect.php');
    $sql ="SELECT  emp.emp_fname,emp.emp_lname,p.update_by,p.update_time
    FROM project_create AS p 
    LEFT JOIN employees AS emp on emp.emp_id = p.update_by
    WHERE p.project_id =$id";


    $result= $con->query($sql);
    foreach($result as $val){
        return $val;
    }
}
function barChart($id){
    include('dbconnect.php');
    $sql = "SELECT 
    p.project_name,
    t.project_id,
    t.task_id,
    a.activity_id,
    a.activity_progress,
    SUM(a.activity_progress) as bar,
    COUNT(a.activity_id),
    ((SUM(a.activity_progress)*100)/(COUNT(a.activity_id)*100)) AS total
FROM 
    project_create AS p
    LEFT JOIN task AS t ON t.project_id = p.project_id
    LEFT JOIN activity AS a ON a.task_id = t.task_id
WHERE 
    p.project_id = $id 
HAVING 
    total = 100";

return $result = $con->query($sql);
}

function inBar($id){
    include('dbconnect.php');
    $sql = "SELECT 
    p.project_name,
    t.project_id,
    t.task_id,
    a.activity_id,
    a.activity_progress,
    SUM(a.activity_progress) as bar,
    COUNT(a.activity_id),
    ((SUM(a.activity_progress)*100)/(COUNT(a.activity_id)*100)) AS total
FROM 
    project_create AS p
    LEFT JOIN task AS t ON t.project_id = p.project_id
    LEFT JOIN activity AS a ON a.task_id = t.task_id
WHERE 
    p.project_id = $id 
HAVING 
    total <> 100";
     $result = $con->query($sql);
    foreach($result as $val){
        return $data[]=$val['total'];
    }
}

function fillter($id){
    include('dbconnect.php');
    $sql = "SELECT 
    p.project_name,
    t.project_id,
    t.task_id,
    a.activity_id,
    a.activity_progress,
    SUM(a.activity_progress) as bar,
    COUNT(a.activity_id),
    ((SUM(a.activity_progress)*100)/(COUNT(a.activity_id)*100)) AS total
FROM 
    project_create AS p
    LEFT JOIN task AS t ON t.project_id = p.project_id
    LEFT JOIN activity AS a ON a.task_id = t.task_id
WHERE 
    p.project_id = $id 
HAVING 
    total = 100";

$result = $con->query($sql);


foreach($result as $val){
    return intval($val['total']);
}
}
function fillterInComplete($id){
    include('dbconnect.php');
    $sql = "SELECT 
    p.project_name,
    t.project_id,
    t.task_id,
    a.activity_id,
    a.activity_progress,
    SUM(a.activity_progress) as bar,
    COUNT(a.activity_id),
    ((SUM(a.activity_progress)*100)/(COUNT(a.activity_id)*100)) AS total
FROM 
    project_create AS p
    LEFT JOIN task AS t ON t.project_id = p.project_id
    LEFT JOIN activity AS a ON a.task_id = t.task_id
WHERE 
    p.project_id = $id 
HAVING 
    total <> 100";

$result = $con->query($sql);


foreach($result as $val){
    return intval($val['total']);
}
}

// echo $table = fillter();

function taskDeadLine($id){
    include('dbconnect.php');
    $sql="SELECT dead_line
    FROM task 
    WHERE project_id = $id";

    $result = $con->query($sql);

    foreach($result as $val){
        return $val;
    }

}

