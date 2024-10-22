<?php
require_once("../config/config.php");
// print_r($_POST);
$project_id = $_POST['project_id'];
$consignee = $_POST['consignee'];
$bill_pass_authority = $_POST['bill_pass_authority'];
$scope_short = $_POST['scope_short'];
$project_manager = $_POST['project_manager'];
$project_manager_team = $_POST['project_manager_team'];
$profit_loss = $_POST['profit_loss'];
// $loss = $_POST['loss'];
$profit_loss_amount = $_POST['profit_loss_amount'];
// $loss_amount = $_POST['loss_amount'];

$quiry_temp = "UPDATE temporary_project_header_all SET `consigneeList`='$consignee', `billpassing_authority`='$bill_pass_authority', `shortDescription`='$scope_short', `detailedDescription`='$scope_short', `assignProjectManagerId`='$project_manager',  `isProfit`='$profit_loss', `profit_loss_amt`='$profit_loss_amount' where `project_id`='$project_id'";
$query_temp_result = mysqli_query($conn, $quiry_temp);  


if (!$query_temp_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
} else {
    $response = ["msg" => "data inserted for third form"];
}
header('Content-Type: application/json');
echo json_encode($response);
?>