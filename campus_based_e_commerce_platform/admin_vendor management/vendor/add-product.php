<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'vendor') {
    header('Location: login.php');
    exit;
}

$vendorId = $_SESSION['user']['id'];
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
    $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $title), '-'));

    if ($title && $categoryId && $price >= 0) {
        try {
            $stmt = getPDOConnection()->prepare('INSERT INTO products (vendor_id, category_id, title, slug, description, short_description, price, quantity, main_image, sku, status) 
                                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$vendorId, $categoryId, $title, $slug, $description, $shortDescription, $price, $quantity, $mainImage, $sku, 'active']);
            $message = 'Product added successfully!';
            header('Refresh: 1; url=products.php');
        } catch (PDOException $e) {
            $message = 'Error adding product.';
        }
    } else {
        $message = 'Please fill in all required fields.';
    }
}
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Add Product</h1>
</div>

<?php if ($message): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>

<div class="card" style="max-width: 800px;">
    <form method="POST" action="">
        <div class="grid grid-2">
            <div class="form-group">
                <label for="title">Product Title *</label>
                <input id="title" name="title" placeholder="Enter product title" required>
            </div>
            <div class="form-group">
                <label for="sku">SKU</label>
                <input id="sku" name="sku" placeholder="Stock Keeping Unit">
            </div>
        </div>

        <div class="grid grid-2">
            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select a category</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price *</label>
                <input id="price" name="price" type="number" step="0.01" min="0" placeholder="0.00" required>
            </div>
        </div>

        <div class="grid grid-2">
            <div class="form-group">
                <label for="quantity">Stock Quantity *</label>
                <input id="quantity" name="quantity" type="number" min="0" placeholder="0" required>
            </div>
            <div class="form-group">
                <label for="main_image">Image URL</label>
                <input id="main_image" name="main_image" type="url" placeholder="https://...">
            </div>
        </div>

        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_description" rows="2" placeholder="Brief product description"></textarea>
        </div>

        <div class="form-group">
            <label for="description">Full Description</label>
            <textarea id="description" name="description" rows="5" placeholder="Detailed product information"></textarea>
        </div>

        <button type="submit" class="button">Add Product</button>
        <a href="products.php" class="button" style="background-color: #95a5a6;">Cancel</a>
    </form>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
