<?php
session_start();
include './config/config.php';
include './class/class_project_details.php';
include './class/class_department.php';
// project details
$project = new project($conn);
$projects = $project->get_project_data();

$department_obj = new department($conn);
$department = $department_obj->get_department();

include 'header.php';
// Sidebar
include 'sidebar.php';
?>
<!-- End Sidebar-->
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
        background-color: rgba(0, 0, 0, 0.5);
        /* Background overlay */
        overflow: hidden;
        overflow-y: scroll;
        /* Scroll only on Y-axis */
    }

    .modal-content1 {
        background-color: white;
        margin: 5% auto;
        /* Adjust margin to center vertically */
        padding: 20px;
        border: 1px solid #888;
        border-radius: 17px;
        width: 45%;
        position: relative;
    }

    /* Hide scrollbars across browsers */
    .modal-content1::-webkit-scrollbar {
        display: none;
        /* Hide scrollbar for WebKit browsers (Chrome, Safari) */
    }

    .modal-content1 {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
<style>
    body {
        display: flex;
        flex-direction: column;
        height: 100vh;
        margin: 0;
    }

    .main {
        flex: 1;
    }

    form {
        padding-bottom: 20px;
    }

    footer {
        background-color: #f8f9fa;
        padding: 10px;
        text-align: center;
    }

    .pagination a {
        color: blue;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid #ddd;
        margin: 0 4px;
        border-radius: 4px;
    }

    .pagination a.active {
        background-color: #f6f9ff;
        color: black;
        border: 1px solid #4CAF50;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }

    .modal3 {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content3 {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
    }

    .close-button {
        cursor: pointer;
        color: red;
        float: right;
    }
</style>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Client Interaction</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Projects</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <div class="text-center" style="width:50%; margin:auto;">
                        <label for="" style="font-weight: 900;color: #012970;">Select Project</label>
                        <select id="select_project_id"
                            style="width:100%;padding:10px;border-radius:5px;border:1px solid #ccc;font-size:16px;"
                            onchange="fetchProjectData(); fetchProjectData1(); toggleBillingMilestone();">
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
                </div>
            </div>
            <!-- End Left side columns -->
            <div class="disabled-table" id="new_milestone_01" style="width:80%; margin:10px auto; display: block;">
                <button class="btn_custom" id="newTopic" style="float: right;">New Topic</button>
            </div>
            <!-- Horizontal Input Boxes -->
            <center>
                <div class="row" style="margin-top:20px; justify-content:center;">
                    <div class="col-md-5" style="width: 31.667%">
                        <label for="ActiveTopics" style="font-weight: 900;color: #012970; ">Active Topics</label>
                        <input type="text" id="Active_Topics" value="0" name="Active_Topics"
                            style="width:15%;padding:10px;border-radius:5px;border:1px solid #ccc;font-size:16px;"
                            readonly />
                    </div>

                    <div class="col-md-5" style="width: 31.667%">
                        <label for="ClosedTopics" style="font-weight: 900;color: #012970;">Closed Topics</label>
                        <input type="text" id="Closed_Topics" value="0" name="Closed_Topics"
                            style="width:15%;padding:10px;border-radius:5px;border:1px solid #ccc;font-size:16px;"
                            readonly />
                    </div>
                </div>
        </div>
        </center>
        <div class="billing-milestone" id="billing_milestone" style="width:80%; margin:20px auto; min-height:50vh;">
            <div>
                <label style='font-weight: 900;color: #012970; '>Search By:</label>
                <input type='text'
                    style='width:15%;padding:10px;border-radius:5px;border:1px solid #ccc;font-size:16px; '>
            </div> <br>
            <table class="table disabled-table">
                <thead>
                    <tr>
                        <th class="text-center">Select</th>
                        <th class="text-center">Topic No</th>
                        <th class="text-center">Subject</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Critical Level</th>
                        <th class="text-center">Init Form</th>
                        <!-- <th class="text-center">Alerts</th> -->
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <tr>
                            <td class="text-center">
                                <input type="radio" name="projectSelect" value="T<?php echo $i; ?>"
                                    id="projectT<?php echo $i; ?>">
                            </td>
                            <td class="text-center">T<?php echo $i; ?></td>
                            <td class="text-center"><?php echo ($i % 2) == 0 ? "Configured" : "Active"; ?></td>
                            <td class="text-center"><?php echo date('Y-m-d', strtotime("+{$i} days")); ?></td>
                            <td class="text-center"><?php echo ($i % 2) == 0 ? "Not Live" : "Live"; ?></td>
                            <td class="text-center"><?php echo rand(01, 05); ?></td>
                            <td class="text-center"><?php echo ($i % 2) == 0 ? "client " : "client "; ?></td>
                            <!-- <td class="text-center"><?php echo sprintf("%02d", rand(1, 5)); ?></td> -->
                            <td class="text-center">
                                <a class="response-btn">Response</a>
                                <a class="response-btn" style="color:red; ">Close</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>



        <div id="project_data">
            <!-- This div will be used to display the returned data from AJAX -->
        </div>


        <div id="response_data">
            <!-- This div will display the response data -->
        </div>
        <!-- Selected Project -->
        <div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="projectModalLabel">Selected Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Please select the <strong id="selectedProject"></strong> project.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="confirmSelection">OK</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Closure</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to Close this Topic?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger" id="confirmYes">Yes, Close Topic</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Bootstrap Modal for Success Message -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalMessage">
                        <!-- Response message will be displayed here -->
                        New record created successfully!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        New record created successfully!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- failModal -->
        <div id="failModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="failModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="failModalLabel">Error</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="failMessage">An error occurred while submitting your response. Please try again.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal for No Data Found -->
        <div class="modal fade" id="noDataModal" tabindex="-1" role="dialog" aria-labelledby="noDataModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="noDataModalLabel">No Data</h5>
                        <span aria-hidden="true">&times;</span>

                    </div>
                    <div class="modal-body" id="noDataModalBody">
                        No data found
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
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

<!-- javascript -->
<script src="assets/js/project_initiation.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    function showNoDataModal() {
        $('#noDataModal').modal('show'); // Show the modal
    }
    function showModal(data) {
        // Fill the modal body with detailed description
        $('#modal-body').html("<p><strong>Details:</strong></p><p>" + data.detailed_desc.replace(/\n/g, '</p><p>') + "</p>"
        )
        // Show the modal
        $('#detailsModal').modal('show');
    }
    function Sort_ByTable() {
        let input = document.getElementById("Sort_By");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("data-table");
        let tr = table.getElementsByTagName("tr");
        let sortedRows = [];

        for (let i = 1; i < tr.length; i++) {
            sortedRows.push(tr[i]);
        }

        sortedRows.sort((a, b) => {
            let aText = a.getElementsByTagName("td")[1].innerText.toLowerCase(); // Assuming you want to sort by Topic No (column index 1)
            let bText = b.getElementsByTagName("td")[1].innerText.toLowerCase(); // Change index as needed

            if (filter) {
                if (aText.includes(filter) || bText.includes(filter)) {
                    return aText.localeCompare(bText);
                }
            } else {
                return aText.localeCompare(bText);
            }
        });

        // Clear the table and append sorted rows
        for (let i = 1; i < tr.length; i++) {
            table.deleteRow(1); // Remove the first row each time
        }

        sortedRows.forEach(row => {
            table.appendChild(row);
        });
    }
    // Function to filter the table rows based on search input
    function filterTable() {
        let input = document.getElementById("search_by");
        let filter = input.value.toLowerCase();
        let table = document.getElementById("data-table");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let tdArray = tr[i].getElementsByTagName("td");
            let found = false;

            for (let j = 0; j < tdArray.length; j++) {
                if (tdArray[j].innerText.toLowerCase().includes(filter)) {
                    found = true;
                    break;
                }
            }

            if (found) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
    // This div will display the response data
    function sendResponse(topic_id) {
        $.ajax({
            url: './client_interaction/php/client_interaction_Response.php',
            type: 'POST',
            data: {
                topic_id: topic_id
            },
            success: function (response) {
                // Show the response data on the page, for example, in a div
                $('#response_data').html(response);
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    }
    $(document).ready(function () {
        $('.response-btn').on('click', function () {
            var project = $(this).data('project');
            $('#selectedProject').text(project);
            $('#projectModal').modal('show');
        });

        $('#confirmSelection').on('click', function () {
            console.log('Confirmed selection of project:', $('#selectedProject').text());
            $('#projectModal').modal('hide');
        });

    });
    // This div will be used to display the returned data from AJAX
    function fetchProjectData() {
        var projectId = document.getElementById("select_project_id").value;

        if (projectId !== "") {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./client_interaction/php/client_interaction_data.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("project_data").innerHTML = xhr.responseText;
                } else {
                    console.error("Error fetching data");
                }
            };

            xhr.send("project_id=" + projectId);
        } else {
            document.getElementById("project_data").innerHTML = "";
        }
    }

    function loadData(page) {
        var projectId = document.getElementById("select_project_id").value;

        if (projectId !== "") {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./client_interaction/php/client_interaction_data.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("project_data").innerHTML = xhr.responseText;
                } else {
                    console.error("Error fetching data");
                }
            };

            xhr.send("project_id=" + projectId + "&page=" + page); // Send current page to server
        } else {
            document.getElementById("project_data").innerHTML = "";
        }
    }


    function fetchProjectData1() {
        var projectId = $('#select_project_id').val(); // Get the selected project_id

        if (projectId) {
            // AJAX request to fetch counts for the selected project
            $.ajax({
                url: './client_interaction/php/fetch_counts_ac_cl.php',
                method: 'GET',
                data: { project_id: projectId }, // Pass the project_id to the backend
                dataType: 'json',
                success: function (data) {
                    $('#Active_Topics').val(data.activeTopics);
                    $('#Closed_Topics').val(data.closedTopics);
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching counts:', error);
                }
            });
        } else {
            // Reset the values if no project is selected
            $('#Active_Topics').val('');
            $('#Closed_Topics').val('');
        }
    }

    function toggleBillingMilestone() {
        var selectElement = document.getElementById("select_project_id");
        var billingMilestoneDiv = document.getElementById("billing_milestone");

        if (selectElement.value === "") {
            billingMilestoneDiv.style.visibility = "visible";
        } else {
            billingMilestoneDiv.style.visibility = "hidden";
        }
    }

    // Show the popup
    document.getElementById("newTopic").addEventListener("click", function () {
        document.getElementById("NewTopic").style.display = "flex";
    });

    // Close the popup
    document.getElementById("NewTopicclosePopup").addEventListener("click", function () {
        document.getElementById("NewTopic").style.display = "none";
    });

    function showResponseModal(topic_id) {
        document.getElementById("topic_id_display").value = topic_id;
        document.getElementById("responseModal").style.display = "block";
    }

    // Function to close the response modal
    function closeResponseModal() {
        document.getElementById("responseModal").style.display = "none";
    }

    // Response submit
    // Response submit
    function submitResponse() {
        const formData = new FormData();

        // Collecting form values
        const topic_id = document.getElementById('topic_id_display').value;
        const short_desc = document.getElementById('short_desc').value;
        const detailed_desc = document.getElementById('detailed_desc').value;
        const discussion_date = document.getElementById('date').value;
        const poke_from = document.querySelector('input[name="poke_from"]:checked').value;
        const poke_to = document.querySelector('input[name="poke_to"]:checked') ? document.querySelector('input[name="poke_to"]:checked').value : "";
        const communication_medium = document.getElementById('communication_medium').value;
        const date_of_letter = document.getElementById('date_of_letter').value;
        const lavel = document.getElementById('lavel').value;

        // Append form fields to FormData
        formData.append('topic_id', topic_id);
        formData.append('short_desc', short_desc);
        formData.append('detailed_desc', detailed_desc);
        formData.append('discussion_date', discussion_date);
        formData.append('poke_from', poke_from);
        formData.append('poke_to', poke_to);
        formData.append('communication_medium', communication_medium);
        formData.append('date_of_letter', date_of_letter);
        formData.append('lavel', lavel);

        // Collect and append PDF files
        const pdfInput = document.getElementById('pdf-files');
        if (pdfInput.files.length > 0) {
            for (let i = 0; i < pdfInput.files.length; i++) {
                formData.append('files[]', pdfInput.files[i]);
            }
        }

        // AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open('POST', './client_interaction/php/insert_data_responce.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log('Response:', xhr.responseText);
                if (xhr.responseText.trim() === "New record created successfully") {
                    // Hide responseModal
                    closeResponseModal();

                    // Show successModal
                    $('#successModal').modal('show');
                    resetForm();

                } else {
                    console.error('Error:', xhr.responseText);
                    document.getElementById('failMessage').innerText = xhr.responseText.trim();
                    $('#failModal').modal('show');
                }
            } else {
                console.error('Error:', xhr.responseText);
                document.getElementById('failMessage').innerText = xhr.responseText.trim();
                $('#failModal').modal('show');
            }
        };

        xhr.send(formData); // Send FormData
    }

    function resetForm() {
        // Clear all input fields and reset values
        document.getElementById('topic_id_display').value = '';
        document.getElementById('short_desc').value = '';
        document.getElementById('detailed_desc').value = '';
        document.getElementById('date').value = '';
        document.getElementById('date_of_letter').value = '';
        document.getElementById('communication_medium').selectedIndex = 0;
        document.getElementById('lavel').selectedIndex = 0;

        // Reset radio buttons
        const radioFrom = document.getElementsByName('poke_from');
        for (const radio of radioFrom) {
            radio.checked = false;
        }

        const radioTo = document.getElementsByName('poke_to');
        for (const radio of radioTo) {
            radio.checked = false;
        }

        // Reset file input
        const pdfInput = document.getElementById('pdf-files');
        pdfInput.value = ''; // Clear selected files
        document.getElementById('selected-files-list').innerHTML = ''; // Clear displayed selected files
        document.getElementById('file-count').innerHTML = '<b>Total Selected Files: 0</b>'; // Reset file count
    }

    function closeResponseModal() {
        document.getElementById('responseModal').style.display = 'none';
    }



    function showFiles(files) {
        // Get the modal body element
        const modalBody = document.getElementById('modal-body');

        // Clear the modal body
        modalBody.innerHTML = '';

        // Check if files array is empty
        if (files.length === 0) {
            modalBody.innerHTML = '<p>No files available.</p>';
        } else {
            // Create a list of files
            const fileList = files.join('<br/>'); // Joining files with line breaks
            modalBody.innerHTML = `<p>Files:</p><p>${fileList}</p>`;
        }

        // Show the modal
        $('#detailsModal').modal('show');
    }

    function showFilesModal(files) {
        let filesList = '<ul>';
        files.forEach(file => {
            // Create clickable links for each file
            filesList += `<li><a href='./client_interaction/upload/${file.trim()}' target='_blank'>${file.trim()}</a></li>`;
        });
        filesList += '</ul>';

        document.getElementById('files-modal-body').innerHTML = filesList;
        $('#filesModal').modal('show'); // Show the modal
    }


    // Function to close the modal
    function closeResponseModal() {
        document.getElementById('responseModal').style.display = 'none';
    }

    // closeTopic
    function closeTopic(topic_id) {
        $.ajax({
            url: './client_interaction/php/topic_close.php',
            type: 'POST',
            data: { topic_id: topic_id },
            success: function (response) {
                $('#confirmationModal').modal('hide');
                $('#successModal').modal('show');

                setTimeout(function () {
                    $('#successModal').modal('hide');
                    location.reload(); // Refresh the page
                }, 2000);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
                alert("Error closing the topic. Please try again.");
            }
        });
    }

    // Attach the event handler to the Close button
    $(document).on('click', '.btn_custom.close-btn', function () {
        const topic_no = $(this).data('topic');
        $('#confirmationModal').data('topic-id', topic_no).modal('show');
    });

    // Handle confirmation button
    $('#confirmYes').on('click', function () {
        const topic_no = $('#confirmationModal').data('topic-id');
        closeTopic(topic_no);
    });

    // Handle the success modal's OK button
    $('#successOk').on('click', function () {
        $('#successModal').modal('hide');
        location.reload();
    });


    $(document).ready(function () {
        $('#confirmNewTopic').click(function () {
            var project_id = $('#project_id').val();
            var subject = $('#subject').val();
            var poke_from = $('input[name="poke_from"]:checked').val();
            var criticality_level = $('#criticality_level').val();

            // Send data via AJAX
            $.ajax({
                url: './client_interaction/php/insertTopic.php',
                type: 'POST',
                data: {
                    project_id: project_id,
                    subject: subject,
                    poke_from: poke_from,
                    criticality_level: criticality_level
                },
                success: function (response) {
                    // Update the modal message with the response
                    $('#modalMessage').text(response);

                    // Show the success modal
                    $('#successModal').modal('show');

                    // Hide the NewTopic modal
                    $('#NewTopic').hide();

                    // After 2 seconds, hide the modal and refresh the page
                    setTimeout(function () {
                        $('#successModal').modal('hide');
                        location.reload(); // Refresh the page
                    }, 2000); // 2000 milliseconds = 2 seconds
                },
                error: function (xhr, status, error) {
                    alert('Error: ' + error);
                    document.getElementById('failMessage').innerText = xhr.responseText.trim();
                    $('#failModal').modal('show');
                }
            });
        });
    });

    function updateToSelection(selectedFrom) {
        // Show the "To" section
        document.getElementById('toSection').style.display = 'block';

        if (selectedFrom === 'monarch') {
            // If "From" is Monarch, uncheck Monarch and check Client by default
            document.getElementById('to_monarch').checked = false; // Uncheck Monarch
            document.getElementById('to_client').checked = true; // Check Client
        } else if (selectedFrom === 'client') {
            // If "From" is Client, uncheck Client and check Monarch by default
            document.getElementById('to_client').checked = false; // Uncheck Client
            document.getElementById('to_monarch').checked = true; // Check Monarch
        }

        // Enable the "To" radio buttons
        document.getElementById('to_monarch').disabled = false;
        document.getElementById('to_client').disabled = false;
    }

    let selectedFilesArray = [];

    // Handle file selection and display
    document.getElementById('pdf-files').addEventListener('change', function () {
        const fileList = Array.from(this.files); // Convert the FileList object to an array
        selectedFilesArray = selectedFilesArray.concat(fileList); // Add new files to the array

        displaySelectedFiles(); // Update the display of selected files
        updateFileCount(); // Update file count
    });

    // Function to display selected files with remove option
    function displaySelectedFiles() {
        const selectedFilesList = document.getElementById('selected-files-list');
        selectedFilesList.innerHTML = ''; // Clear the list first

        selectedFilesArray.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'pdf-file-item mb-2 d-flex align-items-center';
            fileItem.innerHTML = `
            <span>${file.name}</span>
            <button type="button" class="btn btn-danger btn-sm ms-2" style=" background-color: white;color: black;" onclick="removeFile(${index})">x</button>
        `;
            selectedFilesList.appendChild(fileItem);
        });
    }

    // Function to remove a specific file
    function removeFile(index) {
        selectedFilesArray.splice(index, 1); // Remove the file from the array
        displaySelectedFiles(); // Refresh the displayed file list
        updateFileCount(); // Update file count
    }

    // Function to update the file count display
    function updateFileCount() {
        const fileCountDisplay = document.getElementById('file-count');
        fileCountDisplay.innerHTML = `<b>Total Selected Files: ${selectedFilesArray.length}</b>`;
    }


</script>