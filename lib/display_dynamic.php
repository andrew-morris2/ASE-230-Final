<?php
function displayClothingImages($jsonFile) {
    $data = file_get_contents($jsonFile);
    $clothingItems = json_decode($data, true);
    $i = 0;
    foreach ($clothingItems as $item) {
        if (isset($item['image']) && $_SESSION['role'] === 'admin') {
            echo '
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Product image-->
                    <img class="card-img-top" src="' . htmlspecialchars($item['image']) . '" alt="..." style="height: 250px;"/>
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">' . htmlspecialchars($item['name']) . '</h5>
                            <!-- Product price-->
                            $' . htmlspecialchars(number_format($item['price'], 2)) . '
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-outline-dark mt-auto" href="admin_details.php?id=' . $item['ID'] . '">Edit Product</a>
                        </div> <!-- End of text-center -->
                    </div> <!-- End of card-footer -->
                </div> <!-- End of card -->
            </div> <!-- End of col -->';
        }
        if (isset($item['image']) && $i < 30 && $_SESSION['role'] === 'customer'){
            echo '
            <div class="col mb-5">
                <div class="card h-100">
                    <!-- Product image-->
                    <img class="card-img-top" src="' . htmlspecialchars($item['image']) . '" alt="..." />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">' . htmlspecialchars($item['name']) . '</h5>
                            <!-- Product price-->
                            $' . htmlspecialchars(number_format($item['price'], 2)) . '
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">
                            <a class="btn btn-outline-dark mt-auto" href="details.php?id=' . $item['ID'] . '">More details</a>
                        </div> <!-- End of text-center -->
                    </div> <!-- End of card-footer -->
                </div> <!-- End of card -->
            </div> <!-- End of col -->
            ';
            $i++;
        }

    }
}
?>

