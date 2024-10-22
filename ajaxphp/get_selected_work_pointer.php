<?php
require_once("../config/config.php");

$work_pipeline_id = $_POST['work_pipeline_id']; 
$array = array();
$query = "SELECT * FROM pipeline_work_pointers_all WHERE pipe_id = '$work_pipeline_id'";
$query_result = mysqli_query($conn, $query);

if (!$query_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
}
$row_count = mysqli_num_rows($query_result);
if ($row_count > 0) {
    $arr = mysqli_fetch_assoc($query_result);
        $array[] = $arr; 
    for ($i = 1; $i <= 30; $i++) {
        if (!empty($arr["wp_id_$i"])) {
            $work_pointers[] = [
                "wp_id" => $arr["wp_id_$i"],
                "wp_des" => $arr["wp_des_$i"],
                "wp_status" => $arr["wp_status_$i"],
                "wp_assigned_to" => $arr["wp_$i" . "_assigned_to"]
            ];
        }

        if($arr["wp_id_$i"]==$arr["current_wp_id"]) {
            break;
        }
    }


    $response = ["msg" => "Get all working pointer", "work_pointers" => $work_pointers];
} else {
    $response = ["msg" => "Not found"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>