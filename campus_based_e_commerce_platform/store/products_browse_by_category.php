<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

$categoryId = intval($_GET['id'] ?? 0);
$category = fetchRow('SELECT * FROM categories WHERE id = ?', [$categoryId]);

if (!$category) {
    header('Location: index.php');
    exit;
}

$products = getProductsByCategory($categoryId);
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1><?php echo htmlspecialchars($category['name']); ?></h1>
    <p><?php echo htmlspecialchars($category['description'] ?? ''); ?></p>
</div>

<div class="products-grid">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <?php if ($product['main_image']): ?>
                        <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                    <?php else: ?>
                        <div style="background: #e0e0e0; height: 200px; display: flex; align-items: center; justify-content: center;">No Image</div>
                    <?php endif; ?>
                </div>
                <div class="product-info">
                    <h4><?php echo htmlspecialchars($product['title']); ?></h4>
                    <p class="description"><?php echo htmlspecialchars(substr($product['short_description'] ?? $product['description'], 0, 100)); ?>...</p>
                    <div class="product-footer">
                        <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                        <a href="product_details.php?id=<?php echo $product['id']; ?>" class="button">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products in this category yet.</p>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
