<?php
require_once("../config/config.php");
$query = "select * from temporary_project_header_all";
$query_result = mysqli_query($conn, $query);
$row_count = mysqli_num_rows($query_result);
if ($row_count > 0) {
    $response = ["msg" => "project found"];
} else {
    $response = ["msg" => "not found"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>