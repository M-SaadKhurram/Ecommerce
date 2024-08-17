<?php
require('connection.inc.php');
require('function.inc.php');

// Check if files are present in the request
if ($_FILES['file']['name'] != '') {
    $file_names = '';
    $total = count($_FILES['file']['name']);
    $flag = true; // Initialize flag outside the loop

    for ($i = 0; $i < $total; $i++) {
        $filename = $_FILES['file']['name'][$i];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $valid_extension = array("png", "jpeg", "jpg");

        if (in_array($extension, $valid_extension)) {
            $new_name = rand() . "." . $extension;
            $path = "upload/" . $new_name; // Ensure correct path separator '/'
            if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $path)) {
                $file_names .= $new_name . ",";
            } else {
                echo "File upload failed: " . $_FILES['file']['error'][$i];
            }
            
        } else {
            $flag = false; // Set flag to false if an invalid extension is found
            break; // Break the loop if an invalid extension is found
        }
    }

    // Process form data only if files are uploaded successfully
    if ($flag && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
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

        // Remove the trailing comma and space from file_names if present
        $file_names = rtrim($file_names, ', ');

        // SQL query to insert the product into the database
       // ... (previous code remains the same)

// Prepare the SQL statement with placeholders
$sql = "INSERT INTO products (`title`, `description`, `price`, `compare_price`, `sku`, `track_qty`, `status`, `category_id`, `subcategory_id`, `brand_id`, `featured`, `image`) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

if ($stmt = mysqli_prepare($conn, $sql)) {
// Bind variables to the prepared statement as parameters
mysqli_stmt_bind_param($stmt, "ssssssssssss", $title, $description, $price, $comparePrice, $sku, $qty, $status, $category, $subcategory, $brand, $featured, $file_names);

// Attempt to execute the prepared statement
if (mysqli_stmt_execute($stmt)) {
echo '1';
} else {
echo '0';
}
mysqli_stmt_close($stmt);
} else {
echo "Error: Unable to prepare statement";
}

mysqli_close($conn);

    }
}
