<?php 
session_start();
$mobile = $_SESSION['mobile'];
$s_otp = $_SESSION['otp'];
$otp = $_POST['otp'];

if ($s_otp == $otp ) {
    $response = ["msg" => "match"];
} else {
    $response = ["msg" => "not match"];
}
header('Content-Type: application/json');

echo json_encode($response);

?>