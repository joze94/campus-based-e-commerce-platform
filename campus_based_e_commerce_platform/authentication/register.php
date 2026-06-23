<?php
require_once 'config.php';
session_start();

// Redirect if already logged in
if (isset($_SESSION['user'])) {
    header('Location: ../store/index.php');
    exit;
}

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
<div class="page-header">
    <h1>Registration</h1>
</div>
<div class="card" style="max-width: 600px; margin: 40px auto;">
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
                    placeholder="joze" 
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
                    placeholder="joseph26@example.com" 
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
                    placeholder="Namiru" 
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
                    placeholder="jane" 
                    value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>"
                    required
                >
            </div>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input 
                type="tel" 
                id="phone" 
                name="phone" 
                placeholder="+25634567890" 
                value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                required
            >
        </div>
        <div class="grid grid-2">
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
        </div>
        <button type="submit" class="button">Register</button>
    </form>

    <div class="login-link" style="margin-top: 20px; text-align: center;">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>
<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
