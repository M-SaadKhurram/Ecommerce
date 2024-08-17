<?php
require('header.inc.php');

// Initialize variables
$category = null;
$errorMessage = "";

// Retrieve the category ID from the URL parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $category_id = intval($_GET['id']);
    
    // Fetch category data based on the ID from the database
    $sql = "SELECT * FROM category WHERE id = $category_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
    } else {
        // Handle if category is not found
        $errorMessage = "Category not found";
    }
} else {
    // Handle if category ID is not provided or is invalid in URL
    $errorMessage = "Invalid category ID";
}

// Update category in the database on form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $status = $_POST['status'];
    // Retrieve other fields as needed

    // SQL update query
    $updateSql = "UPDATE category SET category_name='$name', slug='$slug', status='$status' WHERE id = $category_id";

    if ($conn->query($updateSql) === TRUE) {
        // Redirect to category list or any other page after successful update
        header("Location: categories.php");
        exit();
    } else {
        // Handle update query error
        $errorMessage = "Error updating record: " . $conn->error;
    }
}
?>

<body class="hold-transition sidebar-mini">
    <?php require('sider.inc.php'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <h1>Update Category</h1>
                <?php if ($errorMessage): ?>
                    <div class="alert alert-danger">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <?php if ($category): ?>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $category['id']); ?>">
                            <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="slug">Slug:</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="<?php echo htmlspecialchars($category['slug']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="1" <?php echo ($category['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?php echo ($category['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                            <!-- Other fields for category information -->

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php
    require("footer.inc.php");
    ?>

