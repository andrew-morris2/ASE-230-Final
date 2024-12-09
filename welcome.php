<?php
session_start();

// This will check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the sign-in page if not logged in
    header("Location: signin.php");
    exit();
}

// Get the user's session
$username = htmlspecialchars($_SESSION['username']);

// Database connection details
$host = 'localhost'; 
$dbname = 'store_db';
$username_db = 'root'; 
$password_db = ''; 

// Function to get all products from the database
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
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
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

    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Welcome <?php echo $username ?>!</h1>
                <p class="lead fw-normal text-white-50 mb-0">Explore our products</p>
            </div>
        </div>
    </header>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
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
                                <a href="details.php?id=<?= $id ?>" class="btn btn-outline-dark">View Details</a>
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

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>