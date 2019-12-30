<?php require_once 'includes/init.php';
if (isset($_SESSION['AdminId'])) {
    header('location:admin/');
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>ورود به مدیریت</title>
</head>

<body>
    <div class="contanier" style="width:40%;background: #fff;padding: 50px;margin: 120px auto;box-shadow: 0 0 3px #ccc;">
        <?php LoginCheck(); ?>
        <form action="" method="post">
            <input type="text" class="textbox" name="admin_username" placeholder="نام کاربری">
            <input type="text" class="textbox" name="admin_password" placeholder="رمز عبور">
            <br>
            <input type="submit" class="btn btn-success" name="Login" value="ورود به پنل مدیریت">

            <a href="index.php" class="btn btn-error">بازگشت</a>

        </form>
        <?php
        if (isset($_GET['Login'])) {
            echo '<p class="alert alert-error">نام کاربری و یا رمز عبور اشتباست</p>';
        }
        ?>
    </div>
</body>

</html>