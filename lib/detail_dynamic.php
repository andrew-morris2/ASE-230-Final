<?php
// Path to the JSON data file
$dataFile = '../data/midtermdata.json';

// Read the data from the JSON file
$jsonData = file_get_contents($dataFile);

// Decode JSON data into an associative array
$items = json_decode($jsonData, true);

// Function to get item details by ID
function getItemDetails($items, $id) {
    foreach ($items as $item) {
        if ($item['ID'] === $id) {
            return $item;
        }
    }
    return null;
}

// Get the item ID from the URL parameter
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Check if the item ID is valid
if (!$id) {
    echo "Error: Item ID is not provided.";
    exit();
}

// Get the item details
$item = getItemDetails($items, $id);

// Check if the item exists
if (!$item) {
    echo "Error: Item not found.";
    exit();
}
// Redirect to details.php if the item is found
header("Location: ../details.php?id=" . urlencode($id) . "&name=" . urlencode($item['name']) . "&description=" . urlencode($item['description']) . "&price=" . urlencode($item['price']) . "&image=" . urlencode($item['image']));
exit();
?>
