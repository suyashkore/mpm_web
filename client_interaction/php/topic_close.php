<?php
session_start(); // Start the session
include '../../config/config.php'; // Update path as necessary
$emp_id = $_SESSION['emp_id'];
if (isset($_POST['topic_id']) && !empty($_POST['topic_id'])) {
    $topic_no = $_POST['topic_id'];

    // SQL query to close the topic (e.g., update status or delete the row)
    $query = "UPDATE `client_intraction_header_all` SET `status` = '2', `closure_date` = NOW() , `closed_by` = ? WHERE `topic_id` = ?";
    
    // Prepare and execute the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $emp_id, $topic_no);
        if ($stmt->execute()) {
        echo "Topic closed successfully!";
    } else {
        echo "Error closing topic.";
    }
} else {
    echo "Invalid topic number.";
}
?>
