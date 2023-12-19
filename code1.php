<?php
declare (strict_types=1);
require 'vendor/autoload.php';
$secret = 'XVQ2UIGO75XRUKJO';
$link = \Sonata\GoogleAuthenticator\GoogleQrUrl::generate('User', $secret, 'code');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <center><h2>Authentication</h2></center>
    <center><h4>Insert Password</h4></center>
    <center><img src="<?=$link;?>" alt=""></center>

</body>
</html>