<?php
require_once("../config/config.php");

$client_type_id = $_POST['client_type_id']; 
$array = array();
$query = "SELECT client_id,name_of_official FROM client_header_all WHERE client_type_id = '$client_type_id'";
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
    $response = ["msg" => "Get all client", "client" => $array, "client_type_id" => $client_type_id];
} else {
    $response = ["msg" => "No clients found", "client_type_id" => $client_type_id];
}
header('Content-Type: application/json');

echo json_encode($response);
?>