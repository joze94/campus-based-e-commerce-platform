<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../authentication/login.php');
    exit;
}

$orders = fetchAll('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC', [$_SESSION['user']['id']]);
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>My Orders</h1>
</div>

<?php if (!empty($orders)): ?>
    <table class="orders-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['created_at']; ?></td>
                    <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                    <td>
                        <a href="order_details.php?id=<?php echo $order['id']; ?>" class="button-small">View Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>You have no orders yet. <a href="../store/index.php">Start shopping</a></p>
<?php endif; ?>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
