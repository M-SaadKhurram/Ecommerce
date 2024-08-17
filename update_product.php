<?php
require('header.inc.php');
// Retrieve the product ID from the URL parameter
$productId = $_GET['id'];
$flag = false;

if ($productId !== '') {

    // Fetch product data based on the ID from the database
    $sql = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        // Handle if product is not found
        echo "product not found";
    }
} else {
    // Handle if product ID is not provided in URL
    echo "Invalid product ID";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = mysqli_real_escape_string($conn,  $_POST['description']);
    $price = $_POST['price'];
    $comparePrice = $_POST['compare_price'];
    $sku = $_POST['sku'];
    $qty = $_POST['qty'];
    $status = $_POST['status'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory_id'];
    $brand = $_POST['brand_id'];
    $featured = $_POST['featured'];

    // Assuming $productId is retrieved appropriately from the URL or fetched product data
    $updateQuery = "UPDATE products SET `title` = '$title', `description` = '$description', `price` =' $price', `compare_price` = '$comparePrice', `sku` = '$sku', `track_qty` = '$qty', `status` = '$status', `category_id` = '$category', `subcategory_id` = '$subcategory', `brand_id` = '$brand', `featured` = '$featured' WHERE `id` = '$productId'";

    // Execute the update query
    $result = $conn->query($updateQuery);


    if ($result) {
        // Handle successful update
        $flag = true;
        $message = "Product updated successfully!";
        // redirect('product.php');
        // Redirect or display a success message
    } else {
        // Handle update failure
        $error = "Error updating product: " . $conn->error;
    }
    if (!empty($_FILES['new_image']['name'][0])) {
        $targetDir = "upload/"; // Your upload directory
        $imageNames = array(); // Array to store uploaded image names

        foreach ($_FILES['new_image']['name'] as $key => $val) {
            // Check if the file is uploaded
            if ($_FILES['new_image']['error'][$key] === UPLOAD_ERR_OK) {
                $newImageName = rand() . '_' . basename($_FILES["new_image"]["name"][$key]);
                $targetFilePath = $targetDir . $newImageName;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                // Check if the file is an actual image
                $check = getimagesize($_FILES["new_image"]["tmp_name"][$key]);
                if ($check !== false) {
                    // Allow certain file formats
                    $allowedTypes = array("jpg", "jpeg", "png", "gif");
                    if (in_array($fileType, $allowedTypes)) {
                        // Check file size (adjust as needed)
                        if ($_FILES["new_image"]["size"][$key] < 5000000) { // 5MB limit
                            // Upload file to server
                            if (move_uploaded_file($_FILES["new_image"]["tmp_name"][$key], $targetFilePath)) {
                                // Add the new image name to the array
                                $imageNames[] = $newImageName;
                            } else {
                                $error = "Error uploading image";
                            }
                        } else {
                            $error = "File is too large. Maximum 5MB allowed";
                        }
                    } else {
                        $error = "Only JPG, JPEG, PNG, and GIF files are allowed";
                    }
                } else {
                    $error = "File is not an image";
                }
            } else {
                $error = "Error uploading image: " . $_FILES['new_image']['error'][$key];
            }
        }

        // Update database with the new image paths outside the loop
        if (!empty($imageNames)) {
            $imageNamesStr = implode(",", $imageNames);
            $updateImageQuery = "UPDATE products SET `image` = '$imageNamesStr' WHERE `id` = $productId";
            $result = $conn->query($updateImageQuery);
            if ($result) {
                $message = "Image updated successfully!";
                redirect('product.php');
            } else {
                $error = "Error updating image in the database";
            }
        }
    } else {
        if ($flag) {
            redirect('product.php');
        }
    }
}




$message = '';
$error = '';
// Fetch Category data from the database
$sql = "SELECT * FROM `category`";
$result = $conn->query($sql);

// Fetch Sub-Category data from the database
$sql2 = "SELECT * FROM `sub`";
$result2 = $conn->query($sql2);

// Fetch Brands data from the database
$sql3 = "SELECT * FROM `brands`";
$result3 = $conn->query($sql3);

?>

<body class="hold-transition sidebar-mini">
    <!-- Sidebar Content -->
    <?php
    require('sider.inc.php')
    ?>
    <!-- Main Content -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Product</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="product.php" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Title</label>
                                                <input type="text" name="title" id="title" class="form-control" value="<?php echo $product['title']; ?>" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="w-100" placeholder="Description"><?php echo $product['description']; ?></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
    <div class="card-body">
        <h2 class="h4 mb-3">Do you want to update images? If you update images, the current images will be deleted</h2>
        <div id="imageCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php
                $imageUrls = explode(',', $product['image']);
                $first = true; // To set the first image as active
                foreach ($imageUrls as $index => $image) {
                    // Output the HTML for each image
                ?>
                    <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                        <img src="upload/<?php echo $image; ?>" class="d-block" style="width: 150px;" alt="Product Image <?php echo $index; ?>">
                    </div>
                <?php
                    $first = false;
                }
                ?>
            </div>
            <!-- Add carousel control buttons -->
            <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Update Image</h2>
                                    <div id="image" class="" name="image">
                                        <div class="dz-message">
                                            <input type="file" name="new_image[]" multiple> <!-- Updated with multiple attribute -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Pricing</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" id="price" class="form-control" value="<?php echo $product['price']; ?>" placeholder="Price">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" name="compare_price" id="compare_price" class="form-control" value="<?php echo $product['compare_price']; ?>" placeholder="Compare Price">
                                                <p class="text-muted mt-3">
                                                    To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Inventory</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                                <input type="text" name="sku" id="sku" class="form-control" value="<?php echo $product['sku']; ?>" placeholder="sku">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="track_qty" name="track_qty" checked>
                                                    <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="number" min="0" name="qty" id="qty" class="form-control" value="<?php echo $product['track_qty']; ?>" placeholder="Qty">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="1" <?php if ($product['status'] == 1) echo 'selected'; ?>>Active</option>
                                            <option value="0" <?php if ($product['status'] == 0) echo 'selected'; ?>>Block</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="h4  mb-3">Product category</h2>
                                    <div class="mb-3">
                                        <label for="category">Category</label>
                                        <select name="category" id="category" class="form-control" required>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'";
                                                    if ($product['category_id'] == $row['id']) {
                                                        echo " selected";
                                                    }
                                                    echo ">" . $row['category_name'] . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No categories found</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="subcategory">Subcategory</label>
                                        <select name="subcategory_id" id="subcategory" class="form-control" required>
                                            <option value="0">Select Subcategory</option>
                                            <?php
                                            if ($result2->num_rows > 0) {
                                                while ($row = $result2->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'";
                                                    if ($product['subcategory_id'] == $row['id']) {
                                                        echo " selected";
                                                    }
                                                    echo ">" . $row['subcategory_name'] . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No subcategories found</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="brand">Brand</label>
                                <select name="brand_id" id="brand" class="form-control" required>
                                    <option value="0">Select Brand</option>
                                    <?php
                                    if ($result3->num_rows > 0) {
                                        while ($row = $result3->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'";
                                            if ($product['brand_id'] == $row['id']) {
                                                echo " selected";
                                            }
                                            echo ">" . $row['brand_name'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No brands found</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Featured product</h2>
                                    <div class="mb-3">
                                        <select name="featured" id="featured" class="form-control">
                                            <option value="0" <?php if ($product['featured'] == 0) echo 'selected'; ?>>No</option>
                                            <option value="1" <?php if ($product['featured'] == 1) echo 'selected'; ?>>Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-5 pt-3">
                        <button class="btn btn-primary" name="upload" type="submit">update</button>
                        <a href="product.php" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
            </div>
            </form>
            <?php if ($message) : ?>
                <p><?php echo $message; ?></p>
            <?php elseif ($error) : ?>
                <p><?php echo $error; ?></p>
            <?php endif; ?>
    </div>
    </section>
    <footer class="main-footer">

        <strong>Copyright &copy; 2014-2022 AmazingShop All rights reserved.
    </footer>
    </div>

    <!-- Bootstrap 4 -->
    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="assets/js/demo.js"></script>
    <!-- ./wrapper -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <!-- Summernote -->
    <script src="assets/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="assets/plugins/dropzone/dropzone.js"></script>
    <script src="assets/js/demo.js"></script>


</body>

</html>
<?php $conn->close(); ?>