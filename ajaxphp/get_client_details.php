<?php
require_once("../config/config.php");

$client_id = $_POST['client_id']; 
$query = "SELECT * FROM client_header_all WHERE client_id = '$client_id'";
$query_result = mysqli_query($conn, $query);

if (!$query_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
}
$row_count = mysqli_num_rows($query_result);
if ($row_count > 0) {
   $arr = mysqli_fetch_assoc($query_result);
    $response = ["msg" => "Get client details", "client_details" => $arr];
} else {
    $response = ["msg" => "Not found"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>