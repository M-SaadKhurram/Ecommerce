<?php
require('header.inc.php');

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
                        <h1>Create Product</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="product.php" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <form method="post" enctype="multipart/form-data>">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="title">Title</label>
                                                <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="w-100" placeholder="Description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Media</h2>
                                    <div id="image" class="dropzone dz-clickable" name="image">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
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
                                                <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
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
                                                <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
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
                                                <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">
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
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
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
                                            <option value="0">Select Category</option>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'>";
                                                    echo $row['category_name'];
                                                    echo "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No categories found</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category">Sub category</label>
                                        <select name="subcategory" id="subcategory" class="form-control" required>
                                            <option value="0">Select Sub-Category</option>
                                            <?php
                                            if ($result2->num_rows > 0) {
                                                while ($row = $result2->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'>";
                                                    echo $row['subcategory_name'];
                                                    echo "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No categories found</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product brand</h2>
                                    <div class="mb-3">
                                        <select name="brand" id="brand" class="form-control" required>
                                            <option value="0">Select brand</option>
                                            <?php
                                            if ($result3->num_rows > 0) {
                                                while ($row = $result3->fetch_assoc()) {
                                                    echo "<option value='" . $row['id'] . "'>";
                                                    echo $row['brand_name'];
                                                    echo "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No categories found</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Featured product</h2>
                                    <div class="mb-3">
                                        <select name="featured" id="featured" class="form-control">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pb-5 pt-3">
                        <button class="btn btn-primary" id="save" name="upload">Create</button>
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
    <script>
        Dropzone.autoDiscover = false;
        $(function() {
            // Summernote
            $('.summernote').summernote({
                height: '300px'
            });



            // Initialize Dropzone
            const dropzone = new Dropzone("#image", {
                url: "insert-product.php",
                parallelUploads: 5,
                uploadMultiple: true,
                autoProcessQueue: false,
                acceptedFiles: "image/jpeg, image/png, image/gif"
            });

            // Attaching the sending event to modify the form data
            dropzone.on("sending", function(file, xhr, formData) {
                formData.append('title', $('#title').val());
                formData.append('description', $('#description').val());
                formData.append('price', $('#price').val());
                formData.append('compare_price', $('#compare_price').val());
                formData.append('sku', $('#sku').val());
                formData.append('qty', $('#qty').val());
                formData.append('status', $('#status').val());
                formData.append('category', $('#category').val());
                formData.append('subcategory', $('#subcategory').val());
                formData.append('brand', $('#brand').val());
                formData.append('featured', $('#featured').val());
                // Add other form data as needed
            });

            // Handling the success event after file upload
            dropzone.on("success", function(file, response) {
                if (response = '1') {
                    alert('Image saved');
                } else {
                    alert('Unable to save image');
                }
            });

            // Trigger file upload when the 'Save' button is clicked
            $('#save').click(function() {
                dropzone.processQueue(); // Initiates the file upload process
            });
        });
    </script>
</body>
</html>
<?php $conn->close();?>