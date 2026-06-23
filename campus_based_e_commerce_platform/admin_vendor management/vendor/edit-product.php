<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendor') {
    header('Location: login.php');
    exit;
}

$vendorId = $_SESSION['user']['id'];
$productId = intval($_GET['id'] ?? 0);
$product = fetchRow('SELECT * FROM products WHERE id = ? AND vendor_id = ?', [$productId, $vendorId]);

if (!$product) {
    header('Location: products.php');
    exit;
}

$categories = getAllCategories();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $categoryId = intval($_POST['category_id'] ?? 0);
    $price = floatval($_POST['price'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $shortDescription = trim($_POST['short_description'] ?? '');
    $sku = trim($_POST['sku'] ?? '');
    $mainImage = trim($_POST['main_image'] ?? '');

    if ($title && $categoryId && $price >= 0) {
        try {
            $stmt = getPDOConnection()->prepare('UPDATE products SET category_id = ?, title = ?, description = ?, short_description = ?, price = ?, quantity = ?, main_image = ?, sku = ?, updated_at = NOW() WHERE id = ? AND vendor_id = ?');
            $stmt->execute([$categoryId, $title, $description, $shortDescription, $price, $quantity, $mainImage, $sku, $productId, $vendorId]);
            $message = 'Product updated successfully!';
            $product = fetchRow('SELECT * FROM products WHERE id = ? AND vendor_id = ?', [$productId, $vendorId]);
        } catch (PDOException $e) {
            $message = 'Error updating product.';
        }
    } else {
        $message = 'Please fill in all required fields.';
    }
}
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Edit Product</h1>
</div>

<?php if ($message): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<div class="card" style="max-width: 800px;">
    <form method="POST" action="">
        <div class="grid grid-2">
            <div class="form-group">
                <label for="title">Product Title *</label>
                <input id="title" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="sku">SKU</label>
                <input id="sku" name="sku" value="<?php echo htmlspecialchars($product['sku']); ?>">
            </div>
        </div>

        <div class="grid grid-2">
            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id'] == $product['category_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price *</label>
                <input id="price" name="price" type="number" step="0.01" min="0" value="<?php echo $product['price']; ?>" required>
            </div>
        </div>

        <div class="grid grid-2">
            <div class="form-group">
                <label for="quantity">Stock Quantity *</label>
                <input id="quantity" name="quantity" type="number" min="0" value="<?php echo $product['quantity']; ?>" required>
            </div>
            <div class="form-group">
                <label for="main_image">Image URL</label>
                <input id="main_image" name="main_image" type="url" value="<?php echo htmlspecialchars($product['main_image']); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_description" rows="2"><?php echo htmlspecialchars($product['short_description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="description">Full Description</label>
            <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

        <button type="submit" class="button">Save Changes</button>
        <a href="products.php" class="button" style="background-color: #95a5a6;">Cancel</a>
    </form>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
