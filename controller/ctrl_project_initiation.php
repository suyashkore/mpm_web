<?php
include '../config/config.php';
include '../class/class_create_project.php';
include '../class/class_remove_temp_project.php';
$create_project = new create_project($conn); 
$project_status = $create_project->create_project();

$remove_temp_project = new remove_temp_project($conn);

// print_r($_POST);

// if($project_status['msg'] == 'project created') {
//     // echo "<script>alert('success')</script>";
//     $project_remove_status = $remove_temp_project->remove_temp_project($project_status['project_id']);
//     if($project_remove_status['msg'] == 'project removed'){
//         // header("Location: ../index.php");
//     }
    
// } else {
//     echo "test";
// }
?> 