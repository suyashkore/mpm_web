<?php
session_start(); // Start the session
include 'config/config.php'; // Include the config file

// Check if session has any data
// if (!empty($_SESSION)) {
//     echo "<pre>";
//     print_r($_SESSION); // Display all session data in a readable format
//     echo "</pre>";
// } else {
//     echo "No session data available.";
// }

// $sql = "SELECT `id`, `emp_id`, `login_pin`, `emp_no`, `name`, `email_id`, `contact_1`, `contact_2`, `dob`, `doj`, `status`, `inserted_on`, `suspended_on`, `DS`, `DF`, `DO`, `PA`, `PM`, `HOD`, `TMPM`, `TMD`, `MT`, `DI`, `HR`, `profile_id`, `Current_position_Code`, `reporting_to`, `pin_reset_on` FROM `employee_header_all` WHERE 1";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     $employees = [];
//     while ($row = $result->fetch_assoc()) {
//         $employees[] = $row; 
//     }
    
//     header('Content-Type: application/json');
//     echo json_encode($employees);
// } else {
//     echo json_encode([]);
// }

// $conn->close();

try {
    // Get the JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO employee_header_all 
        (emp_id, login_pin, emp_no, name, email_id, contact_1, contact_2, dob, doj, status, 
        inserted_on, suspended_on, DS, DF, DO, PA, PM, HOD, TMPM, TMD, MT, DI, HR, profile_id, 
        Current_position_Code, reporting_to, pin_reset_on) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Set defaults for any missing or empty values
    $input['contact_2'] = $input['contact_2'] ?? null;
    $input['dob'] = $input['dob'] ?? null;
    $input['doj'] = $input['doj'] ?? null;
    $input['status'] = $input['status'] ?? null;
    $input['suspended_on'] = $input['suspended_on'] ?? null;
    $input['DS'] = $input['DS'] ?? null;
    $input['DF'] = $input['DF'] ?? null;
    $input['DO'] = $input['DO'] ?? null;
    $input['PA'] = $input['PA'] ?? null;
    $input['PM'] = $input['PM'] ?? null;
    $input['TMPM'] = $input['TMPM'] ?? null;
    $input['TMD'] = $input['TMD'] ?? null;
    $input['MT'] = $input['MT'] ?? null;
    $input['DI'] = $input['DI'] ?? null;
    $input['HR'] = $input['HR'] ?? null;
    $input['Current_position_Code'] = $input['Current_position_Code'] ?? null;
    $input['reporting_to'] = $input['reporting_to'] ?? null;
    $input['pin_reset_on'] = $input['pin_reset_on'] ?? null;

    // Bind parameters
    $stmt->bind_param("sssssssssssssssssssssssss", 
        $input['emp_id'], 
        $input['login_pin'], 
        $input['emp_no'], 
        $input['name'], 
        $input['email_id'], 
        $input['contact_1'], 
        $input['contact_2'], 
        $input['dob'], 
        $input['doj'], 
        $input['status'], 
        $input['inserted_on'], 
        $input['suspended_on'], 
        $input['DS'], 
        $input['DF'], 
        $input['DO'], 
        $input['PA'], 
        $input['PM'], 
        $input['HOD'], 
        $input['TMPM'], 
        $input['TMD'], 
        $input['MT'], 
        $input['DI'], 
        $input['HR'], 
        $input['profile_id'], 
        $input['Current_position_Code'], 
        $input['reporting_to'], 
        $input['pin_reset_on']
    );

    // Execute the statement
    $stmt->execute();

    // Respond with a success message
    echo json_encode(['status' => 'success', 'message' => 'Employee inserted successfully']);
} catch (mysqli_sql_exception $e) {
    // Respond with an error message
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
