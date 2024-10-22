<?php 
require_once("../config/config.php");
$array = array();
$query = "SELECT dept_name,dept_id FROM department_header_all";
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
    $response = ["msg" => "Get all department", "department" => $array];
} else {
    $response = ["msg" => "No department found"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>
