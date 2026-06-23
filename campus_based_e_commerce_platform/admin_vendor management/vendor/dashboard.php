<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendor') {
    header('Location: login.php');
    exit;
}

$vendorId = $_SESSION['user']['id'];
$vendorProducts = fetchAll('SELECT * FROM products WHERE vendor_id = ? ORDER BY created_at DESC', [$vendorId]);
$totalProducts = count($vendorProducts);
$totalSales = fetchRow('SELECT SUM(o.total_amount) as total FROM order_items oi 
                        JOIN orders o ON oi.order_id = o.id 
                        JOIN products p ON oi.product_id = p.id 
                        WHERE p.vendor_id = ?', [$vendorId])['total'] ?? 0;
$totalOrders = fetchRow('SELECT COUNT(DISTINCT o.id) as count FROM order_items oi 
                         JOIN orders o ON oi.order_id = o.id 
                         JOIN products p ON oi.product_id = p.id 
                         WHERE p.vendor_id = ?', [$vendorId])['count'] ?? 0;
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Vendor Dashboard</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Products</h3>
        <p class="stat-number"><?php echo $totalProducts; ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Sales</h3>
        <p class="stat-number">$<?php echo number_format($totalSales, 2); ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Orders</h3>
        <p class="stat-number"><?php echo $totalOrders; ?></p>
    </div>
</div>

<div class="admin-menu">
    <h2>Management</h2>
    <ul class="menu-list">
        <li><a href="products.php" class="button">View Products</a></li>
        <li><a href="add-product.php" class="button">Add Product</a></li>
        <li><a href="sales.php" class="button">View Sales</a></li>
        <li><a href="profile.php" class="button">Edit Profile</a></li>
    </ul>
</div>

<div style="margin-top: 20px;">
    <a href="../../authentication/logout.php" class="button">Logout</a>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
