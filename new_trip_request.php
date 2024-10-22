<?php
session_start();
include './config/config.php';
include './class/class_project_details.php';
include './class/class_department.php';
include 'header.php';

// Project details
$project = new project($conn);
$projects = $project->get_project_data();

$department_obj = new department($conn);
$department = $department_obj->get_department();

// Sidebar
include 'sidebar.php';
$activeTripsSql = "SELECT COUNT(*) as active_count FROM `trip_request_header_all` WHERE `status` IN ('1','3','4','5','6','7')";
$completedTripsSql = "SELECT COUNT(*) as completed_count FROM `trip_request_header_all` WHERE `status`='9'";
$closedTripsSql = "SELECT COUNT(*) as closed_count FROM `trip_request_header_all` WHERE `status`='8'";
$cancelledTripsSql = "SELECT COUNT(*) as cancelled_count FROM `trip_request_header_all` WHERE `status`='2'";

// Execute queries
$activeTripsResult = $conn->query($activeTripsSql);
$completedTripsResult = $conn->query($completedTripsSql);
$closedTripsResult = $conn->query($closedTripsSql);
$cancelledTripsResult = $conn->query($cancelledTripsSql);

// Fetch the counts
$activeTrips = $activeTripsResult->fetch_assoc()['active_count'];
$completedTrips = $completedTripsResult->fetch_assoc()['completed_count'];
$closedTrips = $closedTripsResult->fetch_assoc()['closed_count'];
$cancelledTrips = $cancelledTripsResult->fetch_assoc()['cancelled_count'];

// Close the connection
$conn->close();
?>
<style>
    /* Button Styling */
    .btn_custom,
    .btn_custom_popup {
        background-color: #007BFF;
        color: white;
        padding: 4px 13px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 13px;
        transition: background-color 0.3s ease;
    }

    .btn_custom:hover,
    .btn_custom_popup:hover {
        background-color: #0056b3;
    }

    /* Popup Styling */
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

    /* Modal Styling */
    .modal {
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

    .modal-content2,
    .modal-content {
        background-color: white;
        margin: 0% auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 17px;
        width: 45%;
        position: relative;
    }

    .modal-content-add {
        top: 159px;
    }

    /* Modal Close Button */
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

    /* Trip Status Styling */
    .trip-status-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        text-align: center;
    }

    .trip-status {
        font-size: 16px;
        padding: 10px;
        color: #333;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .trip-status:hover {
        color: #007BFF;
    }

    /* Scrollbar Styling in Modal Content */
    .modal-content {
        max-height: 500px;
        overflow-y: auto;
    }

    .modal-content::-webkit-scrollbar {
        width: 8px;
    }

    .modal-content::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .modal-content::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Toast Notification Styling */
    #toastNotification.success {
        background-color: #28a745;
    }

    #toastNotification.error {
        background-color: #dc3545;
    }

    #toastNotification.show {
        display: block;
        opacity: 1;
        transition: opacity 0.5s ease-in-out;
    }

    #toastNotification.fadeout {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
    }

    /* General Page Layout */
    body {
        display: flex;
        flex-direction: column;
        height: 100vh;
        margin: 0;
    }

    .main {
        flex: 1;
        background-color: #f6f9ff;
    }

    form {
        padding-bottom: 80px;
    }

    footer {
        background-color: #f8f9fa;
        padding: 60px;
        text-align: center;
    }

    .team-member-input {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .team-member-input label {
        margin-right: 10px;
    }

    .team-member-input input {
        margin-right: 10px;
    }

    .m_heading {
        font-weight: bold;
        background: #9191f5;
        padding: 10px;
        color: white;
    }
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

<link rel="stylesheet" href="./trip/css/new_trip.css">
<!-- Link to the external CSS file -->

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Transportation</h1>
        <nav>
            <ol class="breadcrumb" style="background-color: #f6f9ff;">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">New Trip Request</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <!-- <h5 class="card-title text-center">Trip Monitoring</h5> -->

            <div class="col-lg-12">
                <div class="row">
                    <!-- Trip Status -->
                    <div class="trip-status-container">
                        <div class="trip-status">Active Trips: <span><?php echo $activeTrips; ?></span></div>
                        <div class="trip-status">Completed Trips: <span><?php echo $completedTrips; ?></span></div>
                        <div class="trip-status">Close Trips: <span><?php echo $closedTrips; ?></span></div>
                        <div class="trip-status">Cancelled Trips: <span><?php echo $cancelledTrips; ?></span></div>
                    </div>
                </div>
                <div class="text-center" style="width:50%;margin:auto;">
                    <select id="select_project_id" onchange="toggleBillingMilestone()"
                        style="width:100%;padding:10px;border-radius:5px;border:1px solid #ccc;font-size:16px;">
                        <option value="">Select Project</option>
                        <?php
                        foreach ($projects['projects'] as $project) {
                            ?>
                            <option value="<?php echo $project['project_id'] ?>"><?php echo $project['project_name']; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <!-- New Button Row -->
                <div class="disabled-table" id="new_milestone_01" style="width:80%; margin:10px auto; display: block;">
                    <button class="btn_custom" style="float: right;" id="NewTripopenPopup">New</button><br>
                </div>
                <!-- datashow -->
                <div id="trip_data" style="margin-top:20px;"></div>
                <!-- datashow close-->
                <!-- Trip details will be loaded here -->
                <div class="modal fade" id="tripDetailsModal" tabindex="-1" role="dialog"
                    aria-labelledby="tripDetailsModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="width: 164%; margin-left: -116px;">
                            <div class="modal-header">
                                <span class="close" data-dismiss="modal">&times;</span> <!-- Close button -->


                            </div>
                            <div class="modal-body" id="modalBody">
                                <!-- datashow -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Trip details will be close -->
                <!-- Cancel_trip -->
                <div class="modal fade" id="cancelTripModal" tabindex="-1" role="dialog"
                    aria-labelledby="cancelTripModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="cancelTripModalLabel">Confirm Trip Cancellation</h5>
                                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button> -->
                                <span class="close" data-dismiss="modal">&times;</span> <!-- Close button -->

                            </div>
                            <div class="modal-body">
                                Are you sure you want to cancel this trip?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" id="confirmCancelTrip">Yes, Cancel
                                    Trip</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="successModal" tabindex="-1" role="dialog"
                    aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                                <span class="close" data-dismiss="modal">&times;</span> <!-- Close button -->

                            </div>
                            <div class="modal-body">
                                Trip has been canceled successfully!
                            </div>
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="closeSuccessModal">Close</button>
                            </div> -->
                        </div>
                    </div>
                </div>

                <!-- Error Message Modal -->
                <div class="modal fade" id="errorMessageModal" tabindex="-1" role="dialog"
                    aria-labelledby="errorMessageModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="errorMessageModalLabel"></h5>
                                <span class="close" data-dismiss="modal">&times;</span> <!-- Close button -->

                            </div>
                            <div class="modal-body" id="errorMessageBody">
                                <!-- Error message will be displayed here -->
                            </div>
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div> -->
                        </div>
                    </div>
                </div>
                <!-- Error Message Modal -->
                <!-- cancle trip -->
                <!-- Confirmation Modal -->
                <div class="modal fade" id="completeTripModal" tabindex="-1" role="dialog"
                    aria-labelledby="completeTripModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="completeTripModalLabel">Confirm Trip Completion</h5>
                                <span class="close" data-dismiss="modal">&times;</span> <!-- Close button -->

                            </div>
                            <div class="modal-body">
                                Are you sure you want to complete this trip?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="confirmCompleteTrip">Yes, Complete
                                    Trip</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="completeSuccessModal" tabindex="-1" role="dialog"
                    aria-labelledby="completeSuccessModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="completeSuccessModalLabel">Success!</h5>
                                <span class="close" data-dismiss="modal">&times;</span> <!-- Close button -->

                            </div>
                            <div class="modal-body">
                                Trip has been completed successfully!
                            </div>
                            <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-primary"
                                    id="closeCompleteSuccessModal">Close</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Error Message Modal -->
            <div class="modal fade" id="errorMessageModal" tabindex="-1" role="dialog"
                aria-labelledby="errorMessageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="errorMessageModalLabel"></h5>
                            <span class="close" data-dismiss="modal">&times;</span> <!-- Close button -->

                        </div>
                        <div class="modal-body" id="errorMessageBody">
                            <!-- Error message will be displayed here -->
                        </div>
                        <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div> -->
                    </div>
                </div>
            </div>
            <!-- Error Message Modal -->


            <!-- Modal for editing trip details -->
            <div id="editTripModal" class="modal1" style="display:none;">
                <div class="modal-content1"
                    style="width: 45%; max-height: 700px; overflow-y: auto; position: relative;">
                    <span class="close">&times;</span>
                    <h5 class="card-title text-center">Edit Trip Request</h5>
                    <form id="editTripForm">
                        <input type="hidden" id="trip_id" name="trip_id">
                        <div>
                            <label for="purpose">Purpose:</label>
                            <input type="text" id="purpose_input" class="form-control" name="purpose">
                        </div>
                        <div>
                            <label for="no_of_team_members">Number of Team Members:</label>
                            <input type="text" id="no_of_team_members_input" class="form-control"
                                name="no_of_team_members">
                        </div>
                        <div id="teamMembersContainer1"></div><!-- Container for dynamic team member inputs -->
                        <div id="daysDataContainer"></div><!-- Container for dynamic day data inputs -->
                        <button type="submit" class="btn btn-primary btn-md">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Toast notification for success or failure message -->
            <div id="toastNotification"
                style="display:none; position:fixed; top:20px; right:50px; background-color:#333; color:#fff; padding:15px; border-radius:5px; z-index:9999;">
                <span id="toastMessage"></span>
            </div>

        </div>

        <!-- Create New Trip -->
        <div id="NewTrippopupForm" class="modal1" style="display: none;">
            <div class="modal-content1" style="width: 45%; max-height: 700px; overflow-y: auto; position: relative;">
                <span class="close" id="NewTripclosePopup">&times;</span>
                <form id="newTripForm">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Create New Trip Request</h5>
                            <div class="row g-3">
                                <!-- Project Name -->
                                <div class="col-md-12">
                                    <label for="project_id" class="form-label">Select Project Name:</label>
                                    <select id="project_id" name="project_id" required class="form-control">
                                        <option value="">Select Project</option>
                                        <?php
                                        foreach ($projects['projects'] as $project) {
                                            ?>
                                            <option value="<?php echo $project['project_id'] ?>">
                                                <?php echo $project['project_name']; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Purpose -->
                                <div class="col-md-12">
                                    <label for="purpose" class="form-label">Purpose</label>
                                    <textarea id="purpose" name="purpose" class="form-control" rows="3" required
                                        placeholder="Enter the purpose of the trip..."></textarea>
                                </div>

                                <!-- Team Members -->
                                <div class="col-md-12">
                                    <label for="teamMembers" class="form-label">No. of Team Members</label>
                                    <input type="number" name="teamMembers" class="form-control" id="teamMembers"
                                        required min="1">
                                    <div class="team-section">
                                        <center>
                                            <label class="form-check-label" style="font-weight:bold;">Team Members
                                                <div id="teamMembersContainer"></div>
                                            </label>
                                        </center>
                                    </div>
                                </div>

                                <!-- Trip Details -->
                                <div class="col-md-12">
                                    <center>
                                        <label class="form-check-label" style="font-weight:bold;">Trip
                                            Details</label>
                                    </center>
                                    <label for="duration" class="form-label">For the period of</label>
                                    <select id="duration" name="duration" required class="form-control">
                                        <option value="">Select Duration</option>
                                        <option value="Hours">For Hours</option>
                                        <option value="Multiple Days">For Multiple Days</option>
                                    </select>
                                </div>

                                <!-- For Hours Section -->
                                <div class="col-md-12 hidden" id="forHours">
                                    <label for="projectStratDate" class="form-label">Date</label>
                                    <input type="date" name="project_strat_date" class="form-control"
                                        id="projectStratDate" min="<?php echo date('Y-m-d'); ?>">

                                    <div class="row">
                                        <!-- Start Time -->
                                        <div class="col-md-6">
                                            <label for="startTimeHours" class="form-label">Start Time</label>
                                            <input type="time" name="start_time_hours" class="form-control"
                                                id="startTimeHours">
                                        </div>

                                        <!-- End Time -->
                                        <div class="col-md-6">
                                            <label for="endTimeHours" class="form-label">End Time</label>
                                            <input type="time" name="end_time_hours" class="form-control"
                                                id="endTimeHours">
                                        </div>
                                    </div>

                                    <label for="vehiclesHours" class="form-label">No. of Vehicles Required</label>
                                    <input type="number" name="vehicles_hours" class="form-control" id="vehiclesHours"
                                        min="1">

                                    <label for="locationHours" class="form-label">Location</label>
                                    <input type="text" name="location_hours" class="form-control" id="locationHours">
                                </div>

                                <!-- For Multiple Days Section -->
                                <div class="col-md-12 hidden" id="forMultipleDays">
                                    <div class="row">
                                        <!-- Start Date Column -->
                                        <div class="col-md-6">
                                            <label for="startDateMultipleDays" class="form-label">Start Date</label>
                                            <input type="date" name="start_date_multiple_days" class="form-control"
                                                id="startDateMultipleDays">
                                        </div>

                                        <!-- End Date Column -->
                                        <div class="col-md-6">
                                            <label for="endDateMultipleDays" class="form-label">End Date</label>
                                            <input type="date" name="end_date_multiple_days" class="form-control"
                                                id="endDateMultipleDays">
                                        </div>
                                    </div>
                                </div>
                                <div id="multipleDaysFields"></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-primary btn-md"
                            onclick="submitForm_01(event);">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Create New Trip close-->
        </div>
        <!-- --------------------------------        defolt         -->
        <div class="billing-milestone" id="billing_milestone" style="width:80%;margin:20px auto;min-height:50vh;">
            <table class="table disabled-table">
                <thead>
                    <tr>
                        <th class="text-center">Project Name</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $projects = ['MTSS project', 'Sanket', 'Monarch', 'test', 'test1'];

                    foreach ($projects as $project) {
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $project; ?></td>
                            <td class="text-center">
                                <button class="details-btn"
                                    style="background-color:#007bff; color:white; padding:3px 10px; font-size:12px; border-radius:5px; border:none; margin-right:5px;">Details</button>
                                <button class="details-btn"
                                    style="background-color:#008000; color:white; padding:5px 10px; font-size:12px; border-radius:5px; border:none; margin-right:5px;">Edit
                                    Trip</button>
                                <button class="details-btn"
                                    style="background-color:red; color:white; padding:5px 10px; font-size:12px; border-radius:5px; border:none; margin-right:5px;">Cancel
                                    Trip</button>
                                <button class="details-btn"
                                    style="background-color:#6c6c6c; color:white; padding:5px 10px; font-size:12px; border-radius:5px; border:none; margin-right:5px;">Complete
                                    Trip</button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectModalLabel">Selected Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Please select the<strong id="selectedProject"></strong> project.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="confirmSelection">OK</button>
                    </div>
                </div>
            </div>
        </div>

<!-- Success Modal -->
<div class="modal fade" id="successModal1" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Success</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Trip request has been generated successfully!
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button> -->
      </div>
    </div>
  </div>
</div>


    </section>
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include 'footer.php' ?>

<!-- ======= popup forms ======= -->
<?php include 'popupforms_project_initiation.php' ?>

<!-- JavaScript -->
<script src="assets/js/project_initiation.js"></script>
<script src="trip/js/new_trip_request.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
<script>

    $('.close').click(function () {
        $('#completeTripModal').modal('hide');
    });
    $('.close').click(function () {
        $('#errorMessageModal').modal('hide');
    });
    $('.close').click(function () {
        $('#completeSuccessModal').modal('hide');
    });
    $('.close').click(function () {
        $('#successModal').modal('hide');
    });
    $('.close').click(function () {
        $('#successModal1').modal('hide');
    });
    $('.close').click(function () {
        $('#cancelTripModal').modal('hide');
    });
    $('.close').click(function () {
        $('#tripDetailsModal').modal('hide');
    });

    document.querySelectorAll('.details-btn').forEach(button => {
        button.addEventListener('click', function () {
            const projectName = this.getAttribute('data-project');
            document.getElementById('selectedProject').textContent = projectName;
            const projectModal = new bootstrap.Modal(document.getElementById('projectModal'));
            projectModal.show();

            document.getElementById('confirmSelection').addEventListener('click', function () {
                projectModal.hide();
            });
        });
    });
</script>
<script>
    // Show the popup
    document.getElementById("NewTripopenPopup").addEventListener("click", function () {
        document.getElementById("NewTrippopupForm").style.display = "flex";
    });

    // Close the popup
    document.getElementById("NewTripclosePopup").addEventListener("click", function () {
        document.getElementById("NewTrippopupForm").style.display = "none";
    });

    // data insert
    const submitForm_01 = (event) => {
    event.preventDefault(); 

    $.ajax({
        url: './trip/ajaxphp/new_trip_request_insert.php',
        type: 'POST',
        data: $('#newTripForm').serialize(), 
        success: function (response) {
            $('#NewTrippopupForm').hide();  
            $('#successModal1').modal('show');
            
            // Set timeout to hide the modal and refresh the page
            setTimeout(function() {
                $('#successModal1').modal('hide'); // Hide modal after 1.5 seconds
                location.reload(); // Refresh the page
            }, 1500); // 1500ms = 1.5 seconds
        },
        error: function (xhr, status, error) {
            alert('An error occurred: ' + error);
        }
    });
};





    $('#select_project_id').on('change', function () {
        var project_id = $(this).val();
        // alert('Selected Project ID: ' + project_id);

        $.ajax({
            url: './trip/ajaxphp/fetch_trip_data.php',
            method: 'POST',
            data: {
                project_id: project_id // send the project_id in the format PRO-00004
            },
            success: function (response) {
                $('#trip_data').html(response);
            }
        });
    });

    //dataShowButton
    $(document).ready(function () {
        $(document).on('click', '.dataShowButton', function () {
            var trip_id = $(this).data('trip-id');
            // alert('Selected Trip ID: ' + trip_id);
            fetchTripDetails(trip_id);
        });

        function fetchTripDetails(trip_id) {
            $.ajax({
                url: './trip/ajaxphp/fetch_trip_details.php',
                type: 'POST',
                data: {
                    trip_id: trip_id
                },
                success: function (response) {
                    $('#modalBody').html(response);
                    $('#tripDetailsModal').modal('show');
                },
                error: function (xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        }
    });

    // cancelTripButton
    let selectedTripId = null;
    $(document).on('click', '.cancelTripButton', function () {
        selectedTripId = $(this).data('trip-id');
        // alert('Selected Trip ID: ' + selectedTripId);
        $('#cancelTripModal').modal('show');
    });

    $(document).on('click', '#confirmCancelTrip', function () {
        if (selectedTripId) {
            $.ajax({
                url: './trip/ajaxphp/Cancel_trip.php',
                type: 'POST',
                data: {
                    trip_id: selectedTripId
                },
                success: function (response) {
                    $('#cancelTripModal').modal('hide');

                    if (response.includes('successfully')) {
                        $('#successModal').modal('show');
                        setTimeout(function() {
                $('#successModal').modal('hide'); // Hide modal after 1.5 seconds
                location.reload(); // Refresh the page
            }, 1500);
                    } else {
                        $('#errorMessageBody').text(response);
                        $('#errorMessageModal').modal('show');
                    }
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    $('#cancelTripModal').modal('hide');
                    alert('An error occurred while canceling the trip.');
                }
            });

        }
    });
    $(document).on('click', '#closeSuccessModal', function () {
        $('#successModal').modal('hide');
        location.reload();
    });


    // Complete Trip Button Handler
    $(document).on('click', '.completeTripButton', function () {
        selectedTripId = $(this).data('trip-id');
        $('#completeTripModal').modal('show');
    });

    // Confirm Completion of Trip
    $(document).on('click', '#confirmCompleteTrip', function () {
        if (selectedTripId) {
            $.ajax({
                url: './trip/ajaxphp/completeTrip.php',
                type: 'POST',
                data: {
                    trip_id: selectedTripId
                },
                success: function (response) {
                    $('#completeTripModal').modal('hide');

                    if (response.includes('successfully')) {
                        $('#completeSuccessModal').modal('show');
                        setTimeout(function() {
                $('#completeSuccessModal').modal('hide'); 
                location.reload(); 
            }, 1500);

                    } else {
                        $('#errorMessageBody').text(response);
                        $('#errorMessageModal').modal('show');
                    }
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    $('#completeTripModal').modal('hide');
                    $('#errorMessageBody').text(
                        'An error occurred while completing the trip.');
                    $('#errorMessageModal').modal('show');
                }
            });
        }
    });

    $(document).on('click', '#closeCompleteSuccessModal', function () {
        $('#completeSuccessModal').modal('hide');
        location.reload();
    });



    // editTripButton

    $(document).on('click', '.editTripButton', function () {
        var tripId = $(this).data('trip-id');

        $.ajax({
            url: './trip/ajaxphp/getTripDetails.php',
            type: 'POST',
            data: {
                trip_id: tripId
            },
            success: function (response) {
                var tripData = JSON.parse(response);

                // Populate input fields with the retrieved data
                $('#trip_id').val(tripData.trip_id);
                $('#purpose_input').val(tripData.purpose);
                $('#no_of_team_members_input').val(tripData.no_of_team_members);

                // Clear existing team member input fields
                $('#teamMembersContainer1').empty();
                var teamMembers = tripData.team ? tripData.team.split(',') : [];

                // Create input fields for each team member
                for (var i = 0; i < teamMembers.length; i++) {
                    var memberDetails = teamMembers[i].trim();
                    var nameMobile = memberDetails.split('(');
                    var memberName = nameMobile[0];
                    var memberMobile = nameMobile[1] ? nameMobile[1].replace(')', '') : '';

                    $('#teamMembersContainer1').append(`
                    <div class="team-member-input">
                        <label for="team_member_name_${i}">Name ${i + 1}:</label>
                        <input type="text" id="team_member_name_${i}" name="team_member_name[]" value="${memberName}" placeholder="Name" class="form-control" style="width: 200px;" required>
                        <label for="team_member_mobile_${i}">Mobile ${i + 1}:</label>
                        <input type="number" id="team_member_mobile_${i}" name="team_member_mobile[]" value="${memberMobile}" placeholder="Mobile number" class="form-control" style="width: 190px;" required>
                    </div>
                `);
                }

                // Clear existing day data inputs
                $('#daysDataContainer').empty();
                var daysData = tripData.days_data;

                // Create input fields for each day
                for (var dayIndex = 0; dayIndex < daysData.length; dayIndex++) {
                    var dayDataParts = daysData[dayIndex].split('#'); // Split the data into individual components

                    // Ensure dayDataParts has the correct number of items before accessing
                    if (dayDataParts.length >= 6) {
                        var date = dayDataParts[0];
                        var startTime = dayDataParts[1];
                        var endTime = dayDataParts[2];
                        var location = dayDataParts[3];
                        var city = dayDataParts[4];
                        var noOfVehicles = dayDataParts[5];

                        $('#daysDataContainer').append(`
        <div class="day-data">
            <h6>Day ${dayIndex + 1} Data:</h6>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="date_${dayIndex}">Date:</label>
                    <input type="date" id="date_${dayIndex}" name="date[]" value="${date}" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="start_time_${dayIndex}">Start Time:
    </label>
                    <input type="time" id="start_time_${dayIndex}" name="start_time[]" value="${startTime}" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="end_time_${dayIndex}">End Time:
    </label>
                    <input type="time" id="end_time_${dayIndex}" name="end_time[]" value="${endTime}" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="location_${dayIndex}">Location:</label>
                    <input type="text" id="location_${dayIndex}" name="location[]" value="${location}" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="city_${dayIndex}">City:</label>
                    <input type="text" id="city_${dayIndex}" name="city[]" value="${city}" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="no_of_vehicles_${dayIndex}">No. of Vehicles:</label>
                    <input type="number" id="no_of_vehicles_${dayIndex}" name="no_of_vehicles[]" value="${noOfVehicles}" class="form-control" required>
                </div>
            </div>
        </div>
    `);
                        // <span class="form-control-plaintext mt-2">${startTime}</span>
                        // <span class="form-control-plaintext mt-2">${endTime}</span>

                    }
                }

                // Show the modal
                $('#editTripModal').css('display', 'block');
            },
            error: function (xhr, status, error) {
                alert('An error occurred while fetching trip details.');
            }
        });

    });

    // Close the modal when clicking the close button
    $('.close').on('click', function () {
        $('#editTripModal').css('display', 'none');
    });

    // Close the modal when clicking outside of it
    $(window).on('click', function (event) {
        if ($(event.target).is('#editTripModal')) {
            $('#editTripModal').css('display', 'none');
        }
    });


    // hideshow
    document.addEventListener("DOMContentLoaded", function () {
        var billingMilestoneDiv = document.getElementById("billing_milestone");
        billingMilestoneDiv.style.visibility = "visible";
    });

    function toggleBillingMilestone() {
        var selectElement = document.getElementById("select_project_id");
        var billingMilestoneDiv = document.getElementById("billing_milestone");

        if (selectElement.value === "") {
            billingMilestoneDiv.style.visibility = "visible";
        } else {
            billingMilestoneDiv.style.visibility = "hidden";
        }
    }


    $(document).on('change', '#no_of_team_members_input', function () {
        var newNumberOfMembers = parseInt($(this).val());

        var currentNumberOfMembers = $('#teamMembersContainer1 .team-member-input').length;

        if (newNumberOfMembers > 0) {
            if (newNumberOfMembers < currentNumberOfMembers) {
                $('#teamMembersContainer1').empty();
            }

            for (var i = 0; i < newNumberOfMembers; i++) {
                if (i >= currentNumberOfMembers) {
                    $('#teamMembersContainer1').append(`
                        <div class="team-member-input">
                            <label for="team_member_name_${i}">Name ${i + 1}:</label>
                            <input type="text" id="team_member_name_${i}" name="team_member_name[]" placeholder="Name" class="form-control" style="width: 200px;" required>
                            <label for="team_member_mobile_${i}">Mobile ${i + 1}:</label>
                            <input type="number" id="team_member_mobile_${i}" name="team_member_mobile[]" placeholder="Mobile number" class="form-control" style="width: 190px;" required>
                        </div>
                    `);
                }
            }
        }
    });

    $('#editTripForm').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            url: './trip/ajaxphp/updateTripDetails.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                var jsonResponse = JSON.parse(response);

                if (jsonResponse.status === 'success') {
                    showToast('Trip details updated successfully!', 'success');
                    $('#editTripModal').css('display', 'none');
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else {
                    showToast('Failed to update trip details. Please try again.', 'error');
                }
            },
            error: function (xhr, status, error) {
                showToast('An error occurred while updating trip details.', 'error');
            }
        });
    });

    function showToast(message, type) {
        var toast = $('#toastNotification');
        $('#toastMessage').text(message);

        toast.removeClass('success error').addClass(type);
        toast.addClass('show');

        setTimeout(function () {
            toast.removeClass('show').addClass('fadeout');
            setTimeout(function () {
                toast.css('display', 'none').removeClass('fadeout');
            }, 500);
        }, 3000);

        toast.css('display', 'block');
    }
</script>