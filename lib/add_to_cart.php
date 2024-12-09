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
        $stmt = $conn->prepare("SELECT order_id FROM Orders WHERE user_id = :user_id AND status = '' ORDER BY order_date DESC LIMIT 1");
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
    $stmt = $conn->prepare("SELECT oi.product_id, oi.quantity, oi.price, p.name AS product_name FROM order_items oi
                        JOIN products p ON oi.product_id = p.id
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

<!-- Display cart items -->
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
