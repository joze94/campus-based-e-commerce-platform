<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$totalUsers = fetchRow('SELECT COUNT(*) as count FROM users')['count'];
$totalProducts = fetchRow('SELECT COUNT(*) as count FROM products')['count'];
$totalOrders = fetchRow('SELECT COUNT(*) as count FROM orders')['count'];
$totalRevenue = fetchRow('SELECT SUM(total_amount) as total FROM orders')['total'] ?? 0;
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Admin Dashboard</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Users</h3>
        <p class="stat-number"><?php echo $totalUsers; ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Products</h3>
        <p class="stat-number"><?php echo $totalProducts; ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Orders</h3>
        <p class="stat-number"><?php echo $totalOrders; ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Revenue</h3>
        <p class="stat-number">$<?php echo number_format($totalRevenue, 2); ?></p>
    </div>
</div>

<div class="admin-menu">
    <h2>Management</h2>
    <ul class="menu-list">
        <li><a href="users.php" class="button">Manage Users</a></li>
        <li><a href="products.php" class="button">Manage Products</a></li>
        <li><a href="categories.php" class="button">Manage Categories</a></li>
        <li><a href="orders.php" class="button">View Orders</a></li>
    </ul>
</div>

<div style="margin-top: 20px;">
    <a href="../../authentication/logout.php" class="button">Logout</a>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
