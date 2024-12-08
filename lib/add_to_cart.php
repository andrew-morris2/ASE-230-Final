<?php
session_start();
include 'db_connection.php'; // Include your database connection script

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    echo "Please log in to add items to your cart.";
    exit();
}

// Retrieve form data
$username = $_SESSION['username']; // Username from session
$product_id = $_POST['product_id']; // Product ID from form
$price = $_POST['price']; // Price from form
$quantity = 1; // Default quantity
$order_id = $_SESSION['order_id'] ?? null; // Existing order ID, if any

try {
    // Connect to the database
    $conn = new PDO("mysql:host=localhost;dbname=store_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Look up user_id based on username
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // If no user found, redirect or display an error
        echo "User not found!";
        exit();
    }

    $user_id = $user['user_id']; // User ID from the database

    // Check if there's an active order
    if (!$order_id) {
        // Create a new order
        $stmt = $conn->prepare("INSERT INTO `Orders` (`user_id`, `order_date`, `total_price`, `status`) 
                                VALUES (:user_id, CURDATE(), 0, 'Pending')");
        $stmt->execute(['user_id' => $user_id]);

        // Get the new order ID
        $order_id = $conn->lastInsertId();
        $_SESSION['order_id'] = $order_id;
    }

    // Check if the product already exists in the order_items table
    $stmt = $conn->prepare("SELECT quantity FROM `order_items` WHERE `order_id` = :order_id AND `product_id` = :product_id");
    $stmt->execute(['order_id' => $order_id, 'product_id' => $product_id]);
    $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingItem) {
        // Update quantity if item exists
        $newQuantity = $existingItem['quantity'] + $quantity;
        $stmt = $conn->prepare("UPDATE `order_items` SET `quantity` = :quantity WHERE `order_id` = :order_id AND `product_id` = :product_id");
        $stmt->execute(['quantity' => $newQuantity, 'order_id' => $order_id, 'product_id' => $product_id]);
    } else {
        // Insert new item if not exists
        $stmt = $conn->prepare("INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`)
                                VALUES (:order_id, :product_id, :quantity, :price)");
        $stmt->execute([
            'order_id' => $order_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price
        ]);
    }

    // Update the total price in the Orders table
    $stmt = $conn->prepare("UPDATE `Orders` SET `total_price` = `total_price` + (:price * :quantity) WHERE `order_id` = :order_id");
    $stmt->execute([
        'price' => $price,
        'quantity' => $quantity,
        'order_id' => $order_id
    ]);

    echo "Item successfully added to cart!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header('Location: ../cart.php');
exit();
?>
