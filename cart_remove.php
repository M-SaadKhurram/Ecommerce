<?php
require('newnav.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Product ID

    if (isset($_SESSION['user'])) {
        // Logged-in user
        $userId = $_SESSION['user']['id'];
        $sql = "DELETE FROM cart WHERE user_id = $userId AND product_id = $id";
        $conn->query($sql);
    } else {
        // Guest user
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['productid'] == $id) {
                    unset($_SESSION['cart'][$key]);
                    break;
                }
            }
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
        }
    }

    header('Location: cart_page.php'); // Redirect back to the cart page
    exit();
}
?>
