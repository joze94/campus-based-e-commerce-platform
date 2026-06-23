<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$orders = fetchAll('SELECT o.*, u.username, up.first_name, up.last_name FROM orders o 
                    LEFT JOIN users u ON o.user_id = u.id 
                    LEFT JOIN user_profiles up ON u.id = up.user_id 
                    ORDER BY o.created_at DESC');
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>View Orders</h1>
</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo htmlspecialchars($order['username']); ?></td>
                <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
                <td><?php echo $order['created_at']; ?></td>
                <td>
                    <a href="../../shopping%20chart/order_details.php?id=<?php echo $order['id']; ?>" class="button-small">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div style="margin-top: 20px;">
    <a href="dashboard.php" class="button">Back to Dashboard</a>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
