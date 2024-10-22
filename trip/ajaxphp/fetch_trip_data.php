<style>
    /* button tag  */

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

    /* show pop up  */
    .popup {
        background-color: white;
        border: 1px solid #ccc;
        padding: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
    }

    .popup-content {
        display: flex;
        flex-direction: column;
    }

    .btn_custom_popup {
        background-color: #007BFF;
        color: white;
        padding: 4px 13px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 13px;
        transition: background-color 0.3s ease;
        margin: 5px 0;
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
    background-color: rgba(0, 0, 0, 0.5); /* Background overlay */
    overflow: hidden;
    overflow-y: scroll; /* Scroll only on Y-axis */
}

.modal-content1 {
    background-color: white;
    margin: 5% auto; /* Adjust margin to center vertically */
    padding: 20px;
    border: 1px solid #888;
    border-radius: 17px;
    width: 45%;
    position: relative;
}

/* Hide scrollbars across browsers */
.modal-content1::-webkit-scrollbar {
    display: none; /* Hide scrollbar for WebKit browsers (Chrome, Safari) */
}

.modal-content1 {
    -ms-overflow-style: none;  /* Hide scrollbar in IE and Edge */
    scrollbar-width: none;      /* Hide scrollbar in Firefox */
}

</style>
<?php
// include 'C:/xampp/htdocs/mpm_web/config/config.php';
include '../../config/config.php'; // Update this path based on your setup


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['project_id'])) {
    $project_id = $_POST['project_id']; // Get project_id as a string

    // echo '<script type="text/javascript">',
    // 'alert("Project ID: ' . htmlspecialchars($project_id) . '");',
    //     '</script>'; // Prepare SQL statement

    // Prepare SQL statement
    $stmt = $conn->prepare("
      SELECT
    ph.project_id,
    ph.project_name,
    trd.trip_id
FROM
    trip_request_details_all trd
JOIN project_header_all ph ON
    trd.project_id = ph.project_id
WHERE
    ph.project_id  = ?
    ");

    // Bind parameter as string
    $stmt->bind_param("s", $project_id); // Changed "i" to "s" for string

    // Execute statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check for results
    if ($result->num_rows > 0) {
        echo '<div class="billing-milestone" id="billing_milestone" style="width:80%;margin:20px auto;min-height:50vh;">
';
        echo '<table class="table disabled-table">
';
        echo '<thead>
                <tr>
                    <th class="text-center">Project Name</th>
                    <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>';

        while ($trip_id = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td class="text-center">' . htmlspecialchars($trip_id['project_name']) . '</td>';
            echo '<td class="text-center">
                    <button style="background-color:#007bff; color:white; padding:5px 10px; font-size:12px; border-radius:5px; border:none; margin-right:5px;" class="dataShowButton"
                    data-trip-id="' . htmlspecialchars($trip_id['trip_id']) . '">Details</button>
                    <button style="background-color:#008000; color:white; padding:5px 10px; font-size:12px; border-radius:5px; border:none; margin-right:5px;" class="editTripButton"
                    data-trip-id="' . htmlspecialchars($trip_id['trip_id']) . '">Edit Trip</button>
                    <button style="background-color:red; color:white; padding:5px 10px; font-size:12px; border-radius:5px; border:none; margin-right:5px;" class="cancelTripButton"
                    data-trip-id="' . htmlspecialchars($trip_id['trip_id']) . '">Cancel Trip</button>
                    <button style="background-color:#6c6c6c; color:white; padding:5px 10px; font-size:12px; border-radius:5px; border:none; margin-right:5px;" class="completeTripButton"
                    data-trip-id="' . htmlspecialchars($trip_id['trip_id']) . '">Complete Trip</button>
                  </td>';
            echo '</tr>';
        }

        echo '</tbody></table></div>';
    } else {
        // echo '<div style="text-align:center;">No trips found for the selected project.</div>';
    }

    // Close the statement
    $stmt->close();
} else {
    echo '<div style="text-align:center;">Please select a project to view trips.</div>';
}

// Close the connection
$conn->close();
