<?php
require_once __DIR__ . '/../../config/database.php';
include __DIR__ . '/../admin_header.php';
// Get user list
$users = $pdo->query('SELECT id, name FROM users')->fetchAll();
// Handle order creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_code = 'OD' . date('YmdHis') . rand(100,999);
    $user_id = (int)$_POST['user_id'];
    $subtotal = (float)$_POST['subtotal'];
    $tax_fee = (float)$_POST['tax_fee'];
    $total = (float)$_POST['total'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare('INSERT INTO orders (order_code, user_id, subtotal, tax_fee, total, status) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$order_code, $user_id, $subtotal, $tax_fee, $total, $status]);
    header('Location: index.php');
    exit;
}
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add Order</h1>
    <form method="post">
        <div class="mb-3">
            <label>Customer</label>
            <select name="user_id" class="form-select" required>
                <?php foreach ($users as $u): ?>
                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Subtotal</label>
            <input type="number" step="0.01" name="subtotal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tax</label>
            <input type="number" step="0.01" name="tax_fee" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Total</label>
            <input type="number" step="0.01" name="total" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Add Order</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>
<?php include '../admin_footer.php'; ?>