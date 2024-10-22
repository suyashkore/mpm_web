<?php
include '../config/config.php';

// Check if the database connection is established
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current page and records per page from the query parameters
if (isset($_POST['trip_id'])) {
    $trip_id = $_POST['trip_id'];

    $stmt = $conn->prepare("SELECT `id`, `request_id`, `trip_id`, `project_id`, `purpose`, `no_of_team_members`, `team`, `trip_type`, `trip_otp`, `otp_sent_to_emp`, `otp_sent_on`, `required_vehicle_type`, `day_1_data`, `day_2_data`, `day_3_data`, `day_4_data`, `day_5_data`, `day_6_data`, `day_7_data`, `day_8_data`, `day_9_data`, `day_10_data`, `day_11_data`, `day_12_data`, `day_13_data`, `day_14_data`, `day_15_data`, `day_16_data`, `day_17_data`, `day_18_data`, `day_19_data`, `day_20_data` FROM `trip_request_details_all` WHERE `trip_id` = ?");
    $stmt->bind_param("s", $trip_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No data found']);
    }
}

$conn->close();
?>
