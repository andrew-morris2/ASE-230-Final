<?php
session_start();
include 'db_connection.php';

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    echo "Please log in to view your cart.";
    exit();
}

// Get the user_id and order_id from session
$username = $_SESSION['username'];
$order_id = $_SESSION['order_id'] ?? null; // Get order_id if it exists in session

try {
    $conn = new PDO("mysql:host=localhost;dbname=store_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Look up the user_id based on username
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found!";
        exit();
    }

    $user_id = $user['user_id']; // User ID from session

    // If order_id is not set in session, fetch the most recent order
    if (!$order_id) {
        $stmt = $conn->prepare("SELECT order_id FROM Orders WHERE user_id = :user_id AND status = 'Pending' ORDER BY order_date DESC LIMIT 1");
        $stmt->execute(['user_id' => $user_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $order_id = $order['order_id'];
            $_SESSION['order_id'] = $order_id; // Set order_id in session
        } else {
            echo "No active order found.";
            exit();
        }
    }

    // Fetch all items in the user's cart (order_items)
    $stmt = $conn->prepare("SELECT oi.product_id, oi.quantity, oi.price, p.name FROM order_items oi
                            JOIN products p ON oi.product_id = p.ID
                            WHERE oi.order_id = :order_id");
    $stmt->execute(['order_id' => $order_id]);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch total price of the order
    $stmt = $conn->prepare("SELECT total_price FROM Orders WHERE order_id = :order_id");
    $stmt->execute(['order_id' => $order_id]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    $total_price = $order['total_price'];

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Welcome to Vogue Vault</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="./css/styles.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Vogue Vault</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="welcome.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                            <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="lib/signin.php">Sign Out</a></li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

<h2>Your Cart</h2>
<?php if ($items): ?>
    <ul>
        <?php foreach ($items as $item): ?>
            <li>
                <?php echo htmlspecialchars($item['product_name']); ?> - 
                Quantity: <?php echo $item['quantity']; ?>, 
                Price: $<?php echo number_format($item['price'], 2); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <p>Total Price: $<?php echo number_format($total_price, 2); ?></p>
<?php else: ?>
    <p>Your cart is empty.</p>
<?php endif; ?>