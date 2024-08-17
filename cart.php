<?php 
require('newnav.php');

// Handle Remove Item
if (isset($_POST['remove'])) {
    $id = intval($_POST['id']); // Sanitize input
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Handle Update Quantity
if (isset($_POST['update'])) {
    $id = intval($_POST['id']); // Sanitize input
    $qty = intval($_POST['qty']); // Sanitize input
    $stmt = $conn->prepare("UPDATE cart SET qty = ? WHERE id = ?");
    $stmt->bind_param("ii", $qty, $id);
    $stmt->execute();
    $stmt->close();
}

// Retrieve User ID from Session
$user_email = isset($_SESSION['USER_Email']) ? $_SESSION['USER_Email'] : '';
$user_id = 0;
if ($user_email) {
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
}

// Display Cart Items for User
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$display = $stmt->get_result();

// Get the user's name from the session
$user_name = isset($_SESSION['USER_Name']) ? htmlspecialchars($_SESSION['USER_Name']) : 'Guest';
?>
<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-4">Shopping Cart</h2>
                <p class="text-center">Hello, <?php echo $user_name; ?>!</p>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total = 0;
                            while ($row = $display->fetch_assoc()) {
                                $subtotal = $row['price'] * $row['qty'];
                                $total += $subtotal;
                                echo "<tr>";
                                echo "<td><img src='upload/{$row['image']}' alt='Product Image' class='img-fluid' style='max-width: 100px;'></td>";
                                echo "<td>{$row['name']}</td>";
                                echo "<td>Rs {$row['price']}</td>";
                                echo "<td>
                                        <form method='POST' action=''>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <input type='number' class='form-control' name='qty' value='{$row['qty']}' min='1'>
                                            <button type='submit' name='update' class='btn btn-primary btn-sm mt-2'>Update</button>
                                        </form>
                                      </td>";
                                echo "<td>Rs {$subtotal}</td>";
                                echo "<td>
                                        <form method='POST' action=''>
                                            <input type='hidden' name='id' value='{$row['id']}'>
                                            <button type='submit' name='remove' class='btn btn-danger btn-sm'>Remove</button>
                                        </form>
                                      </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <a href="shop.php" class="btn btn-primary">Continue Shopping</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <h4>Total: Rs <?php echo $total; ?></h4>
                        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <?php require('footer.php'); ?>

