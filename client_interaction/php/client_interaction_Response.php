<?php
include '../../config/config.php'; 

if (isset($_POST['topic_id']) && !empty($_POST['topic_id'])) {
    $topic_no = $_POST['topic_id'];

    $query = "SELECT `id`, `topic_id`, `line_no`, `short_desc`, `detailed_desc`, `poke_from`, `poke_to`, `files`, `alert_no`, `inserted_on`, `discussion_date`, `deviation`,`date_of_letter` 
              FROM `client_intraction_transaction_all`
              WHERE `topic_id` = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $topic_no);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='billing-milestone' id='billing_milestone' style='width:80%; margin:50px auto; min-height:50vh;'>";
        echo "<table class='table disabled-table'>";
        echo "<tr class='text-center'>
                <th>Line NO</th>
                <th>Short Discussion</th>
                <th>Details Discussion</th>
                <th>Date</th>
                <th>Letter date</th>
                <th>From</th>
                <th>To</th>
                <th>Files</th>
                <th>Alerts</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            $date = date("d-m-Y", strtotime($row['discussion_date']));
            $date_of_letter = $row['date_of_letter'] === '0000-00-00 00:00:00' ? "N/A" : date("d-m-Y", strtotime($row['date_of_letter']));
            $poke_from = $row['poke_from'] == 1 ? 'Client' : ($row['poke_from'] == 2 ? 'Monarch' : 'Unknown');
            $poke_to = $row['poke_to'] == 1 ? 'Client' : ($row['poke_to'] == 2 ? 'Monarch' : 'Unknown');

            // Handling files
            $files_array = !empty(trim($row['files'])) ? explode(',', $row['files']) : [];
            $files_count = count($files_array); // Count the number of files

            echo "<tr class='text-center'>";
            echo "<td>" . $row['line_no'] . "</td>";

            // Handling Short Description
            $short_desc = empty($row['short_desc']) ? "N/A" : $row['short_desc'];

            echo "<td>
                    <span>$short_desc</span>... 
                    " . (empty($row['short_desc']) ? "" : "<a href='javascript:void(0)' class='read-more' onclick='showModal1(" . json_encode($row) . ")'>Read More</a>") . "
                  </td>";
            
            

            // Handling Detailed Description
            $details_excerpt = empty($row['detailed_desc']) ? "N/A" : $row['detailed_desc'];
    
            echo "<td>
                    <span>$details_excerpt</span>... 
                    " . (empty($row['detailed_desc']) ? "" : "<a href='javascript:void(0)' class='read-more' onclick='showModal(" . json_encode($row) . ")'>Read More</a>") . "
                  </td>";

            echo "<td>" . $date . "</td>";
            echo "<td>" . $date_of_letter . "</td>"; 
            echo "<td>" . $poke_from . "</td>"; 
            echo "<td>" . $poke_to . "</td>"; 

            // Displaying Files
            echo "<td>";
            if ($files_count > 0) {
                echo "<a href='javascript:void(0)' onclick='showFilesModal(" . json_encode($files_array) . ")'>$files_count</a>"; 
            } else {
                echo "No files";
            }
            echo "</td>";

            echo "<td>" . $row['alert_no'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";

        // Modal for detailed description
        echo "<div class='modal fade' id='detailsModal' tabindex='-1' role='dialog' aria-labelledby='modalLabel' aria-hidden='true'>";
        echo "<div class='modal-dialog' role='document'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header'>";
        echo "<h5 class='modal-title' id='modalLabel'>Discussion</h5>";
        echo "</div>";
        echo "<div class='modal-body' id='modal-body'>";
        echo "</div>";
        echo "<div class='modal-footer'>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

        // Modal for displaying file links
        echo "<div class='modal fade' id='filesModal' tabindex='-1' role='dialog' aria-labelledby='filesModalLabel' aria-hidden='true'>";
        echo "<div class='modal-dialog' role='document'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header'>";
        echo "<h5 class='modal-title' id='filesModalLabel'>Files</h5>";
        echo "</div>";
        echo "<div class='modal-body' id='files-modal-body'>";
        echo "</div>";
        echo "<div class='modal-footer'>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";

    } else {
        echo "<script>showNoDataModal();</script>";  
    }
} else {
    echo "Invalid topic ID.";
}
?>
