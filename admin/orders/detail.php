<?php
require_once __DIR__ . '/../../config/database.php';
include __DIR__ . '/../admin_header.php';
$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT o.*, u.name as customer FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE o.id = ?');
$stmt->execute([$id]);
$order = $stmt->fetch();
$stmt2 = $pdo->prepare('SELECT od.*, p.name as product_name, p.thumbnail, p.descriptions FROM order_details od LEFT JOIN products p ON od.product_id = p.id WHERE od.order_id = ?');
$stmt2->execute([$id]);
$details = $stmt2->fetchAll();
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Order Details</h1>
    <?php if ($order): ?>
    <div class="mb-3">
        <strong>Order Code:</strong> <?= htmlspecialchars($order['order_code']) ?><br>
        <strong>Customer:</strong> <?= htmlspecialchars($order['customer']) ?><br>
        <strong>Order Date:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?><br>
        <strong>Note:</strong> <?= htmlspecialchars($order['note']) ?><br>
        <strong>Status:</strong>
        <span
            class="badge bg-<?= $order['status']=='approved'?'success':($order['status']=='cancelled'?'danger':'warning') ?>">
            <?= htmlspecialchars($order['status']) ?>
        </span><br>
        <strong>Subtotal:</strong> <?= number_format($order['subtotal'], 0, ',', '.') ?>₫<br>
        <strong>Tax:</strong> <?= number_format($order['tax_fee'], 0, ',', '.') ?>₫<br>
        <strong>Total:</strong> <?= number_format($order['total'], 0, ',', '.') ?>₫
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($details as $d): ?>
            <tr>
                <td>
                    <?php
                    $img = !empty($d['thumbnail']) ? $d['thumbnail'] : 'no-image.png';
                    ?>
                    <img src="../../assets/images/product-images/<?= htmlspecialchars($img) ?>" width="60"
                        alt="<?= htmlspecialchars($d['product_name']) ?>">
                </td>
                <td><?= htmlspecialchars($d['product_name']) ?></td>
                <td><?= htmlspecialchars($d['descriptions'] ?? '') ?></td>
                <td><?= $d['quantity'] ?></td>
                <td><?= number_format($d['price'], 0, ',', '.') ?>₫</td>
                <td><?= number_format($d['subtotal'], 0, ',', '.') ?>₫</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h5 class="mt-4">Product List in This Order:</h5>
    <ul>
        <?php foreach ($details as $d): ?>
        <li><?= htmlspecialchars($d['product_name']) ?> (x<?= $d['quantity'] ?>)</li>
        <?php endforeach; ?>
    </ul>
    <?php else: ?>
    <div class="alert alert-danger">Order not found.</div>
    <?php endif; ?>
    <a href="index.php" class="btn btn-secondary">Back</a>
</div>
<?php include '../admin_footer.php'; ?>