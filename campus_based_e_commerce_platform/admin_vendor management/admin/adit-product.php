<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
	header('Location: login.php');
	exit;
}

$productId = intval($_GET['id'] ?? 0);
if ($productId <= 0) {
	header('Location: products.php');
	exit;
}

$product = fetchRow('SELECT * FROM products WHERE id = ?', [$productId]);
if (!$product) {
	header('Location: products.php');
	exit;
}

$categories = getAllCategories();
$vendors = getAllVendors();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = trim($_POST['title'] ?? '');
	$sku = trim($_POST['sku'] ?? '');
	$categoryId = intval($_POST['category_id'] ?? 0);
	$vendorId = intval($_POST['vendor_id'] ?? 0);
	$price = floatval($_POST['price'] ?? 0);
	$quantity = intval($_POST['quantity'] ?? 0);
	$shortDescription = trim($_POST['short_description'] ?? '');
	$description = trim($_POST['description'] ?? '');
	$mainImage = trim($_POST['main_image'] ?? '');

	if ($title === '' || $categoryId <= 0 || $vendorId <= 0 || $price < 0) {
		$message = 'Please provide all required fields.';
	} else {
		try {
			$slug = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $title), '-'));
			$stmt = getPDOConnection()->prepare('UPDATE products SET vendor_id = ?, category_id = ?, title = ?, slug = ?, description = ?, short_description = ?, price = ?, quantity = ?, main_image = ?, sku = ?, updated_at = NOW() WHERE id = ?');
			$stmt->execute([$vendorId, $categoryId, $title, $slug, $description, $shortDescription, $price, $quantity, $mainImage, $sku, $productId]);
			$message = 'Product updated successfully.';
			$product = fetchRow('SELECT * FROM products WHERE id = ?', [$productId]);
		} catch (PDOException $e) {
			$message = 'Error updating product: ' . $e->getMessage();
		}
	}
}

?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
	<h1>Edit Product</h1>
</div>

<div class="card">
	<?php if ($message): ?>
		<div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
	<?php endif; ?>

	<form method="POST" action="">
		<div class="grid grid-2">
			<div class="form-group">
				<label for="title">Title</label>
				<input id="title" name="title" value="<?php echo htmlspecialchars($product['title']); ?>" required>
			</div>
			<div class="form-group">
				<label for="sku">SKU</label>
				<input id="sku" name="sku" value="<?php echo htmlspecialchars($product['sku']); ?>">
			</div>
		</div>

		<div class="grid grid-2">
			<div class="form-group">
				<label for="category_id">Category</label>
				<select id="category_id" name="category_id" required>
					<option value="">Select category</option>
					<?php foreach ($categories as $category): ?>
						<option value="<?php echo $category['id']; ?>" <?php echo $category['id'] == $product['category_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['name']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for="vendor_id">Vendor</label>
				<select id="vendor_id" name="vendor_id" required>
					<option value="">Select vendor</option>
					<?php foreach ($vendors as $vendor): ?>
						<option value="<?php echo $vendor['id']; ?>" <?php echo $vendor['id'] == $product['vendor_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($vendor['username']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="grid grid-2">
			<div class="form-group">
				<label for="price">Price</label>
				<input id="price" name="price" type="number" step="0.01" min="0" value="<?php echo htmlspecialchars($product['price']); ?>" required>
			</div>
			<div class="form-group">
				<label for="quantity">Quantity</label>
				<input id="quantity" name="quantity" type="number" min="0" value="<?php echo htmlspecialchars($product['quantity']); ?>" required>
			</div>
		</div>

		<div class="form-group">
			<label for="main_image">Main Image URL</label>
			<input id="main_image" name="main_image" type="url" value="<?php echo htmlspecialchars($product['main_image']); ?>">
		</div>

		<div class="form-group">
			<label for="short_description">Short Description</label>
			<textarea id="short_description" name="short_description" rows="3"><?php echo htmlspecialchars($product['short_description']); ?></textarea>
		</div>

		<div class="form-group">
			<label for="description">Description</label>
			<textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($product['description']); ?></textarea>
		</div>

		<div style="display:flex; gap:10px;">
			<button type="submit" class="button">Save Changes</button>
			<a href="products.php" class="button" style="background-color:#95a5a6;">Cancel</a>
		</div>
	</form>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>

