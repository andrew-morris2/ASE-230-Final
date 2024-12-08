<?php
session_start();
require 'db_connection.php'; // Include your DB connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if the user is not logged in
    header('Location: login.php');
    exit();
}

// Get the user_id from session
$user_id = $_SESSION['user_id'];

// Check if the user has an active order
$active_order_query = "SELECT * FROM orders WHERE user_id = ? AND status = 'in progress'";
$stmt = $db->prepare($active_order_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User has an active order, get the order details
    $order = $result->fetch_assoc();
    $order_id = $order['order_id'];

    // Fetch the order items for the active order
    $order_items_query = "SELECT oi.*, p.name AS product_name, p.price AS product_price FROM order_items oi
                          JOIN products p ON oi.product_id = p.ID
                          WHERE oi.order_id = ?";
    $stmt = $db->prepare($order_items_query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_items = $stmt->get_result();

    // Calculate the total price of the cart
    $total_price = 0;
    while ($item = $order_items->fetch_assoc()) {
        $total_price += $item['quantity'] * $item['product_price'];
    }
} else {
    // No active order, inform the user
    echo "<h1>Your cart is empty.</h1>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Your Cart - Vogue Vault</title>
    <!-- Bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="index.php">Vogue Vault</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="welcome.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Items Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <h1 class="mb-4">Your Cart</h1>
            <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Reset the result pointer to the start
                    $order_items->data_seek(0);
                    while ($item = $order_items->fetch_assoc()):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td>$<?= htmlspecialchars(number_format($item['product_price'], 2)) ?></td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                        <td>$<?= htmlspecialchars(number_format($item['quantity'] * $item['product_price'], 2)) ?></td>
                        <td>
                            <a href="remove_item.php?item_id=<?= $item['order_item_id'] ?>" class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total Price:</strong></td>
                        <td colspan="2">$<?= number_format($total_price, 2) ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Vogue Vault 2023</p></div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="js/scripts.js"></script>
</body>
</html>