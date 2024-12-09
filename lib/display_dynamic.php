<?php
session_start();

$host = 'localhost'; 
$dbname = 'store_db';
$username = 'root'; 
$password = ''; 

function getAllProducts($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all products
    } catch (PDOException $e) {
        echo "Error fetching products: " . $e->getMessage();
        return [];
    }
}

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get all product details
    $products = getAllProducts($pdo);

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
    <title>Welcome - Vogue Vault</title>
    <!-- Bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="./css/styles.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="../index.php">Vogue Vault</a>
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

    <!-- Products List Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5">
                <?php
                if (!empty($products)) {
                    foreach ($products as $product) {
                        $name = htmlspecialchars($product['name']);
                        $description = htmlspecialchars($product['description']);
                        $price = number_format($product['price'], 2);
                        $image = htmlspecialchars($product['image']);
                        $id = htmlspecialchars($product['ID']);
                ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img class="card-img-top" src="<?= $image ?>" alt="<?= $name ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $name ?></h5>
                                <p class="card-text"><?= $description ?></p>
                                <p class="card-text">$<?= $price ?></p>
                                <a href="product_details.php?id=<?= $id ?>" class="btn btn-outline-dark">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo "<p>No products available.</p>";
                }
                ?>
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