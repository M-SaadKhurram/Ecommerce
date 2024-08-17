<?php
ob_start();

require('newnav.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['USER_LOGIN']) || $_SESSION['USER_LOGIN'] != 'yes') {
        header('Location: login.php');
        exit();
    }

    // Retrieve user ID from session
    $user_id = $_SESSION['USER_ID']; // Assuming USER_ID is stored in session

    // Get user input from the form
    $recipient_name = $_POST['recipient_name'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];

    // Calculate total amount
    $total_amount = 0;
    $cart_items = mysqli_query($conn, "SELECT * FROM cart WHERE `user_id` = $user_id");
    while ($item = mysqli_fetch_assoc($cart_items)) {
        $total_amount += $item['price'] * $item['qty'];
    }

    // Insert order into `orders` table
    $order_query = "INSERT INTO orders (`user_id`, `total_amount`, `recipient_name`, `phone_number`, `address`, `city`) 
                    VALUES ('$user_id', '$total_amount', '$recipient_name', '$phone_number', '$address', '$city')";
    mysqli_query($conn, $order_query);

    // Get the last inserted order ID
    $order_id = mysqli_insert_id($conn);

    // Insert items into `order_items` table
    $cart_items = mysqli_query($conn, "SELECT * FROM cart WHERE user_id = $user_id");
    while ($item = mysqli_fetch_assoc($cart_items)) {
        $item_query = "INSERT INTO order_items (`order_id`, `product_name`, `price`, `quantity`) 
                       VALUES ('$order_id', '{$item['name']}', '{$item['price']}', '{$item['qty']}')";
        mysqli_query($conn, $item_query);
    }

    // Clear the cart
    mysqli_query($conn, "DELETE FROM cart WHERE `user_id` = $user_id");

    // Redirect to order confirmation page
    header('Location: order_confirmation.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">        
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Checkout</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="form-group">
                <label for="recipient_name">Name</label>
                <input type="text" class="form-control" id="recipient_name" name="recipient_name" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" required>
            </div>
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    </div>
    <?php
ob_end_flush();
require('footer.php');
?>
