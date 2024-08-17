<?php
// Include database connection
require('newnav.php');

// Ensure no output before header
if (ob_get_level()) ob_end_clean();

header('Content-Type: application/json'); // Set content type to JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $id = intval($_POST['id']); // Product ID
    $quantity = intval($_POST['quantity']); // Quantity

    if (isset($_SESSION['user'])) {
        // Logged-in user
        $userId = intval($_SESSION['user']['id']); // Ensure user ID is an integer

        // Check if the product is already in the cart
        $sql = "SELECT * FROM cart WHERE user_id = $userId AND product_id = $id";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Update quantity if the product is already in the cart
            $sql = "UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $userId AND product_id = $id";
        } else {
            // Add new product to the cart
            $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($userId, $id, $quantity)";
        }

        if ($conn->query($sql)) {
            echo json_encode(['error' => false, 'message' => 'Item added to cart']);
        } else {
            echo json_encode(['error' => true, 'message' => 'Database error: ' . $conn->error]);
        }
    } else {
        // Guest user
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Check if the product is already in the cart
        $exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['productid'] == $id) {
                $item['quantity'] += $quantity;
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $_SESSION['cart'][] = ['productid' => $id, 'quantity' => $quantity];
        }

        echo json_encode(['error' => false, 'message' => 'Item added to cart']);
    }

    $conn->close();
} else {
    echo json_encode(['error' => true, 'message' => 'Invalid request']);
}
?>
