<style>
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
        /* Hide scrollbar in IE and Edge */
        scrollbar-width: none;
        /* Hide scrollbar in Firefox */
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
        cursor: pointer;
    }

    /*CSS change by kuldeep */

    #uploadingIndicator {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 150px;
    }

    .loader-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 10px;
    }

    .loader {
        border: 8px solid #f3f3f3;
        border-top: 8px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    #uploadingIndicator p {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }

    .btn:disabled {
        background-color: #ccc;
        cursor: not-allowed;
    }
</style>
<div id="createNewClient" class="modal1">
    <div class="modal-content1">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">Create New Client
        </p>
        <form id="create_new_client_form" class="row g-3" action="" method="POST">
            <input type="text" name="client_type_id_01" class="form-control" id="client_type_id_01" required>

            <div class="col-12">
                <label for="offcerIncharge" class="form-label">Officer Incharge</label>
                <input type="text" name="offcer_incharge" class="form-control" id="offcerIncharge" required>
            </div>
            <div class="col-12">
                <label for="designationOfClient" class="form-label">Designation Of Client</label>
                <input type="text" name="designation_of_client" class="form-control" id="designationOfClient" required>
            </div>
            <div class="col-12">
                <label for="officeOsdName" class="form-label">Office OSD Name</label>
                <input type="text" name="office_osd_name" class="form-control" id="officeOsdName" required>
            </div>
            <div class="col-12">
                <label for="officeOsdNumber" class="form-label">Office OSD Number</label>
                <input type="text" name="office_osd_number" class="form-control" id="officeOsdNumber" required>
            </div>
            <div class="col-12">
                <label for="officeOsdEmail" class="form-label">Office OSD Email</label>
                <input type="text" name="office_osd_email" class="form-control" id="officeOsdEmail" required>
            </div>
            <div class="col-12">
                <label for="officeAddress" class="form-label">Office Address</label>
                <input type="text" name="office_address" class="form-control" id="officeAddress" required>
            </div>
            <div class="col-12">
                <label for="officialCommunicationEmailId" class="form-label">Official Communication Email ID</label>
                <input type="text" name="official_communication_email_id" class="form-control"
                    id="officialCommunicationEmailId" required>
            </div>
            <div class="col-12">
                <label for="mobileNumber" class="form-label">Mobile Number</label>
                <input type="text" name="mobile_number" class="form-control" id="mobileNumber" required>
            </div>
            <div class="text-center">
                <button type="button"
                    style="margin-top: 23px;background: green;color: white;border: 1px solid #a49b9b;border-radius: 5px;padding: 2px;font-weight: 400;"
                    onclick="createNewClientForProject();">Create
                    Now</button>
                <button type="button" onclick="cancel()"
                    style="margin-top: 23px;background: red;color: white;border: 1px solid #a49b9b;border-radius: 5px;padding: 2px;font-weight: 400;">Cancel</button>
            </div>
        </form>

    </div>
</div>

<!-- edit client details  -->
<div id="editClientDetails" class="modal1">
    <div class="modal-content1">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">Edit Client Details
        </p>
        <form class="row g-3 ">
            <div class="col-12">
                <label for="offcerIncharge" class="form-label">Officer Incharge</label>
                <input type="text" name="offcer_incharge" class="form-control" id="offcerIncharge_edit">
            </div>
            <div class="col-12">
                <label for="designationOfClient" class="form-label">Designation Of Client</label>
                <input type="text" name="designation_of_client" class="form-control" id="designationOfClientEdit">
            </div>
            <div class="col-12">
                <label for="officeOsdName" class="form-label">Office OSD Name</label>
                <input type="text" name="office_osd_name" class="form-control" id="officeOsdNameEdit">
            </div>
            <div class="col-12">
                <label for="officeOsdNumber" class="form-label">Office OSD Number</label>
                <input type="text" name="office_osd_number" class="form-control" id="officeOsdNumberEdit">
            </div>
            <div class="col-12">
                <label for="officeOsdEmail" class="form-label">Office OSD Email</label>
                <input type="text" name="office_osd_email" class="form-control" id="officeOsdEmailEdit">
            </div>
            <div class="col-12">
                <label for="officeAddress" class="form-label">Office Address</label>
                <input type="text" name="office_address" class="form-control" id="officeAddressEdit">
            </div>
            <div class="col-12">
                <label for="officialCommunicationEmailId" class="form-label">Official Communication Email ID</label>
                <input type="text" name="official_communication_email_id" class="form-control"
                    id="officialCommunicationEmailIdEdit">
            </div>
            <div class="col-12">
                <label for="mobileNumber" class="form-label">Mobile Number</label>
                <input type="text" name="mobile_number" class="form-control" id="mobileNumberEdit">
            </div>
            <div class="text-center">
                <button type="submit"
                    style="margin-top: 23px;background: green;color: white;border: 1px solid #a49b9b;border-radius: 5px;padding: 2px;font-weight: 400;">Save
                    Changes</button>
                <button type="button" onclick="editCancel()"
                    style="margin-top: 23px;background: red;color: white;border: 1px solid #a49b9b;border-radius: 5px;padding: 2px;font-weight: 400;">Cancel</button>
            </div>
        </form>

    </div>
</div>

<!-- decide project  -->

<div id="decideProject" class="modal1">
    <div class="modal-content1 modal-content-add">
        <span class="close" onclick="closeModal()">&times;</span>
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">What You Want
        </p>
        <fieldset class="row mb-3">
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1"
                    style="margin-left: 4.0rem;" onclick="continueEditing();">
                <label class="form-check-label" for="gridRadios1" style="margin-left: 1.0rem;">
                    Continue Editing
                </label>
            </div>
            <div class="col-md-6 form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2"
                    style="margin-left: 2.0rem;" onclick="initiateNew();">
                <label class="form-check-label" for="gridRadios2" style="margin-left: 1.0rem;">
                    Initiate New
                </label>
            </div>
            </legend>
        </fieldset>
    </div>
</div>


<!-- Add Billing Milestone -->
<div id="addBillingMilestone" class="modal1">
    <div class="modal-content1">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">Add Billing Milestone</p>
        <div class="row g-3 ">
            <div class="col-12">
                <label for="offcerIncharge" class="form-label">Billing Milestone Name</label>
                <input type="text" name="new_billing_milestone" class="form-control" id="new_billing_milestone">
                <input type="hidden" name="billingmilestone_project_id" class="form-control"
                    id="billingmilestone_project_id">
            </div>
            <!-- <div class="col-12">
                <label for="designationOfClient" class="form-label">Designation Of Client</label>
                <input type="text" name="designation_of_client" class="form-control" id="designationOfClient">
            </div> -->

            <div class="text-center">
                <button type="submit" class="btn_custom" style="background: green;" onclick="addBm();">Add</button>
                <button type="button" class="btn_custom" onclick="cancel()" style="background: red;">Cancel</button>
            </div>
        </div>

    </div>
</div>


<!-- Add Working Pipeline -->
<div id="addWorkingPipeline" class="modal1">
    <div class="modal-content1">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">Add Working Pipeline</p>
        <div class="row g-3 ">
            <div class="col-12">
                <label for="offcerIncharge" class="form-label">Working Pipeline Name</label>
                <input type="text" name="new_working_pipeline_name" class="form-control" id="new_working_pipeline_name">
                <input type="hidden" name="working_pipeline_project_id" class="form-control"
                    id="working_pipeline_project_id">
                <input type="hidden" name="working_pipeline_bm_id" class="form-control" id="working_pipeline_bm_id">
            </div>

            <?php
            foreach ($department['department'] as $dept) {
                ?>
                <label><input type="checkbox" value="<?php echo $dept['dept_id']; ?>"
                        onclick="updateSelectionOrder(this)"><?php echo $dept['dept_name']; ?></label><br>
                <?php
            }
            ?>
            <input type="hidden" id="dept_order" name="dept_order">

            <div class="text-center">
                <button type="submit" class="btn_custom" style="background: green;" onclick="addWpipe();">Add</button>
                <button type="button" class="btn_custom" onclick="cancelWp()" style="background: red;">Cancel</button>
            </div>
        </div>

    </div>
</div>


<!-- Add Work pointer -->
<div id="addWorkPointer" class="modal1">
    <div class="modal-content1">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">Add Work Pointer</p>
        <div class="row g-3">
            <div class="col-12">
                <label for="offcerIncharge" class="form-label">Work Pointer Name</label>
                <input type="text" name="new_work_pointer_name" class="form-control" id="new_work_pointer_name">
                <input type="text" name="wpo_project_id" class="form-control" id="wpo_project_id">
                <input type="text" name="wpo_bm_id" class="form-control" id="wpo_bm_id">
                <input type="text" name="workpipel_id" class="form-control" id="workpipel_id">
            </div>
            <div class="text-center">
                <button type="submit" class="btn_custom" style="background: green;"
                    onclick="addWpointer();">Add</button>
                <button type="button" class="btn_custom" onclick="cancelWpointer()"
                    style="background: red;">Cancel</button>
            </div>
        </div>
        <div class="col-12">
            <label for="uploadExcel" class="form-label">Choose XLSX File</label>
            <input type="file" name="xlsx_file" class="form-control" id="uploadExcel" accept=".xlsx">
        </div>
        <div class="text-center">
            <button type="button" class="btn_custom" onclick="Uploadxlsx()" style="background: green;">Upload</button>
        </div>
    </div>
</div>





<!-- Plese Select client-->
<div id="client_not_select" class="modal1">
    <div class="modal-content2">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">You have not selected client . Please Select Client.</p>
        <div class="row g-3 ">


            <div class="text-center">
                <button type="button" class="btn_custom" onclick="cancelNotSelect()"
                    style="background: red;">Ok..!</button>
            </div>
        </div>

    </div>
</div>


<!-- Success-->
<div id="success_add" class="modal1">
    <div class="modal-content2">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">Successfully Added</p>
        <div class="row g-3 ">


            <div class="text-center">
                <button type="button" class="btn_custom" onclick="successAdd()" style="background: red;">Ok..!</button>
            </div>
        </div>

    </div>
</div>


<!-- Plese Select client-->
<div id="client_type_not_select" class="modal1">
    <div class="modal-content2">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">You have not selected client type . Please Select Client type.</p>
        <div class="row g-3 ">


            <div class="text-center">
                <button type="button" class="btn_custom" onclick="cancelTypeNotSelect()"
                    style="background: red;">Ok..!</button>
            </div>
        </div>

    </div>
</div>

<!-- forword work pointer-->
<div id="forword_work_pointer" class="modal1">
    <div class="modal-content1">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">Forword Work Pointer</p>
        <div class="row g-3 ">


            <div class="text-center">
                <button type="button" class="btn_custom" onclick="forword()"
                    style="background: grfeen;">Forword</button>
                <button type="button" class="btn_custom" onclick="cancelForword()"
                    style="background: red;">Cancel</button>
            </div>
        </div>

    </div>
</div>

<!-- allocate work pointer-->
<div id="allocate_work_pointer" class="modal1">
    <div class="modal-content1">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">Allocate Work Pointer</p>
        <div class="row g-3 ">


            <div class="text-center">
                <button type="button" class="btn_custom" onclick="allocate()"
                    style="background: grfeen;">Allocate</button>
                <button type="button" class="btn_custom" onclick="cancelAllocate()"
                    style="background: red;">Cancel</button>
            </div>
        </div>

    </div>
</div>

<!-- rework work pointer-->
<div id="rework_work_pointer" class="modal1">
    <div class="modal-content1">
        <h6 class="text-center">MPM</h6>
        <p class="m_heading text-center">Rework Work Pointer</p>
        <div class="row g-3 ">
            <div class="text-center">
                <button type="button" class="btn_custom" onclick="allocate()"
                    style="background: grfeen;">Rework</button>
                <button type="button" class="btn_custom" onclick="cancelRework()"
                    style="background: red;">Cancel</button>
            </div>
        </div>

    </div>
</div>


<!-- Initiate New Billing slide 1 -->
<div id="InitiateBill" class="modal1" style="display: none;">
    <div class="modal-content1" style="width: 45%; max-height: 700px; overflow-y: auto; position: relative;">
        <span class="close" id="closePopup">&times;</span><br>
        <form id="newBillingForm">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Initiate New Billing</h5>
                    <p class="text-center"><strong>To initiate the billing sequence kindly fill the information</strong>
                    </p>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <label for="baseAmount" class="form-label">
                                <strong>Base Amount</strong><span style="color:red">*</span>
                            </label>
                            <input type="text" name="baseAmount" class="form-control d-inline" id="baseAmount" required
                                min="0" placeholder="Rs.0.00"
                                style="width: auto; display: inline-block; margin-left: 10px;">
                        </div>
                    </div><br>
                    <p class="text-center"><strong>Enter the Settlement Amount of the Necessary Attributes</strong></p>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="necessaryAttribute1" class="form-label"><strong>Necessary Attribute
                                    1</strong><span style="color:red">*</span></label>
                            <select id="necessaryAttribute1" name="necessaryAttribute1" class="form-control" required>
                                <option value="">Select Attribute</option>
                                <option value="Attribute1">Letter of Agreement (LOA)</option>
                                <option value="Attribute2">Bank Guarantee (BG)</option>
                                <option value="Attribute3">Security Deposit</option>
                            </select><br>
                            <input type="text" name="amount1" class="form-control" id="amount1" required min="0"
                                placeholder="Enter the amount">
                            <p>please select to Add/Substract the above amount from Base Amount</p>
                            <div class="form-check form-check-inline" required>
                                <input class="form-check-input" type="radio" name="operation1" id="add1" value="add">
                                <label class="form-check-label" for="add1">Add</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="operation1" id="subtract1"
                                    value="subtract">
                                <label class="form-check-label" for="subtract1">Subtract</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="necessaryAttribute2" class="form-label"><strong>Necessary Attribute
                                    2</strong></label>
                            <select id="necessaryAttribute2" name="necessaryAttribute2" class="form-control">
                                <option value="">Select Attribute</option>
                                <option value="Attribute1">Letter of Agreement (LOA)</option>
                                <option value="Attribute2">Bank Guarantee (BG)</option>
                                <option value="Attribute3">Security Deposit</option>
                            </select><br>
                            <input type="text" name="amount2" class="form-control" id="amount2" min="0"
                                placeholder="Enter the amount">
                            <p>please select to Add/Substract the above amount from Base Amount</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="operation2" id="add2" value="add">
                                <label class="form-check-label" for="add2">Add</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="operation2" id="subtract2"
                                    value="subtract">
                                <label class="form-check-label" for="subtract2">Subtract</label>
                            </div>
                        </div>
                    </div>
                    <div id="dynamicAttributesContainer"></div><br>
                    <a href="#" id="createNewAttributeLink" class="text-decoration-underline text-color-blue">+ Create
                        New Necessary Attribute</a><br><br>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <label for="totalAmount" class="form-label"><strong>Sum Amount</strong>
                            </label>
                            <input type="text" name="totalAmount" class="form-control d-inline" id="totalAmount"
                                readonly placeholder="Rs. 0.00"
                                style="width: auto; display: inline-block; margin-left: 10px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="button" id="next1" class="btn btn-primary" onclick="showNextSlide(1)">Next</button>
            </div>
        </form>
    </div>
</div>

<!-- Initiate New Billing slide 2 -->
<div id="secondModal" class="modal1" style="display: none;">
    <div class="modal-content1" style="width: 45%; max-height: 700px; overflow-y: auto; position: relative;">
        <span class="close" id="closeSecondModal">&times;</span><br>
        <form id="newBillingForm2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Initiate New Billing</h5>
                    <p class="text-center"><strong>Please enter the penalty levied on you</strong></p>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <label for="penaltyName" class="form-label"><strong>Penalty Name</strong></label>
                            <input type="text" name="penaltyName" class="form-control d-inline" id="penaltyName"
                                placeholder="Enter Name of the penalty"
                                style="width: 245px; display: inline-block; margin-left: 10px;">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <label for="penaltyAmount" class="form-label"><strong>Enter The Amount</strong><span
                                    style="color:red">*</span></label>
                            <input type="text" name="penaltyAmount" class="form-control d-inline" id="penaltyAmount"
                                required min="0" placeholder="Rs. 0.00"
                                style="width: auto; display: inline-block; margin-left: 10px;">
                        </div>
                    </div><br>
                    <p class="text-center"><strong>Please Enter the Taxes</strong></p>
                    <div class="tax-container">
                        <div class="row">
                            <div class="col-md-6">
                                <select id="selectTax1" name="selectTax1" class="form-control" required>
                                    <option value="">Please Select Tax</option>
                                    <option value="Tax1">Value-Added Tax (VAT)</option>
                                    <option value="Tax2">Goods and Services Tax (GST)</option>
                                    <option value="Tax3">Sales Tax</option>
                                    <option value="Tax4">Other</option>
                                </select><br>
                                <input type="text" name="amount1" class="form-control" id="amount1" required min="0"
                                    placeholder="Enter the amount">
                            </div>
                            <div class="col-md-6">
                                <select id="selectTax2" name="selectTax2" class="form-control">
                                    <option value="">Please Select Tax</option>
                                    <option value="Tax1">Value-Added Tax (VAT)</option>
                                    <option value="Tax2">Goods and Services Tax (GST)</option>
                                    <option value="Tax3">Sales Tax</option>
                                    <option value="Tax4">Other</option>
                                </select><br>
                                <input type="text" name="amount2" class="form-control" id="amount2" min="0"
                                    placeholder="Enter the amount">
                            </div>
                        </div>
                    </div><br>
                    <div class="tax-container">
                        <div class="row">
                            <div class="col-md-6">
                                <select id="selectTax3" name="selectTax3" class="form-control">
                                    <option value="">Please Select Tax</option>
                                    <option value="Tax1">Value-Added Tax (VAT)</option>
                                    <option value="Tax2">Goods and Services Tax (GST)</option>
                                    <option value="Tax3">Sales Tax</option>
                                    <option value="Tax4">Other</option>
                                </select><br>
                                <input type="text" name="amount1" class="form-control" id="amount1" min="0"
                                    placeholder="Enter the amount">
                            </div>
                            <div class="col-md-6">
                                <select id="selectTax4" name="selectTax4" class="form-control">
                                    <option value="">Please Select Tax</option>
                                    <option value="Tax1">Value-Added Tax (VAT)</option>
                                    <option value="Tax2">Goods and Services Tax (GST)</option>
                                    <option value="Tax3">Sales Tax</option>
                                    <option value="Tax4">Other</option>
                                </select><br>
                                <input type="text" name="amount2" class="form-control" id="amount2" min="0"
                                    placeholder="Enter the amount">
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <label for="totalSum" class="form-label"><strong>Total Amount</strong></label>
                            <input type="text" name="totalSum" class="form-control d-inline" id="totalSum" readonly
                                placeholder="Rs. 0.00" style="width: auto; display: inline-block; margin-left: 10px;">
                        </div>
                    </div><br>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" onclick="showPreviousSlide(1)">Back</button>
                        <button type="button" class="btn btn-primary" onclick="showNextSlide(2)">Next</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Initiate New Billing slide 3 -->
<div id="thirdModal" class="modal1" style="display: none;">
    <div class="modal-content1" style="width: 45%; max-height: 700px; overflow-y: auto; position: relative;">
        <span class="close" id="closeThirdModal">&times;</span><br>
        <form id="newBillingForm3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-center">Initiate New Billing</h5>
                    <p class="text-center"><strong>Upload Documents Submitted to Client</strong></p>
                    <div class="document-upload">
                        <div class="file-upload-container text-center">
                            <input type="file" id="fileInput" class="text-center" accept="application/pdf, image/*">
                            <button type="button" class="btn btn-primary mt-2" onclick="uploadFile()">Upload</button>
                        </div>
                        <div id="uploadingIndicator" class="text-center" style="display:none;">
                            <p><strong>Uploading Your Documents...</strong></p>
                            <div class="loader-container">
                                <div class="loader"></div>
                            </div>
                        </div>

                        <div id="uploadedFilesList" class="text-center mt-4">
                            <h6><strong>Your Files</strong></h6>
                            <ul id="filesList" class="list-group">
                            </ul>
                        </div>
                    </div><br>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" onclick="showPreviousSlide(2)">Back</button>
                        <button type="button" class="btn btn-primary" onclick="validateFormSecondSlide()">Initiate
                            Billing Now</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!--Suyash-->
<!-- NewTopic -->

<div id="NewTopic" class="modal1" style="display: none;">
    <div class="modal-content1" style="width: 45%; max-height: 600px; overflow-y: auto; position: relative;">
        <form id="newTripForm">
            <div class="card">
                <span class="close" id="NewTopicclosePopup">&times;</span>
                <div class="card-body">
                    <h5 class="card-title text-center">Create New Client Interaction</h5>
                    <div class="row g-3">
                        <!-- Project Name -->
                        <div class="col-md-12">
                            <label for="project_id" class="form-label">Select Project Name:<span style="color: red;">*</span></label>
                            <select id="project_id" name="project_id" required class="form-control">
                                <option value="">Select Project</option>
                                <?php foreach ($projects['projects'] as $project): ?>
                                    <option value="<?php echo $project['project_id']; ?>">
                                        <?php echo $project['project_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Subject -->
                        <div class="col-md-12">
                            <label for="subject" class="form-label">Subject<span style="color: red;">*</span></label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>
                        <!-- Radio Button Section: From -->
                        <div class="col-md-12">
                            <label class="form-label"><b>From<span style="color: red;">*</span></b></label><br>
                            <div class="form-check form-check-inline" style="margin-right: 15px;">
                                <input class="form-check-input" type="radio" name="poke_from" id="from_client" value="1"
                                    required>
                                <label class="form-check-label" for="from_client">Client</label>
                            </div>
                            <div class="form-check form-check-inline" style="margin-right: 0rem; padding-left: 18.5em;">
                                <input class="form-check-input" type="radio" name="poke_from" id="from_monarch"
                                    value="2" required>
                                <label class="form-check-label" for="from_monarch">Monarch</label>
                            </div>
                        </div>
                        <!-- Critical Level -->
                        <div class="col-md-12">
                            <label for="criticality_level" class="form-label">Critical Level<span style="color: red;">*</span></label>
                            <select id="criticality_level" name="criticality_level" class="form-control" required>
                                <option value="">Select Critical Level</option>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="button" id="confirmNewTopic" class="btn btn-primary btn-md">Confirm</button>
            </div>
        </form>
    </div>
</div>

<!-- endNewTopic -->

<!-- Suyash -->
<div id="responseModal" class="modal1">
    <div class="modal-content1" style="width: 45%; max-height: 700px; overflow-y: auto; position: relative;">
        <div class="card">
            <span class="close" onclick="closeResponseModal()">&times;</span>
            <div class="card-body">
                <div class="col-md-12">
                    <input type="hidden" id="topic_id_display" class="form-control" readonly><br><br>
                </div>

                <!-- Radio Button Section: From -->
                <div class="col-md-12">
                    <label class="form-label"><b>From<span style="color: red;">*</span></b></label><br>
                    <div class="form-check form-check-inline" style="margin-right: 15px;">
                        <input class="form-check-input" type="radio" name="poke_from" id="from_client" value="1"
                            required onclick="updateToSelection('monarch')">
                        <label class="form-check-label" for="from_client">Client</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-right: 0rem; padding-left: 18.5em;">
                        <input class="form-check-input" type="radio" name="poke_from" id="from_monarch" value="2"
                            required onclick="updateToSelection('client')">
                        <label class="form-check-label" for="from_monarch">Monarch</label>
                    </div>
                </div>

                <!-- Radio Button Section: To -->
                <div class="col-md-12" id="toSection" style="display: none;">
                    <!-- <label class="form-label"><b>To</b></label><br> -->
                    <div class="form-check form-check-inline" style="margin-right: 177px; display: none;">
                        <input class="form-check-input" type="radio" name="poke_to" id="to_monarch" value="1" required
                            disabled readonly>
                        <label class="form-check-label" for="to_monarch">Client</label>
                    </div>
                    <div class="form-check form-check-inline" style="margin-right: 8rem; display: none; padding-left: 9.5em;">
                        <input class="form-check-input" type="radio" name="poke_to" id="to_client" value="2" required
                            disabled readonly>
                        <label class="form-check-label" for="to_client">Monarch</label>
                    </div>
                </div>
<br>
                <!-- Communication Medium and Criticality Level -->
                <div class="row">
                    <div class="col-md-6">
                        <label for="communication_medium" class="form-label">Communication Medium<span style="color: red;">*</span></label>
                        <select name="communication_medium" id="communication_medium" class="form-control" required>
                            <option value="">Select Medium</option>
                            <option value="1">Face to Face</option>
                            <option value="2">By Letter or Electronic Communication</option>
                        </select><br>
                    </div>




                    <div class="col-md-6">
                        <label for="lavel" class="form-label">Criticality Level<span style="color: red;">*</span></label>
                        <select id="lavel" name="lavel" class="form-control" required>
                            <option value="">Select Level</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select><br>
                    </div>
                </div>

                <div class="col-md-12">
                    <label for="short_desc" class="form-label">Short Description<span style="color: red;">*</span></label>
                    <input type="text" name="short_desc" id="short_desc" class="form-control" required><br><br>
                </div>

                <div class="col-md-12">
                    <label for="detailed_desc" class="form-label">Detailed Description</label>
                    <textarea name="detailed_desc" id="detailed_desc" class="form-control" rows="3"
                        required></textarea><br><br>
                </div>

                <!-- Horizontal Row: Date and Date of Letter -->
                <div class="row">
                    <!-- Date Field -->
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date<span style="color: red;">*</span></label>
                        <input type="date" name="date" id="date" class="form-control" required><br>
                    </div>
                    <!-- Date of Letter Field -->
                    <div class="col-md-6">
                        <label for="date_of_letter" class="form-label">Date of Letter</label>
                        <input type="date" name="date_of_letter" id="date_of_letter" class="form-control"><br>
                    </div>
                </div>

                <div class="col-md-12" id="pdf-upload-section">
                    <label class="form-label">Upload PDF</label>
                    <div id="pdf-inputs">
                        <div class="pdf-input-group d-flex align-items-center mb-2">
                            <input type="file" id="pdf-files" class="form-control" accept=".pdf" multiple>
                        </div>
                        <div id="selected-files-list"></div> 
                        <div id="file-count" class="mt-2"><b>Total Selected Files: 0</b></div>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn btn-primary btn-md" onclick="submitResponse(event)">Submit</button>
    </div>
</div>
<!-- end Modal for Response -->