<?php
session_start();
include './config/config.php';
include './class/class_client.php';
include './class/class_manager.php';

$client_type_obj = new client($conn);
$client_types = $client_type_obj->get_client_types();

$manager_obj = new manager($conn);
$manager = $manager_obj->get_all_manager();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>User Profile</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">


    <style>
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        nav .nav-item {
            margin-right: 15px;
        }

        nav .nav-item:last-child {
            margin-right: 0;
        }

        nav button {
            padding: 8px 12px;
            font-size: 16px;
            border: none;
            color: #fff;
            cursor: pointer;
            border-radius: 4px;
        }

        nav .btn-home {
            background-color: #007bff;
        }

        nav .btn-signout {
            background-color: #dc3545;
        }

        nav button:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
<?php include 'sidebar.php';?>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/mpm_logo.png" alt="">
        <span class="d-none d-lg-block">Monarch</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

            <nav>
                <ul class="d-flex align-items-center">
                    <?php if (isset($_SESSION['name'])): ?>
                        <li class="nav-item">
                            <form action="index.php" method="get" class="d-inline">
                                <button type="submit" class="btn btn-home">Home</button>
                            </form>
                        </li>
                        <li class="nav-item">
                            <form action="./logout.php" method="post" class="d-inline">
                                <button type="submit" class="btn btn-signout">Sign Out</button>
                            </form>
                        </li>
                    <?php endif;?>
                </ul>
            </nav>
        </div>
    </header>


    <!-- ======= Main Content ======= -->
    <main id="main" class="main">
        <div class="container mt-5 pt-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User Profile</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="assets/img/avtar.jpg" alt="Profile" class="img-fluid rounded-circle">
                        </div>
                        <div class="col-md-8">
                            <h6>
                                <span><?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : ''; ?></span>
                            </h6>
                            <p>
                                <span><?php echo isset($_SESSION['profile_name']) ? htmlspecialchars($_SESSION['profile_name']) : ''; ?></span>
                            </p>
                            <hr>
                            <h6>Contact Information</h6>
                            <p>Email: <?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'N/A'; ?></p>
                            <p>Phone: <?php echo isset($_SESSION['phone']) ? htmlspecialchars($_SESSION['phone']) : 'N/A'; ?></p>
                            <hr>
                            <a href="edit-profile.html" class="btn btn-primary">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- End Main Content -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="container text-center">
            <p>&copy; 2024 Monarch. All Rights Reserved.</p>
        </div>
    </footer><!-- End Footer -->

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
