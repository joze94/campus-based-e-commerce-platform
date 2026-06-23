<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../authentication/login.php');
    exit;
}

$message = '';

// Handle remove item
if (isset($_GET['remove'])) {
    $productId = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        $message = 'Item removed from cart.';
    }
}

// Handle update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] ?? [] as $productId => $quantity) {
        $productId = intval($productId);
        $quantity = intval($quantity);
        if (isset($_SESSION['cart'][$productId]) && $quantity > 0) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }
    }
    $message = 'Cart updated.';
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Shopping Cart</h1>
</div>

<?php if ($message): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<?php if (!empty($cart)): ?>
    <form method="POST" action="">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $productId => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['title']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td>
                            <input type="number" name="quantities[<?php echo $productId; ?>]" value="<?php echo $item['quantity']; ?>" min="1" style="width: 60px;">
                        </td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <a href="cart.php?remove=<?php echo $productId; ?>" class="button-small" onclick="return confirm('Remove this item?');">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" name="update_cart" class="button">Update Cart</button>
    </form>

    <div class="cart-summary">
        <h3>Order Summary</h3>
        <p>Subtotal: $<?php echo number_format($total, 2); ?></p>
        <p class="total-price">Total: $<?php echo number_format($total, 2); ?></p>
        <a href="checkout.php" class="button">Proceed to Checkout</a>
    </div>
<?php else: ?>
    <p>Your cart is empty. <a href="../store/index.php">Continue shopping</a></p>
<?php endif; ?>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
