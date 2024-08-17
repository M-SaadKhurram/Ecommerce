<!-- Custom CSS -->
<style>
    .services-icon-wap {
        transition: transform 0.3s;
    }

    .services-icon-wap:hover {
        transform: translateY(-10px);
    }

    .modal-content {
        border-radius: 1rem;
    }

    .modal-header {
        border-bottom: none;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
</style>
<?php require('newnav.php'); ?>


<!-- About Us Section -->
<section class="bg-primary text-white" style="margin-top: -99;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white">About Us</h1>
                <p class="lead text-white">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <img src="assets/img/about-hero.svg" alt="About Hero" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="container py-5">
    <div class="row text-center">
        <div class="col-lg-6 mx-auto">
            <h1 class="h1">Our Services</h1>
            <p class="lead">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                Lorem ipsum dolor sit amet.
            </p>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-md-6 col-lg-3 pb-5">
            <div class="card shadow-sm h-100 py-5 services-icon-wap">
                <div class="card-body">
                    <div class="display-4 text-primary"><i class="fa fa-truck"></i></div>
                    <h2 class="h5 mt-4">Delivery Services</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 pb-5">
            <div class="card shadow-sm h-100 py-5 services-icon-wap">
                <div class="card-body">
                    <div class="display-4 text-primary"><i class="fas fa-exchange-alt"></i></div>
                    <h2 class="h5 mt-4">Shipping & Return</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 pb-5">
            <div class="card shadow-sm h-100 py-5 services-icon-wap">
                <div class="card-body">
                    <div class="display-4 text-primary"><i class="fa fa-percent"></i></div>
                    <h2 class="h5 mt-4">Promotion</h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 pb-5">
            <div class="card shadow-sm h-100 py-5 services-icon-wap">
                <div class="card-body">
                    <div class="display-4 text-primary"><i class="fa fa-user"></i></div>
                    <h2 class="h5 mt-4">24 Hours Service</h2>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?php require('footer.php'); ?>


