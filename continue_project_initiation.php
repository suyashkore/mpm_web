<?php
session_start();
include './config/config.php';
include './class/class_client.php';
include './class/class_temp_project_details.php';

$client_type_obj = new client($conn); 
$client_types = $client_type_obj->get_client_types();

// get temp project details 
$temp_project_obj = new temp_project($conn); 
$temp_project = $temp_project_obj->get_temp_project_data('PRO-00006');
$project = $temp_project['projects'];
$today = date('Y-m-d');

// print_r($project);
  
?>
<!-- header  -->
<?php include 'header.php'; ?>
<!-- ======= Sidebar ======= -->
<?php include 'sidebar.php'; ?>
<!-- End Sidebar-->
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Project Initiation Continue Editing</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Create New Project</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-2">

            </div>
            <!-- Left side columns -->
            <div class="col-lg-8">
                <!-- Horizontal Form -->

                <form id="initiateProject" action="./controller/ctrl_project_initiation.php" method="post">
                    <input type="hidden" name="project_id" id="project_id"
                        value="<?php if(isset($project)) echo $project['project_id']; ?>">

                    <div class="slide" id="slide1">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Enter Project Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="projectName" class="form-label">Project Name</label>
                                        <input type="text" name="project_name" class="form-control" id="projectName"
                                            value="<?php if(isset($project)) echo $project['project_name']; ?>"
                                            required>
                                        <span id="error-message" class="error">Invalid project name. Only alphabetic
                                            characters and single space are allowed.</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="clientType" class="form-label">Client Type</label>
                                        <select id="clientTypeOption" name="client_type_option" class="form-select"
                                            onchange="getClient();">
                                            <option value="" selected>Choose...</option>
                                            <?php 
                                    foreach($client_types['client'] as $client){
                                        // print_r($client);
                                        ?>
                                            <option value="<?php echo $client['client_type_id']; ?>"
                                                <?php if ($client['client_type_id'] == $project['client_type_id']) echo 'selected'; ?>>
                                                <?php echo $client['client_type_name']; ?></option>
                                            <?php
                                    }
                                    ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="selectClient" class="form-label">Select Client </label>
                                        <select id="selectClient" name="select_client" class="form-select">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="clientDetails" class="form-label"
                                            style="color:blue;font-weight:bold;cursor:pointer;"
                                            onclick="editClientDetails();">Client Details</label>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="createNewClient" class="form-label"
                                            style="color:blue;font-weight:bold;cursor:pointer;"
                                            onclick="createNewClient();">Create New Client </label>

                                    </div>

                                    <div class="col-md-6">
                                        <label for="projectStatus" class="form-label">Project Status</label>
                                        <select id="projectStatus" name="project_status" class="form-select" required>
                                            <option value="" selected>Choose...</option>
                                            <option value="Order received"
                                                <?php if ($project['project_status'] == 'Order received') echo 'selected'; ?>>
                                                Order received</option>
                                            <option value="Order pending"
                                                <?php if ($project['project_status'] == 'Order pending') echo 'selected'; ?>>
                                                Order pending</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="projectStratDate" class="form-label">Project Start Date</label>
                                        <input type="Date" name="project_start_date" class="form-control"
                                            id="projectStratDate" min="<?php echo $today; ?>"
                                            value="<?php if(isset($project)) echo $project['project_start_date']; ?>"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="projectComplitionTime" class="form-label">Project Completion Time
                                            <span style="font-size:12px;">(In Months)</span></label>
                                        <input type="text" name="project_complition_time" class="form-control"
                                            id="projectComplitionTime"
                                            value="<?php if(isset($project)) echo $project['project_comp_time']; ?>"
                                            required oninput="getDate();">
                                        <span id="complition_label" style="display:none;color:green;">Complition Date :
                                        </span><span id="complition_date" style="display:none;color:green;"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="salesPersonName" class="form-label">Sales Team Contact Person
                                            Name</label>
                                        <input type="text" name="sales_person_name" class="form-control"
                                            id="salesPersonName"
                                            value="<?php if(isset($project)) echo $project['sales_person_details']; ?>"
                                            required oninput="salesName()">
                                        <span id="error-message1" class="error">Invalid Name</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="salesPersonNo" class="form-label">Sales Team Contact Person
                                            Number</label>
                                        <input type="text" name="sales_person_no" class="form-control"
                                            id="salesPersonNo" minlength="10" maxlength="10" pattern="[6-9][0-9]{9}"
                                            required>
                                        <div id="error-message-mobile" style="color: red; display: none;">Invalid
                                            pattern: The number must be 10 digits long and start with a digit between 6
                                            and 9.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="projectType" class="form-label">Select Project Type</label>
                                        <select id="projectType" name="project_type" class="form-select">
                                            <option selected>Choose...</option>
                                            <option
                                                <?php if ($project['project_status'] == 'New Track Survey') echo 'selected'; ?>>
                                                New Track Survey</option>
                                            <option>Track Upgradation</option>
                                            <option>Building & Structural Survey</option>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" id="next1" class="btn btn-primary"
                                            onclick="validateFormFirstSlide()">Next</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- slide2  -->
                    <div class="slide" id="slide2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Project Value</h5>
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="revenueAmount" class="form-label">Revenue Amount (Thousand)</label>
                                        <input type="text" name="revenue_amount" class="form-control" id="revenueAmount"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="includingGst" class="form-label">Including GST</label>
                                        <select id="includingGst" name="including_gst" class="form-select">
                                            <option selected>YES</option>
                                            <option selected>NO</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="otherTaxes" class="form-label">Other Taxes</label>
                                        <input type="text" name="other_taxes" class="form-control" id="otherTaxes">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" name="loa" type="checkbox" id="loa">
                                            <label class="form-check-label" for="loa" style="font-weight:bold;">
                                                Letter Of Acceptance (LOA) <span style="color:red">*</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="bi bi-arrow-up-square"></i> <label class="form-check-label"
                                            for="uploadFile" style="color:blue;font-size:15px;cursor:pointer">Upload
                                            File</label>
                                    </div>

                                    <div class="col-md-6 loaamount" id="loaAmount" style="display:none;">
                                        <label for="amountLoa" class="form-label">Amount</label>
                                        <input type="text" name="amount_loa" class="form-control" id="amountLoa">
                                    </div>
                                    <div class="col-md-6 loaamount" style="display:none;">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" name="contract" type="checkbox"
                                                id="contract">
                                            <label class="form-check-label" for="contract" style="font-weight:bold;">
                                                Contract <span style="color:red">*</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="bi bi-arrow-up-square"></i> <label class="form-check-label"
                                            for="uploadFile" style="color:blue;font-size:15px;cursor:pointer">Upload
                                            File</label>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" name="sd" type="checkbox" id="sd">
                                            <label class="form-check-label" for="sd" style="font-weight:bold;">
                                                Security Deposit (SD) <span style="color:red">*</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="bi bi-arrow-up-square"></i> <label class="form-check-label"
                                            for="uploadFile" style="color:blue;font-size:15px;cursor:pointer">Upload
                                            File</label>
                                    </div>

                                    <div class="col-md-4 sd" style="display:none;">
                                        <label for="percentage" class="form-label">Percentage(%)</label>
                                        <input type="text" name="percentage" class="form-control" id="percentage">
                                    </div>
                                    <div class="col-md-4 sd" style="display:none;">
                                        <label for="selctFileSd" class="form-label">Select</label>
                                        <select id="selctFileSd" name="select_file_sd" class="form-select">
                                            <option selected>Choose...</option>
                                            <option>Amount will be settled in bill</option>
                                            <option>Amount to be submitted</option>
                                            <option>Within the time limit</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 sd" style="display:none;">
                                        <label for="amountSd" class="form-label">Amount</label>
                                        <input type="text" name="amount_sd" class="form-control" id="amountSd">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" name="pg" type="checkbox" id="pg">
                                            <label class="form-check-label" for="pg" style="font-weight:bold;">
                                                Performance Guarantee (PG) <span style="color:red">*</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="bi bi-arrow-up-square"></i> <label class="form-check-label"
                                            for="upoadFilepg" style="color:blue;font-size:15px;cursor:pointer">Upload
                                            File</label>
                                    </div>

                                    <div class="col-md-4 pg" style="display:none;">
                                        <label for="percentagePg" class="form-label">Percentage(%)</label>
                                        <input type="text" name="percentage_pg" class="form-control" id="percentagePg">
                                    </div>
                                    <div class="col-md-4 pg" style="display:none;">
                                        <label for="selectFilePg" class="form-label">Select</label>
                                        <select id="selectFilePg" name="select_file_pg" class="form-select">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 pg" style="display:none;">
                                        <label for="amountPg" class="form-label">Amount</label>
                                        <input type="text" name="amount_pg" class="form-control" id="amountPg">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" name="bg" type="checkbox" id="bg">
                                            <label class="form-check-label" for="bg" style="font-weight:bold;">
                                                Bank Guarantee (BG) 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="bi bi-arrow-up-square"></i> <label class="form-check-label"
                                            for="uploadFileBg" style="color:blue;font-size:15px;cursor:pointer">Upload
                                            File</label>
                                    </div>

                                    <div class="col-md-4 bg" style="display:none;">
                                        <label for="percentageBg" class="form-label">Percentage(%)</label>
                                        <input type="text" name="percentage_bg" class="form-control" id="percentageBg">
                                    </div>
                                    <div class="col-md-4 bg" style="display:none;">
                                        <label for="selectBg" class="form-label">Select</label>
                                        <select id="selectBg" name="select_bg" class="form-select">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 bg" style="display:none;">
                                        <label for="amountBg" class="form-label">Amount</label>
                                        <input type="text" name="amount_bg" class="form-control" id="amountBg">
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" name="emd" type="checkbox" id="emd">
                                            <label class="form-check-label" for="emd" style="font-weight:bold;">
                                                Ernest Money Deposit (EMD) 
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="bi bi-arrow-up-square"></i> <label class="form-check-label"
                                            for="uploadFileEmd" style="color:blue;font-size:15px;cursor:pointer">Upload
                                            File</label>
                                    </div>

                                    <div class="col-md-6 emd" style="display:none;">
                                        <label for="amontemd" class="form-label">Amount</label>
                                        <input type="text" name="amontemd" class="form-control" id="amontemd">
                                    </div>
                                    <div class="col-12 emd" style="display:none;"></div>

                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" name="wo" type="checkbox" id="wo">
                                            <label class="form-check-label" for="wo" style="font-weight:bold;">
                                                Work Order (WO)
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <i class="bi bi-arrow-up-square"></i> <label class="form-check-label"
                                            for="uploadWo" style="color:blue;font-size:15px;cursor:pointer">Upload
                                            File</label>
                                    </div>

                                    <div class="text-center">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="backSlide()">Back</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="validateFormSecondSlide()">Next</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- third form  -->
                    <div class="slide" id="slide3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Project Value</h5>
                                <div class="row g-3">
                                    <div class="col-md-12 text-center">
                                        <label for="" class="form-label" style="color:blue;font-weight:bold;">Project
                                            Consignee</label>

                                    </div>
                                    <div class="col-md-12">
                                        <label for="consignee" class="form-label">Consignee</label>
                                        <input type="text" name="consignee" class="form-control" id="consignee"
                                            required>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="addConsignee" class="form-label"
                                            style="color:blue;text-decoration:underline;font-size:15px;font-weight:bold;float:right;cursor:pointer;">Add
                                            Consignee</label>

                                    </div>
                                    <div class="col-md-12">
                                        <label for="billPassAuthority" class="form-label">Bill Pass Authority</label>
                                        <input type="text" class="form-control" name="bill_pass_authority"
                                            id="billPassAuthority">

                                    </div>
                                    <div class="col-md-12">
                                        <label for="scopeShort" class="form-label">Scope of project (Short
                                            Description)</label>
                                        <input type="text" name="scope_short" class="form-control" id="scopeShort">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="scopeDetails" class="form-label">Scope of project (In
                                            Details)</label>
                                        <textarea class="form-control" name="scope_details" id="scopeDetails"
                                            row="3"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="assignProjectManager" class="form-label">Assign Project Manager
                                            :</label>

                                    </div>
                                    <div class="col-md-6">
                                        <label for="projectManager" class="form-label">Project Manager</label>
                                        <select id="projectManager" name="project_manager" class="form-select">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="projectManagerTeam" class="form-label">Project Manager Team</label>
                                        <select id="projectManagerTeam" name="project_manager_team" class="form-select">
                                            <option selected>Choose...</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="isit" class="form-label">Is It :</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-check-input" type="radio" name="profit_loss" id="profit"
                                            value="profit" style="border: 2px solid green;" onchange="amountForIt();">
                                        <label for="profit" class="form-label" style="color:green">Profit Making</label>
                                        &nbsp;&nbsp;
                                        <input class="form-check-input" type="radio" name="profit_loss" id="loss"
                                            value="loss" style="border: 2px solid red;" onchange="amountForIt();">
                                        <label for="loss" class="form-label" style="color:red">Loss Making</label>
                                    </div>
                                    <div class="col-md-6" id="pamt" style="display:none">
                                        <label for="profitAmount" class="form-label">Amount</label>
                                        <input type="text" name="profit_loss_amount" class="form-control" id="profitAmount">
                                    </div>
                                    <div class="col-md-6" id="lamt" style="display:none;">
                                        <label for="lossAmount" class="form-label">Loss Amount</label>
                                        <input type="text" name="loss_amount" class="form-control" id="lossAmount">
                                    </div>  


                                    <div class="text-center">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="backSlide()">Back</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="validateFormThirdSlide()">Next</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- fourth slide  -->
                    <div class="slide" id="slide4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-center">Project Value</h5>

                                <div class="row g-3">
                                    <div class="col-md-12 text-center">
                                        <label for="" class="form-label" style="color:blue;font-weight:bold;">Project
                                            Assign</label>

                                    </div>

                                    <div class="col-md-12">
                                        <label for="assign" class="form-label">Assign :</label>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="projectManager" class="form-label">Project Manager</label>
                                        <input type="text" name="projectmanager" class="form-control"
                                            id="projectManager">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="noOfTeamMenber" class="form-label">No of Project Team Member</label>
                                        <input type="text" name="no_of_tem_member" class="form-control"
                                            id="noOfTeamMenber">
                                    </div>

                                    <div class="col-md-12">
                                        <label for="DeptFlowSeq" class="form-label">Department Flow Sequence</label>
                                    </div>
                                    <div class="col-md-12" id="departmentContainer"></div>

                                    <div class="col-md-12">
                                        <label for="AddNewDept" class="form-label"
                                            style="color:blue;font-size:15px;text-decoration:underline;float:right;font-weight:bold;"
                                            onclick="addDepartment();">+
                                            Add
                                            New Department</label>
                                    </div>

                                    <div class="text-center">
                                        <button type="button" class="btn btn-secondary"
                                            onclick="backSlide()">Back</button>
                                        <button type="submit" class="btn btn-primary"
                                            onclick="createProject()">Create</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-2">

            </div><!-- End Right side columns -->

        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include 'footer.php' ?>

<!-- ======= popup forms ======= -->
<?php include 'popupforms_project_initiation.php' ?>

<!-- javascript -->
<script src="assets/js/project_initiation.js"></script>

<!-- javascript for page  -->

<script>
window.onload = function() {
    getClientEdit('<?php echo $project['selectedClientId']; ?>');
    getDate();
};

// get client for continue editing
function getClientEdit(client_id) {
    let client_type_id = $('#clientTypeOption').val();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './ajaxphp/get_clients.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status == 200) {
            let response = JSON.parse(xhr.responseText);
            console.log(response);

            let optionsHtml = '';
            if (response.msg === 'Get all client') {
                optionsHtml += `<option value="" disabled selected>Choose...</option>`;
                response.client.forEach(client => {
                    let isSelected = client.client_id == client_id ? 'selected' : '';
                    optionsHtml +=
                        `<option value="${client.client_id}" ${isSelected}>${client.name_of_official}</option>`;
                });
            } else {
                optionsHtml += `<option value="" disabled selected>Choose...</option>`;
            }
            document.getElementById('selectClient').innerHTML = optionsHtml;
        } else {
            console.error('Error fetching data: ' + xhr.status);
        }
    };
    var params = 'client_type_id=' + encodeURIComponent(client_type_id);
    xhr.send(params);
}
</script>