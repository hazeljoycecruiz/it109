<?php
declare(strict_types=1);
$errors = array();

session_start();

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

require 'vendor/autoload.php';
$secret = 'XVQ2UIGO75XRUKJO';
$link = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate('user', $secret, 'eJournal');
$g = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();



if(isset($_POST['authentication'])){
  $code = htmlspecialchars($_POST['pass-code'], ENT_QUOTES, 'UTF-8');

  if ($g->checkCode($secret, $code)) {
      header("location: index.php");
  } else {
      array_push($errors, "Wrong Code Try Again");
  }
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" type="text/css" href="codestyle.css">
  <script src="script.js"></script>
  <title>Two-Factor Authentication</title>
</head>

<body>
  <div class="container">
    <form action="code.php"  method= "post" class="form-horizontal" id="form">
      <h1>
      <center><?php include('errors.php'); ?></center> 
      </h1>
   

      <h1>TWO-FACTOR AUTHENTICATION</h1>
      <center><img src="<?= htmlspecialchars($link, ENT_QUOTES, 'UTF-8'); ?>" alt=""></center>
      
    
      
      <br>
      <br>
      <h3>Enter the Code</h3>

      
      <div class="input">
        <input name="pass-code" placeholder="Enter Code">
      </div>

      <div class="form__buttons">
        <button type="submit" value="Login"  name="authentication" class="button--primary">Log In</button>
      </div>

    </form>
  </div>
  <script src="script.js"></script>
</body>

</html>


<!-- <form action=""  method= "post" class="form-horizontal" id="form">
       <div class="input ">
        <input name="pass-code" placeholder="Enter Code">
      </div> 
      <div class="form-group">
        <div class="input-group">
          <div class= "input-group-addon addon-diff-color">
            <span class = "glyphicon glyphicon-lock"></span>
          </div> 
          <input type="text" autocomplete = "off" class = "form-control"
           name="pass-code" placeholder="Enter Code">
        </div>
         <input name="pass-code" placeholder="Enter Code"> 
      </div>

      <div class = "form-group"> 
        <input type="submit" value="Login" class="btn btn-warning btn-block" name="submit">
      </div>

       <div class="form__buttons">

      <input type="submit" value="Login" class = "button button--primary" name = "submit" >
        
      </div> -->