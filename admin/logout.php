<?php
session_start();
session_destroy();
unset($_SESSION['AdminId']);
header('location:../Login.php');
?>