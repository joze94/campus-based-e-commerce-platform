<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

$categories = getAllCategories();
$products = fetchAll('SELECT p.*, c.name as category_name FROM products p 
                      LEFT JOIN categories c ON p.category_id = c.id 
                      WHERE p.status = "active" 
                      ORDER BY p.created_at DESC LIMIT 12');
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Welcome to Campus Shop</h1>
    <p>Browse products from verified vendors on campus</p>
</div>

<div class="filters">
    <h3>Categories</h3>
    <div class="category-list">
        <a href="index.php" class="category-link">All Products</a>
        <?php foreach ($categories as $category): ?>
            <a href="products_browse_by_category.php?id=<?php echo $category['id']; ?>" class="category-link">
                <?php echo htmlspecialchars($category['name']); ?>
            </a>
        <?php endforeach; ?>
    </div>
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
                    <p class="category"><?php echo htmlspecialchars($product['category_name']); ?></p>
                    <p class="description"><?php echo htmlspecialchars(substr($product['short_description'] ?? $product['description'], 0, 100)); ?>...</p>
                    <div class="product-footer">
                        <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                        <a href="product_details.php?id=<?php echo $product['id']; ?>" class="button">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products available yet.</p>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
