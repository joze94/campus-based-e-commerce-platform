<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();

$categories = getAllCategories();
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Categories</h1>
</div>

<div class="categories-grid">
    <?php foreach ($categories as $category): ?>
        <div class="category-card">
            <h3><?php echo htmlspecialchars($category['name']); ?></h3>
            <p><?php echo htmlspecialchars($category['description'] ?? ''); ?></p>
            <a href="products_browse_by_category.php?id=<?php echo $category['id']; ?>" class="button">Browse Products</a>
        </div>
    <?php endforeach; ?>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
