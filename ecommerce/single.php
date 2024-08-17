<?php require('newnav.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT p.*, b.brand_name FROM products p 
    INNER JOIN brands b ON p.brand_id = b.id 
    WHERE p.id = $id";
$result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {     
        $row = $result->fetch_assoc();
    

?>

<!-- Modal -->
<div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="w-100 pt-1 mb-5 text-right">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" method="get" class="modal-content modal-body border-0 p-0">
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                <button type="submit" class="input-group-text bg-success text-light">
                    <i class="fa fa-fw fa-search text-white"></i>
                </button>
            </div>
        </form>
    </div>
</div>



<!-- Open Content -->
<section class="bg-light">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-5 mt-5">
                <div class="card mb-3">
                <?php
                                    $images = explode(',', $row['image']); // Assuming multiple images are stored as a comma-separated string in the database
                                    $firstImage = $images[0]; // Get the first image

                                    ?>
                <img class="card-img img-fluid" src="upload/<?php echo $firstImage?>" alt="Product Image 1">
                </div>
                <div class="row">
                    
                   <!-- Start Carousel Wrapper -->
<div id="multi-item-example" class="col-10 carousel slide carousel-multi-item" data-bs-ride="carousel">
    <!-- Start Slides -->
    <div class="carousel-inner product-links-wap" role="listbox">

        <?php
        $images = explode(',', $row['image']); // Assuming multiple images are stored as a comma-separated string in the database

        // Loop through each image to create carousel items
        for ($i = 0; $i < count($images); $i += 3) {
            echo '<div class="carousel-item ' . ($i === 0 ? 'active' : '') . '">
                    <div class="row">';

            // Loop through three images for each carousel item
            for ($j = $i; $j < $i + 3 && $j < count($images); $j++) {
                echo '<div class="col-4">
                        <a href="upload/' . $images[$j] . '" target="_blank">
                            <img class="card-img img-fluid" src="upload/' . $images[$j] . '" alt="Product Image ' . ($j + 1) . '">
                        </a>
                    </div>';
            }
            
            

            echo '</div>
                </div>';
        }
        ?>

    </div>
    </div>
    <!-- End Slides -->

   
</div>
<!-- End Carousel Wrapper -->
            </div>
            <!-- col end -->
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h2"><?php echo $row['title'] ?></h1>
                        <p class="h3 py-2"><?php echo $row['price'] ;}}?></p>
                        <p class="py-2">
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <span class="list-inline-item text-dark">Rating 4.8 | 36 Comments</span>
                        </p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Brand:<?php echo $row['brand_name'] ?></h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>Easy Wear</strong></p>
                            </li>
                        </ul>

                        <h6>Description:</h6>
                        <p><?php echo $row['description']?></p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Avaliable Color :</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>White / Black</strong></p>
                            </li>
                        </ul>

                       
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Close Content -->

<?php  require('footer.php') ?> 
<!-- End Slider Script -->

</body>

</html>