<?php
include '../../config/config.php'; // Update this path based on your setup

// Prepare SQL queries
// $activeTopicsQuery = "SELECT count(*) AS count FROM `client_intraction_header_all` WHERE `status`=1 and project_id= ";
// $closedTopicsQuery = "SELECT count(*) AS count FROM `client_intraction_header_all` WHERE `status`=2 and project_id=";

// // Execute queries
// $activeResult = $conn->query($activeTopicsQuery);
// $closedResult = $conn->query($closedTopicsQuery);

// // Fetch results
// $activeCount = $activeResult->fetch_assoc()['count'];
// $closedCount = $closedResult->fetch_assoc()['count'];

// // Return as JSON
// echo json_encode(array(
//     'activeTopics' => $activeCount,
//     'closedTopics' => $closedCount,
// ));

// // Close connection
// $conn->close();

$project_id = isset($_GET['project_id']) ? $_GET['project_id'] : '';

// Initialize response array
$response = array('activeTopics' => 0, 'closedTopics' => 0);

if ($project_id) {
    // Query to count active topics
    $activeTopicsQuery = "SELECT count(*) AS count FROM `client_intraction_header_all` WHERE `status`=1 AND project_id='$project_id'";
    $activeResult = $conn->query($activeTopicsQuery);
    $activeRow = $activeResult->fetch_assoc();
    $response['activeTopics'] = $activeRow['count'];

    // Query to count closed topics
    $closedTopicsQuery = "SELECT count(*) AS count FROM `client_intraction_header_all` WHERE `status`=2 AND project_id='$project_id'";
    $closedResult = $conn->query($closedTopicsQuery);
    $closedRow = $closedResult->fetch_assoc();
    $response['closedTopics'] = $closedRow['count'];
}

// Return the counts as JSON
echo json_encode($response);
?>
