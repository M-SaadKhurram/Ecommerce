<?php
session_start(); // Start session if needed

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecom";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
