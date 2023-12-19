<!-- edit-entry.php -->

<?php
session_start();
include 'server.php';

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = 'You must log in first';
    header('location: login.php');
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch entry details based on the ID
    $query = "SELECT * FROM entries WHERE id = '$id'";
    $result = mysqli_query($db, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $entry = mysqli_fetch_assoc($result);
    } else {
        echo 'Error: Entry not found.';
        exit();
    }
} else {
    echo 'Error: Entry ID not provided.';
    exit();
}

// Update the entry when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_content = mysqli_real_escape_string($db, $_POST['content']);

    // Update the entry in the database
    $update_query = "UPDATE entries SET entry_title = '$new_content' WHERE id = '$id'";
    mysqli_query($db, $update_query);

    echo 'Entry updated successfully!';
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
            <!-- Display the entry details in a form for editing -->
            <form method="post" action="edit-entry.php?id=<?php echo $id; ?>">
                <textarea name="content" class="text-editor" id="text-editor" style="width: 100%;"><?php echo $entry['entry_title']; ?></textarea>
                <button type="submit" class="btn btn-success">Save Changes</button>
            </form>
        </main>


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

</body>

</html>