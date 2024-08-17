<?php
require('connection.inc.php');
require('function.inc.php');
if ($_SESSION['ADMIN_LOGIN'] != 'yes' || !isset($_SESSION['ADMIN_Email'])) {
    header('location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Shop :: Administrative Panel</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">

    <!-- AdminLTE styles -->
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    
    <link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="assets/plugins/dropzone/dropzone.css">
    <!-- Your HTML content goes here -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <!-- Your custom scripts if any -->

<style>
    .wider-details {
    width: 600px; /* Adjust width as needed */
    height: 200px;
}

</style>


    
  </head>