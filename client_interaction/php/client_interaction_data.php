<style>
    /* button tag */
    .btn_custom {
        background-color: #007BFF;
        color: white;
        padding: 4px 13px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 13px;
        transition: background-color 0.3s ease;
    }

    .btn_custom:hover {
        background-color: #0056b3;
    }

    /* Modal background */
    .modal1 {
        display: none;
        position: fixed;
        z-index: 1060;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        overflow: auto;
    }

    /* Modal content */
    .modal-content1 {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 17px;
        width: 45%;
        position: relative;
        text-align: center;
    }
    
</style>

<?php
include '../../config/config.php'; 

$limit = 5; // Define how many records per page
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$start = ($page - 1) * $limit;

if (isset($_POST['project_id']) && !empty($_POST['project_id'])) {
    $project_id = $_POST['project_id'];

    // Get the total number of records
    $count_query = "SELECT COUNT(*) AS total FROM client_intraction_header_all WHERE project_id = ?";
    $stmt = $conn->prepare($count_query);
    $stmt->bind_param("s", $project_id);
    $stmt->execute();
    $count_result = $stmt->get_result();
    $total_records = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_records / $limit);

    // Fetch the paginated records
    $query = "SELECT id, topic_id, project_id, topic_no, subject, initiated_from, initiated_on, criticality_level, inserted_on, inserted_by, status, closure_date, closed_by 
    FROM client_intraction_header_all 
    WHERE project_id = ? 
    ORDER BY status ASC, initiated_on DESC 
    LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $project_id, $start, $limit);  // Correct type for LIMIT params is integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='billing-milestone' id='billing_milestone' style='width:80%; margin:-450px auto; min-height:50vh;'>";
        echo "<div>
        <label for='search_by' style='font-weight: 900;color: #012970;'>Search By:</label>
        <input type='text' id='search_by' onkeyup='filterTable()' name='search_by'
         style='width:15%;padding:10px;border-radius:5px;border:1px solid #ccc;font-size:16px;'>
        </div> <br>";
        echo "<table id='data-table' class='table disabled-table'>";
        echo "<tr class='text-center'>
                <th>Select</th>
                <th>Topic No</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Status</th>
                <th>Critical Level</th>
                <th>Init Form</th>
                <th>Action</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            $date = date("d-m-Y", strtotime($row['initiated_on']));
            echo "<tr class='text-center'>";
            echo "<td><input type='radio' name='select_topic' value='" . $row['topic_id'] . "' onclick='sendResponse(\"" . $row['topic_id'] . "\")'></td>";
            echo "<td>" . $row['topic_no'] . "</td>";
            echo "<td>" . $row['subject'] . "</td>";
            echo "<td>" . $date . "</td>"; // Display date in dd-mm-yyyy format
            $statusDisplay = ($row['status'] == 1) ? 'Active' : (($row['status'] == 2) ? 'Closed' : 'Unknown');
            echo "<td>" . $statusDisplay . "</td>";
            echo "<td>" . $row['criticality_level'] . "</td>";
            $initiated_fromDisplay = ($row['initiated_from'] == 1) ? 'client' : (($row['initiated_from'] == 2) ? 'Monarch' : 'Unknown');
            echo "<td>" . $initiated_fromDisplay . "</td>";
            
            // Check the status and enable or disable buttons accordingly
            if ($row['status'] == 2) { // Closed
                echo "<td>
                    <button class='btn_custom response-btn' style='background-color:lightgray; color:gray;' disabled>Response</button>
                    <button class='btn_custom close-btn' style='background-color:lightgray; color:gray;' disabled>Close</button>
                </td>";
            } else { // Active
                echo "<td>
                    <button class='btn_custom response-btn' style='background-color:white; color:Blue;' onclick='showResponseModal(\"" . $row['topic_id'] . "\")'>Response</button>
                    <button class='btn_custom close-btn' style='background-color:white; color:red;' data-topic='" . $row['topic_id'] . "'>Close</button>
                </td>";
            }

            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";

        // Pagination
        echo '<div class="pagination" style="text-align: center; margin-top: 380px;">';
        if ($page > 1) {
            echo '<a href="#" onclick="loadData(' . ($page - 1) . ')">Previous</a> ';
        }

        for ($i = 1; $i <= $total_pages; $i++) {
            $activeClass = ($i == $page) ? 'class="active"' : '';
            echo '<a href="#" ' . $activeClass . ' onclick="loadData(' . $i . ')">' . $i . '</a> ';
        }

        if ($page < $total_pages) {
            echo '<a href="#" onclick="loadData(' . ($page + 1) . ')">Next</a>';
        }
        echo '</div>';
    } else {
    
                   echo "No data found.";

    }
} else {
    echo "Invalid project ID.";
}
?>
