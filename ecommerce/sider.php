
<div class="container py-5">
        <div class="row">

        <div class="col-lg-3">
    <h1 class="h2 pb-4">Categories</h1>
    <ul class="list-unstyled templatemo-accordion">
        <li class="pb-3">
            <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                Products
                <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
            </a>
            <ul class="collapse show list-unstyled pl-3">

                <?php

                $sql = "SELECT * FROM `category`";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <li><a class='text-decoration-none' href='category.php?category={$row['category_name']}'>{$row['category_name']}</a></li>
                    ";
                    }
                }

                ?>
            </ul>
        </li>
    </ul>
</div>


            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-inline shop-top-menu pb-3 pt-1">
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3" href="#">All</a>
                            </li>
                            <!-- <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3" href="#">Men's</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none" href="#">Women's</a>
                            </li> -->
                        </ul>
                    </div>
                    <div class="col-md-6 pb-4">
                        <div class="d-flex">
                            <select class="form-control">
                                <option>Featured</option>
                                <option>A to Z</option>
                                <option>Item</option>
                            </select>
                        </div>
                    </div>
                </div>