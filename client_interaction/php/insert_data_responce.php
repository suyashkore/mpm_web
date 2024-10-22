<?php
session_start();
include '../../config/config.php';

$emp_id = $_SESSION['emp_id'] ?? null; 
$topic_id = $_POST['topic_id'] ?? null;
$short_desc = $_POST['short_desc'] ?? null;
$detailed_desc = $_POST['detailed_desc'] ?? null;
$discussion_date = $_POST['discussion_date'] ?? null;
$poke_from = $_POST['poke_from'] ?? null;
$poke_to = $_POST['poke_to'] ?? null;
$communication_medium = $_POST['communication_medium'] ?? null;
$date_of_letter = $_POST['date_of_letter'] ?? null;
$criticality_level = $_POST['lavel'] ?? null;

if (!$topic_id || !$short_desc || !$discussion_date || !$poke_from || !$poke_to || !$communication_medium || !$date_of_letter || !$criticality_level) {
    echo "Error: All fields are required.";
    exit;
}

$sql_last_line_no = "SELECT MAX(line_no) as last_line_no FROM client_intraction_transaction_all WHERE topic_id = ?";
$stmt = $conn->prepare($sql_last_line_no);
$stmt->bind_param("s", $topic_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$last_line_no = $row['last_line_no'] ?? 0;
$new_line_no = $last_line_no + 1;

$date_01 = date('Y-m-d H:i:s'); 
$query_for_last_id = "SELECT last_id FROM unique_id_header_all WHERE table_name = 'client_intraction_transaction_all'";
$query_result_getbm = $conn->query($query_for_last_id); 

if (mysqli_num_rows($query_result_getbm) > 0) {
    $lastrec = mysqli_fetch_assoc($query_result_getbm);
    $current_id = sprintf('%05d', intval($lastrec['last_id']) + 1);

    $query_for_last_id = "UPDATE unique_id_header_all SET last_id = ?, modified_on = ? WHERE table_name = 'client_intraction_transaction_all'";
    $stmt_update = $conn->prepare($query_for_last_id);
    $stmt_update->bind_param('ss', $current_id, $date_01);
    $stmt_update->execute();
    $stmt_update->close();
} else {
    $query_new = "INSERT INTO unique_id_header_all (table_name, id_for, prefix, last_id, created_on) VALUES ('client_intraction_transaction_all', 'letter_no', 'LT', '00001', ?)";
    $stmt_new = $conn->prepare($query_new);
    $stmt_new->bind_param('s', $date_01);
    $stmt_new->execute();
    $stmt_new->close();
    
    $current_id = '00001';
}

$letter_no = 'LT-' . $current_id; 

$uploadDir = '../../client_interaction/upload/';
$fileNames = [];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (!empty($_FILES['files']['name'][0])) {
    foreach ($_FILES['files']['name'] as $key => $name) {
        $fileType = pathinfo($name, PATHINFO_EXTENSION);
        if (in_array(strtolower($fileType), ['pdf'])) {
            $tmpName = $_FILES['files']['tmp_name'][$key];
            $filePath = $uploadDir . basename($name);

            if (move_uploaded_file($tmpName, $filePath)) {
                $fileNames[] = $name; 
            } else {
                error_log("Error uploading file: " . $name);
            }
        } else {
            echo "Invalid file type for: $name. Only PDF files are allowed.";
            exit;
        }
    }
}

$files = implode(',', $fileNames);

$sql = "INSERT INTO client_intraction_transaction_all 
        (topic_id, short_desc, detailed_desc, discussion_date, poke_from, poke_to, line_no, files, inserted_on, communication_medium, date_of_letter, criticality_level, letter_no) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Preparation failed: " . $conn->error);
    echo "Error preparing the statement.";
    exit;
}

$stmt->bind_param("ssssssisssss", $topic_id, $short_desc, $detailed_desc, $discussion_date, $poke_from, $poke_to, $new_line_no, $files, $communication_medium, $date_of_letter, $criticality_level, $letter_no);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error; 
    error_log("SQL Error: " . $stmt->error); 
}

$stmt->close();
$conn->close();
?>
