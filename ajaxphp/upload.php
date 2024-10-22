<?php
require_once("../config/config.php");
use PhpOffice\PhpSpreadsheet\IOFactory;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Enable output buffering at the start
ob_start();

header('Content-Type: application/json'); // Ensure JSON content type

$response = ['success' => false, 'message' => ''];

try {
    if (isset($_FILES['xlsx_file']['name'])) {
        $filename = $_FILES['xlsx_file']['name'];
        $fileTmp = $_FILES['xlsx_file']['tmp_name'];
        $fileExt = pathinfo($filename, PATHINFO_EXTENSION);

        if ($fileExt == 'xlsx') {
            require '../vendor/autoload.php';
            // Load the uploaded XLSX file
            $spreadsheet = IOFactory::load($fileTmp);
            $worksheet = $spreadsheet->getActiveSheet();
            $isFirstRow = true;

            // Loop through rows and get data
            foreach ($worksheet->getRowIterator() as $row) {
                if ($isFirstRow) {
                    $isFirstRow = false;
                    continue;
                }

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                // Check if rowData has required values
                if (!empty($rowData[0]) && !empty($rowData[1])) {
                    $pipe_id = $rowData[0];
                    $line_status = $rowData[1];

                    // Insert data into the database
                    $sql = "INSERT INTO pipeline_work_pointers_all (pipe_id, line_status) 
                            VALUES ('" . $conn->real_escape_string($pipe_id) . "', 
                                    '" . $conn->real_escape_string($line_status) . "')";
                    if (!$conn->query($sql)) {
                        throw new Exception("Database Error: " . $conn->error);
                    }
                }
            }

            $response['success'] = true;
            $response['message'] = 'File uploaded and data imported successfully!';
        } else {
            $response['message'] = 'Please upload a valid XLSX file.';
        }
    } else {
        $response['message'] = 'No file uploaded.';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Clear the buffer and return the JSON response
ob_end_clean();
echo json_encode($response);
?>
