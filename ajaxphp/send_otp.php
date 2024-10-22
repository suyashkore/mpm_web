<?php
session_start();
require_once("../config/config.php");
$mobile = $_SESSION['mobile'];    
// $mobile = 774392159; 
$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
date_default_timezone_set("Asia/Kolkata");
$date = date("d-m-Y");
 $error_flag = 0;
 $otp_prefix = ":-";
 $new_line = "\n";
 $dot = ".";
 $colon = ":";

 $message = urlencode("Welcome to BMAPAN. Your OTP to verify contact number is $otp Developed by MISCOS Technologies Private 
Limited ");

 $response_type = "json";

 // Define route
 $route = "4";
 $mobile = "91" . $mobile;
 // Prepare your post parameters
 $postData = [
     "authkey" => "362180A9fmXMgXDi3O65c9e9bdP1",
     "mobiles" => $mobile,
     "message" => $message,
     "sender" => "BMAPAN",
     "route" => $route,
     "response" => $response_type,
 ];

 // API URL
 $url = "http://api.msg91.com/api/sendhttp.php?authkey=362180A9fmXMgXDi3O65c9e9bdP1&sender=BMAPAN&mobiles=$mobile&route=$route&message=$message&DLT_TE_ID=1307171060435463268";

 // Init the resource
 $ch = curl_init();
 curl_setopt_array($ch, [
     CURLOPT_URL => $url,
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_POST => true,
     CURLOPT_POSTFIELDS => $postData,
 ]);

 // Ignore SSL certificate verification
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

 // Get response
 $output = curl_exec($ch);

 // Print error if any
 if (curl_errno($ch)) {
     $error_flag = 1;
     'cURL Error: ' . curl_error($ch);
 } else {
     // Print API response
     'API Response: ' . $output;
 }

 curl_close($ch);
//  return $error_flag;

$response = ["msg" => "success"];

header('Content-Type: application/json');

echo json_encode($output);

?>
