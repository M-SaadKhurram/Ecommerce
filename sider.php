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
                                <a role="button" data-toggle="collapse" href="#collapse-<?php echo $categoryId;?>" aria-expanded="true" aria-controls="collapse-<?php echo $categoryId;?>">
                                    <?php echo htmlspecialchars($categoryName);?>
                                </a>
                            </h5>
                            <div id="collapse-<?php echo $categoryId;?>" class="collapse show" data-parent="#widget-cat-acc">
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
                                                <li><a href="category.php?subcategory=<?php echo urlencode($subCategoryName);?>"><?php echo htmlspecialchars($subCategoryName);?></a></li>
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
                                <input type="checkbox" class="custom-control-input" id="brand-<?php echo $brandId;?>" name="filter-brands[]" value="<?php echo htmlspecialchars($brandName);?>">
                                <label class="custom-control-label" for="brand-<?php echo $brandId;?>"><?php echo htmlspecialchars($brandName);?></label>
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