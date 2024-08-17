<?php
        require('connection.inc.php'); // This file should handle the database connection
require('function.inc.php'); // This might contain additional functions

// Initialize cart count
$cart_count = 0;

// Retrieve User Email from Session
$user_email = isset($_SESSION['USER_Email']) ? $_SESSION['USER_Email'] : '';

// Initialize user_id
$user_id = 0;

// Check if user_email is set and fetch user_id
if ($user_email) {
    // Retrieve user_id
    $sql = "SELECT id FROM users WHERE email = '$user_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];
    }

    // Retrieve cart item count for the user
    $sql = "SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cart_count = $row['cart_count'];
    }
}

// Get the user's name from the session or default to 'Guest'
$user_name = isset($_SESSION['USER_Name']) ? htmlspecialchars($_SESSION['USER_Name']) : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="frontend/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="frontend/assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="frontend/assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="frontend/assets/css/plugins/jquery.countdown.css">
    <link rel="stylesheet" href="frontend/assets/css/style.css">
    <link rel="stylesheet" href="frontend/assets/css/skins/skin-demo-13.css">
    <link rel="stylesheet" href="frontend/assets/css/demos/demo-13.css">
    <style>
        .compare-price {
            text-decoration: line-through;
        }
        .icon-shopping-cart {
    font-size: 2.5rem; /* Adjust size as needed */
}

.badge {
    font-size: 1.5rem; /* Adjust size of badge text */
    padding: 0.5rem 1rem; /* Adjust padding of badge */
}

.cart span {
    font-size: 1.5rem; /* Adjust size of cart text */
}
/* Default styles */
.navbar {
    background-color: #333;
    padding: 1em;
    text-align: center;
}

.menu {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: space-between;
}

.menu li {
    margin-right: 20px;
}

.menu a {
    color: #fff;
    text-decoration: none;
}

/* Responsive styles */
@media (max-width: 768px) {
    .navbar {
        padding: 0.5em;
    }
    .menu {
        flex-direction: column;
        align-items: center;
    }
    .menu li {
        margin-right: 0;
        margin-bottom: 10px;
    }
}

@media (max-width: 480px) {
    .navbar {
        padding: 0.2em;
    }
    .menu a {
        font-size: 14px;
    }
}

    </style>
</head>

<body>
    <header class="header header-10 header-intro-clearance mb-5 pb-5">
        <div class="header-top">
            <div class="container">
                <div class="header-left">
                    <a href="tel:#"><i class="icon-phone"></i>Call: +0123 456 789</a>
                </div><!-- End .header-left -->
                <div class="header-right">
                    <ul class="top-menu">
                        <li>
                            <a href="#">Links</a>
                            <ul>
                                <li class="login">
                                    <a href="login.php" target="_blank">Sign in / Sign up</a>
                                </li>
                            </ul>
                        </li>
                    </ul><!-- End .top-menu -->
                </div><!-- End .header-right -->
            </div><!-- End .container -->
        </div><!-- End .header-top -->

        <div class="header-middle">
            <div class="container">
                <div class="header-left">
                    <a href="home.php" class="logo">
                        <img src="frontend/assets/images/demos/demo-13/logo.png" alt="Molla Logo" width="105" height="25">
                    </a>
                </div><!-- End .header-left -->
                <div class="header-center">
                    <div class="header-search header-search-extended header-search-visible header-search-no-radius d-none d-lg-block">
                        <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                        <form action="#" method="get">
                            <div class="header-search-wrapper search-wrapper-wide">
                                <div class="select-custom">
                                    <select id="cat" name="cat">
                                        <option value="">All Departments</option>
                                        <!-- Optionally add more categories here -->
                                    </select>
                                </div><!-- End .select-custom -->
                                <label for="q" class="sr-only">Search</label>
                                <input type="search" class="form-control" name="q" id="q" placeholder="Search product ..." required>
                                <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
                            </div><!-- End .header-search-wrapper -->
                        </form>
                    </div><!-- End .header-search -->
                </div>
                <div class="header-right">
                    <!-- cart -->
                    <div class="d-flex align-items-center">
    <a href="cart.php" class="cart d-flex align-items-center text-dark text-decoration-none">
        <i class="icon-shopping-cart fs-3 me-2"></i> <!-- Increased size of the icon and margin-right for spacing -->
        <span class="badge bg-primary rounded-pill fs-5"><?= $cart_count ?></span> <!-- Increased font size of the count -->
        <span class="ms-2 fs-5">Cart</span> <!-- Increased font size of the text and margin-start for spacing -->
    </a>
</div>
                </div><!-- End .header-right -->
            </div><!-- End .container -->
        </div><!-- End .header-middle -->

        <div class="header-bottom sticky-header">
            <div class="container">
                <div class="header-left">
            
                <div class="col-lg-9">
    <nav class="navbar">
        <ul class="menu sf-arrows">
            <li class="megamenu-container">
                <a href="home.php" class="">Home</a>
            </li>
            <li class="megamenu-container">
                <a href="Shop.php" class="">Shop</a>
            </li>
            <li class="megamenu-container">
                <a href="about.php" class="">About</a>
            </li>
            <li class="megamenu-container">
                <a href="contact.php" class="">Contact</a>
            </li>
        </ul>
    </nav>
</div>
                </div><!-- End .header-left -->

                <div class="header-right">
                    <i class="la la-lightbulb-o"></i>
                    <p>Clearance Up to 30% Off</p>
                </div>
            </div><!-- End .container -->
        </div><!-- End .header-bottom -->
    </header><!-- End .header -->