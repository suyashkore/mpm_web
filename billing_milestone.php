<?php
session_start();
include './config/config.php';
include './class/class_project_details.php';
include './class/class_department.php';
// project details 
$project = new project($conn); 

if($_SESSION['hod'] != '') {
    $projects = $project->get_project_data_by_dept($_SESSION['hod']);
} else {
    $projects = $project->get_project_data();
}

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
</style>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Billing Milestone</h1>
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
                    <div class="text-center" style="width:50%;margin:auto;">
                        <label for="" style="font-weight: 900;color: #012970;">Select Project</label>
                        <select id="select_project_id"
                            style="width:100%;padding:10px;border-radius:5px;border:1px solid #ccc;font-size:16px;"
                            onchange="projectDetails();">
                            <option value="">Select Project</option>

                            <?php 
                            foreach($projects['projects'] as $project) {
                                ?>
                            <option value="<?php echo $project['project_id'] ?>"><?php echo $project['project_name']; ?>
                            </option>
                            <?php
                            }
                            ?>

                        </select>
                    </div>
                </div>
            </div><!-- End Left side columns -->

            <div class="text-center" id="project_details" style="width:80%;margin:10px auto;display:none;">
                <b>Project Name :</b> <span id="pro_name"></span> <br> <b>Project Status :</b> <span
                    id="pro_status"></span>
            </div>

            <div class="disabled-table" id="new_milestone_01" style="width:80%;margin:10px auto;display: block;">
                <button class="btn_custom" style="float: right;">New</button>
            </div>
            <div class="billing-milestone" id="billing_milestone" style="width:80%;margin:20px auto;min-height:50vh;">
                <table class="table disabled-table">
                    <thead>
                        <tr>
                            <th class="text-center">Select</th>
                            <th class="text-center">Billing Milestone</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for($i = 1; $i < 5; $i++) {
                        ?>
                        <tr>
                            <td class="text-center">
                                <input type="radio">
                            </td>
                            <td class="text-center">BM<?php echo $i; ?></td>
                            <td class="text-center"><?php echo ($i % 2) == 0 ? "Configured" : "Active"; ?></td>
                            <td class="text-center">
                                <button class="btn_custom">working Pipeline</button>
                                <button class="btn_custom" style="background-color:#cfc383;">Initiate Bill</button>
                                <button class="btn_custom" style="background-color:green;">Payment Sequence</button>
                                <button class="btn_custom" style="background-color:gold;">Actions</button>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>

            <!-- realtime data  -->
            <div id="new_milestone" style="width:80%;margin:10px auto;display:none;">
                <button class="btn_custom" style="float: right;" onClick="addNewBillingMilestone();">New</button>
            </div>
            <div class="billing-milestone_01" id="billing_milestone_real_time"
                style="width:80%;margin:20px auto;display:none;">

                <table id="bmTable" class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Select</th>
                            <th class="text-center">Billing Milestone</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox">
                            </td>
                            <td class="text-center">BM<?php echo $i; ?></td>
                            <td></td>
                            <td class="text-center">
                                <button class="btn_custom">Working pipeline</button>
                                <button class="btn_custom">Payment Sequence</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- realtime data for working pipeline -->
            <div id="new_working_pipeline" style="width:80%;margin:0px auto;display:none;">
                <button class="btn_custom" style="float: right;" onClick="addNewWorkingPipeline();">New</button>
            </div>
            <div class="billing-milestone_01" id="working_pipeline" style="width:80%;margin:20px auto;display:none;">

                <table id="wpTable" class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Select</th>
                            <th class="text-center">Working Pipeline</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox">
                            </td>
                            <td class="text-center">BM<?php echo $i; ?></td>
                            <td class="text-center">Active</td>
                            <td class="text-center">
                                <button class="btn_custom">Action</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- realtime data for work pointer -->
            <div id="new_work_pointer" style="width:80%;margin:0px auto;display:none;">
                <button class="btn_custom" style="float: right;" onClick="addNewWorkPointer();">New</button>
            </div>
            <div class="billing-milestone_01" id="work_pointer" style="width:80%;margin:20px auto;display:none;">

                <table id="wPoTable" class="table datatable">
                    <thead>
                        <tr>
                            <th class="text-center">Select All<br> <input type="checkbox" id="selectAll"> </th>
                            <th class="text-center">Work Pointer(Desc)</th>
                            <!-- <th class="text-center">Status</th> -->
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox">
                            </td>
                            <td class="text-center">BM<?php echo $i; ?></td>
                            <td class="text-center">Active</td>
                            <td class="text-center">
                                <button class="btn_custom">Action</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- realtime data  -->
            <div id="new_milestone" style="width:80%;margin:10px auto;display:none;">
                <button class="btn_custom" style="float: right;" onClick="addNewBillingMilestone();">New</button>
            </div>
            <div class="billing-milestone_01" id="billing_milestone_real_time"
                style="width:80%;margin:20px auto;display:none;">

                <table id="bmTable" class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Select</th>
                            <th class="text-center">Billing Milestone</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox">
                            </td>
                            <td class="text-center">BM<?php echo $i; ?></td>
                            <td></td>
                            <td class="text-center">
                                <button class="btn_custom">Working pipeline</button>
                                <button class="btn_custom">Payment Sequence</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="myModal" class="modal" style="display: none;">
    <div class="modal-content2" style="margin: 1% auto;">
        <h6 class="card-title text-center">Billing Milestone Details</h6>
        <div class="row g-3">
            <div class="text-center" id="tableContainer">
                <!-- Data will be injected here -->
            </div>
        </div>
        <button class="close-modal btn_custom" onclick="closeModal()">Close</button>
    </div>
</div>

        </div>

    </section>

</main><!-- End #main -->

<!-- pop up for table  -->
<!-- transform:translate(-50%, -50%); -->
<div id="popupMessage"
    style="display:none;position:fixed;top:50%;left:50%;background-color:white;padding:20px;border:1px solid #ccc;box-shadow:0px 0px 10px rgba(0,0,0,0.1);">
    <p>Please select the project.</p>
    <button onclick="closePopup()">OK</button>
</div>

<!-- ======= Footer ======= -->
<?php include 'footer.php' ?>
<!-- ======= popup forms ======= -->
<?php include 'popupforms_project_initiation.php' ?>

<!-- javascript -->
<script src="assets/js/project_initiation.js"></script>
<script src="assets/js/working_pipeline_status.js"></script>

<script>
document.getElementById('selectAll').addEventListener('change', function() {
    // alert("test");
    let checkboxes = document.querySelectorAll('#wPoTable .selectItem');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = this.checked;
    });
});



// JavaScript to handle table interaction and popup display
document.querySelectorAll('.disabled-table').forEach(function(table) {
    table.addEventListener('click', function(event) {
        event.preventDefault();
        showPopup();
    });
});

function showPopup() {
    document.getElementById('popupMessage').style.display = 'block';
}

function closePopup() {
    document.getElementById('popupMessage').style.display = 'none';
}

// billing milestone 

const projectDetails = () => {
    // const projectId = document.getElementById("select_project_id").value;
    let projectId = $('#select_project_id').val();
    let selectedText = $('#select_project_id option:selected').text();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './ajaxphp/get_data_billingmilestone.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        let response = JSON.parse(xhr.responseText);
        if (xhr.status == 200) {
            var bm = response.billing_milestone;
            $('#billing_milestone_real_time').css("display", "");
            $('#new_milestone_01').css("display", "none");
            $('#new_milestone').css("display", "");
            $('#billing_milestone').css("display", "none");
            $('#project_details').css("display", "");
            $('#billingmilestone_project_id').val(projectId);
            $('#wpo_project_id').val(projectId);
            $('#pro_name').text(selectedText);
            // alert($('#pro_name'));

            const tableBody = $('#bmTable tbody');
            tableBody.empty();
            bm.forEach((milestone) => {
                let row = `<tr>
                            <td class="text-center">
                                <input name="bm_radio" value="${milestone.BM_id}" type="radio" onclick="activateRowButtons(this, 'bmTable')">
                            </td>
                            <td class="text-center">${milestone.BM_name}</td>
                            <td class="text-center">${milestone.status}</td>
                            <td class="text-center">
                                <button  class="btn_custom_popup" onClick="workingPipeline();" disabled>Working Pipeline</button>
                                <button class="btn_custom_popup"  onclick="InitiateBill()" style="background-color:#cfc383;">Initiate Bill</button>   
                                <button class="btn_custom_popup" style="background-color:green;" disabled>Payment Sequence</button>
                                <button class="btn_custom" style="background-color:gold;"  onclick="showPopup_02(this)" disabled>Actions</button>
                            </td>
                        </tr>`;
                tableBody.append(row);

                // <button class="btn_custom_popup" style="background-color:#007bff;" onclick="showDepartment(this);"  disabled>Departments</button>
            });
        } else {
            console.error('Error fetching data: ' + xhr.status);
        }
    };
    var params = 'project_id=' + encodeURIComponent(projectId);

    xhr.send(params);
}

const addNewBillingMilestone = () => {
    // alert("test");
    var modal = document.getElementById("addBillingMilestone");
    modal.style.display = "block";
}

function cancel() {
    var modal = document.getElementById("addBillingMilestone");
    modal.style.display = "none";
}

const addBm = () => {
    var bmName = $('#new_billing_milestone').val();
    var bmProId = $('#billingmilestone_project_id').val();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './ajaxphp/add_new_billingmilestone.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        let response = JSON.parse(xhr.responseText);
        if (xhr.status == 200) {
            console.log(response);
            projectDetails();
            cancel();
            var modal = document.getElementById("success_add");
            modal.style.display = "block";
        } else {
            console.error('Error fetching data: ' + xhr.status);
        }
    };
    var params = 'project_id=' + encodeURIComponent(bmProId) + '&bmname=' + encodeURIComponent(bmName);
    xhr.send(params);
}

// actions button pop up 

function showPopup_01(button) {
    // Create or show the popup
    let popup = document.createElement('div');
    popup.id = 'bmAction';
    popup.classList.add('popup');
    popup.innerHTML = `
        <div class="popup-content">
            <button class="btn_custom_popup" onClick="acceptWork();">Accept</button>
            <button class="btn_custom_popup" style="background-color:red" onClick="rejectWork();">Reject</button>
            <button class="btn_custom_popup" style="background-color:green" onClick="UploadWorkHours();">Upload Working Hours</button>
            <button class="btn_custom_popup" style="background-color:gray" onClick="uploadFile();">Upload Files</button>
            <button class="btn_custom_popup" style="background-color:blue" onClick="complete();">Mark Complete</button>   
        </div>
    `;

    let rect = button.getBoundingClientRect();
    popup.style.position = 'absolute';
    popup.style.top = `${rect.bottom + window.scrollY}px`;
    popup.style.left = `${rect.left + window.scrollX}px`;

    document.body.appendChild(popup);

    document.addEventListener('click', function closePopup(e) {
        if (!popup.contains(e.target) && e.target !== button) {
            popup.remove();
            document.removeEventListener('click', closePopup);
        }
    });
}

function showPopup_02(button) {
    // Create or show the popup
    let popup = document.createElement('div');

    var selectedValue = $('#bmTable input[name="bm_radio"]:checked').val(); 
    let projectId = $('#select_project_id').val(); 
    popup.id = 'bmAction';
    popup.classList.add('popup');
    popup.innerHTML = `
        <div class="popup-content">
            <button class="btn_custom_popup" onClick="activeBm();">Configured</button>
            <button class="btn_custom_popup" style="background-color:green">Operational</button>
            <button class="btn_custom_popup" style="background-color:gray;">Mark Complete</button>
            <button class="btn_custom_popup" style="background-color:red">Closed</button>
            <button class="btn_custom_popup" style="background-color:#17a2b8" id="DetailsBtn">Details</button>
            
        </div>
    `;

    let rect = button.getBoundingClientRect();
    popup.style.position = 'absolute';
    popup.style.top = `${rect.bottom + window.scrollY}px`;
    popup.style.left = `${rect.left + window.scrollX}px`;

    document.body.appendChild(popup);


    document.getElementById('DetailsBtn').addEventListener('click', function() {
            console.log('Project ID:', projectId);
            console.log('BM ID:', selectedValue);

            fetch('./ajaxphp/details_bm.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `projectId=${encodeURIComponent(projectId)}&selectedValue=${encodeURIComponent(selectedValue)}`
            })
            .then(response => response.text())
            .then(data => {
                try {
                    const jsonData = JSON.parse(data); 
                    if (jsonData.error) {
                        console.error('Error:', jsonData.error);
                        document.getElementById('resultContainer').innerHTML = `<p style="color: red;">Error: ${jsonData.error}</p>`;
                    } else {
                        console.log('Data fetched:', jsonData);
                        displayFetchedData(jsonData);
                    }
                } catch (e) {
                    console.error('JSON parsing error:', e, 'Response data:', data);
                    document.getElementById('resultContainer').innerHTML = `<p style="color: red;">Error parsing data.</p>`;
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                document.getElementById('resultContainer').innerHTML = `<p style="color: red;">Fetch error: ${error.message}</p>`;
            });
        });

    document.addEventListener('click', function closePopup(e) {
        if (!popup.contains(e.target) && e.target !== button) {
            popup.remove();
            document.removeEventListener('click', closePopup);
        }
    });
}

function displayFetchedData(data) {
    const tableContainer = document.getElementById('tableContainer');
    const tableHTML = `
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>BM Name</th>
                <td>${data.BM_name !== null ? data.BM_name : 'Not available'}</td>
            </tr>
            <tr>
                <th>BM Sequence No</th>
                <td>${data.BM_sequence_no !== null ? data.BM_sequence_no : 'Not available'}</td>
            </tr>
            <tr>
                <th>Working Pipelines</th>
                <td>${data.working_pipelines !== null ? data.working_pipelines : 'Not available'}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>${data.status !== null ? data.status : 'Not available'}</td>
            </tr>
            <tr>
                <th>Billing Amount</th>
                <td>${data.billing_amount !== null ? data.billing_amount : 'Not available'}</td>
            </tr>
            <tr>
                <th>Texas Deductions</th>
                <td>${data.texas_deductions !== null ? data.texas_deductions : 'Not available'}</td>
            </tr>
            <tr>
                <th>Base Amount with Tax</th>
                <td>${data.base_amt_with_tax !== null ? data.base_amt_with_tax : 'Not available'}</td>
            </tr>
            <tr>
                <th>Actual Received Amount</th>
                <td>${data.actual_received_amt !== null ? data.actual_received_amt : 'Not available'}</td>
            </tr>
            <tr>
                <th>Amount Received On</th>
                <td>${data.amt_received_on !== null ? data.amt_received_on : 'Not available'}</td>
            </tr>
            <tr>
                <th>Working Pipeline Status</th>
                <td>${data.working_pipeline_status !== null ? data.working_pipeline_status : 'Not available'}</td>
            </tr>
            <tr>
                <th>Billing Sequence Status</th>
                <td>${data.billing_sequence_status !== null ? data.billing_sequence_status : 'Not available'}</td>
            </tr>
            <tr>
                <th>Bill Submitted Status</th>
                <td>${data.bill_submitted_status !== null ? data.bill_submitted_status : 'Not available'}</td>
            </tr>
            <tr>
                <th>Payment Status</th>
                <td>${data.payment_status !== null ? data.payment_status : 'Not available'}</td>
            </tr>
            <tr>    
                <th>Configured From</th>
                <td>${data.Configured_from !== null ? data.Configured_from : 'Not available'}</td>
            </tr>
        </tbody>
    </table>
`;
    // Inject the table into the modal's content
    tableContainer.innerHTML = tableHTML;
    // Open the modal
    openModal();
}
// Function to open the modal
function openModal() {
    const modal = document.getElementById('myModal');
    modal.style.display = 'block';
}
// Function to close the modal
function closeModal() {
    const modal = document.getElementById('myModal');
    modal.style.display = 'none';
}


function workPipeline(button, status) {
    let popup = document.createElement('div');
    popup.id = 'wpipeAction';
    popup.classList.add('popup');
    const configuredDisabled = status === 'operational' ? 'disabled' : '';
    const operationalDisabled = status === 'operational' ? 'disabled' : '';
    popup.innerHTML = `
        <div class="popup-content">
            <button class="btn_custom_popup" style="background-color:blue;" onclick="changeWorkpipelineStatus('configured');" ${configuredDisabled}>Configured</button>
            <button class="btn_custom_popup" style="background-color:green;" onclick="changeWorkpipelineStatus('operational');" ${configuredDisabled}>Operational</button>
            <button class="btn_custom_popup" style="background-color:gray;">Mark Complete</button>
            <button class="btn_custom_popup" style="background-color:red;">Closed</button>
            <button class="btn_custom_popup" style="background-color:#17a2b8">Details</button>

            
        </div>
    `;

    // Position the popup relative to the button
    let rect = button.getBoundingClientRect();
    popup.style.position = 'absolute';
    popup.style.top = `${rect.bottom + window.scrollY}px`;
    popup.style.left = `${rect.left + window.scrollX}px`;

    // Append the popup to the body or a specific container
    document.body.appendChild(popup);

    // Close the popup if clicked outside
    document.addEventListener('click', function closePopup(e) {
        if (!popup.contains(e.target) && e.target !== button) {
            popup.remove();
            document.removeEventListener('click', closePopup);
        }
    });
}

const activeBm = () => {
    var selectedValue = $('#bmTable input[name="bm_radio"]:checked').val();
    // alert(selectedValue);
}

// working pipeline 

const addNewWorkingPipeline = () => {
    var modal = document.getElementById("addWorkingPipeline");
    modal.style.display = "block";

}

function cancelWp() {
    var modal = document.getElementById("addWorkingPipeline");
    modal.style.display = "none";
}

const addWpipe = () => {
    var wpipeName = $('#new_working_pipeline_name').val();
    var orderDept = $('#dept_order').val();
    var wpipeName = $('#new_working_pipeline_name').val();
    var projectId = $('#working_pipeline_project_id').val();
    var bmId = $('#working_pipeline_bm_id').val();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './ajaxphp/add_new_workpipeline.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        let response = JSON.parse(xhr.responseText);
        if (xhr.status == 200) {
            workingPipeline();
            cancelWp();
            var modal = document.getElementById("success_add");
            modal.style.display = "block";
        } else {
            console.error('Error fetching data: ' + xhr.status);
        }
    };
    var params = 'bm_id=' + encodeURIComponent(bmId) + '&wpipe_name=' + encodeURIComponent(wpipeName) +
        '&project_id=' + encodeURIComponent(projectId) + '&dept_order=' + encodeURIComponent(orderDept);
    // console.log(params);
    xhr.send(params);
}

// select department order for working pipeline 

let selectionOrder = [];

function updateSelectionOrder(checkbox) {
    const value = checkbox.value;
    const index = selectionOrder.indexOf(value);

    if (checkbox.checked) {
        if (index === -1) {
            selectionOrder.push(value);
        }
    } else {
        if (index !== -1) {
            selectionOrder.splice(index, 1);
        }
    }
    document.getElementById("dept_order").value = selectionOrder.join(',');
}

const workingPipeline = () => {
    let projectId = $('#select_project_id').val();
    let billing_milestone_id = $('input[name="bm_radio"]:checked').val();
    let selectedText = $('#select_project_id option:selected').text();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './ajaxphp/get_data_workpointer.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        let response = JSON.parse(xhr.responseText);
        console.log(response);
        if (xhr.status == 200) {
            var wp = response.work_pointer;
            console.log(wp);
            $('#new_working_pipeline').css("display", "");
            $('#working_pipeline').css("display", "");
            $('#bmAction').css("display", "none");
            $('#working_pipeline_bm_id').val(billing_milestone_id);
            $('#working_pipeline_project_id').val(projectId);
            $('#wpo_bm_id').val(billing_milestone_id);

            const tableBody = $('#wpTable tbody');
            tableBody.empty();
            if (response.msg == "Not found") {
                let row = `<tr>
                    <td colspan="4" class="text-center">
                        No work pipeline found
                    </td>
                </tr>`;
                tableBody.append(row);
            } else {

                wp.forEach((workPointer) => {
                    let row = `<tr>
                            <td class="text-center">
                                <input name="wp_radio" value="${workPointer.pipe_id}" type="radio" onclick="activateRowButtons(this, 'wpTable')">
                            </td>
                            <td class="text-center">${formatText(workPointer.WP_name)}</td>
                            <td class="text-center">${workPointer.status}</td>
                            <td class="text-center">
                                <button class="btn_custom_popup" style="background-color:;" onClick="workPOinterDetails()" disabled>Work Pointer</button>
                                <button class="btn_custom"  onclick="showDepartment(this)" style="background-color:green;">Department</button>
                                <button class="btn_custom" onclick="workPipeline(this,'${workPointer.status}')" style="background-color:gold;" disabled>Actions</button>
                            </td>   
                        </tr>`;
                    tableBody.append(row);
                });
            }

        } else {
            console.error('Error fetching data: ' + xhr.status);
        }
    };
    var params = 'billing_milestone_id=' + encodeURIComponent(billing_milestone_id);

    xhr.send(params);
}

function formatText(text) {
    const words = text.split(' ');
    let formattedText = '';

    for (let i = 0; i < words.length; i += 4) {
        const line = words.slice(i, i + 4).join(' ');
        formattedText += line + '<br>';
    }

    return formattedText.trim();
}

// work pointer 

const addNewWorkPointer = () => {
    // alert("test");
    var modal = document.getElementById("addWorkPointer");
    modal.style.display = "block";

}

function cancelWpointer() {
    var modal = document.getElementById("addWorkPointer");
    modal.style.display = "none";
}

const workPOinterDetails = () => {
    let workPipeLineId = $('input[name="wp_radio"]:checked').val();
    // alert(workPipeLineId);
    $('#new_work_pointer').css("display", "");
    $('#work_pointer').css("display", "");
    $('#wpipeAction').css("display", "none");
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './ajaxphp/get_data_work_pointer.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        let response = JSON.parse(xhr.responseText);
        if (xhr.status == 200) {
            console.log(response);
            var workPOinter = response.work_pointers;
            // $('#new_work_pointer').css("display", "");
            // $('#wPoTable').css("display", "none");
            $('#workpipel_id').val(workPipeLineId);

            const tableBody = $('#wPoTable tbody');
            tableBody.empty();
            if (response.msg == "Not found") {
                let row = `<tr>
                    <td colspan="5" class="text-center">
                        No work pointer found
                    </td>
                </tr>`;
                tableBody.append(row);
            } else {
                workPOinter.forEach((wp) => {
                    let row = `<tr>
                            <td class="text-center">
                                <input class="selectItem" name="wpointer_radio" value="${wp.wp_id}" type="checkbox">
                            </td>
                            <td class="text-center">${wp.wp_des}</td>
                            <td class="text-center">
                                <button class="btn_custom"  onclick="showPopup_01(this)">Actions</button>
                            </td>
                           
                        </tr>`;
                    // <td class="text-center">${wp.wp_status}</td>
                    // <td class="text-center">
                    //         <button class="btn_custom"  onclick="showPopup_01(this)">Actions</button>
                    //     </td>

                    tableBody.append(row);
                });

                let row = `<tr>
                    <td colspan="5" class="">
                        <button class="btn_custom"  onclick="forwaordWorkPointer();">Forword</button>
                        <button class="btn_custom"  onclick="allocateWorkPointer();" style="background-color:#20c997;">Allocate</button>
                        <button class="btn_custom"  onclick="reworkWorkPointer();" style="background-color:#6f42c1;">Rework</button>
                        <button class="btn_custom"  onclick="closedWorkPointer();" style="background-color:red;">Closed</button>

                    </td>
                </tr>`;
                tableBody.append(row);
            }


            // let table = $('#wPoTable').DataTable();
            // table.draw();

        } else {
            console.error('Error fetching data: ' + xhr.status);
        }
    };
    var params = 'work_pipeline_id=' + encodeURIComponent(workPipeLineId);

    xhr.send(params);
}

// actions button pop up 

function showPopup_03(button) {
    // Create or show the popup
    let popup = document.createElement('div');
    popup.id = 'wpoAction';
    popup.classList.add('popup');
    popup.innerHTML = `
        <div class="popup-content">
            <button class="btn_custom_popup" onClick="activeBm();">Active</button>
            <button class="btn_custom_popup" style="background-color:gray">Suspended</button>
            <button class="btn_custom_popup" style="background-color:green">Complete</button>
            <button class="btn_custom_popup" style="background-color:red">Closed</button>
            
        </div>
    `;

    // Position the popup relative to the button
    let rect = button.getBoundingClientRect();
    popup.style.position = 'absolute';
    popup.style.top = `${rect.bottom + window.scrollY}px`;
    popup.style.left = `${rect.left + window.scrollX}px`;

    // Append the popup to the body or a specific container
    document.body.appendChild(popup);

    // Close the popup if clicked outside
    document.addEventListener('click', function closePopup(e) {
        if (!popup.contains(e.target) && e.target !== button) {
            popup.remove();
            document.removeEventListener('click', closePopup);
        }
    });
}

// add work pointer 
const addWpointer = () => {
    var wpoName = $('#new_work_pointer_name').val();
    var wpo_project_id = $('#wpo_project_id').val();
    var wpo_bm_id = $('#wpo_bm_id').val();
    var wpowpipeId = $('#workpipel_id').val();

    var xhr = new XMLHttpRequest();
    xhr.open('POST', './ajaxphp/add_new_workpointer.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        let response = JSON.parse(xhr.responseText);
        if (xhr.status == 200) {
            // console.log(response);
            workPOinterDetails();
            cancelWpointer();
            var modal = document.getElementById("success_add");
            modal.style.display = "block";
        } else {
            console.error('Error fetching data: ' + xhr.status);
        }
    };
    var params = 'wpoName=' + encodeURIComponent(wpoName) + '&wpo_project_id=' + encodeURIComponent(
        wpo_project_id) + '&wpo_bm_id=' + encodeURIComponent(wpo_bm_id) + '&wpowpipeId=' + encodeURIComponent(
        wpowpipeId);
    xhr.send(params);
}

// for active perticular button 

function activateRowButtons(radio, tableId) {
    const table = document.getElementById(tableId);
    table.querySelectorAll('button').forEach(button => {
        button.disabled = true;
    });

    const row = radio.closest('tr');
    row.querySelectorAll('button').forEach(button => {
        button.disabled = false;
    });
}
</script>


<!-- workpointer opertaions  -->
<!-- 1> for forword  -->
<script>
const forwaordWorkPointer = () => {
    // get_selected_work_pointer
    let projectId = $('#select_project_id').val();
    // alert(projectId);
    let selectedValues = [];
    $('#wPoTable .selectItem:checked').each(function() {
        selectedValues.push($(this).val());
    });

    console.log(selectedValues);

    var modal = document.getElementById("forword_work_pointer");
    modal.style.display = "block";
}
const cancelForword = () => {
    var modal = document.getElementById("forword_work_pointer");
    modal.style.display = "none";
}

// 2> for allocate 

const allocateWorkPointer = () => {
    var modal = document.getElementById("allocate_work_pointer");
    modal.style.display = "block";
}
const cancelAllocate = () => {
    var modal = document.getElementById("allocate_work_pointer");
    modal.style.display = "none";
}

// 2> for rework 

const reworkWorkPointer = () => {
    var modal = document.getElementById("rework_work_pointer");
    modal.style.display = "block";
}
const cancelRework = () => {
    var modal = document.getElementById("rework_work_pointer");
    modal.style.display = "none";
}

// closed work pointer 
const closedWorkPointer = () => {
    var modal = document.getElementById("closed_work_pointer");
    modal.style.display = "block";
}
const cancelClosedWp = () => {
    var modal = document.getElementById("closed_work_pointer");
    modal.style.display = "none";
}


// show department 

const showDepartment = (button) => {
    // Create or show the popup
    let popup = document.createElement('div');
    popup.id = 'showDept';
    popup.classList.add('popup');
    popup.innerHTML = `
        <div class="popup-content">
    <table class="btn_custom_popup_table">
        <tr>
            <td>
                <input type="checkbox">
            </td>
            <td>Land Acqusition</td>
           
        </tr>
        <tr>
            <td>
                <input type="checkbox">
            </td>
            <td>CAD</td>
           
        </tr>
        <tr>
            <td>
                <input type="checkbox">
            </td>
            <td>GIS</td>
           
        </tr>
        <tr>
            <td>
                <input type="checkbox">
            </td>
            <td>Drone</td>
           
        </tr>
    </table>
</div> `;

    // Position the popup relative to the button
    let rect = button.getBoundingClientRect();
    popup.style.position = 'absolute';
    popup.style.top = `${rect.bottom + window.scrollY}px`;
    popup.style.left = `${rect.left + window.scrollX}px`;

    // Append the popup to the body or a specific container
    document.body.appendChild(popup);

    // Close the popup if clicked outside
    document.addEventListener('click', function closePopup(e) {
        if (!popup.contains(e.target) && e.target !== button) {
            popup.remove();
            document.removeEventListener('click', closePopup);
        }
    });
}


// work pointer operations 

// accepet 
const acceptWork = () => {
    var modal = document.getElementById("accepet_work");
    modal.style.display = "block";
}
const acceptNo = () => {
    var modal = document.getElementById("accepet_work");
    modal.style.display = "none";
}

const acceptYes = () => {
    var modal = document.getElementById("accepet_work");
    modal.style.display = "none";
    var modal = document.getElementById("success_add");
    modal.style.display = "block";
}
// Reject 

const rejectWork = () => {
    var modal = document.getElementById("reject_work");
    modal.style.display = "block";
}
const rejectNo = () => {
    var modal = document.getElementById("reject_work");
    modal.style.display = "none";
}

const rejectYes = () => {
    var modal = document.getElementById("reject_work");
    modal.style.display = "none";
    var modal = document.getElementById("success_add");
    modal.style.display = "block";
}


// Upload file 

const uploadFile = () => {
    var modal = document.getElementById("upload_file");
    modal.style.display = "block";
}
const uploadFileCancel = () => {
    var modal = document.getElementById("upload_file");
    modal.style.display = "none";
}

const uploadFileAdd = () => {
    var modal = document.getElementById("upload_file");
    modal.style.display = "none";
    var modal = document.getElementById("success_add");
    modal.style.display = "block";
}

// Upload working Hours

const UploadWorkHours = () => {
    var modal = document.getElementById("upload_hours");
    modal.style.display = "block";
}
const uploadHourCancel = () => {
    var modal = document.getElementById("upload_hours");
    modal.style.display = "none";
}

const uploadHourAdd = () => {
    var modal = document.getElementById("upload_hours");
    modal.style.display = "none";
    var modal = document.getElementById("success_add");
    modal.style.display = "block";
}

// complete_work

const complete = () => {
    var modal = document.getElementById("complete_work");
    modal.style.display = "block";
}
const completeNO = () => {
    var modal = document.getElementById("complete_work");
    modal.style.display = "none";
}

const completeYes = () => {
    var modal = document.getElementById("complete_work");
    modal.style.display = "none";
    var modal = document.getElementById("success_add");
    modal.style.display = "block";
}
</script>



<!-- code by kuldeep -->
 <!-- Initiate New Billing slides -->
<script>
    document.querySelector('.initiate-billing-btn').addEventListener('click', function() {
        document.getElementById('initiateNewBilling').style.display = 'block';
    });

    document.getElementById('closeinitiateNewBilling').addEventListener('click', function() {
        document.getElementById('initiateNewBilling').style.display = 'none';
    });

    window.addEventListener('click', function(event) {
        if (event.target === document.getElementById('initiateNewBilling')) {
            document.getElementById('initiateNewBilling').style.display = 'none';
        }
    });

    function showNextSlide(slideNumber) {
        document.getElementById('initiateNewBilling').style.display = 'none';
        document.getElementById('secondModal').style.display = 'none';
        document.getElementById('thirdModal').style.display = 'none';

        if (slideNumber === 1) {
            document.getElementById('secondModal').style.display = 'block';
        } else if (slideNumber === 2) {
            document.getElementById('thirdModal').style.display = 'block';
        }
    }

    function showPreviousSlide(slideNumber) {
        document.getElementById('secondModal').style.display = 'none';
        document.getElementById('thirdModal').style.display = 'none';

        if (slideNumber === 1) {
            document.getElementById('initiateNewBilling').style.display = 'block';
        } else if (slideNumber === 2) {
            document.getElementById('secondModal').style.display = 'block';
        }
    }
</script>


<!-- Initiate New Billing slide amount count  -->
<script>
    let attributeCount = 3;
    let taxCount = 3;

    function openModal() {
        document.getElementById("initiateNewBilling").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("initiateNewBilling").style.display = "none";
    }
    window.onclick = function(event) {
        var modal = document.getElementById("initiateNewBilling");
        var secondModal = document.getElementById("secondModal");
        var thirdModal = document.getElementById("thirdModal");
        if (event.target == modal) {
            modal.style.display = "none";
        } else if (event.target == secondModal) {
            secondModal.style.display = "none";
        } else if (event.target == thirdModal) {
            thirdModal.style.display = "none";
        }
    };
    document.querySelector(".initiate-billing-btn").addEventListener("click", openModal);
    document.getElementById('closeinitiateNewBilling').onclick = function() {
        document.getElementById('initiateNewBilling').style.display = 'none';
    };
    document.getElementById('closeSecondModal').onclick = function() {
        document.getElementById('secondModal').style.display = 'none';
    };
    document.getElementById('closeThirdModal').onclick = function() {
        document.getElementById('thirdModal').style.display = 'none';
    };

    document.getElementById('createNewAttributeLink').addEventListener('click', function(event) {
        event.preventDefault();
        const newRow = document.createElement('div');
        newRow.classList.add('row');

        const newAttribute1 = document.createElement('div');
        newAttribute1.classList.add('col-md-6');
        newAttribute1.innerHTML = `
        <label for="necessaryAttribute${attributeCount}" class="form-label"><strong>Necessary Attribute ${attributeCount}</strong></label>
        <select id="necessaryAttribute${attributeCount}" name="necessaryAttribute${attributeCount}" class="form-control" required>
            <option value="">Select Attribute</option>
            <option value="Attribute1">Letter of Agreement (LOA)</option>
            <option value="Attribute2">Bank Guarantee (BG)</option>
            <option value="Attribute3">Security Deposit</option>
        </select><br>
        <input type="text" name="amount${attributeCount}" class="form-control" id="amount${attributeCount}" required min="0" placeholder="Enter the amount">
        <p>please select to Add/Subtract the above amount from Base Amount</p>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="operation${attributeCount}" id="add${attributeCount}" value="add">
            <label class="form-check-label" for="add${attributeCount}">Add</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="operation${attributeCount}" id="subtract${attributeCount}" value="subtract">
            <label class="form-check-label" for="subtract${attributeCount}">Subtract</label>
        </div>
    `;
        newRow.appendChild(newAttribute1);
        attributeCount++;

        const newAttribute2 = document.createElement('div');
        newAttribute2.classList.add('col-md-6');
        newAttribute2.innerHTML = `
        <label for="necessaryAttribute${attributeCount}" class="form-label"><strong>Necessary Attribute ${attributeCount}</strong></label>
        <select id="necessaryAttribute${attributeCount}" name="necessaryAttribute${attributeCount}" class="form-control">
            <option value="">Select Attribute</option>
            <option value="Attribute1">Letter of Agreement (LOA)</option>
            <option value="Attribute2">Bank Guarantee (BG)</option>
            <option value="Attribute3">Security Deposit</option>
        </select><br>
        <input type="text" name="amount${attributeCount}" class="form-control" id="amount${attributeCount}" min="0" placeholder="Enter the amount">
        <p>please select to Add/Subtract the above amount from Base Amount</p>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="operation${attributeCount}" id="add${attributeCount}" value="add">
            <label class="form-check-label" for="add${attributeCount}">Add</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="operation${attributeCount}" id="subtract${attributeCount}" value="subtract">
            <label class="form-check-label" for="subtract${attributeCount}">Subtract</label>
        </div>
    `;
        newRow.appendChild(newAttribute2);
        document.getElementById('dynamicAttributesContainer').appendChild(newRow);
        attributeCount++;
    });

    function uploadFile() {
        const fileInput = document.getElementById('fileInput');
        const filesList = document.getElementById('filesList');
        const uploadingIndicator = document.getElementById('uploadingIndicator');

        if (fileInput.files.length > 0) {
            uploadingIndicator.style.display = 'block';
            const file = fileInput.files[0];
            setTimeout(function() {
                uploadingIndicator.style.display = 'none';
                const li = document.createElement('li');
                li.textContent = file.name;
                filesList.appendChild(li);
            }, 2000);
        }
    }

    function showNextSlide(slideIndex) {
        switch (slideIndex) {
            case 1:
                document.getElementById("initiateNewBilling").style.display = "none";
                document.getElementById("secondModal").style.display = "flex";
                break;
            case 2:
                document.getElementById("secondModal").style.display = "none";
                document.getElementById("thirdModal").style.display = "flex";
                break;
        }
    }

    function showPreviousSlide(slideIndex) {
        switch (slideIndex) {
            case 1:
                document.getElementById("secondModal").style.display = "none";
                document.getElementById("initiateNewBilling").style.display = "flex";
                break;
            case 2:
                document.getElementById("thirdModal").style.display = "none";
                document.getElementById("secondModal").style.display = "flex";
                break;
        }
    }
</script>
<!-- calculations script -->
<script>
    function updateSumAmount() {
        let baseAmount = parseFloat(document.getElementById('baseAmount').value) || 0;
        let totalAttributeAmount = 0;
        let amountFields = ['amount1', 'amount2'];

        amountFields.forEach(fieldId => {
            let amount = parseFloat(document.getElementById(fieldId).value) || 0;
            let operation = document.querySelector(`input[name="operation${fieldId.charAt(fieldId.length - 1)}"]:checked`);

            if (operation) {
                totalAttributeAmount += (operation.value === 'add' ? amount : -amount);
            }
        });
        baseAmount += totalAttributeAmount;
        document.getElementById('totalAmount').value = 'Rs. ' + baseAmount.toFixed(2);
        updateTotalAmount(baseAmount);
    }

    function updateTotalAmount(baseAmount) {
        let penaltyAmount = parseFloat(document.getElementById('penaltyAmount').value) || 0;
        let totalTaxAmount = 0;
        let taxFields = ['amount1', 'amount2'];

        taxFields.forEach(fieldId => {
            let taxAmount = parseFloat(document.getElementById(fieldId).value) || 0;
            let operation = document.querySelector(`input[name="operation${fieldId.charAt(fieldId.length - 1)}"]:checked`);
        });
        let finalAmount = baseAmount + penaltyAmount + totalTaxAmount;
        document.getElementById('totalSum').value = 'Rs. ' + finalAmount.toFixed(2);
    }

    function handleFieldChanges() {
        updateSumAmount();
        let baseAmount = parseFloat(document.getElementById('totalAmount').value.replace('Rs. ', '') || 0);
        updateTotalAmount(baseAmount);
    }
    document.getElementById('baseAmount').addEventListener('input', handleFieldChanges);
    document.getElementById('amount1').addEventListener('input', handleFieldChanges);
    document.getElementById('amount2').addEventListener('input', handleFieldChanges);

    document.getElementById('penaltyAmount').addEventListener('input', handleFieldChanges);
    document.getElementById('amount1').addEventListener('input', handleFieldChanges);
    document.getElementById('amount2').addEventListener('input', handleFieldChanges);

    document.querySelectorAll('input[name="operation1"]').forEach(input => {
        input.addEventListener('change', handleFieldChanges);
    });
    document.querySelectorAll('input[name="operation2"]').forEach(input => {
        input.addEventListener('change', handleFieldChanges);
    });

    document.getElementById('selectTax1').addEventListener('change', handleFieldChanges);
    document.getElementById('selectTax2').addEventListener('change', handleFieldChanges);

    document.querySelectorAll('input[name="operation1"]').forEach(input => {
        input.addEventListener('change', handleFieldChanges);
    });
    document.querySelectorAll('input[name="operation2"]').forEach(input => {
        input.addEventListener('change', handleFieldChanges);
    });

    // Function to open the popup
function InitiateBill() {
    document.getElementById("InitiateBill").style.display = "flex";
}

// Close the popup when clicking the close button
document.getElementById("closePopup").addEventListener("click", function () {
    document.getElementById("InitiateBill").style.display = "none";
});

function Uploadxlsx() {
        // Get the file input element
        var fileInput = document.getElementById('uploadExcel');
        
        // Check if a file is selected
        if (fileInput.files.length === 0) {
            alert('Please select a file.');
            return;
        }

        // Create a FormData object
        var formData = new FormData();
        formData.append('xlsx_file', fileInput.files[0]); // Append the file to the form data

        // AJAX request to upload the XLSX file
        $.ajax({
            url: './ajaxphp/upload.php',  // The URL to the upload PHP script
            type: 'POST',
            data: formData,
            contentType: false,   // Set contentType to false for file uploads
            processData: false,   // Set processData to false for file uploads
            success: function(response) {
                // Handle success response
                alert('File uploaded successfully.');
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Handle error response
                alert('Error uploading file: ' + error);
            }
        });
    }

</script>