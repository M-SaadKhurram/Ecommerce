<?php
require('header.inc.php');

// Assuming you have a database connection in connection.inc.php

// Retrieve the category ID from the URL parameter
if(isset($_GET['id'])) {
    $category_id = $_GET['id'];
    
    // Fetch category data based on the ID from the database
    $sql = "SELECT * FROM category WHERE id = $category_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
    } else {
        // Handle if category is not found
        echo "Category not found";
    }
} else {
    // Handle if category ID is not provided in URL
    echo "Invalid category ID";
}

// Update category in the database on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    // Retrieve other fields as needed

    // SQL update query
    $updateSql = "UPDATE category SET category_name='$name', slug='$slug' WHERE id = $category_id";

    if ($conn->query($updateSql) === TRUE) {
        // Redirect to category list or any other page after successful update
        header("Location: categories.php");
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
                <h1>Update Category</h1>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $category['category_name']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug:</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="<?php echo $category['slug']; ?>">
                            </div>
                            <!-- Other fields for category information -->

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
