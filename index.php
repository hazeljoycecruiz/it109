<?php

session_start();

// Check for logout
if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
} elseif (isset($_GET['login']) || isset($_GET['register'])) {
  session_destroy();
  unset($_SESSION['username']);
}

// Check for inactivity and destroy session if needed
if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 3600) {
  // 300 seconds (5 minutes) of inactivity, destroy the session
  session_unset();
  session_destroy();
  header("location: login.php");
} else {
  // Update last activity timestamp
  $_SESSION['last_activity'] = time();
}

// Check if user is not logged in and not on the login page
if (!isset($_SESSION['username']) && basename($_SERVER['PHP_SELF']) !== 'login.php') {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}

?>

<?php include('server.php') ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.example.com; style-src 'self' https://fonts.googleapis.com; img-src 'self' data: https://images.example.com;">


  <title>eJournal</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/notebook.jpg" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
  <link href="assets/css/style2.css" rel="stylesheet">



  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/notebook.jpg" alt="">
        <span class="d-none d-lg-block">eJournal</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">


      <ul class="d-flex align-items-center">

        <img src="assets/img/moon.jpg" id="theme">
        <li class="nav-item dropdown">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/prof.jpg" alt="Profile" class="rounded-circle">
            <?php if (isset($_SESSION['username'])) : ?>
              <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['username']; ?></span>
            <?php endif ?>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <?php if (isset($_SESSION['username'])) : ?>
                <a class="dropdown-item d-flex align-items-center" href="index.php?logout='1'">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                </a>
              <?php endif ?>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="index.php">
          <i class="bi-house"></i>
          <span>Home</span>
        </a>
      </li><!-- End Home Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed " href="entries-data.php">
          <i class="bi bi-grid"></i>
          <span>View Entries</span>
        </a>
      </li><!-- End Entries Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="new-entry.php">
          <i class="bi bi-file-earmark"></i>
          <span>New Entry</span>
        </a>
      </li><!-- End New Entry Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">
    <form method="post" action="index.php">
      <?php include('errors.php'); ?>

      <div class="pagetitle">
        <h1><?php echo htmlspecialchars("Home", ENT_QUOTES, 'UTF-8'); ?></h1>
      </div><!-- End Page Title -->

      <div class="container home1">
        <div class="row">
          <div class="box">
            <?php if (isset($_SESSION['success'])) : ?>
              <div class="error success">
                <h3>
                  <br>
                  <br>
                  <center>
                    <?php
                    echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8');
                    unset($_SESSION['success']);
                    ?>
                  </center>
                </h3>
              </div>
            <?php endif ?>
            <input type="text" placeholder="<?php echo htmlspecialchars("Journal Title", ENT_QUOTES, 'UTF-8'); ?>" class="textbox" name="journal_title" id="textbox">

          </div>

          <div class="col-lg-6 box1">
            <i class="iconp bi bi-pencil-square">
              <a href="new-entry.php">
                <button class="btn1" type="submit" name="submit_journal"><?php echo htmlspecialchars("New Entry", ENT_QUOTES, 'UTF-8'); ?></button>
              </a>
            </i>

            <i class="iconp bi bi-view-list">
              <a href="entries-data.php">
                <button class="btn1" type="button"><?php echo htmlspecialchars("View Entry", ENT_QUOTES, 'UTF-8'); ?></button>
              </a>
            </i>
          </div>
        </div>
      </div>
    </form>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->

  <script>
    var theme = document.getElementById("theme");

    theme.onclick = function() {
      document.body.classList.toggle("dark-theme");
      if (document.body.classList.contains("dark-theme")) {
        theme.src = "assets/img/sun.jpg";
      } else {
        theme.src = "assets/img/moon.jpg";
      }
    }
  </script>
</body>

</html>