<?php
require_once 'config.php';
session_start();

if (isset($_SESSION['user'])) {
    header('Location: ../store/index.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $message = 'Please enter your email address.';
    } else {
        $user = fetchRow('SELECT * FROM users WHERE email = ?', [$email]);
        if ($user) {
            // In production, send reset email here
            $message = 'Password reset link has been sent to your email (simulated).';
        } else {
            $message = 'No account found with this email address.';
        }
    }
}
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>Forgot Password</h1>
</div>

<div class="card" style="max-width: 400px; margin: 40px auto;">
    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                placeholder="student@example.edu" 
                required
            >
        </div>
        <button type="submit" class="button">Reset Password</button>
    </form>

    <div class="login-link" style="margin-top: 20px; text-align: center;">
        Back to <a href="login.php">login</a>
    </div>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
