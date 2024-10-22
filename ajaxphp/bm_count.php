<?php
require_once("../config/config.php");


header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectId = $_POST['projectId'];
    $bmId = $_POST['selectedValue'];


    // Prepare the SQL query to fetch pipe_id and work pointer count
    $sql = "SELECT pipe_id, COUNT(*) AS count FROM working_pipeline_header_all WHERE project_id = ? AND BM_id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind parameters and execute the statement
        $stmt->bind_param("ss", $projectId, $bmId);
        $stmt->execute();
        $result = $stmt->get_result();


        // Fetch the result
        if ($response = $result->fetch_assoc()) {
            echo json_encode($response);
        } else {
            echo json_encode(['error' => 'No data found.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare statement.']);
    }


    $conn->close();
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>