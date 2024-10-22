<?php
require_once("../config/config.php");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if projectId and selectedValue are set
    if (!isset($_POST['projectId']) || !isset($_POST['selectedValue'])) {
        echo json_encode(['error' => 'Invalid input data.']);
        exit;
    }

    $projectId = $_POST['projectId'];
    $bmId = $_POST['selectedValue'];

    // Prepare the SQL query to fetch pipe_id and work pointer count
    $sql = "SELECT `id`, `project_id`, `BM_id`, `BM_name`, `BM_sequence_no`, `working_pipelines`, `inserted_on`, `introduced_by`, `status`, `billing_amount`, `texas_deductions`, `base_amt_with_tax`, `actual_received_amt`, `amt_received_on`, `working_pipeline_status`, `billing_sequence_status`, `bill_submitted_status`, `payment_status`, `Configured_from` FROM `billing_milestone_header_all` WHERE project_id = ? AND BM_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("ss", $projectId, $bmId);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            // Fetch the result
            if ($response = $result->fetch_assoc()) {
                echo json_encode($response);
            } else {
                echo json_encode(['error' => 'No data found.']);
            }
        } else {
            echo json_encode(['error' => 'Execution failed: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
