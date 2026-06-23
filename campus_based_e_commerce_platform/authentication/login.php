<?php
require_once 'config.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['user'])) {
    header('Location: ../store/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Username and password are required.';
    } else {
        $user = loginUser($username, $password);
        if ($user) {
            $_SESSION['user'] = $user;
            
            if ($user['role'] === 'admin') {
                header('Location: ../admin_vendor%20management/admin/dashboard.php');
            } elseif ($user['role'] === 'vendor') {
                header('Location: ../admin_vendor%20management/vendor/dashboard.php');
            } else {
                header('Location: ../store/index.php');
            }
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Login</h1>
</div>
<div class="card" style="max-width: 400px; margin: 40px auto;">
    <?php if ($error): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                placeholder="Enter your username" 
                value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                required
            >
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                placeholder="Enter your password" 
                required
            >
        </div>
        <button type="submit" class="button">Login</button>
    </form>

    <div class="login-link" style="margin-top: 20px; text-align: center;">
        Don't have an account? <a href="register.php">Register here</a><br>
        <a href="forgot-password.php">Forgot password?</a>
    </div>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
