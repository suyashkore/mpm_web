<?php
session_start();
require_once("../config/config.php");

$mobile = $_SESSION['mobile']; 
$pin = 'P-'.$_POST['pin']; 
$array = array();
$query = "update employee_header_all set login_pin='$pin' WHERE contact_1 = '$mobile'";
$query_result = mysqli_query($conn, $query);

if (!$query_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
}
if ($query_result) {
    $response = ["msg" => "update"];
} else {
    $response = ["msg" => "not update"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>