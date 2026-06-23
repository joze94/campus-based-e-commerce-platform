<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendor') {
    header('Location: login.php');
    exit;
}

$vendorId = $_SESSION['user']['id'];
$products = fetchAll('SELECT p.*, c.name as category_name FROM products p 
                      LEFT JOIN categories c ON p.category_id = c.id 
                      WHERE p.vendor_id = ? 
                      ORDER BY p.created_at DESC', [$vendorId]);
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>My Products</h1>
    <a href="add-product.php" class="button">Add New Product</a>
</div>

<?php if (!empty($products)): ?>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Created</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['title']); ?></td>
                    <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo htmlspecialchars($product['status']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($product['created_at'])); ?></td>
                    <td>
                        <a href="edit-product.php?id=<?php echo $product['id']; ?>" class="button-small">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="card">
        <p>You haven't added any products yet. <a href="add-product.php">Add your first product</a></p>
    </div>
<?php endif; ?>

<div style="margin-top: 20px;">
    <a href="dashboard.php" class="button">Back to Dashboard</a>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
