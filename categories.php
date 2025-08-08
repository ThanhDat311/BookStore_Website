<?php
include 'header.php';
require_once __DIR__ . '/config/database.php';
// PDO instance: $pdo
$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($categoryId > 0) {
  // Get specific category
  $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
  $stmt->execute([$categoryId]);
  $category = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$category) {
    echo "<div class='container py-5'><h5>Category not found!</h5></div>";
    exit;
  }

  // Get products of this category
  $stmt = $pdo->prepare("
        SELECT p.*, pi.image_url 
        FROM products p 
        LEFT JOIN product_images pi ON p.id = pi.product_id 
        WHERE p.category_id = ?
    ");
  $stmt->execute([$categoryId]);
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  // Get all categories
  $categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

  // Get 20 newest products
  $allProducts = $pdo->query("
        SELECT p.*, pi.image_url 
        FROM products p 
        LEFT JOIN product_images pi ON p.id = pi.product_id 
        ORDER BY p.id DESC 
        LIMIT 20
    ")->fetchAll(PDO::FETCH_ASSOC);

  // Get products by each category
  $productsByCategory = [];
  foreach ($categories as $cat) {
    $stmt = $pdo->prepare("
            SELECT p.*, pi.image_url 
            FROM products p 
            LEFT JOIN product_images pi ON p.id = pi.product_id 
            WHERE p.category_id = ?
        ");
    $stmt->execute([$cat['id']]);
    $productsByCategory[$cat['id']] = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>

<div class="page-content">
    <section class="product-tab-section section-padding bg-light">
        <div class="container">
            <?php if ($categoryId > 0): ?>
            <h5 class="mb-4">Category: <?= htmlspecialchars($category['name']) ?></h5>
            <div class="row">
                <?php foreach ($products as $product): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <?php
                        $thumb = $product['thumbnail'] ?? $thumbnail ?? '';
                        if (preg_match('/^http/', $thumb)) {
                            $imgSrc = 'assets/images/no-image.png';
                        } elseif (preg_match('/^assets\/images\/product-images\//', $thumb)) {
                            $imgSrc = htmlspecialchars($thumb);
                        } elseif (preg_match('/^\//', $thumb)) {
                            $imgSrc = htmlspecialchars($thumb);
                        } else {
                            $imgPath = 'assets/images/product-images/' . $thumb;
                            if (!empty($thumb) && file_exists($imgPath)) {
                                $imgSrc = $imgPath;
                            } else {
                                $imgSrc = 'assets/images/no-image.png';
                            }
                        }
                        ?>
                        <img src="<?= $imgSrc ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>"
                            style="object-fit:cover; height:220px; width:100%;">
                        <div class="card-body">
                            <h6 class="card-title"><?= htmlspecialchars($product['name']) ?></h6>
                            <p class="card-text text-danger fw-bold">
                                <?= number_format($product['price'], 0, ',', '.') ?> đ
                            </p>
                            <p class="text-muted">In stock: <?= $product['stock'] ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php else: ?>
            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                        type="button">All</button>
                </li>
                <?php foreach ($categories as $cat): ?>
                <li class="nav-item">
                    <button class="nav-link" id="cat<?= $cat['id'] ?>-tab" data-bs-toggle="tab"
                        data-bs-target="#cat<?= $cat['id'] ?>" type="button">
                        <?= htmlspecialchars($cat['name']) ?>
                    </button>
                </li>
                <?php endforeach; ?>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="all">
                    <div class="row">
                        <?php foreach ($allProducts as $product): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="<?= $product['image_url'] ?>" class="card-img-top"
                                    alt="<?= $product['name'] ?>">
                                <div class="card-body">
                                    <h6 class="card-title"><?= htmlspecialchars($product['name']) ?></h6>
                                    <p class="card-text text-danger fw-bold">
                                        <?= number_format($product['price'], 0, ',', '.') ?> đ</p>
                                    <p class="text-muted">In stock: <?= $product['stock'] ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php foreach ($categories as $index => $cat): ?>
                <div class="tab-pane fade" id="cat<?= $cat['id'] ?>" role="tabpanel">
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
                                        <form method="post" style="display:inline;">
                                            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" name="add_to_cart"
                                                class="btn p-0 border-0 bg-transparent"><i
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
                                        <p class="mb-0 h6 fw-bold product-price">
                                            <?= number_format($p['price'], 0, ',', '.') ?>₫
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php'; ?>