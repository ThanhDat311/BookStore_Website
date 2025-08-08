<?php
require_once __DIR__ . '/../../config/database.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int)$_POST['user_id'];
    $subtotal = (float)$_POST['subtotal'];
    $tax_fee = (float)$_POST['tax_fee'];
    $total = (float)$_POST['total'];
    $status = $_POST['status'];
    $stmt = $pdo->prepare('UPDATE orders SET user_id=?, subtotal=?, tax_fee=?, total=?, status=? WHERE id=?');
    $stmt->execute([$user_id, $subtotal, $tax_fee, $total, $status, $id]);
    header('Location: index.php');
    exit;
}
include __DIR__ . '/../admin_header.php';
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
$stmt->execute([$id]);
$order = $stmt->fetch();
if (!$order) {
    echo '<div class="container py-5"><div class="alert alert-danger">Order not found.</div></div>';
    include '../admin_footer.php';
    exit;
}
$users = $pdo->query('SELECT id, name FROM users')->fetchAll();
?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Order</h1>
    <form method="post">
        <div class="mb-3">
            <label>Customer</label>
            <select name="user_id" class="form-select" required>
                <?php foreach ($users as $u): ?>
                <option value="<?= $u['id'] ?>" <?= $order['user_id']==$u['id']?'selected':'' ?>>
                    <?= htmlspecialchars($u['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Subtotal</label>
            <input type="number" step="0.01" name="subtotal" class="form-control" value="<?= $order['subtotal'] ?>"
                required>
        </div>
        <div class="mb-3">
            <label>Tax</label>
            <input type="number" step="0.01" name="tax_fee" class="form-control" value="<?= $order['tax_fee'] ?>"
                required>
        </div>
        <div class="mb-3">
            <label>Total</label>
            <input type="number" step="0.01" name="total" class="form-control" value="<?= $order['total'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="pending" <?= $order['status']=='pending'?'selected':'' ?>>Pending</option>
                <option value="approved" <?= $order['status']=='approved'?'selected':'' ?>>Approved</option>
                <option value="cancelled" <?= $order['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Order</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
</div>
<?php include '../admin_footer.php'; ?>