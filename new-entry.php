<?php
session_start();
include 'server.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo "Form submitted";
  $entry_title = mysqli_real_escape_string($db, $_POST['entry_title']);
  $content = mysqli_real_escape_string($db, $_POST['content']);
  echo "Entry title: $entry_title, Content: $content";


  // Check if the entry title exists in the entries table
  $check_query = "SELECT * FROM entries WHERE entry_title = '$entry_title'";
  $result = mysqli_query($db, $check_query);

  if (mysqli_num_rows($result) > 0) {
    // If entry title exists, update the content
    $update_query = "UPDATE entries SET content = '$content' WHERE entry_title = '$entry_title'";
    mysqli_query($db, $update_query);
    echo "Entry updated successfully!";
  } else {
    // If entry title doesn't exist, insert a new entry
    if (isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
      $journal_id = getJournalId($db, $user_id);

      if ($journal_id !== null) {
        $insert_query = "INSERT INTO entries (journal_id, entry_title, content, created_at) VALUES ('$journal_id', '$entry_title', '$content', NOW())";
        mysqli_query($db, $insert_query);
        echo "New entry created successfully!";
      } else {
        echo "Error: Journal ID not found for the user.";
      }
    } else {
      echo "Error: User ID not found in the session.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.example.com; style-src 'self' https://fonts.googleapis.com; img-src 'self' data: https://images.example.com;">

  <title>eJournal | New Entry</title>
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

  <!-- Include stylesheet -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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
          </a>
          <!-- End Profile Image Icon -->
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
        <a class="nav-link collapsed" href="entries-data.php">
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
    <div class="pagetitle">
      <h1>eJournal</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Create New Entry</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <form method="post" action="new-entry.php">
        <div class="jtitle text-center">
          <div class="col ms-5">
            <textarea id="entry_title" name="entry_title" class="textarea bi bi-star-fill" style="width: 100%;" placeholder="Entry Title"></textarea>

            <!-- Move the prompt div here -->
            <div id="prompt" class="mt-3 text-center fs-5 fw-bold"></div>
            <!-- Replace the button with a clickable icon -->
            <div id="generatePromptBtn" class="btn mt-3" style="padding: 5px;">
              <button type="button" class="btn btn-outline-primary">
                <i class="bi bi-balloon-heart"></i>
              </button>
            </div>

            <div id="text-editor" class="text-editor">
              <textarea name="content" placeholder="Your text here"></textarea>
            </div>

            <button type="submit" name="submit_entry" class="btn btn-success">Save Entry</button>


          </div>
        </div>
      </form>
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

  <!-- Include the Quill library -->
  <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Quill initialization
      const quill = new Quill("#text-editor", {
        modules: {
          toolbar: {
            container: [
              [{
                header: [1, 2, 3, 4, false]
              }],
              ["bold", "italic", "underline"],
              ["link", "image", "blockquote", "code-block"],
              [{
                list: "ordered"
              }, {
                list: "bullet"
              }],
            ],
            handlers: {
              image: selectLocalImage, // Make sure selectLocalImage is defined
            },
          },
        },
        placeholder: "",
        theme: "snow",
      });

      // Additional functionality from main2.js
      function selectLocalImage() {
        // Your implementation for handling local image selection
      }
    });

    var theme = document.getElementById("theme");

    theme.onclick = function() {
      document.body.classList.toggle("dark-theme");
      if (document.body.classList.contains("dark-theme")) {
        theme.src = "assets/img/sun.jpg";
      } else {
        theme.src = "assets/img/moon.jpg";
      }
    }



    document.addEventListener('DOMContentLoaded', function() {
      var prompts = [
        "“First ask yourself: What is the worst that can happen? Then prepare to accept it. Then proceed to improve on the worst.” - DALE CARNEGIE",
        "“Do not wait for leaders; do it alone, person to person.” - MOTHER TERESA",
        "“Success is not final, failure is not fatal: It is the courage to continue that counts.” - WINSTON CHURCHILL",
        "“The only way to do great work is to love what you do.” - STEVE JOBS",
        "“Your work is going to fill a large part of your life, and the only way to be truly satisfied is to do what you believe is great work.” - STEVE JOBS",
        "“In three words I can sum up everything I've learned about life: it goes on.” - ROBERT FROST",
        "“The only limit to our realization of tomorrow will be our doubts of today.” - FRANKLIN D. ROOSEVELT",
      ];

      function generatePrompt() {
        var randomPrompt = prompts[Math.floor(Math.random() * prompts.length)];
        document.getElementById('prompt').innerHTML = '<div class="fancy-prompt text-lg">' + randomPrompt + '</div>';
      }

      document.getElementById('generatePromptBtn').addEventListener('click', function() {
        generatePrompt();
      });
    });
  </script>
</body>

</html>