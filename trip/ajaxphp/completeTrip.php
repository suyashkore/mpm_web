<?php
include '../../config/config.php'; // Update this path based on your setup


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['trip_id'])) {
    $trip_id = $_POST['trip_id'];

    // Check current status of the trip
    $statusQuery = $conn->prepare("SELECT status FROM trip_request_header_all WHERE trip_id = ?");
    if (!$statusQuery) {
        die("Query preparation failed: " . $conn->error);
    }
    $statusQuery->bind_param("s", $trip_id);
    $statusQuery->execute();
    $result = $statusQuery->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentStatus = $row['status'];

        // Only allow completion if the trip is in the status 8
        if ($currentStatus == 8) {
            $newStatus = 9;
            $stmt = $conn->prepare("UPDATE trip_request_header_all SET status = ? WHERE trip_id = ? AND status = ?");
            if (!$stmt) {
                die("Query preparation failed: " . $conn->error);
            }
            $stmt->bind_param("ssi", $newStatus, $trip_id, $currentStatus);

            if ($stmt->execute()) {
                echo 'Trip completed successfully!';
            } else {
                echo 'Error completing the trip: ' . $stmt->error;
            }
            $stmt->close();  // Close the statement after execution
        } else {
            echo 'Please first close the trip before completing it.';
        }
    } else {
        echo 'Trip not found.';
    }

    $statusQuery->close();  // Close the status query statement
}

$conn->close();  // Close the database connection