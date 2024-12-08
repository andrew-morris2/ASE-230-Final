<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Your one-stop shop for quality clothing." />
    <meta name="author" content="Vogue Vault" />
    <title>Welcome to Vogue Vault</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>
<body>
    <!-- Navigation--> <!-- NOTE: I did use ChatGPT to extend the bootstrap template as it didn't offer a whole lot other than displaying products -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#!">Vogue Vault</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                            <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                        </ul>
                    </li>  
                </ul>
                <form class="d-flex">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="lib/signin.php">Sign in</a></li>
                    </ul>       
                </form>
            </div>
        </div>
    </nav>

    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Welcome to Vogue Vault</h1>
                <p class="lead fw-normal text-white-50 mb-0">Discover the latest trends and styles at unbeatable prices.</p>
                <a href="lib/signin.php" class="btn btn-light btn-lg mt-4">Start Shopping</a>
            </div>
        </div>
    </header>

    <!-- Featured Categories Section -->
    <section id="shop" class="py-5">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mb-4">Featured Categories</h2>
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img class="card-img-top" src="https://images.unsplash.com/photo-1511659920815-b29cba44c8aa?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDR8fG1lbnMlMjB0cmlwZXxlbnwwfHx8fDE2ODAwMzU4NzM&ixlib=rb-4.0.3&q=80&w=1080" alt="Men's Fashion" />
                        <div class="card-body text-center">
                            <h5 class="card-title">Men's Fashion</h5>
                            <p class="card-text">Stylish and trendy clothing for the modern man.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img class="card-img-top" src="https://images.unsplash.com/photo-1497630122943-84c74a43cfa8?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDd8fGFjY2Vzc29yaWVzfGVufDB8fHx8MTY4MDAzNTg5Mg&ixlib=rb-4.0.3&q=80&w=1080" alt="Women's Fashion" />
                        <div class="card-body text-center">
                            <h5 class="card-title">Women's Fashion</h5>
                            <p class="card-text">Elegant and fashionable outfits for every occasion.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <img class="card-img-top" src="https://dummyimage.com/450x300/dee2e6/6c757d.jpg" alt="Accessories" />
                        <div class="card-body text-center">
                            <h5 class="card-title">Accessories</h5>
                            <p class="card-text">Complete your look with our stylish accessories.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Testimonials Section -->
    <section class="py-5 bg-light">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mb-4">What Our Customers Say</h2>
            <div class="row gx-4 gx-lg-5">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <p class="card-text">"Absolutely love the quality of the clothes! Best shop ever!"</p>
                            <p class="text-muted">- Sarah J.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <p class="card-text">"Amazing styles and great customer service. Highly recommend!"</p>
                            <p class="text-muted">- Mike D.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body">
                            <p class="card-text">"Fast shipping and exactly what I ordered. I’ll be back!"</p>
                            <p class="text-muted">- Emily R.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 text-center">
            <h2 class="fw-bold">Join Our Fashion Community</h2>
            <p class="lead mb-4">Stay updated with the latest trends and exclusive offers.</p>
            <a href="signup.php" class="btn btn-primary btn-lg">Sign Up Now</a>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Vogue Vault 2023</p></div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>