<?php
ob_start();
 require('newnav.php');

$loginError = "";

// Handle Add to Cart
if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_LOGIN'] != 'yes' || !isset($_SESSION['USER_Email'])) {
        $loginError = "You must be logged in to add items to your cart.";
    } else {
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_qty = 1;
        $user_email = $_SESSION['USER_Email'];

        // Get user ID based on email
        $user_result = mysqli_query($conn, "SELECT id FROM users WHERE email='$user_email'");
        $user_row = mysqli_fetch_assoc($user_result);
        $user_id = $user_row['id'];

        $insert_product = mysqli_query($conn, "INSERT INTO cart (`user_id`, `name`, `price`, `image`, `qty`) VALUES ('$user_id', '$product_name', '$product_price', '$product_image', '$product_qty')");
        header('Location: cart.php');
        exit();
    }
}

// Define the query to fetch products based on category and subcategory
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
$subcategory = isset($_GET['subcategory']) ? mysqli_real_escape_string($conn, $_GET['subcategory']) : '';

$query = "SELECT p.*, s.subcategory_name, c.category_name FROM products p 
    LEFT JOIN sub s ON p.subcategory_id = s.id 
    LEFT JOIN category c ON p.category_id = c.id WHERE p.status=1";

if (!empty($category)) {
    $query .= " AND c.category_name = '$category'";
}

if (!empty($subcategory)) {
    $query .= " AND s.subcategory_name = '$subcategory'";
}

$results = $conn->query($query);
?>

<div class="modal fade" id="loginErrorModal" tabindex="-1" role="dialog" aria-labelledby="loginErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginErrorModalLabel">Login Required</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if ($loginError): ?>
                        <p><?php echo htmlspecialchars($loginError); ?></p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <a href="login.php" target="_blank" class="btn btn-primary">Go to Login</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-9 col-xl-8">
                <?php if (!empty($category) || !empty($subcategory)) { ?>
                    <div class="mb-4">
                        <h2>
                            <?php 
                            if (!empty($category)) {
                                echo "" . htmlspecialchars($category); 
                            }
                            if (!empty($subcategory)) {
                                echo "" . htmlspecialchars($subcategory);
                            }
                            ?>
                        </h2>
                    </div>
                <?php } ?>
                
                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- All Products Tab -->
                    <div class="tab-pane fade show active" id="hot-all-tab" role="tabpanel" aria-labelledby="hot-all-link">
                        <div class="row">
                            <?php
                            if ($results && $results->num_rows > 0) {
                                while ($row = $results->fetch_assoc()) {
                                    $images = explode(',', $row['image']);
                                    $firstImage = $images[0];
                            ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="product">
                                            <figure class="product-media">
                                                <a href='single.php?id=<?php echo htmlspecialchars($row["id"]); ?>'>
                                                    <img src="upload/<?php echo htmlspecialchars($firstImage); ?>" alt="Product image" class="product-image">
                                                </a>

                                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                        <div class="product-action">
                                                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['title']); ?>">
                                                            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($firstImage); ?>">
                                                            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($row['price']); ?>">

                                                            <input type="submit" class="btn-product submit_btn btn-cart btn" value="Add To Cart " name="add_to_cart">
                                                        </div>
                                                    </form>
                                                
                                            </figure>

                                            <div class="product-body">
                                                <div class="product-cat">
                                                    <a href="#"><?php echo htmlspecialchars($row['subcategory_name']); ?></a>
                                                </div>
                                                <h3 class="product-title">
                                                    <a href="single.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                                </h3>
                                                <div class="product-price">
                                                    <span class="new-price">Rs  <?php echo htmlspecialchars($row['price']); ?></span>
                                                    <?php if (!empty($row['compare_price'])) { ?>
                                                        <span class="old-price"><del>$<?php echo htmlspecialchars($row['compare_price']); ?></del></span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<p>No products found.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="col-lg-3 col-xl-4 order-lg-first">
                <div class="sidebar sidebar-shop">
                    <!-- Categories Widget -->
                    <div class="widget widget-categories">
                        <h3 class="widget-title">Categories</h3>
                        <div class="widget-body">
                            <div class="accordion" id="widget-cat-acc">
                                <?php
                                // Fetch categories
                                $categorySql = "SELECT * FROM category";
                                $categoryResults = $conn->query($categorySql);
                                if ($categoryResults->num_rows > 0) {
                                    while ($categoryRow = $categoryResults->fetch_assoc()) {
                                        $categoryName = $categoryRow['category_name'];
                                        $categoryId = $categoryRow['id'];
                                ?>
                                        <div class="acc-item">
                                            <h5>
                                                <a href="category.php?category=<?php echo urlencode($categoryName); ?>" role="button" aria-expanded="true" aria-controls="collapse-<?php echo $categoryId; ?>">
                                                    <?php echo htmlspecialchars($categoryName); ?>
                                                </a>
                                            </h5>
                                            <div id="collapse-<?php echo $categoryId; ?>" class="collapse show" data-parent="#widget-cat-acc">
                                                <div class="collapse-wrap">
                                                    <ul>
                                                        <?php
                                                        // Fetch subcategories for the current category
                                                        $subSql = "SELECT * FROM sub WHERE category_id = '$categoryId'";
                                                        $subResults = $conn->query($subSql);
                                                        if ($subResults->num_rows > 0) {
                                                            while ($subRow = $subResults->fetch_assoc()) {
                                                                $subCategoryName = $subRow['subcategory_name'];
                                                        ?>
                                                                <li><a href="category.php?subcategory=<?php echo urlencode($subCategoryName); ?>"><?php echo htmlspecialchars($subCategoryName); ?></a></li>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <!-- Brands Widget -->
                    <div class="widget">
                        <h3 class="widget-title">Brands</h3>
                        <div class="widget-body">
                            <div class="filter-items">
                                <?php
                                // Fetch brands
                                $brandSql = "SELECT * FROM brands";
                                $brandResults = $conn->query($brandSql);
                                if ($brandResults->num_rows > 0) {
                                    while ($brandRow = $brandResults->fetch_assoc()) {
                                        $brandName = $brandRow['brand_name'];
                                        $brandId = $brandRow['id'];
                                ?>
                                        <div class="filter-item">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="brand-<?php echo $brandId; ?>" name="filter-brands[]" value="<?php echo htmlspecialchars($brandName); ?>">
                                                <label class="custom-control-label" for="brand-<?php echo $brandId; ?>"><?php echo htmlspecialchars($brandName); ?></label>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div>
            </aside>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Script to show modal if there's an error -->
<script>
    <?php if ($loginError): ?>
        $(document).ready(function() {
            $('#loginErrorModal').modal('show');
        });
    <?php endif; ?>
</script>
<?php
ob_end_flush();
require('footer.php');
?>