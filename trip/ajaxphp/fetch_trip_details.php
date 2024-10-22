<style>
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


    .modal-content2 {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 17px;
        width: 45%;
        position: relative;
        /* text-align: center; */

    }

    .modal-content-add {
        top: 159px;

    }

    .m_heading {
        font-weight: bold;
        background: #9191f5;
        padding: 10px;
        color: white;
    }

    .close {
        position: absolute;
        top: -5px;
        right: 25px;
        color: #000;
        font-size: 35px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: red;
    }
</style>
<?php
// include 'C:/xampp/htdocs/mpm_web/config/config.php';
include '../../config/config.php'; // Update this path based on your setup

if (isset($_POST['trip_id']) && !empty($_POST['trip_id'])) {
    $trip_id = $_POST['trip_id'];
    $stmt = $conn->prepare("
        SELECT
            id, `trip_id`, `project_id`, `purpose`, `no_of_team_members`, `team`, `trip_type`, `trip_otp`, `otp_sent_to_emp`, `otp_sent_on`, `required_vehicle_type`,
            `day_1_data`, `day_2_data`, `day_3_data`, `day_4_data`, `day_5_data`, `day_6_data`, `day_7_data`, `day_8_data`, `day_9_data`, `day_10_data`,
            `day_11_data`, `day_12_data`, `day_13_data`, `day_14_data`, `day_15_data`, `day_16_data`, `day_17_data`, `day_18_data`, `day_19_data`, `day_20_data`
        FROM
            trip_request_details_all
        WHERE
            trip_id = ?
    ");

    $stmt->bind_param("s", $trip_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<h5>Trip Details</h5>';
        echo '<table class="modal-content1" style="width:100%; border-collapse:collapse;">';

        while ($tripDetail = $result->fetch_assoc()) {
            // General trip details
            echo '<tr style="background-color:#f2f2f2; font-weight:bold;">';
            echo '<th style="padding:8px; border:1px solid #ddd;">Field</th>';
            echo '<th style="padding:8px; border:1px solid #ddd;">Value</th>';
            echo '</tr>';

            echo '<tr>';
            echo '<td style="padding:8px; border:1px solid #ddd;">No of Team Members</td>';
            echo '<td style="padding:8px; border:1px solid #ddd;">' . htmlspecialchars($tripDetail['no_of_team_members']) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td style="padding:8px; border:1px solid #ddd;">Purpose</td>';
            echo '<td style="padding:8px; border:1px solid #ddd;">' . htmlspecialchars($tripDetail['purpose']) . '</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td style="padding:8px; border:1px solid #ddd;">Members/Mobile No</td>';
            echo '<td style="padding:8px; border:1px solid #ddd;">' . htmlspecialchars($tripDetail['team']) . '</td>';
            echo '</tr>';

            // Create a new row for Day Data
            echo '<tr style="background-color:#f2f2f2; font-weight:bold;">';
            echo '<th style="padding:8px; border:1px solid #ddd;" colspan="2">Day-by-Day Data</th>';
            echo '</tr>';

            // Loop through all day data fields and display them
            for ($i = 1; $i <= 20; $i++) {
                $dayField = "day_{$i}_data";
                if (!empty($tripDetail[$dayField])) {
                    // Split the data string by '#'
                    $dayData = explode('#', $tripDetail[$dayField]);

                    // Assign values to appropriate variables
                    $date = isset($dayData[0]) ? DateTime::createFromFormat('Y-m-d', htmlspecialchars($dayData[0])) : false;
                    $formattedDate = $date ? $date->format('d-m-y') : 'Invalid Date';
                    $start_time = isset($dayData[1]) ? htmlspecialchars($dayData[1]) : 'N/A';
                    $end_time = isset($dayData[2]) ? htmlspecialchars($dayData[2]) : 'N/A';
                    $location = isset($dayData[3]) ? htmlspecialchars($dayData[3]) : 'N/A';
                    $city = isset($dayData[4]) ? htmlspecialchars($dayData[4]) : 'N/A';
                    $no_of_vehicle = isset($dayData[5]) ? htmlspecialchars($dayData[5]) : 'N/A';

                    echo '<tr>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">Day ' . $i . ' Date</td>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">' . $formattedDate . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">Start Time</td>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">' . $start_time . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">End Time</td>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">' . $end_time . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">Location</td>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">' . $location . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">City</td>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">' . $city . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">No. of Vehicles</td>';
                    echo '<td style="padding:8px; border:1px solid #ddd;">' . $no_of_vehicle . '</td>';
                    echo '</tr>';
                }
            }
        }

        echo '</table>';
    } else {
        echo '<div>No details found for this trip.</div>';
    }

    $stmt->close();
} else {
    echo '<div>Invalid trip ID.</div>';
}

$conn->close();
