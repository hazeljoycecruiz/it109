<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.example.com; style-src 'self' https://fonts.googleapis.com; img-src 'self' data: https://images.example.com;">


  <title>e-Journal | Login</title>
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



<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/notebook.jpg" alt="">
                  <span class="d-none d-lg-block">e-Journal</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">
                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">
                      <?php echo htmlspecialchars("Login to Your Account", ENT_QUOTES, 'UTF-8'); ?>
                    </h5>
                    <p class="text-center small">
                      <?php echo htmlspecialchars("Enter your username & password to login", ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                  </div>

                  <form method="post" action="login.php" class="row g-3 needs-validation" novalidate>
                    <?php include('errors.php'); ?>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">
                        <?php echo htmlspecialchars("Username", ENT_QUOTES, 'UTF-8'); ?>
                      </label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">
                          <?php echo htmlspecialchars("Please enter your username.", ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">
                        <?php echo htmlspecialchars("Password", ENT_QUOTES, 'UTF-8'); ?>
                      </label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">
                        <?php echo htmlspecialchars("Please enter your password!", ENT_QUOTES, 'UTF-8'); ?>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                          <?php echo htmlspecialchars("Remember me", ENT_QUOTES, 'UTF-8'); ?>
                        </label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="login_user" type="submit">
                        <?php echo htmlspecialchars("Login", ENT_QUOTES, 'UTF-8'); ?>
                      </button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">
                        <?php echo htmlspecialchars("Don't have an account?", ENT_QUOTES, 'UTF-8'); ?>
                        <a href="register.php"><?php echo htmlspecialchars("Create an account", ENT_QUOTES, 'UTF-8'); ?></a>
                      </p>
                      <p class="small mb-0">
                        <a href="forgetpassword.php"><?php echo htmlspecialchars("Forget Password?", ENT_QUOTES, 'UTF-8'); ?></a>
                      </p>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
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

</body>

</html>