<?php
// include 'C:/xampp/htdocs/mpm_web/config/config.php';
include '../../config/config.php'; // Update this path based on your setup


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trip_id = $_POST['trip_id'];
    $purpose = $_POST['purpose'];
    $no_of_team_members = $_POST['no_of_team_members'];
    $team_member_names = $_POST['team_member_name'];
    $team_member_mobiles = $_POST['team_member_mobile'];
    $dates = $_POST['date'];
    $start_times = $_POST['start_time'];
    $end_times = $_POST['end_time'];
    $locations = $_POST['location'];
    $cities = $_POST['city'];
    $no_of_vehicles = $_POST['no_of_vehicles'];

    $team_data = [];
    for ($i = 0; $i < count($team_member_names); $i++) {
        $team_data[] = $team_member_names[$i] . '(' . $team_member_mobiles[$i] . ')';
    }
    $team_string = implode(', ', $team_data);

    $days_data_values = [];
    $days_placeholders = [];

    for ($i = 1; $i <= 20; $i++) {
        if (isset($dates[$i - 1]) && isset($start_times[$i - 1]) && isset($end_times[$i - 1]) && isset($locations[$i - 1]) && isset($cities[$i - 1]) && isset($no_of_vehicles[$i - 1])) {
            $day_data = $dates[$i - 1] . '#' . $start_times[$i - 1] . '#' . $end_times[$i - 1] . '#' . $locations[$i - 1] . '#' . $cities[$i - 1] . '#' . $no_of_vehicles[$i - 1];
            $days_data_values[] = $day_data;
            $days_placeholders[] = "day_{$i}_data = ?";
        }
    }

    $sql = "UPDATE trip_request_details_all
            SET purpose = ?, no_of_team_members = ?, team = ?, " . implode(', ', $days_placeholders) . "
            WHERE trip_id = ?";

    $stmt = $conn->prepare($sql);

    $bind_values = array_merge([$purpose, $no_of_team_members, $team_string], $days_data_values, [$trip_id]);

    $stmt->bind_param(str_repeat('s', count($bind_values)), ...$bind_values);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update the trip.']);
    }

    $stmt->close();
    $conn->close();
}
