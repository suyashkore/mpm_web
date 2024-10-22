<?php
// include 'C:/xampp/htdocs/mpm_web/config/config.php';
include '../../config/config.php'; // Update this path based on your setup



if (isset($_POST['trip_id'])) {
    $trip_id = $_POST['trip_id'];

    // First, check the current status of the trip
    $stmt = $conn->prepare("SELECT status FROM trip_request_header_all WHERE trip_id = ?");
    $stmt->bind_param("s", $trip_id);
    $stmt->execute();
    $stmt->bind_result($current_status);
    $stmt->fetch();

    if ($current_status === null) {
        echo 'Trip not found.';
    } elseif (in_array($current_status, haystack: ['1', '3', '4'])) {
        $stmt->close();

        $stmt = $conn->prepare("UPDATE trip_request_header_all SET status = '2' WHERE trip_id = ?");
        $stmt->bind_param("s", $trip_id);

        if ($stmt->execute()) {
            echo 'Trip canceled successfully!';
        } else {
            echo 'Error canceling trip: ' . $conn->error;
        }
        $stmt->close();
    } else {
        echo 'Trip cannot be canceled. Current status is not valid.';
    }

    $stmt->close();
}

$conn->close();
