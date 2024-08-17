<?php
// require "connection.inc.php";
    session_start();
    // session_reset();
    unset($_SESSION['ADMIN_LOGIN']);
    unset($_SESSION['ADMIN_USERNAME']);
    unset($_SESSION['ROLE']);
    header('location:home.php');
    die();
?>