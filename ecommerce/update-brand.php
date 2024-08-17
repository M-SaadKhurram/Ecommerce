<?php
require('header.inc.php');

// Assuming you have a database connection in connection.inc.php

// Retrieve the brand ID from the URL parameter
if(isset($_GET['id'])) {
    $brand_id = $_GET['id'];
    
    // Fetch brand data based on the ID from the database
    $sql = "SELECT * FROM brands WHERE id = $brand_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $brand = $result->fetch_assoc();
    } else {
        // Handle if brand is not found
        echo "brand not found";
    }
} else {
    // Handle if brand ID is not provided in URL
    echo "Invalid brand ID";
}

// Update brand in the database on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['brand_id'])) {
    $brand_id = $_POST['brand_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $status=$_POST['status'];
    // Retrieve other fields as needed

    // SQL update query
    $updateSql = "UPDATE brands SET brand_name='$name', slug='$slug' WHERE id = $brand_id";

    if ($conn->query($updateSql) === TRUE) {
        // Redirect to brand list or any other page after successful update
        header("Location: brands.php");
        exit();
    } else {
        // Handle update query error
        echo "Error updating record: " . $conn->error;
    }
}
?>

<body class="hold-transition sidebar-mini">
    <?php require('sider.inc.php'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <h1>Update brand</h1>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="brand_id" value="<?php echo $brand['id']; ?>">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $brand['brand_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug:</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="<?php echo $brand['slug']; ?>">
                            </div>
                           
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php
    require("footer.inc.php");
    $conn->close();
    ?>
