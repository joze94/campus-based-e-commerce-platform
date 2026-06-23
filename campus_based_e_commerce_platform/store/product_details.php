<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

$productId = intval($_GET['id'] ?? 0);
$product = getProductDetails($productId);

if (!$product) {
    header('Location: index.php');
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user'])) {
    $quantity = intval($_POST['quantity'] ?? 1);
    
    if ($quantity > 0 && $quantity <= $product['quantity']) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'product_id' => $productId,
                'title' => $product['title'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }
        $message = 'Product added to cart!';
    } else {
        $message = 'Invalid quantity.';
    }
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1><?php echo htmlspecialchars($product['title']); ?></h1>
</div>

<div class="product-detail">
    <div class="product-detail-image">
        <?php if ($product['main_image']): ?>
            <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
        <?php else: ?>
            <div style="background: #e0e0e0; height: 400px; display: flex; align-items: center; justify-content: center;">No Image</div>
        <?php endif; ?>
    </div>
    
    <div class="product-detail-info">
        <p class="category">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
        <p class="vendor">Vendor: <?php echo htmlspecialchars($product['vendor_name']); ?></p>
        <p class="price-large">$<?php echo number_format($product['price'], 2); ?></p>
        
        <?php if ($message): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <div class="product-description">
            <h3>Description</h3>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
        </div>
        
        <p class="stock">Available: <?php echo htmlspecialchars($product['quantity']); ?> units</p>
        
        <?php if (isset($_SESSION['user'])): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $product['quantity']; ?>" value="1" required>
                </div>
                <button type="submit" class="button">Add to Cart</button>
            </form>
        <?php else: ?>
            <p><a href="../authentication/login.php">Login</a> to add items to cart.</p>
        <?php endif; ?>
    </div>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
