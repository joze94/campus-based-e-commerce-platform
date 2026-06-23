<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../authentication/login.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shippingAddress = trim($_POST['shipping_address'] ?? '');
    
    if (empty($shippingAddress)) {
        $message = 'Shipping address is required.';
    } else {
        $total = 0;
        $items = [];
        foreach ($cart as $productId => $item) {
            $total += $item['price'] * $item['quantity'];
            $items[] = [
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ];
        }
        
        $orderId = createOrder($_SESSION['user']['id'], $total, $shippingAddress, $items);
        
        if ($orderId) {
            unset($_SESSION['cart']);
            header('Location: order_confirmation.php?order_id=' . $orderId);
            exit;
        } else {
            $message = 'Error creating order. Please try again.';
        }
    }
}

$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Checkout</h1>
</div>

<?php if ($message): ?>
    <div class="alert alert-error"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<div class="checkout-container">
    <div class="checkout-form">
        <h3>Shipping Information</h3>
        <form method="POST" action="">
            <div class="form-group">
                <label for="shipping_address">Shipping Address</label>
                <textarea id="shipping_address" name="shipping_address" rows="4" required></textarea>
            </div>
            <button type="submit" class="button">Place Order</button>
        </form>
    </div>
    
    <div class="order-summary">
        <h3>Order Summary</h3>
        <table class="cart-table">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php foreach ($cart as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p class="total-price">Total: $<?php echo number_format($total, 2); ?></p>
    </div>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
