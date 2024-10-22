<?php
// include 'C:/xampp/htdocs/mpm_web/config/config.php';
include '../../config/config.php'; // Update this path based on your setup


// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the trip_id is set in the POST request
if (isset($_POST['trip_id'])) {
    $trip_id = $_POST['trip_id'];

    // Prepare the SQL statement to retrieve trip details
    $stmt = $conn->prepare("
        SELECT `id`, `request_id`, `trip_id`, `project_id`, `purpose`, `no_of_team_members`, `team`, `trip_type`, `trip_otp`,
               `otp_sent_to_emp`, `otp_sent_on`, `required_vehicle_type`, `day_1_data`, `day_2_data`, `day_3_data`,
               `day_4_data`, `day_5_data`, `day_6_data`, `day_7_data`, `day_8_data`, `day_9_data`, `day_10_data`,
               `day_11_data`, `day_12_data`, `day_13_data`, `day_14_data`, `day_15_data`, `day_16_data`, `day_17_data`,
               `day_18_data`, `day_19_data`, `day_20_data`
        FROM `trip_request_details_all`
        WHERE trip_id = ?
    ");

    // Bind the trip_id parameter to the prepared statement
    $stmt->bind_param("s", $trip_id);

    // Execute the statement
    $stmt->execute();

    // Get the result set from the statement
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the trip details
        $tripDetails = $result->fetch_assoc();

        // Concatenate all day_*_data columns into a format like date#start_time#end_time#location#city#no_of_vehicle
        $daysData = [];
        for ($i = 1; $i <= 20; $i++) {
            $dayData = $tripDetails['day_' . $i . '_data'];
            if (!empty($dayData)) {
                $daysData[] = $dayData; // Add each day's data to the array
            }
        }

        // Add concatenated data to response
        $tripDetails['days_data'] = $daysData;

        // Return the data as a JSON object
        echo json_encode($tripDetails);
    } else {
        // If no trip details were found, return an error message
        echo json_encode(['error' => 'No trip details found']);
    }

    // Close the statement
    $stmt->close();
} else {
    // If trip_id is not set, return an error message
    echo json_encode(['error' => 'Invalid trip ID']);
}

// Close the database connection
$conn->close();
