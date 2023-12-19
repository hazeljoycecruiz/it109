<?php
session_start();

// Include or require the file where the database connection is established
include 'server.php'; // Update with the correct path

if (isset($_GET['logout'])) {
  session_destroy();
  unset($_SESSION['username']);
  header("location: login.php");
} elseif (isset($_GET['login']) || isset($_GET['register'])) {
  session_destroy();
  unset($_SESSION['username']);
}

if (!isset($_SESSION['username']) && basename($_SERVER['PHP_SELF']) !== 'login.php') {
  $_SESSION['msg'] = "You must log in first";
  header('location: login.php');
}

// Fetch entries from the database
$entries = []; // Initialize an empty array
// Replace the following code with your database query to fetch entries

$query = "SELECT entry_id, entry_title, created_at FROM entries";
$result = mysqli_query($db, $query);

while ($row = mysqli_fetch_assoc($result)) {
  $entries[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.example.com; style-src 'self' https://fonts.googleapis.com; img-src 'self' data: https://images.example.com;">



  <title>eJournal | View Entries</title>
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
        <span class="d-none d-lg-block"><?php echo htmlspecialchars('eJournal', ENT_QUOTES, 'UTF-8'); ?></span>
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
                  <span><?php echo htmlspecialchars('Sign Out', ENT_QUOTES, 'UTF-8'); ?></span>
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
          <span><?php echo htmlspecialchars('Home', ENT_QUOTES, 'UTF-8'); ?></span>
        </a>
      </li><!-- End Home Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="entries-data.php">
          <i class="bi bi-grid"></i>
          <span><?php echo htmlspecialchars('View Entries', ENT_QUOTES, 'UTF-8'); ?></span>
        </a>
      </li><!-- End Entries Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="new-entry.php">
          <i class="bi bi-file-earmark"></i>
          <span><?php echo htmlspecialchars('New Entry', ENT_QUOTES, 'UTF-8'); ?></span>
        </a>
      </li><!-- End New Entry Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?php echo htmlspecialchars('View Entries', ENT_QUOTES, 'UTF-8'); ?></h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">

              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col"><?php echo htmlspecialchars('Entry Title', ENT_QUOTES, 'UTF-8'); ?></th>
                    <th scope="col"><?php echo htmlspecialchars('Date Created', ENT_QUOTES, 'UTF-8'); ?></th>
                    <th scope="col"><?php echo htmlspecialchars('Actions', ENT_QUOTES, 'UTF-8'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($entries as $index => $entry) {
                    echo "<tr>";
                    echo "<th scope='row'>" . ($index + 1) . "</th>";
                    echo "<td>" . htmlspecialchars($entry['entry_title'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($entry['created_at'], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>";
                    echo "<button class='btn btn-danger' onclick='deleteEntry(" . $entry['entry_id'] . ")'>Delete</button>";
                    echo "<a href='edit-entry.php?id=" . $entry['entry_id'] . "' class='btn btn-primary'>Edit</a>";
                    echo "</td>";
                    echo "</tr>";
                  }
                  ?>

                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

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
  <script src="assets/js/main.js"></script>
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

  <!-- Add this JavaScript at the end of your HTML file -->
  <script>
    function deleteEntry(entryId) {
      if (confirm("Are you sure you want to delete this entry?")) {
        // Use AJAX to send a request to the server to delete the entry
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            // Reload the page after successful deletion
            location.reload();
          }
        };
        xhttp.open("POST", "server.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("delete_entry=1&id=" + entryId);
      }
    }
  </script>

</body>

</html>