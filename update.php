<?php
require('connection.inc.php');
require('function.inc.php');
$id=$_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$comparePrice = $_POST['compare_price'];
$sku = $_POST['sku'];
$qty = $_POST['qty'];
$status = $_POST['status'];
$category = $_POST['category'];
$subcategory = $_POST['subcategory'];
$brand = $_POST['brand'];
$featured = $_POST['featured'];
if ($id!='') {
echo '1';
}else{
    echo '0';
}