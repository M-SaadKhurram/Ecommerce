
<?php
require('header.inc.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    // Assuming you have a function to safely sanitize input (e.g., for an integer)
    $product_id = sanitizeInput($_POST['product_id']);

    // Perform deletion
    $deleteSql = "DELETE FROM products WHERE id = '$product_id'"; // Corrected syntax here
    if ($conn->query($deleteSql) === TRUE) {
        // Deletion successful
        // Redirect to the same page after deletion (refreshing the category list)
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Error handling if deletion fails
        echo "Error deleting record: " . $conn->error;
    }
}
?>



<body class="hold-transition sidebar-mini">
 <?php 
 require('sider.inc.php')
 ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="newproduct.php" class="btn btn-primary">New Product</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">

                <div class="card border">

                    <div class="card-body table-responsive p-2">
                        <table id="myTable" class="table data-table ">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Product_Id</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Compare_price</th>
                                    <th>Stock_Keeping_Unit</th>
                                    <th>Quantity</th>
                                    <th>Category</th>
                                    <th>Sub_Category</th>
                                    <th>Brand</th>
                                    <th>Featured</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Image</th>
                                    <th>Status</th>

                                    <th>Action</th>
                                    <!-- Inside the table body -->
                            <!-- Previous HTML code remains unchanged -->

<tbody>
    <?php
    // Fetching all rows and columns data
    $sql_data = "SELECT 
    p.*, 
    c.category_name, 
    s.subcategory_name, 
    b.brand_name 
 FROM products p 
 LEFT JOIN category c ON p.category_id = c.id 
 LEFT JOIN sub s ON p.subcategory_id = s.id 
 LEFT JOIN brands b ON p.brand_id = b.id";

$result_data = $conn->query($sql_data);
$sno = 1;

    if ($result_data->num_rows > 0) {
        while ($row_data = $result_data->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $sno . "</td>";
            $sno++; 
            echo "<td>" . $row_data['id'] . "</td>";
            echo "<td>" . $row_data['title'] . "</td>";
            echo "<td>" . $row_data['price'] . "</td>";
            echo "<td>" . $row_data['compare_price'] . "</td>";
            echo "<td>" . $row_data['sku'] . "</td>";
            echo "<td>" . $row_data['track_qty'] . "</td>";
            echo "<td>" . $row_data['category_name'] . "</td>"; // Display category name
            echo "<td>" . $row_data['subcategory_name'] . "</td>"; // Display subcategory name
            echo "<td>" . $row_data['brand_name'] . "</td>"; // Display brand name
            echo "<td>" . $row_data['featured'] . "</td>";
            echo "<td>" . $row_data['created_at'] . "</td>";
            echo "<td>" . $row_data['updated_at'] . "</td>";
            
            echo "<td>";
            // Fetch the images for the current product and create a carousel
            $imageUrls = explode(',', $row_data['image']); // Assuming the images are stored as comma-separated URLs
            echo '<div id="carousel_' . $row_data['id'] . '" class="carousel slide" data-ride="carousel">';
            echo '<div class="carousel-inner">';
            foreach ($imageUrls as $index => $image) {
                echo '<div class="carousel-item' . ($index === 0 ? ' active' : '') . '">';
                echo '<img src="upload/' . $image . '" class="d-block" alt="Product Image" style="width: 150px;">';
                echo '</div>';
            }
            echo '</div>';
            echo '<a class="carousel-control-prev" href="#carousel_' . $row_data['id'] . '" role="button" data-slide="prev">';
            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Previous</span>';
            echo '</a>';
            echo '<a class="carousel-control-next" href="#carousel_' . $row_data['id'] . '" role="button" data-slide="next">';
            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Next</span>';
            echo '</a>';
            echo '</div>';
            echo "</td>";

            echo "<td>";
            if ($row_data['status'] == '1') {
                echo "
                    <svg class='text-success-500 h-6 w-6 text-success' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' aria-hidden='true'>
                        <path stroke-linecap='round' stroke-linejoin='round' d='M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'></path>
                    </svg>
                ";
            } else {
                echo "
                    <svg class='text-danger h-6 w-6' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' aria-hidden='true'>
                        <path stroke-linecap='round' stroke-linejoin='round' d='M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'></path>
                    </svg>
                ";
            }
            echo"</td>";

            // Update and Delete actions
            echo "<td>";
            echo "<a href='update_product.php?id=" . $row_data["id"] . "' class='btn btn-sm btn-info my-2'>";
            echo "<svg class='filament-link-icon w-4 h-4 mr-1 icon-spacing' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                    <path d='M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z'></path>
                </svg>";
            echo "Update</a>";

            // Delete form for each product
            echo "<form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>";
            echo "<input type='hidden' name='product_id' value='" . $row_data["id"] . "'>";
            echo "<button type='submit' class='text-danger' onclick=\"return confirm('Are you sure you want to delete this Product?');\">
                    <svg class='filament-link-icon w-4 h-4 mr-1' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'>
                        <path fill-rule='evenodd' d='M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z' clip-rule='evenodd'></path>
                    </svg>
                    Delete</button>";
            echo "</form>";

            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='15'>No data found</td></tr>";
    }
    ?>
</tbody>

<!-- Rest of the HTML code remains unchanged -->



                        </table>


                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php
    require("footer.inc.php");
    $conn->close(); ?>
    <!-- /.content-wrapper -->