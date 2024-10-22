<?php
include '../../config/config.php'; // Update this path based on your setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $project_id = $_POST['project_id'] ?? null;
    $purpose = $_POST['purpose'] ?? null;
    $trip_type = $_POST['duration'] ?? null;
    $team_member_names = $_POST['team_member_name'] ?? [];
    $team_member_mobiles = $_POST['team_member_mobile'] ?? [];
    $start_time_hours = $_POST['start_time_hours'] ?? null;
    $end_time_hours = $_POST['end_time_hours'] ?? null;
    $location_hours = $_POST['location_hours'] ?? null;
    $start_date = $_POST['start_date_multiple_days'] ?? null;
    $end_date = $_POST['end_date_multiple_days'] ?? null;
    $project_strat_date = $_POST['project_strat_date'] ?? null;
    $vehicles_hours = $_POST['vehicles_hours'] ?? null;

    // Validation
    if (empty($project_id)) {
        echo "Project ID is required.";
        exit;
    }
    if (empty($purpose)) {
        echo "Purpose is required.";
        exit;
    }

    // Fetch last ID for trip_id
    $query_getbm = "SELECT last_id FROM unique_id_header_all WHERE table_name = 'trip_request_header_all'";
    $query_result_getbm = mysqli_query($conn, $query_getbm);
    
    if (!$query_result_getbm) {
        echo "Error fetching last ID: " . mysqli_error($conn);
        exit;
    }

    // Determine the new trip ID
    if (mysqli_num_rows($query_result_getbm) > 0) {
        $lastrec = mysqli_fetch_assoc($query_result_getbm);
        $current_id = sprintf('%05d', intval($lastrec['last_id']) + 1);

        // Update last ID
        $query_for_last_id = "UPDATE unique_id_header_all SET last_id = ?, modified_on = ? WHERE table_name = 'trip_request_header_all'";
        $stmt_update = $conn->prepare($query_for_last_id);
        $stmt_update->bind_param('ss', $current_id, date('Y-m-d H:i:s'));
        $stmt_update->execute();
        $stmt_update->close();
    } else {
        // Insert new ID if no records exist
        $query_new = "INSERT INTO unique_id_header_all (table_name, id_for, prefix, last_id, created_on) VALUES ('trip_request_header_all', 'trip_id', 'TRI', '00001', ?)";
        $stmt_new = $conn->prepare($query_new);
        $stmt_new->bind_param('s', date('Y-m-d H:i:s'));
        $stmt_new->execute();
        $stmt_new->close();
        
        $current_id = '00001';
    }

    $new_trip_id = 'TRI-' . $current_id;

    // Create team string
    $team_members = [];
    for ($i = 0; $i < count($team_member_names); $i++) {
        $name = $team_member_names[$i] ?? '';
        $mobile = $team_member_mobiles[$i] ?? '';
        if (!empty($name) && !empty($mobile)) {
            $team_members[] = $name . ' (' . $mobile . ')';
        }
    }
    $team_string = implode(', ', $team_members); 
    $no_of_team_members = count($team_members); 

    // For trip type 'Hours'
    if ($trip_type === 'Hours') {
        if (empty($start_time_hours) || empty($end_time_hours)) {
            echo "Start time and end time are required for hours.";
            exit;
        }

        // Calculate duration in decimal format
        $start_time = new DateTime($start_time_hours);
        $end_time = new DateTime($end_time_hours);
        $interval = $start_time->diff($end_time);
        $duration_hours = $interval->h + ($interval->i / 60); // Convert minutes to decimal
        $duration_format = number_format($duration_hours, 2) . '-H'; // Format as H-hours

        $day_data = "$project_strat_date#$start_time_hours#$end_time_hours#$location_hours#$location_hours#$vehicles_hours";

        $insert_sql = "INSERT INTO trip_request_details_all (trip_id, project_id, purpose, day_1_data, no_of_team_members, team, trip_type)
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("sssssss", $new_trip_id, $project_id, $purpose, $day_data, $no_of_team_members, $team_string, $duration_format);

    } elseif ($trip_type === 'Multiple Days') {
        // For trip type 'Multiple Days'
        if (empty($start_date) || empty($end_date)) {
            echo "Start date and end date are required for multiple days.";
            exit;
        }

        $start_date_obj = new DateTime($start_date);
        $end_date_obj = new DateTime($end_date);
        $duration_days = $start_date_obj->diff($end_date_obj)->days + 1;
        $duration_format = $duration_days . '-D'; // Format as D-days

        $days_data = [];
        for ($i = 1; $i <= $duration_days; $i++) {
            $vehicles = $_POST['vehicles']['day' . $i] ?? null;
            $start_time = $_POST['startTime' . $i] ?? null;
            $end_time = $_POST['endTime' . $i] ?? null;
            $city = $_POST['city' . $i] ?? null;
            $location = $_POST['location' . $i] ?? null;

            $days_data[] = "$start_date#$start_time#$end_time#$location#$city#$vehicles";
        }

        $day_columns = array_map(fn($i) => "day_" . $i . "_data", range(1, $duration_days));
        $insert_sql = "INSERT INTO trip_request_details_all (trip_id, project_id, purpose, no_of_team_members, team, trip_type, " . implode(", ", $day_columns) . ")
                       VALUES (?, ?, ?, ?, ?, ?, " . implode(", ", array_fill(0, $duration_days, '?')) . ")";

        $stmt = $conn->prepare($insert_sql);
        $params = array_merge([$new_trip_id, $project_id, $purpose, $no_of_team_members, $team_string, $duration_format], $days_data);
        $types = 'sssiss' . str_repeat('s', $duration_days);
        $stmt->bind_param($types, ...$params);
    } else {
        echo "Invalid trip type selected.";
        exit;
    }

    // Execute the prepared statement for trip details
    if ($stmt->execute()) {
        echo "New trip request inserted successfully with trip_id: $new_trip_id.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Insert into trip_request_header_all
    $status = 1;
    $trip_from_date = $start_date ?? null;
    $trip_till_date = $end_date ?? null;
    $trip_no_of_days = $duration_days ?? 1;
    $requested_on = date('Y-m-d H:i:s');

    $header_sql = "INSERT INTO trip_request_header_all (trip_id, status, trip_from_date, trip_till_date, trip_no_of_days, requested_on)
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_header = $conn->prepare($header_sql);
    $stmt_header->bind_param("sissis", $new_trip_id, $status, $trip_from_date, $trip_till_date, $trip_no_of_days, $requested_on);

    if ($stmt_header->execute()) {
        echo "New trip request header inserted successfully.";
    } else {
        echo "Error inserting trip header: " . $stmt_header->error;
    }

    $stmt_header->close();
    $conn->close();
}
?>
