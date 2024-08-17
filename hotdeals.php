<div class="col-lg-9 col-xl-8">
                    <!-- Hot Deals Products Section -->
                    <div class="heading heading-flex heading-border mb-3">
                        <div class="heading-left">
                            <h2 class="title">Hot Deals Products</h2>
                            <!-- End .title -->
                        </div>
                        <!-- End .heading-left -->

                        <div class="heading-right">
                            <ul class="nav nav-pills nav-border-anim justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="hot-all-link" data-toggle="tab" href="#hot-all-tab" role="tab" aria-controls="hot-all-tab" aria-selected="true">All</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="hot-elec-link" data-toggle="tab" href="#hot-elec-tab" role="tab" aria-controls="hot-elec-tab" aria-selected="false">Electronics</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="hot-furn-link" data-toggle="tab" href="#hot-furn-tab" role="tab" aria-controls="hot-furn-tab" aria-selected="false">Shoes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="hot-clot-link" data-toggle="tab" href="#hot-clot-tab" role="tab" aria-controls="hot-clot-tab" aria-selected="false">Clothes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="hot-acc-link" data-toggle="tab" href="#hot-acc-tab" role="tab" aria-controls="hot-acc-tab" aria-selected="false">Accessories</a>
                                </li>
                            </ul>
                        </div><!-- End .heading-right -->
                    </div><!-- End .heading -->

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

                                                    <div class="product-action-vertical">
                                                        <a href='#' class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                                        <a href='#' class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>
                                                        <a href="popup/quickView.html" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                                                    </div><!-- End .product-action-vertical -->

                                                    <div class="product-action">
                                                        <a href='single.php?id=<?php echo htmlspecialchars($row["id"]); ?>' class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
                                                    </div><!-- End .product-action -->
                                                </figure><!-- End .product-media -->

                                                <div class="product-body">

                                                    <h3 class="product-title">
                                                        <a href="single.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                                    </h3><!-- End .product-title -->
                                                    <div class="product-price">
                                                        <span class="new-price">$<?php echo htmlspecialchars($row['price']); ?></span>
                                                        <?php if (!empty($row['compare_price'])) { ?>
                                                            <span class="old-price"><del>$<?php echo htmlspecialchars($row['compare_price']); ?></del></span>
                                                        <?php } ?>
                                                    </div><!-- End .product-price -->
                                                </div><!-- End .product-body -->
                                            </div><!-- End .product -->
                                        </div><!-- End .col-md-4 -->
                                <?php
                                    } // Closing brace for while loop
                                } else {
                                    echo "<p>No products found.</p>";
                                }
                                ?>
                            </div><!-- End .row -->
                        </div><!-- End .tab-pane -->

                        <!-- Electronics Tab -->
                        <div class="tab-pane fade" id="hot-elec-tab" role="tabpanel" aria-labelledby="hot-elec-link">
                            <div class="row">
                                <?php
                                // Fetch electronics products
                                $electronicsQuery = "SELECT * FROM products WHERE category_id = 14"; // Adjust category_id for Electronics
                                $cat14Results = $conn->query($electronicsQuery);

                                if ($cat14Results && $cat14Results->num_rows > 0) {
                                    while ($row = $cat14Results->fetch_assoc()) {
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
                                                    </div><!-- End .product-action-vertical -->

                                                    <div class="product-action">
                                                        <a href='single.php?id=<?php echo htmlspecialchars($row["id"]); ?>' class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
                                                    </div><!-- End .product-action -->
                                                </figure><!-- End .product-media -->

                                                <div class="product-body">

                                                    <h3 class="product-title">
                                                        <a href="single.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                                    </h3><!-- End .product-title -->
                                                    <div class="product-price">
                                                        <span class="new-price">$<?php echo htmlspecialchars($row['price']); ?></span>
                                                        <?php if (!empty($row['compare_price'])) { ?>
                                                            <span class="old-price"><del>$<?php echo htmlspecialchars($row['compare_price']); ?></del></span>
                                                        <?php } ?>
                                                    </div><!-- End .product-price -->
                                                </div><!-- End .product-body -->
                                            </div><!-- End .product -->
                                        </div><!-- End .col-md-4 -->
                                <?php
                                    } // Closing brace for while loop
                                } else {
                                    echo "<p>No electronics products found.</p>";
                                }
                                ?>
                            </div><!-- End .row -->
                        </div><!-- End .tab-pane -->

                        <!-- Furniture Tab -->
                        <div class="tab-pane fade" id="hot-furn-tab" role="tabpanel" aria-labelledby="hot-furn-link">
                            <div class="row">
                                <?php
                                // Fetch furniture products
                                $furnitureQuery = "SELECT * FROM products WHERE category_id = 13"; // Adjust category_id for Furniture
                                $furnResults = $conn->query($furnitureQuery);

                                if ($furnResults && $furnResults->num_rows > 0) {
                                    while ($row = $furnResults->fetch_assoc()) {
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
                                                    </div><!-- End .product-action-vertical -->

                                                    <div class="product-action">
                                                        <a href='single.php?id=<?php echo htmlspecialchars($row["id"]); ?>' class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
                                                    </div><!-- End .product-action -->
                                                </figure><!-- End .product-media -->

                                                <div class="product-body">

                                                    <h3 class="product-title">
                                                        <a href="single.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                                    </h3><!-- End .product-title -->
                                                    <div class="product-price">
                                                        <span class="new-price">$<?php echo htmlspecialchars($row['price']); ?></span>
                                                        <?php if (!empty($row['compare_price'])) { ?>
                                                            <span class="old-price"><del>$<?php echo htmlspecialchars($row['compare_price']); ?></del></span>
                                                        <?php } ?>
                                                    </div><!-- End .product-price -->
                                                </div><!-- End .product-body -->
                                            </div><!-- End .product -->
                                        </div><!-- End .col-md-4 -->
                                <?php
                                    } // Closing brace for while loop
                                } else {
                                    echo "<p>No furniture products found.</p>";
                                }
                                ?>
                            </div><!-- End .row -->
                        </div><!-- End .tab-pane -->

                        <!-- Clothes Tab -->
                        <div class="tab-pane fade" id="hot-clot-tab" role="tabpanel" aria-labelledby="hot-clot-link">
                            <div class="row">
                                <?php
                                // Fetch clothes products
                                $clothesQuery = "SELECT * FROM products WHERE category_id = 3"; // Adjust category_id for Clothes
                                $clotResults = $conn->query($clothesQuery);

                                if ($clotResults && $clotResults->num_rows > 0) {
                                    while ($row = $clotResults->fetch_assoc()) {
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
                                                    </div><!-- End .product-action-vertical -->

                                                    <div class="product-action">
                                                        <a href='single.php?id=<?php echo htmlspecialchars($row["id"]); ?>' class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
                                                    </div><!-- End .product-action -->
                                                </figure><!-- End .product-media -->

                                                <div class="product-body">
                                                    <div class="product-cat">
                                                        <a href="#"><?php echo htmlspecialchars($row['subcategory_name']); ?></a>
                                                    </div><!-- End .product-cat -->
                                                    <h3 class="product-title">
                                                        <a href="single.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                                    </h3><!-- End .product-title -->
                                                    <div class="product-price">
                                                        <span class="new-price">$<?php echo htmlspecialchars($row['price']); ?></span>
                                                        <?php if (!empty($row['compare_price'])) { ?>
                                                            <span class="old-price"><del>$<?php echo htmlspecialchars($row['compare_price']); ?></del></span>
                                                        <?php } ?>
                                                    </div><!-- End .product-price -->
                                                </div><!-- End .product-body -->
                                            </div><!-- End .product -->
                                        </div><!-- End .col-md-4 -->
                                <?php
                                    } // Closing brace for while loop
                                } else {
                                    echo "<p>No clothes products found.</p>";
                                }
                                ?>
                            </div><!-- End .row -->
                        </div><!-- End .tab-pane -->

                        <!-- Accessories Tab -->
                        <div class="tab-pane fade" id="hot-acc-tab" role="tabpanel" aria-labelledby="hot-acc-link">
                            <div class="row">
                                <?php
                                // Fetch accessories products
                                $accessoriesQuery = "SELECT * FROM products WHERE category_id = 4"; // Adjust category_id for Accessories
                                $accResults = $conn->query($accessoriesQuery);

                                if ($accResults && $accResults->num_rows > 0) {
                                    while ($row = $accResults->fetch_assoc()) {
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
                                                    </div><!-- End .product-action-vertical -->

                                                    <div class="product-action">
                                                        <a href='single.php?id=<?php echo htmlspecialchars($row["id"]); ?>' class="btn-product btn-cart" title="Add to cart"><span>add to cart</span></a>
                                                    </div><!-- End .product-action -->
                                                </figure><!-- End .product-media -->

                                                <div class="product-body">
                                                    <div class="product-cat">
                                                        <a href="#"><?php echo htmlspecialchars($row['subcategory_name']); ?></a>
                                                    </div><!-- End .product-cat -->
                                                    <h3 class="product-title">
                                                        <a href="single.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['title']); ?></a>
                                                    </h3><!-- End .product-title -->
                                                    <div class="product-price">
                                                        <span class="new-price">$<?php echo htmlspecialchars($row['price']); ?></span>
                                                        <?php if (!empty($row['compare_price'])) { ?>
                                                            <span class="old-price"><del>$<?php echo htmlspecialchars($row['compare_price']); ?></del></span>
                                                        <?php } ?>
                                                    </div><!-- End .product-price -->
                                                </div><!-- End .product-body -->
                                            </div><!-- End .product -->
                                        </div><!-- End .col-md-4 -->
                                <?php
                                    } // Closing brace for while loop
                                } else {
                                    echo "<p>No accessories products found.</p>";
                                }
                                ?>
                            </div><!-- End .row -->
                        </div><!-- End .tab-pane -->

                    </div><!-- End .tab-content -->
                </div><!-- End .col-lg-9 col-xl-8 -->
