<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

$searchQuery = trim($_GET['q'] ?? '');
$results = [];

if ($searchQuery) {
    $searchTerm = '%' . $searchQuery . '%';
    $results = fetchAll('SELECT p.*, c.name as category_name, u.username as vendor_name FROM products p 
                        LEFT JOIN categories c ON p.category_id = c.id 
                        LEFT JOIN users u ON p.vendor_id = u.id 
                        WHERE p.status = "active" AND (p.title LIKE ? OR p.description LIKE ? OR c.name LIKE ?) 
                        ORDER BY p.title', [$searchTerm, $searchTerm, $searchTerm]);
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Search Products</h1>
</div>

<div class="container">
    <div class="card" style="margin-bottom: 2rem;">
        <form method="GET" action="" style="display: flex; gap: 1rem;">
            <input 
                type="text" 
                name="q" 
                placeholder="Search products, categories..." 
                value="<?php echo htmlspecialchars($searchQuery); ?>"
                style="flex: 1; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;"
            >
            <button type="submit" class="button">Search</button>
        </form>
    </div>

    <?php if ($searchQuery): ?>
        <?php if (!empty($results)): ?>
            <h2>Results for "<?php echo htmlspecialchars($searchQuery); ?>" (<?php echo count($results); ?> found)</h2>
            <div class="products-grid">
                <?php foreach ($results as $product): ?>
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
                            <p class="vendor" style="font-size: 0.875rem; color: #7f8c8d;">by <?php echo htmlspecialchars($product['vendor_name']); ?></p>
                            <div class="product-footer">
                                <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                                <a href="../store/product_details.php?id=<?php echo $product['id']; ?>" class="button">View</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card">
                <h2>No results found for "<?php echo htmlspecialchars($searchQuery); ?>"</h2>
                <p>Try searching with different keywords or <a href="../store/categories.php">browse by category</a></p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="card">
            <p>Enter a search term to find products.</p>
        </div>
    <?php endif; ?>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
