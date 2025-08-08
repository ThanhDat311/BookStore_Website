<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include 'header.php';
require_once __DIR__ . '/config/database.php';

$stmt_categories = $pdo->query('SELECT * FROM categories');
$categories = $stmt_categories->fetchAll();
?>

<!--page loader-->

<!--end loader-->

<!--end top header-->


<!--start page content-->
<div class="page-content">
    <!--start carousel-->
    <section class="slider-section">
        <div id="carouselBookStore" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselBookStore" data-bs-slide-to="0" class="active"
                    aria-current="true"></button>
                <button type="button" data-bs-target="#carouselBookStore" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#carouselBookStore" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active"
                    style="background: url('assets/images/sliders/s_1.webp') center center/cover no-repeat; min-height:400px;">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center" style="min-height:400px;">
                        <div class="text-center text-white p-5 rounded-3" style="max-width:500px; width:100%;">
                            <h3 class="h3 fw-light fw-bold">Discover New Books</h3>
                            <h1 class="h1 fw-bold">New Releases</h1>
                            <p class="text-dark fw-bold"><i>Up to 30% off on new books!</i></p>
                            <div><a class="btn btn-light btn-ecomm" href="categories.php">Shop Now</a></div>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="carousel-item"
                    style="background: url('assets/images/sliders/s_2.webp') center center/cover no-repeat; min-height:400px;">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center" style="min-height:400px;">
                        <div class="text-center text-white p-5 rounded-3" style="max-width:500px; width:100%;">
                            <h3 class="h3 text-white fw-light fw-bold">Bestsellers</h3>
                            <h1 class="h1 text-white fw-bold">Top Best Seller</h1>
                            <p class="fw-bold"><i>Special discounts on bestsellers!</i></p>
                            <div><a class="btn btn-light btn-ecomm" href="categories.php">Explore Now</a></div>
                        </div>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="carousel-item"
                    style="background: url('assets/images/sliders/s_3.webp') center center/cover no-repeat; min-height:400px;">
                    <div class="w-100 h-100 d-flex justify-content-center align-items-center" style="min-height:400px;">
                        <div class="text-center text-white p-5 rounded-3" style="max-width:500px; width:100%;">
                            <h3 class="h3 fw-light fw-bold">Books for All Ages</h3>
                            <h1 class="h1 fw-bold">A World of Books</h1>
                            <p class="fw-bold"><i>Explore our wide collection for everyone!</i></p>
                            <div><a class="btn btn-light btn-ecomm" href="categories.php">See All</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselBookStore"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselBookStore"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <!--end carousel-->



    <!--start Featured Products slider-->
    <section class="section-padding">
        <div class="container">
            <div class="text-center pb-3">
                <h3 class="mb-0 h3 fw-bold">Featured Products</h3>
                <p class="mb-0 text-capitalize">The purpose of lorem ipsum</p>
            </div>
            <div class="product-thumbs">
                <?php
                require_once __DIR__ . '/config/database.php';
                $stmt = $pdo->query('SELECT * FROM products ORDER BY created_at DESC LIMIT 8');
                $products = $stmt->fetchAll();
                foreach ($products as $p):
                ?>
                <div class="card">
                    <div class="position-relative overflow-hidden">
                        <div
                            class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                            <a href="javascript:;"><i class="bi bi-heart"></i></a>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="add_to_cart" class="btn p-0 border-0 bg-transparent"><i
                                        class="bi bi-basket3"></i></button>
                            </form>
                        </div>
                        <a href="product-details.php?id=<?= $p['id'] ?>">
                            <?php if ($p['thumbnail']): ?>
                            <img src="assets/images/product-images/<?= htmlspecialchars($p['thumbnail']) ?>"
                                class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>"
                                style="object-fit:cover; height:220px; width:100%;">
                            <?php else: ?>
                            <img src="assets/images/no-image.png" class="card-img-top" alt="No image"
                                style="object-fit:cover; height:220px; width:100%;">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="product-info text-center">
                            <h6 class="mb-1 fw-bold product-name"><?= htmlspecialchars($p['name']) ?></h6>
                            <div class="ratings mb-1 h6">
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <p class="mb-0 h6 fw-bold product-price"><?= number_format($p['price'], 0, ',', '.') ?>₫</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!--end Featured Products slider-->


    <!--start tabular product-->
    <section class="product-tab-section section-padding bg-light">
        <div class="container">
            <div class="text-center pb-3">
                <h3 class="mb-0 h3 fw-bold">Products</h3>
                <p class="mb-0 text-capitalize">Product Categories</p>
            </div>
            <div class="row">
                <div class="col-auto mx-auto">
                    <div class="product-tab-menu table-responsive">
                        <?php
                        require_once __DIR__ . '/config/database.php';
                        
                        $stmt_categories = $pdo->query('SELECT * FROM categories');
                        $categories = $stmt_categories->fetchAll();
                        ?>
                        <ul class="nav nav-pills flex-nowrap" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#all-products"
                                    type="button" role="tab">
                                    All products
                                </button>
                            </li>
                            <?php foreach ($categories as $index => $cat): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cat-<?= $cat['id'] ?>"
                                    type="button" role="tab">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </button>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <hr>
            <div class="tab-content tabular-product">

                <div class="tab-pane fade show active" id="all-products" role="tabpanel">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4">
                        <?php
                        $stmt_all = $pdo->query('SELECT * FROM products ORDER BY created_at DESC LIMIT 20');
                        $allProducts = $stmt_all->fetchAll();
                        foreach ($allProducts as $p):
                            $stmt_img = $pdo->prepare('SELECT image_url FROM product_images WHERE product_id = ? LIMIT 1');
                            $stmt_img->execute([$p['id']]);
                            $img = $stmt_img->fetchColumn();
                            $thumbnail = $img ?: 'no-image.png';
                        ?>
                        <div class="col">
                            <div class="card">
                                <div class="position-relative overflow-hidden">
                                    <div
                                        class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                                        <a href="javascript:;"><i class="bi bi-heart"></i></a>
                                        <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                                    </div>
                                    <a href="product-details.php?id=<?= $p['id'] ?>">
                                        <img src="assets/images/product-images/<?= htmlspecialchars($thumbnail) ?>"
                                            class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>"
                                            style="object-fit:cover; height:200px; width:100%;">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="product-info text-center">
                                        <h6 class="mb-1 fw-bold product-name"
                                            title="<?= htmlspecialchars($p['name']) ?>">
                                            <?= mb_strimwidth(htmlspecialchars($p['name']), 0, 40, '...') ?>
                                        </h6>
                                        <div class="ratings mb-1 h6">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        </div>
                                        <p class="mb-0 h6 fw-bold product-price">
                                            <?= number_format($p['price'], 0, ',', '.') ?>₫
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Tabs by category -->
                <?php foreach ($categories as $index => $cat): ?>
                <div class="tab-pane fade" id="cat-<?= $cat['id'] ?>" role="tabpanel">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-4 row-cols-xxl-5 g-4">
                        <?php
                            $stmt_products = $pdo->prepare('SELECT * FROM products WHERE category_id = ? ORDER BY created_at DESC LIMIT 10');
                            $stmt_products->execute([$cat['id']]);
                            $products = $stmt_products->fetchAll();
                            foreach ($products as $p):
                                $stmt_img = $pdo->prepare('SELECT image_url FROM product_images WHERE product_id = ? LIMIT 1');
                                $stmt_img->execute([$p['id']]);
                                $img = $stmt_img->fetchColumn();
                                $thumbnail = $img ?: 'no-image.png';
                            ?>
                        <div class="col">
                            <div class="card">
                                <div class="position-relative overflow-hidden">
                                    <div
                                        class="product-options d-flex align-items-center justify-content-center gap-2 mx-auto position-absolute bottom-0 start-0 end-0">
                                        <a href="javascript:;"><i class="bi bi-heart"></i></a>
                                        <a href="javascript:;"><i class="bi bi-basket3"></i></a>
                                    </div>
                                    <a href="product-details.php?id=<?= $p['id'] ?>">
                                        <img src="assets/images/product-images/<?= htmlspecialchars($thumbnail) ?>"
                                            class="card-img-top" alt="<?= htmlspecialchars($p['name']) ?>"
                                            style="object-fit:cover; height:200px; width:100%;">
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="product-info text-center">
                                        <h6 class="mb-1 fw-bold product-name"
                                            title="<?= htmlspecialchars($p['name']) ?>">
                                            <?= mb_strimwidth(htmlspecialchars($p['name']), 0, 40, '...') ?>
                                        </h6>
                                        <div class="ratings mb-1 h6">
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                            <i class="bi bi-star-fill text-warning"></i>
                                        </div>
                                        <p class="mb-0 h6 fw-bold product-price">
                                            <?= number_format($p['price'], 0, ',', '.') ?>₫
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!--end tabular product-->


    <!--start features-->
    <section class="product-thumb-slider section-padding">
        <div class="container">
            <div class="text-center pb-3">
                <h3 class="mb-0 h3 fw-bold">What We Offer!</h3>
                <p class="mb-0 text-capitalize">The purpose of lorem ipsum</p>
            </div>
            <div class="row row-cols-1 row-cols-lg-4 g-4">
                <div class="col d-flex">
                    <div class="card depth border-0 rounded-0 border-bottom border-primary border-3 w-100">
                        <div class="card-body text-center">
                            <div class="h1 fw-bold my-2 text-primary">
                                <i class="bi bi-truck"></i>
                            </div>
                            <h5 class="fw-bold">Free Delivery</h5>
                            <p class="mb-0">Nor again is there anyone who loves or pursues or desires to obtain pain of
                                itself.</p>
                        </div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card depth border-0 rounded-0 border-bottom border-danger border-3 w-100">
                        <div class="card-body text-center">
                            <div class="h1 fw-bold my-2 text-danger">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <h5 class="fw-bold">Secure Payment</h5>
                            <p class="mb-0">Nor again is there anyone who loves or pursues or desires to obtain pain of
                                itself.</p>
                        </div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card depth border-0 rounded-0 border-bottom border-success border-3 w-100">
                        <div class="card-body text-center">
                            <div class="h1 fw-bold my-2 text-success">
                                <i class="bi bi-minecart-loaded"></i>
                            </div>
                            <h5 class="fw-bold">Free Returns</h5>
                            <p class="mb-0">Nor again is there anyone who loves or pursues or desires to obtain pain of
                                itself.</p>
                        </div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card depth border-0 rounded-0 border-bottom border-warning border-3 w-100">
                        <div class="card-body text-center">
                            <div class="h1 fw-bold my-2 text-warning">
                                <i class="bi bi-headset"></i>
                            </div>
                            <h5 class="fw-bold">24/7 Support</h5>
                            <p class="mb-0">Nor again is there anyone who loves or pursues or desires to obtain pain of
                                itself.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </section>
    <!--end features-->


    <!--start special product-->
    <section class="section-padding bg-section-2">
        <div class="container">
            <div class="card border-0 rounded-0 p-3 depth">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center">
                        <img src="assets/images/extra-images/promo-large.webp" class="img-fluid rounded-0" alt="...">
                    </div>
                    <div class="col-lg-6">
                        <div class="card-body">
                            <h3 class="fw-bold">New Features of Trending Products</h3>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-transparent px-0">Contrary to popular belief, Lorem Ipsum
                                    is not simply
                                    random text.</li>
                                <li class="list-group-item bg-transparent px-0">All the Lorem Ipsum generators on the
                                    Internet tend.
                                </li>
                                <li class="list-group-item bg-transparent px-0">There are many variations of passages of
                                    Lorem Ipsum
                                    available.</li>
                                <li class="list-group-item bg-transparent px-0">There are many variations of passages
                                    available.</li>
                            </ul>
                            <div class="buttons mt-4 d-flex flex-column flex-lg-row gap-3">
                                <a href="javascript:;" class="btn btn-lg btn-dark btn-ecomm px-5 py-3">Buy Now</a>
                                <a href="javascript:;" class="btn btn-lg btn-outline-dark btn-ecomm px-5 py-3">View
                                    Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--start special product-->
    <section class="section-padding">
        <div class="container">
            <div class="text-center pb-3">
                <h3 class="mb-0 h3 fw-bold">Shop By Brands</h3>
                <p class="mb-0 text-capitalize">Select your favorite brands and purchase</p>
            </div>
            <div class="row row-cols-2 row-cols-lg-5 g-4">
                <div class="col">
                    <a href="javascript:;"
                        style="display:block; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s, box-shadow 0.3s;">
                        <img src="assets/images/brands/01.webp" alt=""
                            style="display:block; width:100%; height:88px; object-fit:contain;">
                    </a>
                </div>
                <div class="col">
                    <a href="javascript:;"
                        style="display:block; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s, box-shadow 0.3s;">
                        <img src="assets/images/brands/02.webp" alt=""
                            style="display:block; width:100%; height:88px; object-fit:contain;">
                    </a>
                </div>
                <div class="col">
                    <a href="javascript:;"
                        style="display:block; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s, box-shadow 0.3s;">
                        <img src="assets/images/brands/03.webp" alt=""
                            style="display:block; width:100%; height:88px; object-fit:contain;">
                    </a>
                </div>
                <div class="col">
                    <a href="javascript:;"
                        style="display:block; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s, box-shadow 0.3s;">
                        <img src="assets/images/brands/04.webp" alt=""
                            style="display:block; width:100%; height:88px; object-fit:contain;">
                    </a>
                </div>
                <div class="col">
                    <a href="javascript:;"
                        style="display:block; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s, box-shadow 0.3s;">
                        <img src="assets/images/brands/05.webp" alt=""
                            style="display:block; width:100%; height:88px; object-fit:contain;">
                    </a>
                </div>
                <div class="col">
                    <a href="javascript:;"
                        style="display:block; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s, box-shadow 0.3s;">
                        <img src="assets/images/brands/06.webp" alt=""
                            style="display:block; width:100%; height:88px; object-fit:contain;">
                    </a>
                </div>
                <div class="col">
                    <a href="javascript:;"
                        style="display:block; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s, box-shadow 0.3s;">
                        <img src="assets/images/brands/07.webp" alt=""
                            style="display:block; width:100%; height:88px; object-fit:contain;">
                    </a>
                </div>
                <div class="col">
                    <a href="javascript:;"
                        style="display:block; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s, box-shadow 0.3s;">
                        <img src="assets/images/brands/08.webp" alt=""
                            style="display:block; width:100%; height:88px; object-fit:contain;">
                    </a>
                </div>
                <div class="col">
                    <a href="javascript:;"
                        style="display:block; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s, box-shadow 0.3s;">
                        <img src="assets/images/brands/09.webp" alt=""
                            style="display:block; width:100%; height:88px; object-fit:contain;">
                    </a>
                </div>
                <div class="col">
                    <a href="javascript:;"
                        style="display:block; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); transition: transform 0.3s, box-shadow 0.3s;">
                        <img src="assets/images/brands/10.webp" alt=""
                            style="display:block; width:100%; height:88px; object-fit:contain;">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <style>
    a:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25) !important;
    }
    </style>
    <!--end shop by brands-->

    <!--start category slider-->
    <section class="cartegory-slider section-padding bg-section-2">
        <div class="container">
            <div class="text-center pb-3">
                <h3 class="mb-0 h3 fw-bold">Top Categories</h3>
                <p class="mb-0 text-capitalize">Select your favorite categories and purchase</p>
            </div>
            <div class="cartegory-box d-flex flex-wrap justify-content-center gap-3">
                <?php

                $sql = "SELECT c.id, c.name, COUNT(p.id) AS product_count
                    FROM categories c
                    LEFT JOIN products p ON c.id = p.category_id
                    GROUP BY c.id, c.name
                    ORDER BY product_count DESC
                    LIMIT 6";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($categories as $index => $category):
                    $imgNumber = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    $imgSrc = "assets/images/categories/$imgNumber.webp";
                ?>
                <a href="categories.php?id=<?= $category['id'] ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-sm" style="width: 160px; transition: transform 0.3s;">
                        <div class="card-body p-2 text-center">
                            <div class="overflow-hidden rounded">
                                <img src="<?= $imgSrc ?>" class="card-img-top rounded-0"
                                    alt="<?= htmlspecialchars($category['name']) ?>"
                                    style="height: 120px; object-fit: cover; transition: transform 0.3s;">
                            </div>
                            <h5 class="mb-1 cartegory-name mt-3 fw-bold"><?= htmlspecialchars($category['name']) ?></h5>
                            <h6 class="mb-0 product-number fw-bold"><?= $category['product_count'] ?> Products</h6>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <!--end category slider-->

    <!-- Hover + Shadow effect -->
    <style>
    .cartegory-box a:hover .card {
        transform: scale(1.05);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
    }

    .cartegory-box a:hover img {
        transform: scale(1.1);
    }
    </style>


    <!--subscribe banner-->
    <section class="product-thumb-slider subscribe-banner p-5">
        <div class="row">
            <div class="col-12 col-lg-6 mx-auto">
                <div class="text-center">
                    <h3 class="mb-0 fw-bold text-white">Get Latest Update by <br> Subscribe Our Newslater</h3>
                    <div class="mt-3">
                        <input type="text" class="form-control form-control-lg bubscribe-control rounded-0 px-5 py-3"
                            placeholder="Enter your email">
                    </div>
                    <div class="mt-3 d-grid">
                        <button type="button" class="btn btn-lg btn-ecomm bubscribe-button px-5 py-3">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--subscribe banner-->


    <!--start blog-->
    <section class="section-padding">
        <div class="container">
            <div class="text-center pb-3">
                <h3 class="mb-0 fw-bold">Latest Blog</h3>
                <p class="mb-0 text-capitalize">Check our latest news</p>
            </div>
            <div class="blog-cards">
                <div class="row row-cols-1 row-cols-lg-3 g-4">
                    <div class="col">
                        <div class="card">
                            <img src="assets/images/blog/01.webp" class="card-img-top rounded-0" alt="..."
                                style="max-height: 356px; object-fit: cover; width: 100%;">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="posted-by">
                                        <p class="mb-0"><i class="bi bi-person me-2"></i>Virendra</p>
                                    </div>
                                    <div class="posted-date">
                                        <p class="mb-0"><i class="bi bi-calendar me-2"></i>15 Aug, 2022</p>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold mt-3">Blog title here</h5>
                                <p class="mb-0">Some quick example text to build on the card title and make.</p>
                                <a href="blog-read.html" class="btn btn-outline-dark btn-ecomm mt-3">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="assets/images/blog/02.webp" class="card-img-top rounded-0" alt="..."
                                style="max-height: 356px; object-fit: cover; width: 100%;">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="posted-by">
                                        <p class="mb-0"><i class="bi bi-person me-2"></i>Virendra</p>
                                    </div>
                                    <div class="posted-date">
                                        <p class="mb-0"><i class="bi bi-calendar me-2"></i>15 Aug, 2022</p>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold mt-3">Blog title here</h5>
                                <p class="mb-0">Some quick example text to build on the card title and make.</p>
                                <a href="blog-read.html" class="btn btn-outline-dark btn-ecomm mt-3">Read More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card">
                            <img src="assets/images/blog/03.webp" class="card-img-top rounded-0" alt="..."
                                style="max-height: 356px; object-fit: cover; width: 100%;">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="posted-by">
                                        <p class="mb-0"><i class="bi bi-person me-2"></i>Virendra</p>
                                    </div>
                                    <div class="posted-date">
                                        <p class="mb-0"><i class="bi bi-calendar me-2"></i>15 Aug, 2022</p>
                                    </div>
                                </div>
                                <h5 class="card-title fw-bold mt-3">Blog title here</h5>
                                <p class="mb-0">Some quick example text to build on the card title and make.</p>
                                <a href="blog-read.html" class="btn btn-outline-dark btn-ecomm mt-3">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </section>
    <!--end blog-->



</div>
<!--end page content-->


<?php include 'footer.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $pid = (int)$_POST['product_id'];
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    if ($pid > 0) {
        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid] += $qty;
        } else {
            $_SESSION['cart'][$pid] = $qty;
        }
        $_SESSION['cart_success'] = 'Added to cart!';
        header('Location: index.php');
        exit;
    }
}
?>
<?php if (!empty($_SESSION['login_success'])): ?>
<script>
toastr.success('<?= $_SESSION['login_success'] ?>');
</script>
<?php unset($_SESSION['login_success']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['cart_success'])): ?>
<script>
toastr.success('<?= $_SESSION['cart_success'] ?>');
</script>
<?php unset($_SESSION['cart_success']);
endif; ?>