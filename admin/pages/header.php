<?php require_once '../includes/init.php';
if (!isset($_SESSION['AdminId'])) {
    header('location:../Login.php');
}
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/style.css">
        <title>وبلاگ من</title>
    </head>
    <body>
    <div class="header"> <!-- start header-->
        <div class="contanier"><!-- start contanier-->
            <ul class="menu">
                <li><a target="_blank" href="../">مشاهده سایت</a></li>
                <li class="logo"><a href="./"><img src="../images/weblogo.png"></a></li>
            </ul>
            <div class="clear"></div>
        </div><!-- end contanier-->
        <div class="clear"></div>
    </div><!-- end header-->
<?php
//var_dump($_SERVER['SCRIPT_FILENAME']);
//?>