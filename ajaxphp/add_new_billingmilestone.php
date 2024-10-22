<?php
session_start();
require_once("../config/config.php");
$emp_id = $_SESSION['emp_id'];
$project_id = $_POST['project_id']; 
$bmname = $_POST['bmname']; 

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
$date_01 = $date->format('Y-m-d H:i:s T');
$query_for_getbm = "SELECT * FROM unique_id_header_all WHERE table_name = 'billing_milestone_header_all' ";
$query_result_getbm = mysqli_query($conn, $query_for_getbm);

if (mysqli_num_rows($query_result_getbm) > 0) {
   $lastrec = mysqli_fetch_assoc($query_result_getbm);

   $current_id = sprintf('%05d', intval($lastrec['last_id']) + 1);

   $query_for_last_id = "UPDATE unique_id_header_all set last_id = '$current_id' , modified_on = '$date_01' WHERE table_name = 'billing_milestone_header_all' ";
    $query_result_last_id = mysqli_query($conn, $query_for_last_id);
} else {

    $query_new = "INSERT INTO unique_id_header_all (table_name,id_for,prefix,last_id,created_on) VALUES ('billing_milestone_header_all','BM_id','BM','00001','$date_01')";
    $query_result_new = mysqli_query($conn, $query_new);

    $current_id = '00001';
}

$curr_bm_id = 'BM-'. $current_id;
$query = "INSERT INTO billing_milestone_header_all (project_id,BM_id,BM_name,inserted_on,introduced_by,status) VALUES ('$project_id','$curr_bm_id','$bmname','$date_01','$emp_id','Configured')";
$query_result = mysqli_query($conn, $query);

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