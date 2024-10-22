<?php
session_start();
require_once("../config/config.php");
$bm_id = $_POST['bm_id']; 
$project_id = $_POST['project_id']; 
$wpipe_name = $_POST['wpipe_name']; 
$dept_order = $_POST['dept_order']; 
$dept_array = explode(',', $dept_order);
// print_r($dept_array);
$emp_id = $_SESSION['emp_id'];
$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
$date_01 = $date->format('Y-m-d H:i:s T');
$query_for_getwp = "SELECT * FROM unique_id_header_all WHERE table_name = 'working_pipeline_header_all' ";
$query_result_getwp = mysqli_query($conn, $query_for_getwp);

if (mysqli_num_rows($query_result_getwp) > 0) {
   $lastrec = mysqli_fetch_assoc($query_result_getwp);

   $current_id = sprintf('%05d', intval($lastrec['last_id']) + 1);

   $query_for_last_id = "UPDATE unique_id_header_all set last_id = '$current_id' , modified_on = '$date_01' WHERE table_name = 'working_pipeline_header_all' ";
    $query_result_last_id = mysqli_query($conn, $query_for_last_id);
} else {

    $query_new = "INSERT INTO unique_id_header_all (table_name,id_for,prefix,last_id,created_on) VALUES ('working_pipeline_header_all','pipe id','WPL','00001','$date_01')";
    $query_result_new = mysqli_query($conn, $query_new);

    $current_id = '00001';
} 
$curr_pipe_id = 'WPL-'. $current_id;

$query = "INSERT INTO working_pipeline_header_all (project_id,BM_id,pipe_id,application_category,WP_name,introduced_by,status,created_on) VALUES ('$project_id','$bm_id','$curr_pipe_id','1','$wpipe_name','$emp_id','Configured','$date_01')";
$query_result = mysqli_query($conn, $query);

$query_dept  = "INSERT INTO dept_seq_definition_all SET project_id = '$project_id',
pipe_id = '$curr_pipe_id',
Bm_id = '$bm_id'";
$query_result = mysqli_query($conn, $query_dept);

for ($i = 1; $i <= count($dept_array); $i++) {
    $dept_value = mysqli_real_escape_string($conn, $dept_array[$i-1]);
    $query = "UPDATE dept_seq_definition_all SET dept_$i = '$dept_value' WHERE
    project_id = '$project_id' AND pipe_id = '$curr_pipe_id' AND Bm_id = '$bm_id'";
    $query_result = mysqli_query($conn, $query);
}

if (!$query_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
}
if ($query_result) {
    $response = ["msg" => "success",];
} else {
    $response = ["msg" => "unsuccess"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>