<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: welcome.php");
    exit();
}

$id = $_GET['id'];


$jsonFile = 'data/midtermdata.json';
$jsonData = file_get_contents($jsonFile);
$clothingItems = json_decode($jsonData, true);


$itemDetails = null;

foreach ($clothingItems as $item) {
    if ($item['ID'] == $id) {
        $itemDetails = $item;
        break;
    }
}

// Check if itemDetails is found
if (!$itemDetails) {
    echo "<h1>Item not found.</h1>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete'])){
        $itemsToKeep = [];
        foreach($clothingItems as $keptItems){
            if($keptItems['ID'] != $id){
                $itemsToKeep[] = $keptItems;
            }
        }
        file_put_contents($jsonFile, json_encode($itemsToKeep, JSON_PRETTY_PRINT));
        header("Location: admin.php");
        exit();
        
    }

    $itemDetails['name'] = htmlspecialchars(trim($_POST['name']));
    $itemDetails['price'] = htmlspecialchars(trim($_POST['price']));
    $itemDetails['description'] = htmlspecialchars(trim($_POST['description']));
    $itemDetails['image'] = htmlspecialchars(trim($_POST['image'])); // If you want to allow changing the image

    // Update the JSON data
    foreach ($clothingItems as &$item) {
        if ($item['ID'] == $id) {
            $item = $itemDetails;
            break;
        }
    }

    // Write the updated data back to the JSON file
    file_put_contents($jsonFile, json_encode($clothingItems, JSON_PRETTY_PRINT));
    header("Location: admin.php"); // Redirect back to admin page after update
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit <?= htmlspecialchars($itemDetails['name']) ?> - Vogue Vault</title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="admin.php">Vogue Vault</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="admin.php">Admin Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="welcome.php">Back to Shop</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Edit Product Details</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($itemDetails['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" step="0.01" id="price" name="price" class="form-control" value="<?= htmlspecialchars($itemDetails['price']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($itemDetails['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image URL</label>
                <input type="text" id="image" name="image" class="form-control" value="<?= htmlspecialchars($itemDetails['image']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form><br>
        <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
            <button type="submit" name="delete" class="btn btn-danger">Delete Item</button>
        </form>
        <a class="btn btn-secondary mt-3" href="admin.php">Back to Admin Dashboard</a>
    </div>

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