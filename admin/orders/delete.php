<?php
require_once __DIR__ . '/../../config/database.php';
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $pdo->prepare('DELETE FROM order_details WHERE order_id = ?')->execute([$id]);
    $pdo->prepare('DELETE FROM orders WHERE id = ?')->execute([$id]);
}
header('Location: index.php');
exit;