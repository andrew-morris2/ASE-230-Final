<?php
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
        echo "Error: Item ID is not provided.";
        exit();
    }

    // Prepare and execute the SQL query to get item details
    $stmt = $pdo->prepare("SELECT * FROM products WHERE ID = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the item details
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the item exists
    if (!$item) {
        echo "Error: Item not found.";
        exit();
    }

    // Redirect to details.php if the item is found
    header("Location: ../details.php?id=" . urlencode($item['ID']) . "&name=" . urlencode($item['name']) . "&description=" . urlencode($item['description']) . "&price=" . urlencode($item['price']) . "&image=" . urlencode($item['image']));
    exit();

} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}

// Close the connection
$pdo = null;
?>



