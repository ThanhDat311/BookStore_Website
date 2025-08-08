<?php
require_once __DIR__ . '/../../config/database.php';
$id = (int)($_GET['id'] ?? 0);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? '';
    $stmt = $pdo->prepare('UPDATE orders SET status = ? WHERE id = ?');
    $stmt->execute([$status, $id]);
    // TODO: send notification email if needed
    header('Location: index.php');
    exit;
}
$stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
$stmt->execute([$id]);
$order = $stmt->fetch();
?>
<?php include '../admin_header.php'; ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Update Order Status</h1>
    <?php if ($order): ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="pending" <?= $order['status']=='pending'?'selected':'' ?>>Pending</option>
                <option value="approved" <?= $order['status']=='approved'?'selected':'' ?>>Approved</option>
                <option value="cancelled" <?= $order['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </form>
    <?php else: ?>
    <div class="alert alert-danger">Order not found.</div>
    <?php endif; ?>
</div>
<?php include '../admin_footer.php'; ?>