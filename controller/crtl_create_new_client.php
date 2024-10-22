<?php 
include '../config/config.php';
include '../class/class_create_new_client.php';
$create_new_client = new create_new_client($conn); 
$client_status = $create_new_client->create_new_client();

if($client_status['msg'] == 'client created') {
    // echo "<script>alert('success')</script>";
    $project_remove_status = $remove_temp_project->remove_temp_project($project_status['project_id']);
    if($project_remove_status['msg'] == 'project removed'){
        header("Location: ../index.php");
    }
    
} else {
    echo "test";
}

?>