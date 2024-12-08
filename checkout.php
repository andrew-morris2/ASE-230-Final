<?php
session_start();

// Database configuration
$host = 'localhost'; // Database host
$dbname = 'store_db'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get the item ID from the URL parameter
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    // Check if the item ID is valid
    if (!$id) {
        echo "<h1>Error: Item ID is not provided.</h1>";
        exit();
    }

    // Prepare and execute the SQL query to get item details
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch the item details
    $itemDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the item exists
    if (!$itemDetails) {
        echo "<h1>Item not found.</h1>";
        exit();
    }

    // Extract item details
    $order_id = $itemDetails['order_id'];
    $name = $itemDetails['name'];
    $description = $itemDetails['description'];
    $price = $itemDetails['price'];
    $image = $itemDetails['image'];

} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
    exit();
}

// Close the connection
$pdo = null;
foreach ($clothingItems as $item) {

    if (isset($itemDetails['image']) && $i < 30 && $_SESSION['type'] === 'standard'){
        echo '
        <div class="col mb-5">
            <div class="card h-100">
                <!-- Product image-->
                <img class="card-img-top" src="' . htmlspecialchars($itemDetails['image']) . '" alt="..." />
                <!-- Product details-->
                <div class="card-body p-4">
                    <div class="text-center">
                        <!-- Product name-->
                        <h5 class="fw-bolder">' . htmlspecialchars($itemDetails['name']) . '</h5>
                        <!-- Product price-->
                        $' . htmlspecialchars(number_format($itemDetails['price'], 2)) . '
                    </div>
                </div>
                <!-- Product actions-->
                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                    <div class="text-center">
                        <a class="btn btn-outline-dark mt-auto" href="details.php?id=' . $itemDetails['ID'] . '">More details</a>
                    </div> <!-- End of text-center -->
                </div> <!-- End of card-footer -->
            </div> <!-- End of card -->
        </div> <!-- End of col -->
        ';
        $i++;
    }

}
?>
