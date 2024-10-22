<?php
session_start(); 
include '../../config/config.php'; 

if (!isset($_SESSION['emp_id'])) {
    die("User not logged in.");
}

$emp_id = $_SESSION['emp_id'];
$date_01 = date('Y-m-d H:i:s'); // Set the current date and time

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $project_id = trim($_POST['project_id']);
        // $topic_no = '001'; 
        $subject = trim($_POST['subject']);
        $initiated_from = trim($_POST['poke_from']);
        $criticality_level = trim($_POST['criticality_level']); 
        $status = '1'; 


        $sql_last_line_no = "SELECT MAX(topic_no) as last_line_no FROM client_intraction_header_all  WHERE topic_id = ?";
$stmt = $conn->prepare($sql_last_line_no);
$stmt->bind_param("s", $topic_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$last_line_no = $row['last_line_no'] ?? 0;
$topic_no = $last_line_no + 1;

        // Get the last ID from the unique_id_header_all table
        $query_getbm = "SELECT last_id FROM unique_id_header_all WHERE table_name = 'client_intraction_header_all'";
        $query_result_getbm = mysqli_query($conn, $query_getbm);

        if (!$query_result_getbm) {
            throw new Exception("Error fetching last ID: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($query_result_getbm) > 0) {
            $lastrec = mysqli_fetch_assoc($query_result_getbm);
            $current_id = sprintf('%05d', intval($lastrec['last_id']) + 1);

            $query_for_last_id = "UPDATE unique_id_header_all SET last_id = ?, modified_on = ? WHERE table_name = 'client_intraction_header_all'";
            $stmt_update = $conn->prepare($query_for_last_id);
            $stmt_update->bind_param('ss', $current_id, $date_01);
            $stmt_update->execute();
            $stmt_update->close();
        } else {
            $query_new = "INSERT INTO unique_id_header_all (table_name, id_for, prefix, last_id, created_on) VALUES ('client_intraction_header_all', 'topic_id', 'TOP', '00001', ?)";
            $stmt_new = $conn->prepare($query_new);
            $stmt_new->bind_param('s', $date_01);
            $stmt_new->execute();
            $stmt_new->close();
            
            $current_id = '00001';
        }

        $topic_id = 'TOP-' . $current_id;

        $sql = "INSERT INTO client_intraction_header_all 
                (topic_id, criticality_level, project_id, topic_no, subject, initiated_from, inserted_by, status, inserted_on, initiated_on) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param('ssssssss', $topic_id, $criticality_level, $project_id, $topic_no, $subject, $initiated_from, $emp_id, $status);

        if ($stmt->execute()) {
            echo "New client interaction created successfully!";
        } else {
            echo "Error: Unable to create interaction. " . $stmt->error;
        }

        $stmt->close();
    }
} catch (mysqli_sql_exception $e) {
    echo 'Connection failed: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
