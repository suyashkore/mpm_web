<?php
require_once("../config/config.php");

$billing_milestone_id = $_POST['billing_milestone_id']; 
$array = array();
$query = "SELECT * FROM working_pipeline_header_all WHERE BM_id = '$billing_milestone_id'";
$query_result = mysqli_query($conn, $query);

if (!$query_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
}
$row_count = mysqli_num_rows($query_result);
if ($row_count > 0) {
    while ($arr = mysqli_fetch_assoc($query_result)) {
        $array[] = $arr; 
    }
    $response = ["msg" => "Get all working pointer", "work_pointer" => $array];
} else {
    $response = ["msg" => "Not found"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>