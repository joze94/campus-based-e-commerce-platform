<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$categories = getAllCategories();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($name)) {
        $message = 'Category name is required.';
    } else {
        try {
            $stmt = getPDOConnection()->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
            $stmt->execute([$name, $description]);
            $message = 'Category added successfully.';
            $categories = getAllCategories();
        } catch (PDOException $e) {
            $message = 'Error adding category.';
        }
    }
}
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Manage Categories</h1>
</div>

<?php if ($message): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<div class="card" style="max-width: 500px;">
    <h3>Add New Category</h3>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3"></textarea>
        </div>
        <button type="submit" class="button">Add Category</button>
    </form>
</div>

<h3 style="margin-top: 30px;">Existing Categories</h3>
<table class="admin-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Products</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo htmlspecialchars($category['name']); ?></td>
                <td><?php echo htmlspecialchars($category['description'] ?? ''); ?></td>
                <td>
                    <?php 
                    $count = fetchRow('SELECT COUNT(*) as count FROM products WHERE category_id = ?', [$category['id']])['count'];
                    echo $count;
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div style="margin-top: 20px;">
    <a href="dashboard.php" class="button">Back to Dashboard</a>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
