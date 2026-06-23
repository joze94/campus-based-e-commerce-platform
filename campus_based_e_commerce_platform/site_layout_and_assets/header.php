<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$projectDir = basename(dirname(__DIR__));
$baseUrl = '/' . rawurlencode($projectDir) . '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus E-Commerce Platform</title>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>site_layout_and_assets/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="<?php echo $baseUrl; ?>store/index.php">CampusShop</a>
            </div>
            <div class="navbar-menu">
                <a href="<?php echo $baseUrl; ?>store/index.php">Store</a>
                <a href="<?php echo $baseUrl; ?>shopping%20chart/cart.php">Cart</a>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="navbar-user">Hello, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
                    <a href="<?php echo $baseUrl; ?>authentication/logout.php">Logout</a>
                <?php else: ?>
                    <a href="<?php echo $baseUrl; ?>authentication/login.php">Login</a>
                    <a href="<?php echo $baseUrl; ?>authentication/register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container">
