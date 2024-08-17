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

<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <!-- Sidebar -->
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
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-xl-8">
            <!-- Hot Deals Products Section -->
            <div class="heading heading-flex heading-border mb-3">
                <div class="heading-left">
                    <h2 class="title">Products</h2>
                </div>
                <div class="heading-right">
                    <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="hot-all-link" data-toggle="tab" href="#hot-all-tab" role="tab" aria-controls="hot-all-tab" aria-selected="true">All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hot-elec-link" data-toggle="tab" href="#hot-elec-tab" role="tab" aria-controls="hot-elec-tab" aria-selected="false">Computers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hot-furn-link" data-toggle="tab" href="#hot-furn-tab" role="tab" aria-controls="hot-furn-tab" aria-selected="false">Laptops</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hot-clot-link" data-toggle="tab" href="#hot-clot-tab" role="tab" aria-controls="hot-clot-tab" aria-selected="false">Watches</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="hot-acc-link" data-toggle="tab" href="#hot-acc-tab" role="tab" aria-controls="hot-acc-tab" aria-selected="false">Accessories</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content">
                <!-- All Products Tab -->
                <div class="tab-pane fade show active" id="hot-all-tab" role="tabpanel" aria-labelledby="hot-all-link">
                    <div class="row">
                        <?php
                        // Fetch all products
                        $allProductsQuery = "SELECT * FROM products";
                        $allProductsResults = $conn->query($allProductsQuery);

                        if ($allProductsResults && $allProductsResults->num_rows > 0) {
                            while ($row = $allProductsResults->fetch_assoc()) {
                                $images = explode(',', $row['image']);
                                $firstImage = $images[0];
                        ?>
                                <div class="col-md-4">
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

                <!-- Computer Tab -->
                <div class="tab-pane fade" id="hot-elec-tab" role="tabpanel" aria-labelledby="hot-elec-link">
                    <div class="row">
                        <?php
                        // Fetch electronics products
                        $elecProductsQuery = "SELECT * FROM products WHERE category_id= 14";
                        $elecProductsResults = $conn->query($elecProductsQuery);

                        if ($elecProductsResults && $elecProductsResults->num_rows > 0) {
                            while ($row = $elecProductsResults->fetch_assoc()) {
                                $images = explode(',', $row['image']);
                                $firstImage = $images[0];
                        ?>
                                <div class="col-md-4">
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
                            echo "<p>No products found in Electronics.</p>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Laptop Tab -->
                <div class="tab-pane fade" id="hot-furn-tab" role="tabpanel" aria-labelledby="hot-furn-link">
                    <div class="row">
                        <?php
                        // Fetch furniture products
                        $furnProductsQuery = "SELECT * FROM products WHERE category_id= 17";
                        $furnProductsResults = $conn->query($furnProductsQuery);

                        if ($furnProductsResults && $furnProductsResults->num_rows > 0) {
                            while ($row = $furnProductsResults->fetch_assoc()) {
                                $images = explode(',', $row['image']);
                                $firstImage = $images[0];
                        ?>
                                <div class="col-md-4">
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
                            echo "<p>No products found in Furniture.</p>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Watches Tab -->
                <div class="tab-pane fade" id="hot-clot-tab" role="tabpanel" aria-labelledby="hot-clot-link">
                    <div class="row">
                        <?php
                        // Fetch Watches products
                        $clotProductsQuery = "SELECT * FROM products WHERE category_id= 11";
                        $clotProductsResults = $conn->query($clotProductsQuery);

                        if ($clotProductsResults && $clotProductsResults->num_rows > 0) {
                            while ($row = $clotProductsResults->fetch_assoc()) {
                                $images = explode(',', $row['image']);
                                $firstImage = $images[0];
                        ?>
                                <div class="col-md-4">
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
                            echo "<p>No products found in Clothes.</p>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Accessories Tab -->
                <div class="tab-pane fade" id="hot-acc-tab" role="tabpanel" aria-labelledby="hot-acc-link">
                    <div class="row">
                        <?php
                        // Fetch accessories products
                        $accProductsQuery = "SELECT * FROM products WHERE category_id= '14'";
                        $accProductsResults = $conn->query($accProductsQuery);

                        if ($accProductsResults && $accProductsResults->num_rows > 0) {
                            while ($row = $accProductsResults->fetch_assoc()) {
                                $images = explode(',', $row['image']);
                                $firstImage = $images[0];
                        ?>
                                <div class="col-md-4">
                                    <div class="product">
                                        <figure class="product-media">
                                            <a href='single.php?id=<?php echo htmlspecialchars($row["id"]); ?>'>
                                                <img src="upload/<?php echo htmlspecialchars($firstImage); ?>" alt="Product image" class="product-image">
                                            </a>

                                            <div class="product-action-vertical">
                                                <a href='#' class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                                <a href='#' class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                                <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                            </div>

                                            <div class="product-action">
                                                <a href='single.php?id=<?php echo htmlspecialchars($row["id"]); ?>' class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
                                            </div>
                                        </figure>

                                        <div class="product-body">
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
                            echo "<p>No products found in Accessories.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>


            <!-- Featured Products Widget -->
            <hr>
            <div class="sidebar sidebar-shop">
                <div class="widget widget-featured ">
                    <h3 class="widget-title">Best Seller</h3>
                    <div class="tab-content tab-content-carousel">
                        <div class="tab-pane p-0 fade show active" id="featured-products" role="tabpanel" aria-labelledby="featured-link">
                            <div class="owl-carousel owl-simple carousel-equal-height carousel-with-shadow" data-toggle="owl" data-owl-options='{
                                    "nav": true, 
                                    "dots": true,
                                    "margin": 20,
                                    "loop": false,
                                    "responsive": {
                                        "0": {
                                            "items":1
                                        },
                                        "480": {
                                            "items":1
                                        },
                                        "768": {
                                            "items":2
                                        },
                                        "992": {
                                            "items":3
                                        },
                                        "1280": {
                                            "items":4
                                        }
                                    }
                                }'>
                                <?php
                                // Fetch featured products
                                $featuredProductsQuery = "SELECT * FROM products WHERE featured = 1";
                                $featuredProductsResults = $conn->query($featuredProductsQuery);

                                if ($featuredProductsResults && $featuredProductsResults->num_rows > 0) {
                                    while ($row = $featuredProductsResults->fetch_assoc()) {
                                        $images = explode(',', $row['image']);
                                        $firstImage = $images[0];
                                ?>
                                        <div class="product ">
                                            <figure class="product-media">
                                                <span class="product-label label-sale">Best Seller</span>
                                                <a href='single.php?id=<?php echo htmlspecialchars($row["id"]); ?>'>
                                                    <img src="upload/<?php echo htmlspecialchars($firstImage); ?>" alt="Product image" class="product-image">
                                                </a>

                                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                        <div class="product-action">
                                                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['title']); ?>">
                                                            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($firstImage); ?>">
                                                            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($row['price']); ?>">

                                                            <input type="submit" class="btn-product submit_btn btn-primary " value="Add To Cart " name="add_to_cart">
                                                        </div>
                                                    </form>
                                                
                                            </figure>

                                            <div class="product-body">
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
                                <?php
                                    }
                                } else {
                                    echo "<p>No featured products available.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
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