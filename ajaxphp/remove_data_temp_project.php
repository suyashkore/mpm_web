<?php
require_once("../config/config.php");

$array = array();
$query = "DELETE FROM temporary_project_header_all
WHERE id = (
    SELECT id FROM (
        SELECT id
        FROM temporary_project_header_all
        ORDER BY id DESC
        LIMIT 1
    ) AS temp
)";
$query_result = mysqli_query($conn, $query);

if (!$query_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
}
if ($query_result) {
    $response = ["msg" => "delete successfully"];
} else {
    $response = ["msg" => "error"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>