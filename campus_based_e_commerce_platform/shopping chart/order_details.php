<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../authentication/login.php');
    exit;
}

$orderId = intval($_GET['id'] ?? 0);
$order = fetchRow('SELECT * FROM orders WHERE id = ?', [$orderId]);
$isAdmin = ($_SESSION['user']['role'] ?? '') === 'admin';

if (!$order || (!$isAdmin && (int) $order['user_id'] !== (int) $_SESSION['user']['id'])) {
    header('Location: orders.php');
    exit;
}

$orderItems = fetchAll('SELECT oi.*, p.title FROM order_items oi 
                        LEFT JOIN products p ON oi.product_id = p.id 
                        WHERE oi.order_id = ?', [$orderId]);
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Order Details</h1>
</div>

<div class="card">
    <div class="order-details">
        <h3>Order #<?php echo $orderId; ?></h3>
        <p><strong>Date:</strong> <?php echo $order['created_at']; ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
        <p><strong>Total Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
        <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
    </div>
    
    <h4>Items</h4>
    <table class="cart-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td>$<?php echo number_format($item['quantity'] * $item['price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        <?php if ($isAdmin): ?>
            <a href="../admin_vendor%20management/admin/orders.php" class="button">Back to Orders</a>
        <?php else: ?>
            <a href="orders.php" class="button">Back to Orders</a>
        <?php endif; ?>
        <a href="../store/index.php" class="button">Continue Shopping</a>
    </div>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
