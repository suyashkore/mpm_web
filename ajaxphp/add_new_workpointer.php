<?php
require_once("../config/config.php");

$wpo_name = $_POST['wpoName']; 
$wpo_project_id = $_POST['wpo_project_id']; 
$wpo_bm_id = $_POST['wpo_bm_id']; 
$wpo_wpipe_id = $_POST['wpowpipeId']; 
$curr_no = rand(10000, 99999);
$current_wp_id = 'WPO-' . $curr_no;

$query = "SELECT * FROM pipeline_work_pointers_all WHERE project_id ='$wpo_project_id' AND line_no = (SELECT MAX(line_no) from pipeline_work_pointers_all )";
$query_result = mysqli_query($conn, $query);
$rec = mysqli_fetch_assoc($query_result);
$current_line_no = $rec['line_no'];
if (mysqli_num_rows($query_result) > 0) {

    
    $next_line_no = intval($rec['line_no']) + 1;
    $query_001 = "SELECT CASE 
    WHEN NULLIF(wp_id_1, '') IS NULL THEN 'wp_id_1'
    WHEN NULLIF(wp_id_2, '') IS NULL THEN 'wp_id_2'
    WHEN NULLIF(wp_id_3, '') IS NULL THEN 'wp_id_3'
    WHEN NULLIF(wp_id_4, '') IS NULL THEN 'wp_id_4'
    WHEN NULLIF(wp_id_5, '') IS NULL THEN 'wp_id_5'
    WHEN NULLIF(wp_id_6, '') IS NULL THEN 'wp_id_6'
    WHEN NULLIF(wp_id_7, '') IS NULL THEN 'wp_id_7'
    WHEN NULLIF(wp_id_8, '') IS NULL THEN 'wp_id_8'
    WHEN NULLIF(wp_id_9, '') IS NULL THEN 'wp_id_9'
    WHEN NULLIF(wp_id_10, '') IS NULL THEN 'wp_id_10'
    WHEN NULLIF(wp_id_11, '') IS NULL THEN 'wp_id_11'
    WHEN NULLIF(wp_id_12, '') IS NULL THEN 'wp_id_12'
    WHEN NULLIF(wp_id_13, '') IS NULL THEN 'wp_id_13'
    WHEN NULLIF(wp_id_14, '') IS NULL THEN 'wp_id_14'
    WHEN NULLIF(wp_id_15, '') IS NULL THEN 'wp_id_15'
    WHEN NULLIF(wp_id_16, '') IS NULL THEN 'wp_id_16'
    WHEN NULLIF(wp_id_17, '') IS NULL THEN 'wp_id_17'
    WHEN NULLIF(wp_id_18, '') IS NULL THEN 'wp_id_18'
    WHEN NULLIF(wp_id_19, '') IS NULL THEN 'wp_id_19'
    WHEN NULLIF(wp_id_20, '') IS NULL THEN 'wp_id_20'
    WHEN NULLIF(wp_id_21, '') IS NULL THEN 'wp_id_21'
    WHEN NULLIF(wp_id_22, '') IS NULL THEN 'wp_id_22'
    WHEN NULLIF(wp_id_23, '') IS NULL THEN 'wp_id_23'
    WHEN NULLIF(wp_id_24, '') IS NULL THEN 'wp_id_24'
    WHEN NULLIF(wp_id_25, '') IS NULL THEN 'wp_id_25'
    WHEN NULLIF(wp_id_26, '') IS NULL THEN 'wp_id_26'
    WHEN NULLIF(wp_id_27, '') IS NULL THEN 'wp_id_27'
    WHEN NULLIF(wp_id_28, '') IS NULL THEN 'wp_id_28'
    WHEN NULLIF(wp_id_29, '') IS NULL THEN 'wp_id_29'
    WHEN NULLIF(wp_id_30, '') IS NULL THEN 'wp_id_30'
    ELSE 'All wp_id columns are filled'
    END AS first_empty_wp_id
    FROM pipeline_work_pointers_all
    WHERE project_id = '$wpo_project_id' AND line_no = (SELECT MAX(line_no) from pipeline_work_pointers_all);
    ";
    $query_result_001 = mysqli_query($conn, $query_001);

    $rec_001 = mysqli_fetch_assoc($query_result_001);
    // print_r($rec_001);
    if($rec_001['first_empty_wp_id'] == 'All wp_id columns are filled'){
        $query = "INSERT INTO pipeline_work_pointers_all (project_id, BM_id, pipe_id, current_wp_id,line_no,line_status,wp_id_1, WP_dept_1,wp_emp_flow_1) VALUES ('$wpo_project_id', '$wpo_bm_id', '$wpo_wpipe_id', '$current_wp_id','$next_line_no','working',CONCAT('$current_wp_id','=','$wpo_name', '@XXX>XXX'),'$wpo_name','Active')";
        $query_result = mysqli_query($conn, $query);
    } else {
        $string = $rec_001['first_empty_wp_id'];
        preg_match('/wp_id_(\d+)/', $string, $matches);
        $num = $matches[1];

        $query = "UPDATE pipeline_work_pointers_all SET current_wp_id = '$current_wp_id',wp_id_$num=CONCAT('$current_wp_id','=','$wpo_name', '@XXX>XXX'), WP_dept_$num='',wp_emp_flow_$num='' WHERE project_id='$wpo_project_id' and line_no = '$current_line_no'";
        $query_result = mysqli_query($conn, $query);
    }

} else {
    $query = "INSERT INTO pipeline_work_pointers_all (project_id, BM_id, pipe_id, current_wp_id,line_no,line_status,wp_id_1, WP_des_1,wp_status_1) VALUES ('$wpo_project_id', '$wpo_bm_id', '$wpo_wpipe_id', '$current_wp_id','1','working','$current_wp_id','$wpo_name','Active')";
    $query_result = mysqli_query($conn, $query);
}

if (!$query_result) {
    echo json_encode(["msg" => "Error in query: " . mysqli_error($conn)]);
    exit;
}
if ($query_result) {
    $response = ["msg" => "success",];
} else {
    $response = ["msg" => "unsuccess"];
}
header('Content-Type: application/json');

echo json_encode($response);
?>