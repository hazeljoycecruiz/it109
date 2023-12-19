<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.example.com; style-src 'self' https://fonts.googleapis.com; img-src 'self' data: https://images.example.com;">



  <title>e-Journal | Register</title>
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
                    <h5 class="card-title text-center pb-0 fs-4"><?php echo htmlspecialchars("Create an Account", ENT_QUOTES, 'UTF-8'); ?></h5>
                    <p class="text-center small"><?php echo htmlspecialchars("Enter your personal details to create an account", ENT_QUOTES, 'UTF-8'); ?></p>
                  </div>

                  <form method="post" action="register.php" class="row g-3 needs-validation" novalidate>
                    <?php include('errors.php'); ?>

                    <div class="col-12">
                      <label for="yourName" class="form-label"><?php echo htmlspecialchars("Username", ENT_QUOTES, 'UTF-8'); ?></label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>" id="yourName" required>
                        <div class="invalid-feedback"><?php echo htmlspecialchars("Please enter your name!", ENT_QUOTES, 'UTF-8'); ?></div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label"><?php echo htmlspecialchars("Email", ENT_QUOTES, 'UTF-8'); ?></label>
                      <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" id="yourEmail" required>
                      <div class="invalid-feedback"><?php echo htmlspecialchars("Please enter a valid email address!", ENT_QUOTES, 'UTF-8'); ?></div>
                    </div>

                    <div class="col-12">
                      <label for="yourName" class="form-label"><?php echo htmlspecialchars("Password", ENT_QUOTES, 'UTF-8'); ?></label>
                      <input type="password" name="password_1" class="form-control" id="password" required>
                      <p id="message"><?php echo htmlspecialchars("Password is", ENT_QUOTES, 'UTF-8'); ?> <span id="strength"></span></p>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label"><?php echo htmlspecialchars("Confirm Password", ENT_QUOTES, 'UTF-8'); ?></label>
                      <input type="password" name="password_2" class="form-control" id="confirmpassword" required>
                      <p id="message"><?php echo htmlspecialchars("Password does not match!", ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms"><?php echo htmlspecialchars("I agree and accept the", ENT_QUOTES, 'UTF-8'); ?> <a href="#"><?php echo htmlspecialchars("terms and conditions", ENT_QUOTES, 'UTF-8'); ?></a></label>
                        <div class="invalid-feedback"><?php echo htmlspecialchars("You must agree before submitting.", ENT_QUOTES, 'UTF-8'); ?></div>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="reg_user"><?php echo htmlspecialchars("Create Account", ENT_QUOTES, 'UTF-8'); ?></button>
                    </div>
                    <p class="small mb-0">
                      Do you already have an account? <a href="forgetpassword.php"><?php echo htmlspecialchars(" Log in", ENT_QUOTES, 'UTF-8'); ?></a>
                    </p>
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      let pass = document.getElementById("password");
      let msg = document.getElementById("message");
      let str = document.getElementById("strength");

      if (pass) {
        pass.addEventListener('input', function() {
          if (pass.value.length === 0) {
            msg.style.display = "none"; // Hide the message when the input is empty
          } else {
            msg.style.display = "block";
          }

          if (pass.value.length < 12) {
            str.innerHTML = "Weak";
            pass.style.borderColor = "#ff5925";
            msg.style.color = "#ff5925";
          } else if (pass.value.length >= 12 && pass.value.length < 20) {
            str.innerHTML = "Moderate";
            pass.style.borderColor = "green";
            msg.style.color = "green";
          } else if (pass.value.length >= 20) {
            str.innerHTML = "Strong";
            pass.style.borderColor = "#26d730";
            msg.style.color = "#26d730";
          }
        });
      }
    });
  </script>

</body>

</html>