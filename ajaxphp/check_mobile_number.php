<?php
session_start();
require_once("../config/config.php");
$mobile = $_POST['mobile']; 

$query = "SELECT * FROM employee_header_all WHERE contact_1 = '$mobile'";
$query_result = mysqli_query($conn, $query);

if (!$query_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit; 
}
$row_count = mysqli_num_rows($query_result);
if ($row_count > 0) {
    $arr = mysqli_fetch_assoc($query_result);
    if(strpos($arr['login_pin'], 'D') === 0) {
        $pin = 'default';
    } else {
        $pin = 'generated';
    }
    $_SESSION['mobile'] = $mobile;
    $response = ["msg" => "number found", "login_pin"=> $pin];
} else {
    $response = ["msg" => "not found"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>