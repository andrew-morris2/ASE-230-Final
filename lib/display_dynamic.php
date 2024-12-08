<?php
session_start();

$host = 'localhost'; 
$dbname = 'store_db';
$username = 'root'; 
$password = ''; 

function getProductDetails($id, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        $itemDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$itemDetails) {
            return null;
        }

        return $itemDetails;
    } catch (PDOException $e) {
        echo "Error fetching product details: " . $e->getMessage();
        return null;
    }
}

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the item ID from the URL parameter
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$id) {
        echo "<h1>Error: Item ID is not provided.</h1>";
        exit();
    }

    // Use the function to get product details
    $itemDetails = getProductDetails($id, $pdo);

    if (!$itemDetails) {
        echo "<h1>Item not found.</h1>";
        exit();
    }

    $name = $itemDetails['name'];
    $description = $itemDetails['description'];
    $price = $itemDetails['price'];
    $image = $itemDetails['image'];

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

$pdo = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= htmlspecialchars($name) ?> - Vogue Vault</title>
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
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Shop</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Item Detail Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <img class="card-img-top mb-5 mb-md-0" src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($name) ?>">
                </div>
                <div class="col-md-6">
                    <div class="small mb-1">Product ID: <?= htmlspecialchars($id) ?></div>
                    <h1 class="display-5 fw-bolder"><?= htmlspecialchars($name) ?></h1>
                    <div class="fs-5 mb-5">
                        <span>$<?= htmlspecialchars(number_format($price, 2)) ?></span>
                    </div>
                    <p class="lead"><?= htmlspecialchars($description) ?></p>
                    <div class="d-flex mb-3">
                        <a class="btn btn-outline-dark flex-shrink-0" href="#">
                            <i class="bi-cart-fill me-1"></i>
                            Add to cart
                        </a>
                    </div>
                    <a class="btn btn-secondary" href="welcome.php">Back to Home</a>
                </div>
            </div>
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
