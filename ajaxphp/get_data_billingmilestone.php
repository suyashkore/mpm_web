<?php
require_once("../config/config.php");

$project_id = $_POST['project_id']; 
$array = array();
$query = "SELECT * FROM billing_milestone_header_all WHERE project_id = '$project_id'";
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
    $response = ["msg" => "Get all billing milestone", "billing_milestone" => $array];
} else {
    $response = ["msg" => "Not found"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>