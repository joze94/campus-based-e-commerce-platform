<?php
require_once 'authentication/config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus E-Commerce Platform - Shop On Campus</title>
    <link rel="stylesheet" href="site_layout_and_assets/style.css">
    <style>
        .hero {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            margin-bottom: 3rem;
        }
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }
        .feature-box {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .feature-box h3 {
            color: #3498db;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="index.php">CampusShop</a>
            </div>
            <div class="navbar-menu">
                <a href="store/index.php">Store</a>
                <a href="store/categories.php">Categories</a>
                <a href="shopping%20chart/cart.php">Cart</a>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="navbar-user">Hello, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
                    <a href="authentication/logout.php">Logout</a>
                <?php else: ?>
                    <a href="authentication/login.php">Login</a>
                    <a href="authentication/register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="hero">
        <h1>Welcome to Campus Shop</h1>
        <p>Your one-stop marketplace for campus vendors and students</p>
        <div class="hero-buttons">
            <a href="store/index.php" class="button">Shop Now</a>
            <a href="pages/about.php" class="button" style="background-color: #95a5a6;">Learn More</a>
        </div>
    </div>

    <div class="container">
        <h2>Why Choose CampusShop?</h2>
        <div class="features">
            <div class="feature-box">
                <h3>🎓 Campus Community</h3>
                <p>Shop from verified vendors right on campus. Support local student businesses.</p>
            </div>
            <div class="feature-box">
                <h3>🛒 Easy Shopping</h3>
                <p>Browse products, add to cart, and checkout in minutes. Simple and secure.</p>
            </div>
            <div class="feature-box">
                <h3>💳 Secure Payment</h3>
                <p>Your transactions are safe and encrypted. Multiple payment options available.</p>
            </div>
            <div class="feature-box">
                <h3>📦 Fast Delivery</h3>
                <p>Campus-wide delivery means your orders arrive quickly. Track your purchases.</p>
            </div>
        </div>

        <div class="card" style="margin-bottom: 2rem;">
            <h2>Featured Products</h2>
            <div class="products-grid">
                <?php 
                $featured = fetchAll('SELECT p.*, c.name as category_name FROM products p 
                                     LEFT JOIN categories c ON p.category_id = c.id 
                                     WHERE p.status = "active" 
                                     ORDER BY p.created_at DESC LIMIT 6');
                foreach ($featured as $product): 
                ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if ($product['main_image']): ?>
                                <img src="<?php echo htmlspecialchars($product['main_image']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>">
                            <?php else: ?>
                                <div style="background: #e0e0e0; height: 200px; display: flex; align-items: center; justify-content: center;">No Image</div>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h4><?php echo htmlspecialchars($product['title']); ?></h4>
                            <p class="category"><?php echo htmlspecialchars($product['category_name']); ?></p>
                            <div class="product-footer">
                                <span class="price">$<?php echo number_format($product['price'], 2); ?></span>
                                <a href="store/product_details.php?id=<?php echo $product['id']; ?>" class="button">View</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>About</h4>
                    <p>Campus E-Commerce Platform connecting students and campus vendors.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="store/index.php">Store</a></li>
                        <li><a href="pages/about.php">About Us</a></li>
                        <li><a href="pages/contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact</h4>
                    <p>Email: support@campusshop.edu</p>
                    <p>Phone: +1-800-CAMPUS-1</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Campus E-Commerce Platform. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
