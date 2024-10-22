<?php
require_once("../config/config.php");
// print_r($_POST);
$project_id = $_POST['project_id'];
$revenue_amount = $_POST['revenue_amount'];
$including_gst = $_POST['including_gst'];
$other_taxes = $_POST['other_taxes'];
$loa = $_POST['loa'];
$amount_loa = $_POST['amount_loa'];
$contract = $_POST['contract'];
$sd = $_POST['sd'];
$percentage = $_POST['percentage'];
$select_file_sd = $_POST['select_file_sd'];
$amount_sd = $_POST['amount_sd'];
$pg = $_POST['pg'];
$percentage_pg = $_POST['percentage_pg'];
$select_file_pg = $_POST['select_file_pg'];
$amount_pg = $_POST['amount_pg'];
$bg = $_POST['bg'];
$select_bg = $_POST['select_bg'];
$amount_bg = $_POST['amount_bg'];
$emd = $_POST['emd'];
$wo = $_POST['wo'];
$project_id = $_POST['project_id'];


$quiry_temp = "UPDATE temporary_project_header_all SET `revenue_amt`='$revenue_amount', `including_gst`='$including_gst', `other_taxes`='$other_taxes' where `project_id`='$project_id'";
$query_temp_result = mysqli_query($conn, $quiry_temp);  


if (!$query_temp_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
} else {
    $response = ["msg" => "data inserted for second form"];
}
header('Content-Type: application/json');
echo json_encode($response);
?>