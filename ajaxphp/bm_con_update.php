<?php
require_once("../config/config.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectId = $_POST['projectId'];
    $bmId = $_POST['selectedValue'];

    if (empty($projectId) || empty($bmId)) {
        echo json_encode(['error' => 'Invalid data provided.']);
        exit;
    }

    $sql = "UPDATE `billing_milestone_header_all` SET `status` = 'Configured' WHERE `project_id` = ? AND `BM_id` = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ss", $projectId, $bmId);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'No record updated.']);
            }
        } else {
            echo json_encode(['error' => 'Failed to execute update query.']);
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
