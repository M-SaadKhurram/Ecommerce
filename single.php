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
        $product_qty = $_POST['qty'];
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

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID to ensure it is an integer
    if ($id <= 0) {
        echo "Invalid product ID.";
        exit();
    }

    // Use a prepared statement to fetch product details
    $stmt = $conn->prepare("SELECT p.*, b.brand_name FROM products p INNER JOIN brands b ON p.brand_id = b.id WHERE p.id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $images = explode(',', $row['image']); // Multiple images stored as a comma-separated string
        $firstImage = $images[0]; // First image
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

        <div class="page-content">
            <div class="container">
                <div class="product-details-top">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-gallery">
                                <figure class="product-main-image">
                                    <img id="product-zoom" src="upload/<?php echo htmlspecialchars($firstImage); ?>" data-zoom-image="upload/<?php echo htmlspecialchars($firstImage); ?>" alt="Product Image">
                                </figure>

                                <div id="product-zoom-gallery" class="product-image-gallery">
                                    <?php foreach ($images as $index => $image): ?>
                                        <a class="product-gallery-item <?php echo $index === 0 ? 'active' : ''; ?>" href="#" data-image="upload/<?php echo htmlspecialchars($image); ?>" data-zoom-image="upload/<?php echo htmlspecialchars($image); ?>">
                                            <img src="upload/<?php echo htmlspecialchars($image); ?>" alt="Product Image <?php echo $index + 1; ?>">
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="product-details">
                                <h1 class="product-title"><?php echo htmlspecialchars($row['title']); ?></h1>

                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: 80%;"></div>
                                    </div>
                                    <a class="ratings-text" href="#product-review-link" id="review-link">(2 Reviews)</a>
                                </div>

                                <div class="product-price">
                                    <span class="new-price">Rs <?php echo htmlspecialchars($row['price']); ?></span>
                                    <?php if (!empty($row['compare_price'])): ?>
                                        <span class="old-price"><del>Rs <?php echo htmlspecialchars($row['compare_price']); ?></del></span>
                                    <?php endif; ?>
                                </div>

                                <div class="product-content">
                                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                                </div>

                                <div class="product-details-action">
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id; ?>" method="post">
                                        <div class="input-group mb-3">
                                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($row['title']); ?>">
                                            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($firstImage); ?>">
                                            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($row['price']); ?>">
                                            <input type="number" class="form-control" id="qty" name="qty" value="1" min="1">
                                            <div class="input-group-append">
                                                <input type="submit" class="btn-product submit_btn btn-cart btn" value="Add To Cart" name="add_to_cart">
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>

                            <div class="product-details-footer">
                                <div class="social-icons social-icons-sm">
                                    <span class="social-label">Share:</span>
                                    <a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            

            <div class="product-details-tab">
                <ul class="nav nav-pills justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="product-desc-link" data-toggle="tab" href="#product-desc-tab" role="tab" aria-controls="product-desc-tab" aria-selected="true">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-shipping-link" data-toggle="tab" href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab" aria-selected="false">Shipping & Returns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="product-review-link" data-toggle="tab" href="#product-review-tab" role="tab" aria-controls="product-review-tab" aria-selected="false">Reviews (2)</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel" aria-labelledby="product-desc-link">
                        <div class="product-desc-content">
                            <?php echo htmlspecialchars($row['description']); ?>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel" aria-labelledby="product-shipping-link">
                        <div class="product-desc-content">
                            <h3>Delivery & Returns</h3>
                            <p>We deliver to over 100 countries around the world. For full details of the delivery options we offer, please view our <a href="#">Delivery Information</a><br>
                                We hope you’ll love every purchase, but if you ever need to return an item you can do so within a month of receipt. For full details of how to make a return, please view our <a href="#">Returns Information</a></p>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
                        <div class="reviews">
                            <h3>Reviews (2)</h3>
                            <div class="review">
                                <div class="row no-gutters">
                                    <div class="col-auto">
                                        <h4><a href="#">Samanta J.</a></h4>
                                        <div class="ratings-container">
                                            <div class="ratings">
                                                <div class="ratings-val" style="width: 80%;"></div>
                                            </div>
                                        </div>
                                        <span class="review-date">6 days ago</span>
                                    </div>
                                    <div class="col">
                                        <h4>Good, perfect size</h4>
                                        <div class="review-content">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus cum dolores assumenda asperiores facilis porro reprehenderit animi culpa atque blanditiis commodi perspiciatis doloremque, possimus, explicabo, autem fugit beatae quae voluptas!</p>
                                        </div>
                                        <div class="review-action">
                                            <a href="#"><i class="icon-thumbs-up"></i>Helpful (2)</a>
                                            <a href="#"><i class="icon-thumbs-down"></i>Unhelpful (0)</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        </div>

<?php
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid product ID.";
}
require('footer.php');
?>

<!-- Plugins JS File -->
<script src="frontend/assets/js/jquery.min.js"></script>
<script src="frontend/assets/js/bootstrap.bundle.min.js"></script>
<script src="frontend/assets/js/jquery.hoverIntent.min.js"></script>
<script src="frontend/assets/js/jquery.waypoints.min.js"></script>
<script src="frontend/assets/js/superfish.min.js"></script>
<script src="frontend/assets/js/owl.carousel.min.js"></script>
<script src="frontend/assets/js/bootstrap-input-spinner.js"></script>
<script src="frontend/assets/js/jquery.elevateZoom.min.js"></script>
<script src="frontend/assets/js/jquery.magnific-popup.min.js"></script>
<!-- Main JS File -->
<script src="assets/js/main.js"></script>

<script>
    $(document).ready(function() {
        // Initialize zoom effect
        $('#product-zoom').elevateZoom({
            zoomType: "inner",
            cursor: "crosshair",
            gallery: "product-zoom-gallery",
            galleryActiveClass: "active",
            imageCrossfade: true
        });

        // Show login error modal if needed
        <?php if ($loginError): ?>
            $('#loginErrorModal').modal('show');
        <?php endif; ?>
    });
</script>

<style>
.product-gallery {
    position: relative;
}

.product-main-image {
    position: relative;
}

.product-image-gallery {
    display: flex;
    flex-wrap: wrap;
    margin-top: 10px;
}

.product-image-gallery .product-gallery-item {
    margin-right: 5px;
}

.product-image-gallery .product-gallery-item img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    cursor: pointer;
}

.product-image-gallery .product-gallery-item.active img {
    border: 2px solid #007bff;
}

.product-main-image img {
    max-width: 100%;
    height: auto;
    display: block;
}

.product-gallery img {
    max-width: 100%;
    height: auto;
}
</style>
