<?php
require('header.inc.php');

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $slug = $_POST['slug'];

    // Check if the brand name already exists
    $checkSql = "SELECT * FROM brands WHERE `brand_name`='$name'";
    $checkResult = mysqli_query($conn, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Brand name already exists!');</script>";
    } else {
        // Brand name is unique, proceed with insertion
        $insertSql = "INSERT INTO brands (`brand_name`, `slug`) VALUES ('$name','$slug')";
        $result = mysqli_query($conn, $insertSql);

        if ($result) {
            $message = "Brand created successfully!";
            redirect('brands.php');
        } else {
            $error = "Error: " . $insertSql . "<br>" . $conn->error;
        }
    }
}
?>

<body class="hold-transition sidebar-mini">
    <?php require('sider.inc.php'); ?>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Create Brand</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="Brands.php" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary my-2" type="submit">Create</button>
                            <a href="brands.php" class="btn btn-outline-dark ml-3">Cancel</a>
                        </form>
                        <?php if ($message): ?>
                            <p><?php echo $message; ?></p>
                        <?php elseif ($error): ?>
                            <p><?php echo $error; ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php
require("footer.inc.php");
$conn->close();
?>

