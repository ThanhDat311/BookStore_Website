<?php
session_start();
include 'header.php';
require_once __DIR__ . '/config/database.php';

// Get product id from GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    echo '<div class="container py-5"><div class="alert alert-danger">Product not found!</div></div>';
    include 'footer.php';
    exit;
}

// Query product
$stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
$stmt->execute([$id]);
$product = $stmt->fetch();
if (!$product) {
    echo '<div class="container py-5"><div class="alert alert-danger">Product not found!</div></div>';
    include 'footer.php';
    exit;
}

// Get additional images
$img_stmt = $pdo->prepare('SELECT image_url FROM product_images WHERE product_id = ?');
$img_stmt->execute([$id]);
$images = $img_stmt->fetchAll();
?>
<!--start product details-->
<section class="py-4">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-xl-7">
                <div class="product-images">
                    <div class="product-zoom-images">
                        <div class="row row-cols-2 g-3">
                            <div class="col">
                                <div class="img-thumb-container overflow-hidden position-relative"
                                    data-fancybox="gallery"
                                    data-src="assets/images/product-images/<?= htmlspecialchars($product['thumbnail']) ?>">
                                    <img src="assets/images/product-images/<?= htmlspecialchars($product['thumbnail']) ?>"
                                        class="img-fluid" alt="">
                                </div>
                            </div>
                            <?php foreach ($images as $img): ?>
                            <div class="col">
                                <div class="img-thumb-container overflow-hidden position-relative"
                                    data-fancybox="gallery"
                                    data-src="assets/images/product-images/<?= htmlspecialchars($img['image_url']) ?>">
                                    <img src="assets/images/product-images/<?= htmlspecialchars($img['image_url']) ?>"
                                        class="img-fluid" alt="">
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-5">
                <div class="product-info">
                    <h4 class="product-title fw-bold mb-1"><?= htmlspecialchars($product['name']) ?></h4>
                    <div class="product-rating">
                        <div class="hstack gap-2 border p-1 mt-3 width-content">
                            <div><span class="rating-number">4.8</span><i class="bi bi-star-fill ms-1 text-warning"></i>
                            </div>
                            <div class="vr"></div>
                            <div>162 Ratings</div>
                        </div>
                    </div>
                    <hr>
                    <div class="product-price d-flex align-items-center gap-3">
                        <div class="h4 fw-bold"><?= number_format($product['price'], 0, ',', '.') ?>₫</div>
                        <div class="h5 fw-light text-muted">Stock: <?= $product['stock'] ?></div>
                    </div>
                    <p class="fw-bold mb-0 mt-1 text-success">Inclusive of all taxes</p>
                    <div class="cart-buttons mt-3">
                        <form method="post" class="buttons d-flex flex-column flex-lg-row gap-3 mt-4">
                            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" name="add_to_cart"
                                class="btn btn-lg btn-dark btn-ecomm px-5 py-3 col-lg-6"><i
                                    class="bi bi-basket2 me-2"></i>Add to Cart</button>
                            <a href="javascript:;" class="btn btn-lg btn-outline-dark btn-ecomm px-5 py-3"><i
                                    class="bi bi-suit-heart me-2"></i>Wishlist</a>
                        </form>
                    </div>
                    <hr class="my-3">
                    <div class="product-info">
                        <h6 class="fw-bold mb-3">Product Details</h6>
                        <p class="mb-1"><?= nl2br(htmlspecialchars($product['descriptions'])) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
</section>
<!--end product details-->

<!--start similar products section-->
<section class="section-padding">
    <div class="container">
        <div class="separator pb-3">
            <div class="line"></div>
            <h3 class="mb-0 h3 fw-bold">Similar Category Books</h3>
            <div class="line"></div>
        </div>
        <div class="similar-products">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5 g-4">
                <?php
                $cat_id = $product['category_id'];
                $stmt_similar = $pdo->prepare('SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 10');
                $stmt_similar->execute([$cat_id, $product['id']]);
                $similar_products = $stmt_similar->fetchAll();
                foreach ($similar_products as $sp): ?>
                <div class="col">
                    <a href="product-details.php?id=<?= $sp['id'] ?>">
                        <div class="card rounded-0">
                            <img src="assets/images/product-images/<?= htmlspecialchars($sp['thumbnail']) ?>"
                                alt="<?= htmlspecialchars($sp['name']) ?>" class="card-img-top rounded-0"
                                style="height: 180px; object-fit: cover;">
                            <div class="card-body border-top">
                                <h5 class="mb-0 fw-bold product-short-title"><?= htmlspecialchars($sp['name']) ?></h5>
                                <p class="mb-0 product-short-name">
                                    <?= htmlspecialchars(mb_strimwidth($sp['descriptions'], 0, 40, '...')) ?></p>
                                <div class="product-price d-flex align-items-center gap-3 mt-2">
                                    <div class="h6 fw-bold"><?= number_format($sp['price'], 0, ',', '.') ?>₫</div>
                                    <div class="h6 fw-light text-muted">Stock: <?= $sp['stock'] ?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <!--end row-->
        </div>
    </div>
</section>
<!--end similar products section-->


</div>
<!--end page content-->

<?php include 'footer.php'; ?>