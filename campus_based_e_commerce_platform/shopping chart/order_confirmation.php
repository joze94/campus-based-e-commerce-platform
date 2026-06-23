<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

$orderId = intval($_GET['order_id'] ?? 0);
$order = fetchRow('SELECT * FROM orders WHERE id = ?', [$orderId]);

if (!$order || $order['user_id'] !== $_SESSION['user']['id']) {
    header('Location: ../store/index.php');
    exit;
}

$orderItems = fetchAll('SELECT oi.*, p.title FROM order_items oi 
                        LEFT JOIN products p ON oi.product_id = p.id 
                        WHERE oi.order_id = ?', [$orderId]);
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Order Confirmation</h1>
</div>

<div class="confirmation-card">
    <div class="alert alert-success">
        <h2>Thank you for your order!</h2>
        <p>Your order #<?php echo $orderId; ?> has been placed successfully.</p>
    </div>
    
    <div class="order-details">
        <h3>Order Details</h3>
        <p><strong>Order ID:</strong> <?php echo $orderId; ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
        <p><strong>Total Amount:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
        <p><strong>Shipping Address:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
        <p><strong>Order Date:</strong> <?php echo $order['created_at']; ?></p>
    </div>
    
    <div class="order-items">
        <h3>Items</h3>
        <table class="cart-table">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php foreach ($orderItems as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="../store/index.php" class="button">Continue Shopping</a>
        <a href="orders.php" class="button">View My Orders</a>
    </div>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
