<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login - MPM web portal</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/mpm_logo.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <!-- py-4 -->
                            <div class="d-flex justify-content-center " style="padding-bottom: 1.5rem !important;">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/mpm_logo.png" alt="" style="max-height: 120px;">
                                    <!-- <span class="d-none d-lg-block">NiceAdmin</span> -->
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3" style="width: 100%;">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your Register mobile Number</p>
                                        <p id="error_text" class="text-center small" style="color:red;"></p>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate>

                                        <div class="col-12">
                                            <label for="yourMObileNumber" class="form-label">Mobile Number</label>
                                            <div class="input-group has-validation">
                                                <!-- <input type="text" name="mobile_number" class="form-control" id="yourMObileNumber" required> -->

                                                <input type="text" name="mobile_number" class="form-control"
                                                    id="yourMobileNumber" required><br>

                                            </div>
                                            <div>
                                                <small id="error-msg" class="text-danger" style="display:none;">Invalid
                                                    mobile number</small>
                                            </div>
                                        </div>

                                        <div class="col-12 text-center">
                                            <button id="nextButton" class="btn btn-primary w-40" type="button"
                                                onclick="checkMobileNumber();" disabled>Next</button>
                                        </div>

                                    <!-- </form> -->

                                </div>
                            </div>


                            <div class="credits text-center">
                                Designed And Developed by <br><a href="#">MOUNARCH TECH SOLUTIONS & SYSTEMS PVT. LTD</a>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->



    <script>
    document.getElementById('yourMobileNumber').addEventListener('input', function() {
        const mobileNumber = this.value;
        const errorMsg = document.getElementById('error-msg');
        const regex = /^[6-9][0-9]{9}$/;
        const nextButton = document.getElementById('nextButton');

        if (regex.test(mobileNumber)) {
            errorMsg.style.display = 'none';
            this.setCustomValidity('');
            nextButton.disabled = false;
        } else {
            errorMsg.style.display = 'block';
            this.setCustomValidity('Invalid');
            nextButton.disabled = true;
        }
    });

    const checkMobileNumber = () => {
        var mobile = $('#yourMobileNumber').val();
        var xhr = new XMLHttpRequest();
        alert(xhr);
        xhr.open('POST', './ajaxphp/check_mobile_number.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            let response = JSON.parse(xhr.responseText);
            console.log(response);
            if (xhr.status == 200) {
                console.log(response);
                if (response.msg === 'number found') {
                    $('#error_text').text('');
                    window.location.href = 'enter_pin.php';
                } else {
                    $('#error_text').text('Please enter registered mobile number');
                }
            } else {
                console.error('Error fetching data: ' + xhr.status);
            }
        };
        var params = 'mobile=' + encodeURIComponent(mobile);
        xhr.send(params);
        
    }
    </script>



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>