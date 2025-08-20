<?php
session_start();
require_once __DIR__ . '/config/database.php';
include 'header.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
if (!$user_id) {
    echo '<div class="container py-5"><div class="alert alert-warning">You need to log in to view your orders.</div></div>';
    include 'footer.php';
    exit;
}

// View order details
$order_detail = null;
if (isset($_GET['order_id'])) {
    $order_id = (int)$_GET['order_id'];
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ? AND user_id = ?');
    $stmt->execute([$order_id, $user_id]);
    $order_detail = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($order_detail) {
        $stmt_items = $pdo->prepare('SELECT od.quantity, od.price, od.subtotal, p.name FROM order_details od JOIN products p ON od.product_id = p.id WHERE od.order_id = ?');
        $stmt_items->execute([$order_id]);
        $order_items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Get all orders
$stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="page-content">
    <div class="container py-4">
        <h3 class="fw-bold mb-4">My Orders</h3>

        <?php if ($order_detail): ?>
        <div class="card mb-4">
            <div class="card-header fw-bold">Order Details #<?= htmlspecialchars($order_detail['order_code']) ?></div>
            <div class="card-body">
                <p><b>Order Date:</b> <?= htmlspecialchars($order_detail['created_at']) ?></p>
                <p><b>Status:</b> <?= htmlspecialchars($order_detail['status']) ?></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt_items = $pdo->prepare('SELECT od.*, p.name, pi.image_url FROM order_details od 
                            JOIN products p ON od.product_id = p.id 
                            LEFT JOIN product_images pi ON pi.product_id = p.id 
                            WHERE od.order_id = ? GROUP BY od.id');
                        $stmt_items->execute([$order_detail['id']]);
                        $order_details_rows = $stmt_items->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($order_details_rows as $row): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><img src="assets/images/product-images/<?= htmlspecialchars($row['image_url'] ?? 'no-image.png') ?>"
                                    alt="" style="width:50px; height:50px; object-fit:cover;"></td>
                            <td><?= $row['quantity'] ?></td>
                            <td><?= number_format($row['price'], 0, ',', '.') ?>₫</td>
                            <td><?= number_format($row['subtotal'], 0, ',', '.') ?>₫</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="mt-3">
                    <b>Subtotal:</b> <?= number_format($order_detail['subtotal'], 0, ',', '.') ?>₫<br>
                    <b>Tax:</b> <?= number_format($order_detail['tax_fee'], 0, ',', '.') ?>₫<br>
                    <b>Total:</b> <?= number_format($order_detail['total'], 0, ',', '.') ?>₫
                </div>
                <a href="<?= APP_URL ?>/account-orders.php" class="btn btn-outline-dark mt-3">Back to Order List</a>
            </div>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header fw-bold">Order List</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Order Code</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['order_code']) ?></td>
                                <td><?= htmlspecialchars($order['created_at']) ?></td>
                                <td><?= htmlspecialchars($order['status']) ?></td>
                                <td><?= number_format($order['total'], 0, ',', '.') ?>₫</td>
                                <td><a href="<?= APP_URL ?>/account-orders.php?order_id=<?= $order['id'] ?>"
                                        class="btn btn-sm btn-dark">View Details</a></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="5" class="text-center">You have no orders yet.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>