<?php
require('header.inc.php');

// Fetch data from the database
$sql = "SELECT * FROM `category`";
$result = $conn->query($sql);

// Handling form submission to store selected category
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $category = $_POST['category'];

    // Check if the subcategory name is unique before insertion
    $checkSql = "SELECT * FROM sub WHERE subcategory_name = '$name'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult && $checkResult->num_rows > 0) {
        echo "<script>alert('Error: Subcategory name already exists!');</script>";
    } else {
        $sql = "INSERT INTO sub (`subcategory_name`, `slug`, `category_id`) VALUES ('$name', '$slug', $category)";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<script>alert('SubCategory created successfully!');</script>";
            redirect('subcategory.php');
        } else {
            echo "<script>alert('Error creating subcategory: " . $conn->error . "');</script>";
        }
    }

    $conn->close();
}
?>

<body class="hold-transition sidebar-mini">
    <?php require('sider.inc.php'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Sub-Category</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="subcategory.php" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </section>

        <div class="card">
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" required>
                            </div>
                        </div>
                    </div>
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
                    <button type="submit" class="btn btn-primary my-3">Save</button>
                </form>
            </div>
        </div>
    </div>

    footer class="main-footer">

    <strong>Copyright &copy; 2014-2022 AmazingShop All rights reserved.
        </footer>

        </div>
        <!-- ./wrapper -->
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable();
            });
        </script>
        <!-- Bootstrap 4 -->
        <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="assets/js/adminlte.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="assets/js/demo.js"></script>


        <script>
            <?php
            if ($message) {
                echo "alert('$message');";
            }
            if ($error) {
                echo "alert('$error');";
            }
            ?>
        </script>
</body>

</html>
<?php
$conn->close();
?>