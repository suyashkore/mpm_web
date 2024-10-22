<?php
require_once("../config/config.php");
// print_r($_POST);
$project_id = $_POST['project_id'];
$client_type_option = $_POST['client_type_option'];
$project_complition_time = $_POST['project_complition_time'];
$project_name = $_POST['project_name'];
// $project_strat_date = $_POST['project_strat_date'];
$project_type = $_POST['project_type'];
$sales_person_name = $_POST['sales_person_name'];
$sales_person_no = $_POST['sales_person_no'];
$select_client = $_POST['select_client'];
$project_status = $_POST['project_status'];

if($_POST['project_id'] == "") {
    $query = "SELECT CONCAT('PRO-', LPAD(MAX(CAST(SUBSTRING(project_id, 5) AS UNSIGNED)) + 1, 5, '0')) AS next_project_id FROM project_header_all WHERE project_id LIKE 'PRO-%';";
    $query_result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($query_result);
    $project_id = $row['next_project_id'];

   $quiry_temp = "INSERT INTO temporary_project_header_all (project_id, project_no, project_name, client_type_id, selectedClientId, project_status, project_start_date, project_comp_time, sales_person_details) 
    VALUES ('$project_id', '3', '$project_name', '$client_type_option', '$select_client', '$project_status', '', '11', '$sales_person_name')";
    $query_temp_result = mysqli_query($conn, $quiry_temp);

} else {
  $quiry_temp = "UPDATE temporary_project_header_all SET `project_id`='$project_id', `project_no`='3', `project_name`='$project_name', `client_type_id`='$client_type_option', `selectedClientId`='$select_client', `project_status`='$project_status', `project_start_date`='', `project_comp_time`='', `sales_person_details`='$sales_person_name'";
    $query_temp_result = mysqli_query($conn, $quiry_temp);  
}

if (!$query_temp_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
} else {
    $response = ["msg" => "Data processed successfully", "project_id" => $project_id];
}
header('Content-Type: application/json');
echo json_encode($response);
?>