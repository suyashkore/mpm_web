<?php 
session_start();
if (!isset($_SESSION['mobile'])) {
    header('Location: ./login.php');
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login(Enter OTP) - MPM web portal</title>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

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
<style>
.otp-input {
    width: 40px;
    text-align: center;
}
</style>

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

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Generate Pin</h5>
                                        <p id="error_text" class="text-center small" style="color:red;display:none;">
                                            Something Wnt Wrong.Try Again ..!</p>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate>

                                        <div class="col-12 text-center">
                                            <label for="pin" class="form-label">Enter New Pin</label>
                                            <div class="d-flex justify-content-center">
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin1" required>
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin2" required>
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin3" required>
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin4" required>
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin5" required>
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin6" required>
                                            </div>
                                        </div>

                                        <div class="col-12 text-center">
                                            <label for="confirm_pin" class="form-label">Confirm Pin</label>
                                            <div class="d-flex justify-content-center">
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin_1" required>
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin_2" required>
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin_3" required>
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin_4" required>
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin_5" required>
                                                <input type="password" maxlength="1" class="form-control mx-1 otp-input"
                                                    id="pin_6" required>
                                            </div>
                                        </div>

                                        <div class="col-12 text-center mt-4">
                                            <button class="btn btn-primary w-30" type="button"
                                                onclick="generateNew_01();">Create</button>
                                        </div>

                                    </form>

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


    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
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

<script>
const generateNew_01 = () => {
    let pin1 = $('#pin1').val();
    let pin2 = $('#pin2').val();
    let pin3 = $('#pin3').val();
    let pin4 = $('#pin4').val();
    let pin5 = $('#pin5').val();
    let pin6 = $('#pin6').val();
    let pin = pin1 + pin2 + pin3 + pin4 + pin5 + pin6;

    let pin_1 = $('#pin_1').val();
    let pin_2 = $('#pin_2').val();
    let pin_3 = $('#pin_3').val();
    let pin_4 = $('#pin_4').val();
    let pin_5 = $('#pin_5').val();
    let pin_6 = $('#pin_6').val();
    let confirm_pin = pin_1 + pin_2 + pin_3 + pin_4 + pin_5 + pin_6;

    if (pin == '') {
        for (let i = 1; i <= 6; i++) {
            $('#pin' + i).css('border-color', 'red');
        }
        for (let i = 1; i <= 6; i++) {
            $('#pin_' + i).css('border-color', 'red');
        }
    } else if (pin === confirm_pin) {
        for (let i = 1; i <= 6; i++) {
            $('#pin' + i).css('border-color', 'green');
        }
        for (let i = 1; i <= 6; i++) {
            $('#pin_' + i).css('border-color', 'green');
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', './ajaxphp/update_pin.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            let response = JSON.parse(xhr.responseText);
            if (xhr.status == 200) {
                console.log(response);
                if (response.msg === 'update') {
                    window.location.href = 'enter_pin.php';
                } else {
                    $('#error_text' + i).css('display', '');
                    window.location.href = 'generate_pin.php';
                }
            } else {
                console.error('Error fetching data: ' + xhr.status);
            }
        };
        var params = 'pin=' + encodeURIComponent(pin);
        xhr.send(params);

    } else {
        for (let i = 1; i <= 6; i++) {
            $('#pin' + i).css('border-color', 'red');
        }
        for (let i = 1; i <= 6; i++) {
            $('#pin_' + i).css('border-color', 'red');
        }
    }
}
const otpInputs = document.querySelectorAll('.otp-input');

otpInputs.forEach((input, index) => {
    input.addEventListener('input', function(e) {
        const value = e.target.value;
        if (!/^[0-9]$/.test(value)) {
            e.target.value = '';
            return;
        }

        if (index < otpInputs.length - 1 && value) {
            otpInputs[index + 1].disabled = false;
            otpInputs[index + 1].focus();
        }
    });

    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && input.value === '' && index > 0) {
            otpInputs[index - 1].focus();
        }
    });
});

document.getElementById('otp1').focus();
</script>