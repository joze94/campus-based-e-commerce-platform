<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendor') {
    header('Location: login.php');
    exit;
}

$vendorId = $_SESSION['user']['id'];
$sales = fetchAll('SELECT oi.*, p.title, o.created_at as order_date, o.status, o.total_amount FROM order_items oi 
                   JOIN orders o ON oi.order_id = o.id 
                   JOIN products p ON oi.product_id = p.id 
                   WHERE p.vendor_id = ? 
                   ORDER BY o.created_at DESC', [$vendorId]);
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Sales Report</h1>
</div>

<?php if (!empty($sales)): ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales as $sale): ?>
                <tr>
                    <td><?php echo htmlspecialchars($sale['title']); ?></td>
                    <td><?php echo $sale['quantity']; ?></td>
                    <td>$<?php echo number_format($sale['price'], 2); ?></td>
                    <td>$<?php echo number_format($sale['quantity'] * $sale['price'], 2); ?></td>
                    <td><?php echo date('M d, Y', strtotime($sale['order_date'])); ?></td>
                    <td><?php echo htmlspecialchars($sale['status']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="card">
        <p>No sales yet.</p>
    </div>
<?php endif; ?>

<div style="margin-top: 20px;">
    <a href="dashboard.php" class="button">Back to Dashboard</a>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
