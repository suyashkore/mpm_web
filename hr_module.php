<?php
session_start();
include './config/config.php';
include './class/class_client.php';
include './class/class_manager.php';
?>

<!-- header  -->
<?php include 'header.php'; ?>
<!-- ======= Sidebar ======= -->
<?php include 'sidebar.php'; ?>
<!-- End Sidebar-->

<main id="main" class="main">
    <div class="pagetitle">
        <h1>HR Module - Employee Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Create Employee Profile</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-2"></div>
    
            <div class="col-lg-8">
                <form id="hrProfileForm" action="./controller/ctrl_hr_profile.php" method="post" onsubmit="return validateForm()">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Enter Employee Information</h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="employeeName" class="form-label" style="font-weight:bold;">
                                        Employee Name <span style="color:red">*</span>
                                    </label>
                                    <input type="text" name="employee_name" class="form-control" id="employeeName" required pattern="[A-Za-z\s]{1,50}" title="Name should contain only letters and spaces, and be 1 to 50 characters long.">
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label" style="font-weight:bold;">
                                        Email <span style="color:red">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-control" id="email" required 
                                        pattern="^(?=.*[a-z])(?=.*\d)[a-z\d._%+-]+@[a-z\d.-]+\.[a-z]{2,}$" 
                                        title="Email must contain at least one lowercase letter and one digit. Example: user1@example.com">
                                </div>

                                <div class="col-md-6">
                                    <label for="contactNumber" class="form-label" style="font-weight:bold;">
                                        Contact Number <span style="color:red">*</span>
                                    </label>
                                    <input type="tel" name="contact_number" class="form-control" id="contactNumber" required pattern="^\+?[6-9][0-9]{11}$" title="Contact number must start with + followed by 6, 7, 8, or 9 and be exactly 10 digits long.">
                                </div>

                                <div class="col-md-6">
                                    <label for="alternateContact" class="form-label" style="font-weight:bold;">
                                        Alternate Contact Number
                                    </label>
                                    <input type="tel" name="alternate_contact" class="form-control" id="alternateContact" pattern="^\+?[6-9][0-9]{11}$" title="Alternate contact number must start with + followed by 6, 7, 8, or 9 and be exactly 10 digits long.">
                                </div>

                                <div class="col-md-6">
                                    <label for="dob" class="form-label" style="font-weight:bold;">
                                        Date of Birth <span style="color:red">*</span>
                                    </label>
                                    <input type="date" name="dob" class="form-control" id="dob" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="doj" class="form-label" style="font-weight:bold;">
                                        Date of Joining <span style="color:red">*</span>
                                    </label>
                                    <input type="date" name="date_of_joining" class="form-control" id="doj" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="status" class="form-label" style="font-weight:bold;">
                                        Status <span style="color:red">*</span>
                                    </label>
                                    <select name="status" class="form-select" id="status" required>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                                <div style="margin-bottom: 10px;"></div>

                                <div class="row g-3">
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="ds" id="ds" value="DS">
                                        <label class="form-check-label" for="ds" style="font-weight:bold;">DS</label>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="df" id="df" value="DF">
                                        <label class="form-check-label" for="df" style="font-weight:bold;">DF</label>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="do" id="do" value="DO">
                                        <label class="form-check-label" for="do" style="font-weight:bold;">DO</label>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="pa" id="pa" value="PA">
                                        <label class="form-check-label" for="pa" style="font-weight:bold;">PA</label>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="pm" id="pm" value="PM">
                                        <label class="form-check-label" for="pm" style="font-weight:bold;">PM</label>
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="hr" id="hr" value="HR">
                                        <label class="form-check-label" for="hr" style="font-weight:bold;">HR</label>
                                    </div>
                                </div>
                            </div>

                            <div style="margin-bottom: 20px;"></div>

                            <div class="col-md-6">
                                    <label for="hod" class="form-label" style="font-weight:bold;">
                                        HOD <span style="color:red">*</span>
                                    </label>
                                    <select name="hod" class="form-select" id="hod" required>
                                        <option value="" disabled selected>Select HOD</option>
                                        <?php foreach ($managers as $manager) : ?>
                                            <option value="<?= $manager['id'] ?>"><?= $manager['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="tmpm" class="form-label" style="font-weight:bold;">
                                        TMPM <span style="color:red">*</span>
                                    </label>
                                    <select name="tmpm" class="form-select" id="tmpm" required>
                                        <option value="" disabled selected>Select TMPM</option>
                                        <?php foreach ($managers as $manager) : ?>
                                            <option value="<?= $manager['id'] ?>"><?= $manager['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="tmd" class="form-label" style="font-weight:bold;">
                                        TMD <span style="color:red">*</span>
                                    </label>
                                    <select name="tmd" class="form-select" id="tmd" required>
                                        <option value="" disabled selected>Select TMD</option>
                                        <?php foreach ($managers as $manager) : ?>
                                            <option value="<?= $manager['id'] ?>"><?= $manager['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="profileId" class="form-label" style="font-weight:bold;">
                                        Profile<span style="color:red">*</span>
                                    </label>
                                    <select name="profile_id" class="form-select" id="profileId" required>
                                        <option value="" disabled selected>Select Profile ID</option>
                                        <?php foreach ($profiles as $profile) : ?>
                                            <option value="<?= $profile['id'] ?>"><?= $profile['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-2"></div>
        </div>
    </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include 'footer.php'; ?>

<!-- <script>
function validateForm() {
    const contactNumber = document.getElementById('contactNumber').value;
    const alternateContact = document.getElementById('alternateContact').value;

    // Check if contact number is a valid length
    const contactRegex = /^\+?[0-9]{10,15}$/;
    if (!contactRegex.test(contactNumber)) {
        alert('Contact Number must be between 10 to 15 digits.');
        return false;
    }

    // Check if alternate contact is valid (if provided)
    if (alternateContact && !contactRegex.test(alternateContact)) {
        alert('Alternate Contact Number must be between 10 to 15 digits.');
        return false;
    }

    return true; // Form is valid
}
</script> -->
