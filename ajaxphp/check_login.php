<?php
session_start();
require_once("../config/config.php");
$mobile = $_SESSION['mobile']; 
$pin = $_POST['pin']; 
$array = array();
$query = "SELECT * FROM employee_header_all WHERE SUBSTRING(login_pin, 3) = '$pin' AND contact_1 = '$mobile'";
$query_result = mysqli_query($conn, $query);

if (!$query_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
}
$row_count = mysqli_num_rows($query_result);
if ($row_count > 0) {
    $arr = mysqli_fetch_assoc($query_result);
    $profile_id = $arr['profile_id'];
    $query_01 = "SELECT * from profile_header_all WHERE profile_id = '$profile_id'";
    $query_result_01 = mysqli_query($conn, $query_01);
    $arr1 = mysqli_fetch_assoc($query_result_01);
    $_SESSION['name'] = $arr['name'];
    $_SESSION['emp_id'] = $arr['emp_id'];
    $_SESSION['profile_name'] = $arr1['profile_name'];

    if(strpos($arr['login_pin'], 'D') === 0) {
        $pin_type = 'default';
    } else {
        $pin_type = 'generated';
    }

    $response = ["msg" => "success" ,"login_pin"=> $pin_type];
    
} else {
    $response = ["msg" => "unsuccess"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>