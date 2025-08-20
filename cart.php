<?php
session_start();
require_once __DIR__ . '/config/database.php';

// Handle product update/removal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_qty']) && isset($_POST['pid']) && isset($_POST['qty'])) {
        $pid = (int)$_POST['pid'];
        $qty = max(1, (int)$_POST['qty']);
        if (isset($_SESSION['cart'][$pid])) {
            $_SESSION['cart'][$pid] = $qty;
        }
        header('Location: cart.php');
        exit;
    }
    if (isset($_POST['remove_pid'])) {
        $pid = (int)$_POST['remove_pid'];
        unset($_SESSION['cart'][$pid]);
        header('Location: cart.php');
        exit;
    }

    // Handle order submission
    if (isset($_POST['place_order'])) {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $products = [];
        $total = 0;
        if ($cart) {
            $ids = implode(',', array_map('intval', array_keys($cart)));
            $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
            while ($row = $stmt->fetch()) {
                $row['cart_qty'] = $cart[$row['id']];
                $row['cart_total'] = $row['cart_qty'] * $row['price'];
                $products[] = $row;
                $total += $row['cart_total'];
            }
        }
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
        $subtotal = $total;
        $tax_fee = round($subtotal * 0.05, 2); // 5% tax
        $grand_total = $subtotal + $tax_fee;
        $order_code = 'OD' . date('YmdHis') . rand(100,999);
        $status = 'pending';
        
        // Save order
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, order_code, status, subtotal, tax_fee, total, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute([$user_id, $order_code, $status, $subtotal, $tax_fee, $grand_total]);
        $order_id = $pdo->lastInsertId();

        // Save order details
        foreach ($products as $p) {
            $stmt = $pdo->prepare("INSERT INTO order_details (order_id, product_id, price, quantity, subtotal) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $order_id,
                $p['id'],
                $p['price'],
                $p['cart_qty'],
                $p['cart_total']
            ]);
        }

        // Clear cart
        unset($_SESSION['cart']);
        $_SESSION['order_success'] = 'Order placed successfully! Order code: ' . $order_code;
        header('Location: cart.php');
        exit;
    }
}

include 'header.php';

// Get products in cart
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$products = [];
$total = 0;
if ($cart) {
    $ids = implode(',', array_map('intval', array_keys($cart)));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    while ($row = $stmt->fetch()) {
        $row['cart_qty'] = $cart[$row['id']];
        $row['cart_total'] = $row['cart_qty'] * $row['price'];
        $products[] = $row;
        $total += $row['cart_total'];
    }
}
?>

<!--end top header-->

<!--start page content-->
<div class="page-content">

    <!--start breadcrumb-->
    <div class="py-4 border-bottom">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:;">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <!--start product details-->
    <section class="section-padding">
        <div class="container">

            <div class="d-flex align-items-center px-3 py-2 border mb-4">
                <div class="text-start">
                    <h4 class="mb-0 h4 fw-bold">My Bag (<?= array_sum(array_column($products, 'cart_qty')) ?> items)
                    </h4>
                </div>
                <div class="ms-auto">
                    <a href="<?= APP_URL ?>/index.php" class="btn btn-light btn-ecomm">Continue Shopping</a>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-12 col-xl-8">
                    <?php if (empty($products)): ?>
                    <div class="alert alert-info">Your cart is currently empty.</div>
                    <?php else: ?>
                    <?php foreach ($products as $item): ?>
                    <div class="card rounded-0 mb-3">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-lg-row gap-3">
                                <div class="product-img">
                                    <img src="assets/images/product-images/<?= htmlspecialchars($item['thumbnail']) ?>"
                                        width="120" alt="<?= htmlspecialchars($item['name']) ?>">
                                </div>
                                <div class="product-info flex-grow-1">
                                    <h5 class="fw-bold mb-0"><?= htmlspecialchars($item['name']) ?></h5>
                                    <div class="product-price d-flex align-items-center gap-2 mt-3">
                                        <div class="h6 fw-bold"><?= number_format($item['price'], 0, ',', '.') ?>₫</div>
                                    </div>
                                    <form method="post" class="mt-3 d-flex align-items-center gap-2">
                                        <input type="hidden" name="pid" value="<?= $item['id'] ?>">
                                        <input type="number" name="qty" value="<?= $item['cart_qty'] ?>" min="1"
                                            class="form-control form-control-sm" style="width:70px;">
                                        <button type="submit" name="update_qty"
                                            class="btn btn-sm btn-dark">Update</button>
                                    </form>
                                </div>
                                <div class="d-none d-lg-block vr"></div>
                                <div class="d-grid gap-2 align-self-start align-self-lg-center">
                                    <form method="post">
                                        <input type="hidden" name="remove_pid" value="<?= $item['id'] ?>">
                                        <button type="submit" class="btn btn-ecomm"><i
                                                class="bi bi-x-lg me-2"></i>Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="card rounded-0 mb-3">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4">Order Summary</h5>
                            <div class="hstack align-items-center justify-content-between">
                                <p class="mb-0">Bag Total</p>
                                <p class="mb-0"><?= number_format($total, 0, ',', '.') ?>₫</p>
                            </div>
                            <hr>
                            <div class="hstack align-items-center justify-content-between fw-bold text-content">
                                <p class="mb-0">Total Amount</p>
                                <p class="mb-0"><?= number_format($total, 0, ',', '.') ?>₫</p>
                            </div>
                            <div class="d-grid mt-4">
                                <form method="post">
                                    <button type="submit" name="place_order" class="btn btn-dark btn-ecomm py-3 px-5"
                                        <?= empty($products) ? 'disabled' : '' ?>>Place Order</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->

        </div>
    </section>
    <!--end product details-->
</div>
<!--end page content-->

<?php include 'footer.php'; ?>
</div>

<!--start qty modal-->
<div class="modal" id="QtyModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content rounded-0">
            <div class="modal-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="">
                        <h5 class="fw-bold mb-0">Select Quantity</h5>
                    </div>
                    <div class="">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <hr>
                <div class="size-chart">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <?php for ($i = 1; $i <= 12; $i++): ?>
                        <div><button type="button"><?= $i ?></button></div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="button" class="btn btn-dark btn-ecomm">Done</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!--end qty modal-->

<!--Back To Top Button-->
<a href="javaScript:;" class="back-to-top"><i class="bi bi-arrow-up"></i></a>
<!--End Back To Top Button-->

<!-- JavaScript files -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/slick/slick.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/loader.js"></script>

<?php if (!empty($_SESSION['order_success'])): ?>
<script>
toastr.success('<?= $_SESSION['order_success'] ?>');
</script>
<?php unset($_SESSION['order_success']); ?>
<?php endif; ?>

</body>

</html>