<?php
require_once __DIR__ . '/../authentication/config.php';
session_start();
?>
<?php include_once __DIR__ . '/../site_layout_and_assets/header.php'; ?>
<div class="page-header">
    <h1>About Campus Shop</h1>
</div>

<div class="container">
    <div class="card">
        <h2>Our Mission</h2>
        <p>CampusShop is dedicated to creating a vibrant marketplace that connects campus vendors with students. We believe in supporting local student businesses while providing students with convenient access to quality products and services.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
        <div class="card">
            <h3>For Students</h3>
            <ul style="list-style: none;">
                <li>✓ Discover campus vendors</li>
                <li>✓ Easy shopping experience</li>
                <li>✓ Secure checkout</li>
                <li>✓ Fast delivery to campus</li>
                <li>✓ Support local businesses</li>
            </ul>
        </div>

        <div class="card">
            <h3>For Vendors</h3>
            <ul style="list-style: none;">
                <li>✓ Reach campus audience</li>
                <li>✓ Manage products easily</li>
                <li>✓ Track sales & revenue</li>
                <li>✓ Admin support</li>
                <li>✓ Grow your business</li>
            </ul>
        </div>
    </div>

    <div class="card" style="margin-top: 2rem;">
        <h2>Why CampusShop?</h2>
        <p>We built CampusShop to solve a real problem: connecting campus vendors with students who want to support local businesses. Our platform is designed to be intuitive, secure, and focused on making shopping on campus easier than ever.</p>
        <p style="margin-top: 1rem;">Whether you're a student looking for great deals or a vendor looking to grow your business, CampusShop is here to help.</p>
    </div>

    <div class="card" style="margin-top: 2rem; text-align: center;">
        <h3>Ready to get started?</h3>
        <p style="margin-bottom: 1rem;">
            <a href="../store/index.php" class="button">Start Shopping</a>
            <a href="../authentication/register.php" class="button" style="background-color: #27ae60;">Create Account</a>
        </p>
    </div>
</div>

<?php include_once __DIR__ . '/../site_layout_and_assets/footer.php'; ?>
