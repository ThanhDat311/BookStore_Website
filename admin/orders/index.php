<?php
require_once __DIR__ . '/../../config/database.php';
include __DIR__ . '/../admin_header.php';

// Get status filter if available
$status = isset($_GET['status']) ? $_GET['status'] : '';
$where = $status ? "WHERE status = '" . addslashes($status) . "'" : '';
$sql = "SELECT o.*, u.name as customer FROM orders o LEFT JOIN users u ON o.user_id = u.id $where ORDER BY o.created_at DESC";
$stmt = $pdo->query($sql);
$orders = $stmt->fetchAll();
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Order Management</h1>
    <form class="mb-3" method="get">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" <?= $status=='pending'? 'selected':'' ?>>Pending</option>
                    <option value="approved" <?= $status=='approved'? 'selected':'' ?>>Approved</option>
                    <option value="cancelled" <?= $status=='cancelled'? 'selected':'' ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Order Code</th>
                <th>Customer</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['order_code']) ?></td>
                <td><?= htmlspecialchars($order['customer']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                <td><span
                        class="badge bg-<?= $order['status']=='approved'?'success':($order['status']=='cancelled'?'danger':'warning') ?>"><?= htmlspecialchars($order['status']) ?></span>
                </td>
                <td><?= number_format($order['total'], 0, ',', '.') ?>₫</td>
                <td>
                    <a href="detail.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-info">View</a>
                    <a href="edit.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete.php?id=<?= $order['id'] ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this order?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include '../admin_footer.php'; ?>