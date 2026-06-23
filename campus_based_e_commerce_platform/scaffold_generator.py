import os
from pathlib import Path

root = Path(r"c:\xampp\htdocs\campus_based_e_commerce_platform")
files = {
    'index.php': """<?php
header('Location: /campus_based_e_commerce_platform/store/index.php');
exit;
""",
    'site_layout_and_assets/header.php': """<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Campus E-Commerce Platform</title>
    <link rel=\"stylesheet\" href=\"/campus_based_e_commerce_platform/site_layout_and_assets/style.css\">
    <script defer src=\"/campus_based_e_commerce_platform/site_layout_and_assets/script.js\"></script>
</head>
<body>
<header class=\"site-header\">
    <div class=\"brand\"><a href=\"/campus_based_e_commerce_platform/store/index.php\">Campus Marketplace</a></div>
    <nav class=\"site-nav\">
        <a href=\"/campus_based_e_commerce_platform/store/index.php\">Home</a>
        <a href=\"/campus_based_e_commerce_platform/store/categories.php\">Categories</a>
        <a href=\"/campus_based_e_commerce_platform/shopping%20chart/cart.php\">Cart</a>
        <a href=\"/campus_based_e_commerce_platform/shopping%20chart/orders.php\">Orders</a>
        <a href=\"/campus_based_e_commerce_platform/authentication/login.php\">Login</a>
        <a href=\"/campus_based_e_commerce_platform/authentication/register+login.php\">Register</a>
        <a href=\"/campus_based_e_commerce_platform/admin_vendor%20management/admin/login.php\">Admin</a>
    </nav>
</header>
<main class=\"page-content\">
""",
    'site_layout_and_assets/footer.php': """</main>
<footer class=\"site-footer\">
    <p>&copy; <?php echo date('Y'); ?> Campus E-Commerce Platform</p>
</footer>
</body>
</html>
""",
    'site_layout_and_assets/style.css': """* {
    box-sizing: border-box;
}
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6f8;
    color: #1f2937;
}
.site-header {
    background: #1e3a8a;
    color: #fff;
    padding: 18px 24px;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
}
.site-header .brand a {
    color: #f8fafc;
    text-decoration: none;
    font-size: 1.4rem;
    font-weight: 700;
}
.site-nav {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.site-nav a {
    color: #e2e8f0;
    text-decoration: none;
    padding: 8px 10px;
    transition: background 0.2s ease;
}
.site-nav a:hover {
    background: rgba(226, 232, 240, 0.15);
    border-radius: 8px;
}
.page-content {
    max-width: 1180px;
    margin: 28px auto;
    padding: 0 18px 40px;
}
.page-header {
    margin-bottom: 24px;
}
.page-header h1,
.page-header h2 {
    margin: 0 0 12px;
    color: #0f172a;
}
.card,
.auth-card,
.product-card,
.table-card {
    background: #fff;
    border: 1px solid #dbeafe;
    border-radius: 16px;
    box-shadow: 0 12px 28px rgba(15, 23, 42, 0.06);
    padding: 24px;
    margin-bottom: 24px;
}
.grid {
    display: grid;
    gap: 24px;
}
.grid-3 {
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
}
.grid-2 {
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
}
.product-card img,
.product-large img {
    width: 100%;
    height: auto;
    border-radius: 14px;
    margin-bottom: 18px;
}
.button,
.btn,
.btn-secondary,
.btn-primary {
    display: inline-block;
    padding: 12px 20px;
    border: none;
    border-radius: 12px;
    background: #3b82f6;
    color: #fff;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.2s ease;
}
.button:hover,
.btn:hover,
.btn-primary:hover {
    background: #1d4ed8;
}
.btn-secondary {
    background: #e2e8f0;
    color: #0f172a;
}
.form-group {
    margin-bottom: 18px;
}
.form-group label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
}
.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid #cbd5e1;
    font-size: 1rem;
}
.form-group textarea {
    resize: vertical;
}
.form-inline {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
}
.alert {
    padding: 18px;
    border-radius: 12px;
    margin-bottom: 20px;
}
.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}
.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.table-card table {
    width: 100%;
    border-collapse: collapse;
}
.table-card th,
.table-card td {
    padding: 14px 12px;
    border-bottom: 1px solid #e2e8f0;
}
.table-card th {
    text-align: left;
    font-weight: 700;
}
.table-card tr:last-child td {
    border-bottom: none;
}
.site-footer {
    text-align: center;
    padding: 24px;
    background: #1e3a8a;
    color: #f8fafc;
}
@media (max-width: 768px) {
    .site-nav {
        width: 100%;
        justify-content: center;
    }
    .grid-2,
    .grid-3 {
        grid-template-columns: 1fr;
    }
}
""",
    'site_layout_and_assets/script.js': """document.addEventListener('DOMContentLoaded', function () {
    // Navigation and UI enhancements can be added here.
});
""",
    'authentication/login.php': """<?php
require_once 'config.php';
session_start();

if (isset($_SESSION['user'])) {
    header('Location: ../store/index.php');
    exit;
}
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($identifier) || empty($password)) {
        $error = 'Please enter both username/email and password.';
    } else {
        $user = loginUser($identifier, $password);
        if ($user) {
            session_regenerate_id(true);
            $_SESSION['user'] = $user;
            if ($user['role'] === 'admin') {
                header('Location: ../admin_vendor management/admin/dashbord.php');
                exit;
            }
            header('Location: ../store/index.php');
            exit;
        }
        $error = 'Login failed. Please check your credentials.';
    }
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="card">
    <h2>Login</h2>
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="identifier">Email or Username</label>
            <input type="text" id="identifier" name="identifier" value="<?php echo htmlspecialchars($_POST['identifier'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="button">Login</button>
    </form>
    <p style="margin-top: 16px;">Forgot your password? <a href="forgot-password.php">Reset here</a></p>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'authentication/logout.php': """<?php
session_start();
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}
session_destroy();
header('Location: ../store/index.php');
exit;
""",
    'authentication/forgot-password.php': """<?php
require_once 'config.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'If this email exists in our system, a password reset link has been sent.';
    } else {
        $message = 'Please enter a valid email address.';
    }
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="card">
    <h2>Forgot Password</h2>
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
        </div>
        <button type="submit" class="button">Request Reset</button>
    </form>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'authentication/profile.php': """<?php
require_once 'config.php';
session_start();
if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
$user = getUserById((int) $_SESSION['user']['id']);
$profile = getUserProfile((int) $_SESSION['user']['id']);
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="card">
    <h2>My Profile</h2>
    <div class="grid grid-2">
        <div>
            <h3>Account Info</h3>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
        </div>
        <div>
            <h3>Profile Details</h3>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($profile['first_name'] ?? 'N/A'); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($profile['last_name'] ?? 'N/A'); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($profile['phone'] ?? 'N/A'); ?></p>
            <p><strong>Department:</strong> <?php echo htmlspecialchars($profile['department'] ?? 'N/A'); ?></p>
            <p><strong>Year of Study:</strong> <?php echo htmlspecialchars($profile['year_of_study'] ?? 'N/A'); ?></p>
        </div>
    </div>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'store/index.php': """<?php
require_once __DIR__ . '/../authentication/config.php';
$categories = getCategories();
$products = fetchProducts();
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Campus Marketplace</h1>
    <p>Browse student vendors, campus services, and essential goods available on campus.</p>
</div>
<div class="card">
    <h2>Top Categories</h2>
    <div class="grid grid-3">
        <?php foreach ($categories as $category): ?>
            <div class="product-card">
                <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                <p><?php echo htmlspecialchars($category['description']); ?></p>
                <a class="button btn-secondary" href="categories.php?category_id=<?php echo $category['id']; ?>">Shop <?php echo htmlspecialchars($category['name']); ?></a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div class="card">
    <h2>Featured Products</h2>
    <div class="grid grid-3">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <?php if ($product['main_image']): ?>
                    <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                <?php endif; ?>
                <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                <p><?php echo htmlspecialchars($product['short_description'] ?? substr($product['description'], 0, 100)); ?></p>
                <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                <a class="button" href="product_details.php?id=<?php echo $product['id']; ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'store/categories.php': """<?php
require_once __DIR__ . '/../authentication/config.php';
$categories = getCategories();
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Browse Categories</h1>
</div>
<div class="grid grid-3">
    <?php foreach ($categories as $category): ?>
        <div class="product-card">
            <h3><?php echo htmlspecialchars($category['name']); ?></h3>
            <p><?php echo htmlspecialchars($category['description']); ?></p>
            <a class="button" href="products_browse_by_category.php?category_id=<?php echo $category['id']; ?>">View Products</a>
        </div>
    <?php endforeach; ?>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'store/products_browse_by_category.php': """<?php
require_once __DIR__ . '/../authentication/config.php';
$categoryId = intval($_GET['category_id'] ?? 0);
$category = fetchRow('SELECT * FROM categories WHERE id = ? AND is_active = 1', [$categoryId]);
if (!$category) {
    header('Location: categories.php');
    exit;
}
$products = fetchRows('SELECT * FROM products WHERE category_id = ? AND status = "active" ORDER BY created_at DESC', [$categoryId]);
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1><?php echo htmlspecialchars($category['name']); ?></h1>
    <p><?php echo htmlspecialchars($category['description']); ?></p>
</div>
<div class="grid grid-3">
    <?php if (empty($products)): ?>
        <div class="card">No products found in this category.</div>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <?php if ($product['main_image']): ?>
                    <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                <?php endif; ?>
                <h3><?php echo htmlspecialchars($product['title']); ?></h3>
                <p><?php echo htmlspecialchars($product['short_description'] ?? substr($product['description'], 0, 100)); ?></p>
                <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                <a class="button" href="product_details.php?id=<?php echo $product['id']; ?>">View Details</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'store/product_details.php': """<?php
require_once __DIR__ . '/../authentication/config.php';
$productId = intval($_GET['id'] ?? 0);
$product = getProductById($productId);
if (!$product) {
    header('Location: index.php');
    exit;
}
$images = getProductImages($productId);
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="grid grid-2">
    <div class="product-large">
        <?php if (!empty($images)): ?>
            <img src="<?php echo htmlspecialchars($images[0]['image_url']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
        <?php elseif ($product['main_image']): ?>
            <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
        <?php endif; ?>
        <h2><?php echo htmlspecialchars($product['title']); ?></h2>
        <p><?php echo htmlspecialchars($product['description']); ?></p>
        <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
        <p><strong>Available:</strong> <?php echo (int) $product['quantity']; ?></p>
        <form method="POST" action="../shopping%20chart/cart.php">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo max(1, (int) $product['quantity']); ?>">
            </div>
            <button type="submit" class="button">Add to Cart</button>
        </form>
    </div>
    <div class="card">
        <h3>Product Details</h3>
        <p><strong>SKU:</strong> <?php echo htmlspecialchars($product['sku'] ?? 'N/A'); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($product['status']); ?></p>
        <p><strong>Vendor ID:</strong> <?php echo htmlspecialchars($product['vendor_id']); ?></p>
    </div>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'shopping chart/cart.php': """<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ../authentication/login.php');
    exit;
}
$userId = (int) $_SESSION['user']['id'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $productId = intval($_POST['product_id'] ?? 0);
    $quantity = max(1, intval($_POST['quantity'] ?? 1));

    if ($action === 'add' && $productId > 0) {
        $existing = fetchRow('SELECT * FROM cart_items WHERE user_id = ? AND product_id = ?', [$userId, $productId]);
        if ($existing) {
            $stmt = getPDOConnection()->prepare('UPDATE cart_items SET quantity = quantity + ? WHERE id = ?');
            $stmt->execute([$quantity, $existing['id']]);
        } else {
            $stmt = getPDOConnection()->prepare('INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)');
            $stmt->execute([$userId, $productId, $quantity]);
        }
        $message = 'Product added to cart.';
    }

    if ($action === 'update' && $productId > 0) {
        $stmt = getPDOConnection()->prepare('UPDATE cart_items SET quantity = ? WHERE user_id = ? AND product_id = ?');
        $stmt->execute([$quantity, $userId, $productId]);
        $message = 'Cart updated.';
    }

    if ($action === 'remove' && $productId > 0) {
        $stmt = getPDOConnection()->prepare('DELETE FROM cart_items WHERE user_id = ? AND product_id = ?');
        $stmt->execute([$userId, $productId]);
        $message = 'Item removed from cart.';
    }
}

$cartItems = fetchRows(
    'SELECT ci.*, p.title, p.price, p.main_image, p.quantity AS available_quantity FROM cart_items ci JOIN products p ON p.id = ci.product_id WHERE ci.user_id = ?',
    [$userId]
);
$totalAmount = 0;
foreach ($cartItems as $item) {
    $totalAmount += $item['price'] * $item['quantity'];
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>My Cart</h1>
</div>
<div class="card">
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <?php if (empty($cartItems)): ?>
        <p>Your cart is currently empty.</p>
        <a class="button" href="../store/index.php">Continue Shopping</a>
    <?php else: ?>
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <form method="POST" action="" style="display: inline-flex; gap: 8px; align-items: center;">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo max(1, (int) $item['available_quantity']); ?>" style="width: 70px;">
                                    <button type="submit" class="btn-secondary">Update</button>
                                </form>
                            </td>
                            <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                    <button type="submit" class="btn-secondary">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card">
            <h3>Order Summary</h3>
            <p><strong>Subtotal:</strong> $<?php echo number_format($totalAmount, 2); ?></p>
            <a class="button" href="checkout.php">Proceed to Checkout</a>
        </div>
    <?php endif; ?>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'shopping chart/checkout.php': """<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ../authentication/login.php');
    exit;
}
$userId = (int) $_SESSION['user']['id'];
$cartItems = fetchRows(
    'SELECT ci.product_id, ci.quantity, p.title, p.price, p.main_image, p.quantity AS available_quantity FROM cart_items ci JOIN products p ON p.id = ci.product_id WHERE ci.user_id = ?',
    [$userId]
);
if (empty($cartItems)) {
    header('Location: cart.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['delivery_address'] ?? '');
    $phone = trim($_POST['delivery_phone'] ?? '');
    $notes = trim($_POST['delivery_notes'] ?? '');

    if ($address === '' || $phone === '') {
        $error = 'Please enter delivery address and phone.';
    } else {
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $shipping = 5.00;
        $tax = round($subtotal * 0.05, 2);
        $total = round($subtotal + $shipping + $tax, 2);
        $orderNumber = 'ORD' . date('YmdHis') . rand(100, 999);

        $pdo = getPDOConnection();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare('INSERT INTO orders (order_number, user_id, address_id, coupon_id, subtotal, discount_amount, tax_amount, shipping_cost, total_amount, order_status, payment_status, delivery_address, delivery_phone, delivery_notes, created_at, updated_at) VALUES (?, ?, NULL, NULL, ?, 0, ?, ?, ?, "pending", "unpaid", ?, ?, ?, NOW(), NOW())');
            $stmt->execute([$orderNumber, $userId, $subtotal, $tax, $shipping, $total, $address, $phone, $notes]);
            $orderId = $pdo->lastInsertId();

            $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, product_title, product_image, quantity, unit_price, subtotal, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())');
            foreach ($cartItems as $item) {
                $itemStmt->execute([$orderId, $item['product_id'], $item['title'], $item['main_image'], $item['quantity'], $item['price'], $item['price'] * $item['quantity']]);
            }
            $pdo->prepare('DELETE FROM cart_items WHERE user_id = ?')->execute([$userId]);
            $pdo->commit();

            header('Location: order_confirmation.php?order_id=' . urlencode($orderId));
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            $error = 'Could not complete checkout. Please try again.';
        }
    }
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Checkout</h1>
</div>
<div class="grid grid-2">
    <div class="card">
        <h2>Delivery Details</h2>
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="delivery_address">Delivery Address</label>
                <textarea id="delivery_address" name="delivery_address" rows="4" required><?php echo htmlspecialchars($_POST['delivery_address'] ?? ''); ?></textarea>
            </div>
            <div class="form-group">
                <label for="delivery_phone">Delivery Phone</label>
                <input type="tel" id="delivery_phone" name="delivery_phone" value="<?php echo htmlspecialchars($_POST['delivery_phone'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="delivery_notes">Delivery Notes</label>
                <textarea id="delivery_notes" name="delivery_notes" rows="3"><?php echo htmlspecialchars($_POST['delivery_notes'] ?? ''); ?></textarea>
            </div>
            <button type="submit" class="button">Place Order</button>
        </form>
    </div>
    <div class="card">
        <h2>Order Summary</h2>
        <?php $subtotal = 0; ?>
        <?php foreach ($cartItems as $item): ?>
            <div style="margin-bottom: 14px;">
                <p><strong><?php echo htmlspecialchars($item['title']); ?></strong></p>
                <p><?php echo $item['quantity']; ?> × $<?php echo number_format($item['price'], 2); ?></p>
            </div>
            <?php $subtotal += $item['price'] * $item['quantity']; ?>
        <?php endforeach; ?>
        <hr>
        <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal, 2); ?></p>
        <p><strong>Tax (5%):</strong> $<?php echo number_format(round($subtotal * 0.05, 2), 2); ?></p>
        <p><strong>Shipping:</strong> $5.00</p>
        <p><strong>Total:</strong> $<?php echo number_format(round($subtotal * 1.05 + 5, 2), 2); ?></p>
    </div>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'shopping chart/order_confirmation.php': """<?php
require_once __DIR__ . '/../authentication/config.php';
$orderId = intval($_GET['order_id'] ?? 0);
$order = fetchRow('SELECT * FROM orders WHERE id = ?', [$orderId]);
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="card">
    <?php if ($order): ?>
        <h2>Order Confirmed</h2>
        <p>Your order has been placed successfully. Order Number: <strong><?php echo htmlspecialchars($order['order_number']); ?></strong></p>
        <p><a class="button" href="orders.php">View My Orders</a></p>
    <?php else: ?>
        <h2>Order Not Found</h2>
        <p>We could not locate your order. Please check your orders page or contact support.</p>
    <?php endif; ?>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'shopping chart/orders.php': """<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ../authentication/login.php');
    exit;
}
$userId = (int) $_SESSION['user']['id'];
$orders = fetchRows('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC', [$userId]);
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>My Orders</h1>
</div>
<div class="table-card">
    <?php if (empty($orders)): ?>
        <p>You have not placed any orders yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                        <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                        <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
                        <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                        <td><a class="button btn-secondary" href="order_details.php?order_id=<?php echo $order['id']; ?>">View</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'shopping chart/order_details.php': """<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();
if (empty($_SESSION['user'])) {
    header('Location: ../authentication/login.php');
    exit;
}
$userId = (int) $_SESSION['user']['id'];
$orderId = intval($_GET['order_id'] ?? 0);
$order = fetchRow('SELECT * FROM orders WHERE id = ? AND user_id = ?', [$orderId, $userId]);
if (!$order) {
    header('Location: orders.php');
    exit;
}
$orderItems = fetchRows('SELECT * FROM order_items WHERE order_id = ?', [$orderId]);
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Order Details</h1>
</div>
<div class="card">
    <h2>Order <?php echo htmlspecialchars($order['order_number']); ?></h2>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($order['order_status']); ?></p>
    <p><strong>Payment:</strong> <?php echo htmlspecialchars($order['payment_status']); ?></p>
    <p><strong>Total:</strong> $<?php echo number_format($order['total_amount'], 2); ?></p>
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_title']); ?></td>
                        <td><?php echo (int) $item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['unit_price'], 2); ?></td>
                        <td>$<?php echo number_format($item['subtotal'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
""",
    'admin_vendor management/admin/login.php': """<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';
    if (empty($identifier) || empty($password)) {
        $error = 'Please enter both email/username and password.';
    } else {
        $user = loginUser($identifier, $password);
        if ($user && $user['role'] === 'admin') {
            session_regenerate_id(true);
            $_SESSION['user'] = $user;
            header('Location: dashbord.php');
            exit;
        }
        $error = 'Admin login failed. Check credentials.';
    }
}
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="card">
    <h2>Admin Login</h2>
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="identifier">Email or Username</label>
            <input type="text" id="identifier" name="identifier" value="<?php echo htmlspecialchars($_POST['identifier'] ?? ''); ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="button">Login</button>
    </form>
</div>
<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
""",
    'admin_vendor management/admin/dashbord.php': """<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$userCount = count(getAllUsers());
$productCount = count(getAllProducts());
$orderCount = count(getAllOrders());
$categoryCount = count(getAllCategories());
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Admin Dashboard</h1>
</div>
<div class="grid grid-3">
    <div class="card"><h3>Users</h3><p><?php echo $userCount; ?></p></div>
    <div class="card"><h3>Products</h3><p><?php echo $productCount; ?></p></div>
    <div class="card"><h3>Orders</h3><p><?php echo $orderCount; ?></p></div>
    <div class="card"><h3>Categories</h3><p><?php echo $categoryCount; ?></p></div>
</div>
<div class="card">
    <h2>Management</h2>
    <nav class="site-nav">
        <a href="users.php">Users</a>
        <a href="products.php">Products</a>
        <a href="orders.php">Orders</a>
        <a href="categories.php">Categories</a>
        <a href="add-product.php">Add Product</a>
        <a href="../../authentication/logout.php">Logout</a>
    </nav>
</div>
<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
""",
    'admin_vendor management/admin/users.php': """<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$users = getAllUsers();
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>User Management</h1>
</div>
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Active</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo $user['is_active'] ? 'Yes' : 'No'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
""",
    'admin_vendor management/admin/products.php': """<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$products = getAllProducts();
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Product Catalog</h1>
</div>
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Vendor</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo htmlspecialchars($product['title']); ?></td>
                    <td><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($product['vendor_username'] ?? 'N/A'); ?></td>
                    <td>$<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($product['status']); ?></td>
                    <td><a class="button btn-secondary" href="adit-product.php?id=<?php echo $product['id']; ?>">Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
""",
    'admin_vendor management/admin/orders.php': """<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$orders = getAllOrders();
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Order Management</h1>
</div>
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Order #</th>
                <th>User</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo htmlspecialchars($order['order_number']); ?></td>
                    <td><?php echo htmlspecialchars($order['username'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                    <td><?php echo htmlspecialchars($order['payment_status']); ?></td>
                    <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                    <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
""",
    'admin_vendor management/admin/categories.php': """<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$categories = getAllCategories();
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Category Management</h1>
</div>
<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Active</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td><?php echo htmlspecialchars($category['slug']); ?></td>
                    <td><?php echo $category['is_active'] ? 'Yes' : 'No'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
""",
    'admin_vendor management/admin/add-product.php': """<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$categories = getAllCategories();
$vendors = getAllVendors();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $categoryId = intval($_POST['category_id'] ?? 0);
    $vendorId = intval($_POST['vendor_id'] ?? 0);
    $price = floatval($_POST['price'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $shortDescription = trim($_POST['short_description'] ?? '');
    $sku = trim($_POST['sku'] ?? '');
    $mainImage = trim($_POST['main_image'] ?? '');
    $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $title), '-'));

    if ($title && $categoryId && $vendorId && $price > 0) {
        $stmt = getPDOConnection()->prepare('INSERT INTO products (vendor_id, category_id, title, slug, description, short_description, price, quantity, main_image, status, sku, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, "active", ?, NOW(), NOW())');
        $stmt->execute([$vendorId, $categoryId, $title, $slug, $description, $shortDescription, $price, $quantity, $mainImage, $sku]);
        $message = 'Product added successfully.';
    } else {
        $message = 'Please provide all required product fields.';
    }
}
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Add New Product</h1>
</div>
<div class="card">
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="grid grid-2">
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="sku">SKU</label>
                <input id="sku" name="sku">
            </div>
        </div>
        <div class="grid grid-2">
            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="vendor_id">Vendor</label>
                <select id="vendor_id" name="vendor_id" required>
                    <option value="">Select vendor</option>
                    <?php foreach ($vendors as $vendor): ?>
                        <option value="<?php echo $vendor['id']; ?>"><?php echo htmlspecialchars($vendor['username']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="grid grid-2">
            <div class="form-group">
                <label for="price">Price</label>
                <input id="price" name="price" type="number" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input id="quantity" name="quantity" type="number" min="0" required>
            </div>
        </div>
        <div class="form-group">
            <label for="main_image">Main Image URL</label>
            <input id="main_image" name="main_image" type="url">
        </div>
        <div class="form-group">
            <label for="short_description">Short Description</label>
            <textarea id="short_description" name="short_description" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5"></textarea>
        </div>
        <button type="submit" class="button">Create Product</button>
    </form>
</div>
<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
""",
    'admin_vendor management/admin/adit-product.php': """<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
$productId = intval($_GET['id'] ?? 0);
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
    $categoryId = intval($_POST['category_id'] ?? 0);
    $vendorId = intval($_POST['vendor_id'] ?? 0);
    $price = floatval($_POST['price'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $shortDescription = trim($_POST['short_description'] ?? '');
    $sku = trim($_POST['sku'] ?? '');
    $mainImage = trim($_POST['main_image'] ?? '');
    $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $title), '-'));

    if ($title && $categoryId && $vendorId && $price >= 0) {
        $stmt = getPDOConnection()->prepare('UPDATE products SET vendor_id = ?, category_id = ?, title = ?, slug = ?, description = ?, short_description = ?, price = ?, quantity = ?, main_image = ?, status = ?, sku = ?, updated_at = NOW() WHERE id = ?');
        $stmt->execute([$vendorId, $categoryId, $title, $slug, $description, $shortDescription, $price, $quantity, $mainImage, $product['status'], $sku, $productId]);
        $message = 'Product updated successfully.';
        $product = fetchRow('SELECT * FROM products WHERE id = ?', [$productId]);
    } else {
        $message = 'Please provide all required product fields.';
    }
}
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Edit Product</h1>
</div>
<div class="card">
    <?php if ($message): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
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
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo $category['id'] === $product['category_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="vendor_id">Vendor</label>
                <select id="vendor_id" name="vendor_id" required>
                    <?php foreach ($vendors as $vendor): ?>
                        <option value="<?php echo $vendor['id']; ?>" <?php echo $vendor['id'] === $product['vendor_id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($vendor['username']); ?></option>
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
        <button type="submit" class="button">Save Changes</button>
    </form>
</div>
<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
""",
    'authentication/register+login.php': """<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $error = 'Username must be 3-20 characters and contain only letters, numbers, and underscores.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters long.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        $studentId = 'S' . date('YmdHis') . mt_rand(100, 999);
        $userId = registerUser($studentId, $username, $firstName, $lastName, $email, $phone, $password);

        if ($userId) {
            $success = 'Registration successful! Redirecting to login...';
            header('Refresh: 2; url=login.php');
        } else {
            $error = 'Registration failed. Email or username may already exist.';
        }
    }
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="card">
    <h2>Registration</h2>
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="grid grid-2">
            <div class="form-group">
                <label for="username">Username</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="john_doe" 
                    value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                    required
                >
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="student@example.edu" 
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                    required
                >
            </div>
        </div>
        <div class="grid grid-2">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input 
                    type="text" 
                    id="first_name" 
                    name="first_name" 
                    placeholder="John" 
                    value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>"
                    required
                >
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input 
                    type="text" 
                    id="last_name" 
                    name="last_name" 
                    placeholder="Doe" 
                    value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                    required
                >
            </div>
        </div>
        <div class="grid grid-2">
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    placeholder="+1234567890" 
                    value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                    required
                >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Minimum 6 characters" 
                    required
                >
            </div>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input 
                type="password" 
                id="confirm_password" 
                name="confirm_password" 
                placeholder="Re-enter password" 
                required
            >
        </div>
        <button type="submit" class="button">Register</button>
    </form>

    <div class="login-link" style="margin-top: 18px;">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
"""
}

for rel_path, content in files.items():
    path = root / rel_path
    path.parent.mkdir(parents=True, exist_ok=True)
    with open(path, 'w', encoding='utf-8') as fh:
        fh.write(content)

print('Scaffold files written.')
"}