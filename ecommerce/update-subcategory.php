<?php require('header.inc.php'); ?>

<?php
// Check if subcategory ID is provided via GET request
if (!isset($_GET['id'])) {
    header("Location: index.php"); // Redirect to your subcategory listing page
    exit();
}

// Fetch subcategory details based on ID
$subcategory_id = sanitizeInput($_GET['id']);
$sql = "SELECT * FROM sub WHERE id = $subcategory_id";
$result = $conn->query($sql);

// Check if subcategory exists
if ($result->num_rows === 0) {
    header("Location: index.php"); // Redirect to your subcategory listing page
    exit();
}

// Fetch category names for dropdown selection
$categoryQuery = "SELECT id, category_name FROM category";
$categoryResult = $conn->query($categoryQuery);

// Fetch existing subcategory details
$subcategoryData = $result->fetch_assoc();

// Handle form submission for updating subcategory
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve values from the form
    $name =($_POST['name']);
    $slug =($_POST['slug']);
    $category_id =($_POST['category_id']);
    $status =($_POST['status']);

    // Construct the SQL query
    $updateSql = "UPDATE sub SET subcategory_name = '$name', slug = '$slug', category_id = $category_id WHERE id = $subcategory_id";
    pr($name);
    // Execute the update query
    if ($conn->query($updateSql) === TRUE) {
        // Successful update - Redirect or perform further actions
        header("Location: subcategory.php");
        
        exit();
    } else {
        // Error handling if the update fails
        echo "Error updating subcategory: " . $conn->error;
    }
}
 

?>

<body class="hold-transition sidebar-mini">
    <?php require('sider.inc.php'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <h1>Update Subcategory</h1>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="container mt-5">
                            <h2>Update Subcategory</h2>
                            <form method="POST">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $subcategoryData['subcategory_name']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="slug">Slug:</label>
                                    <input type="text" class="form-control" id="slug" name="slug" value="<?php echo $subcategoryData['slug']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="category">Category:</label>
                                    <select class="form-control" id="category" name="category_id">
                                        <?php
                                        while ($row = $categoryResult->fetch_assoc()) {
                                            $selected = ($row['id'] == $subcategoryData['category_id']) ? 'selected' : '';
                                            echo "<option value='" . $row['id'] . "' $selected>" . $row['category_name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                


                                <button type="submit" class="btn btn-primary">Update Subcategory</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <?php
    require("footer.inc.php");
    $conn->close();
    ?>