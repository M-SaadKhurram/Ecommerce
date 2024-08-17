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



<main class="main">
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


    <div class="intro-slider-container" style="margin-top: -6pc;">
        <div class="intro-slider owl-carousel owl-simple owl-nav-inside" data-toggle="owl" data-owl-options='{
                        "nav": false,
                        "responsive": {
                            "992": {
                                "nav": true
                            }
                        }
                    }'>
            <div class="intro-slide" style="background-image: url(frontend/assets/images/demos/demo-13/slider/slide-1.png);">
                <div class="container intro-content">
                    <div class="row">
                        <div class="col-auto offset-lg-3 intro-col">
                            <h3 class="intro-subtitle">Trade-In Offer</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title">MacBook Air <br>Latest Model
                                <span>
                                    <sup class="font-weight-light">from</sup>
                                    <span class="text-primary">$999<sup>,99</sup></span>
                                </span>
                            </h1><!-- End .intro-title -->

                            <a href="category.html" class="btn btn-outline-primary-2">
                                <span>Shop Now</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .col-auto offset-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->

            <div class="intro-slide" style="background-image: url(frontend/assets/images/demos/demo-13/slider/slide-2.jpg);">
                <div class="container intro-content">
                    <div class="row">
                        <div class="col-auto offset-lg-3 intro-col">
                            <h3 class="intro-subtitle">Trevel & Outdoor</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title">Original Outdoor <br>Beanbag
                                <span>
                                    <sup class="font-weight-light line-through">$89,99</sup>
                                    <span class="text-primary">$29<sup>,99</sup></span>
                                </span>
                            </h1><!-- End .intro-title -->

                            <a href="category.html" class="btn btn-outline-primary-2">
                                <span>Shop Now</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .col-auto offset-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->

            <div class="intro-slide" style="background-image: url(frontend/assets/images/demos/demo-13/slider/slide-3.jpg);">
                <div class="container intro-content">
                    <div class="row">
                        <div class="col-auto offset-lg-3 intro-col">
                            <h3 class="intro-subtitle">Fashion Promotions</h3><!-- End .h3 intro-subtitle -->
                            <h1 class="intro-title">Tan Suede <br>Biker Jacket
                                <span>
                                    <sup class="font-weight-light line-through">$240,00</sup>
                                    <span class="text-primary">$180<sup>,99</sup></span>
                                </span>
                            </h1><!-- End .intro-title -->

                            <a href="category.html" class="btn btn-outline-primary-2">
                                <span>Shop Now</span>
                                <i class="icon-long-arrow-right"></i>
                            </a>
                        </div><!-- End .col-auto offset-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container intro-content -->
            </div><!-- End .intro-slide -->
        </div><!-- End .owl-carousel owl-simple -->

        <span class="slider-loader"></span><!-- End .slider-loader -->
    </div><!-- End .intro-slider-container -->

    <div class="mb-4"></div><!-- End .mb-2 -->

    <div class="container">
        <h2 class="title text-center mb-2">Explore Popular Categories</h2><!-- End .title -->

        <div class="cat-blocks-container">
            <div class="row">
                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="category.html" class="cat-block">
                        <figure>
                            <span>
                                <img src="frontend/assets/images/demos/demo-13/cats/1.jpg" alt="Category image">
                            </span>
                        </figure>

                        <h3 class="cat-block-title">Computer & Laptop</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->

                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="category.html" class="cat-block">
                        <figure>
                            <span>
                                <img src="frontend/assets/images/demos/demo-13/cats/2.jpg" alt="Category image">
                            </span>
                        </figure>

                        <h3 class="cat-block-title">Lighting</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->

                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="category.html" class="cat-block">
                        <figure>
                            <span>
                                <img src="frontend/assets/images/demos/demo-13/cats/3.jpg" alt="Category image">
                            </span>
                        </figure>

                        <h3 class="cat-block-title">Smart Phones</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->

                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="category.html" class="cat-block">
                        <figure>
                            <span>
                                <img src="frontend/assets/images/demos/demo-13/cats/4.jpg" alt="Category image">
                            </span>
                        </figure>

                        <h3 class="cat-block-title">Televisions</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->

                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="category.html" class="cat-block">
                        <figure>
                            <span>
                                <img src="frontend/assets/images/demos/demo-13/cats/5.jpg" alt="Category image">
                            </span>
                        </figure>

                        <h3 class="cat-block-title">Cooking</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->

                <div class="col-6 col-sm-4 col-lg-2">
                    <a href="category.html" class="cat-block">
                        <figure>
                            <span>
                                <img src="frontend/assets/images/demos/demo-13/cats/6.jpg" alt="Category image">
                            </span>
                        </figure>

                        <h3 class="cat-block-title">Furniture</h3><!-- End .cat-block-title -->
                    </a>
                </div><!-- End .col-sm-4 col-lg-2 -->
            </div><!-- End .row -->
        </div><!-- End .cat-blocks-container -->
    </div><!-- End .container -->

    <div class="mb-2"></div><!-- End .mb-2 -->

    <?php

    // Define the query to fetch products based on category and subcategory
    $category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
    $subcategory = isset($_GET['subcategory']) ? mysqli_real_escape_string($conn, $_GET['subcategory']) : '';

    $query = "SELECT p.*, s.subcategory_name FROM products p 
        INNER JOIN sub s ON p.subcategory_id = s.id 
    ";

    if (!empty($category)) {
        $query .= " AND p.category_id IN (SELECT id FROM category WHERE category_name = '$category')";
    }

    if (!empty($subcategory)) {
        $query .= " AND p.subcategory_id IN (SELECT id FROM sub WHERE subcategory_name = '$subcategory')";
    }

    $results = $conn->query($query);
    ?>

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-xl-11">
                    <!-- Hot Deals Products Section -->
                    <div class="heading heading-flex heading-border mb-3">
                        <div class="heading-left">
                            <h2 class="title">Best Seller</h2>
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
                                // Fetch Computer products
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

                                                            <input type="submit" class="btn-product btn-cart btn" value="Add To Cart " name="add_to_cart">
                                                        </div>
                                                    </form>
                                                </figure>

                                                <div class="product-body">
                                                    <h3 class="product-title">
                                                        <a href="single.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                                    </h3>
                                                    <div class="product-price">
                                                        <span class="new-price">Rs<?php echo htmlspecialchars($row['price']); ?></span>
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
                                // Fetch Laptop products
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

                                                            <input type="submit" class="btn-product btn-cart btn" value="Add To Cart " name="add_to_cart">
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
                                // Fetch Watchrs products
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

                                                            <input type="submit" class="btn-product btn-cart btn" value="Add To Cart " name="add_to_cart">
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
                                $accProductsQuery = "SELECT * FROM products WHERE category_id= '18'";
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


                                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                        <div class="product-action">
                                                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['title']); ?>">
                                                            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($firstImage); ?>">
                                                            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($row['price']); ?>">

                                                            <input type="submit" class="btn-product btn-cart btn" value="Add To Cart " name="add_to_cart">
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
                                    echo "<p>No products found in Accessories.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                </div><!-- End .row -->
            </div><!-- End .container -->
        </div><!-- End .page-content -->
</main><!-- End .main -->
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