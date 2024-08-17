<?php
require('newnav.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Display</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="zay/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Your CSS styles */
        .card {
            height: 400px;
            /* Adjust the height value as needed */
        }

        .card-img {
            height: 250px;

        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <?php
         require('sider.php');
                // Using JOIN to fetch subcategory names
                $sql = "SELECT p.*, s.subcategory_name FROM products p 
                    INNER JOIN sub s ON p.subcategory_id = s.id 
                ";
                $results = $conn->query($sql);

                if ($results && $results->num_rows > 0) {
                    echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">';
                    while ($row = $results->fetch_assoc()) {
        ?>
                        <div class="col-md-4">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <?php
                                    $images = explode(',', $row['image']); // Assuming multiple images are stored as a comma-separated string in the database
                                    $firstImage = $images[0]; // Get the first image
                                    ?>
                                    <img class="card-img rounded-0 img-fluid" src="upload/<?php echo $firstImage ?>">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            <!-- <li><a class="btn btn-success text-white" href="shop-single.html"><i class="far fa-heart"></i></a></li> -->
                                            <li><a class="btn btn-success text-white mt-2" href='single.php?id=<?php echo $row["id"]; ?>'><i class="far fa-eye"></i></a></li>

                                            <li><a class="btn btn-success text-white mt-2" href='cart.php?id=<?php echo $row["id"]; ?>'><i class="fas fa-cart-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="shop-single.html" class="h3 text-decoration-none"><?php echo $row['title'] ?></a>
                                    <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                        <li><?php echo $row['subcategory_name'] ?></li>
                                        <!-- <li class="pt-2">
                                            <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                            <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                        </li> -->
                                    </ul>
                                    <ul class="list-unstyled d-flex justify-content-center mb-1">
                                        <li>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-muted fa fa-star"></i>
                                            <i class="text-muted fa fa-star"></i>
                                        </li>
                                    </ul>
                                    <p class="text-center mb-0">Rs <?php echo $row['price'] ?></p>
                                </div>
                            </div>
                        </div>
        <?php
                    }
                    echo '</div>'; // Close the row div
                }
        if (isset($error_message)) {
            echo '<div class="alert alert-danger">' . $error_message . '</div>';
        }

        ?>
    </div>
    </div>
    </div>

    </div>
    <!-- Bootstrap JS, Popper.js, and jQuery
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="zay/js/jquery-1.11.0.min.js"></script>
    <script src="zay/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="zay/js/bootstrap.bundle.min.js"></script>
    <script src="zay/js/templatemo.js"></script>
    <script src="zay/js/custom.js"></script>
    <?php require('footer.php')?> 
    
</body>

</html>