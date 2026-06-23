<?php
require_once __DIR__ . '/../../authentication/config.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Username and password are required.';
    } else {
        $user = loginUser($username, $password);
        if ($user && $user['role'] === 'vendor') {
            $_SESSION['user'] = $user;
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid credentials or not a vendor.';
        }
    }
}
?>
<?php include_once __DIR__ . '/../../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Vendor Login</h1>
</div>

<div class="card" style="max-width: 400px; margin: 40px auto;">
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="button">Login</button>
    </form>

    <div class="login-link" style="margin-top: 20px; text-align: center;">
        Don't have an account? Contact admin to become a vendor.
    </div>
</div>

<?php include_once __DIR__ . '/../../site_layout_and_assets/footer.php'; ?>
