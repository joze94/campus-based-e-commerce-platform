    </div>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>About</h4>
                    <p>Campus E-Commerce Platform for students and vendors.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) === '/' ? '/' : str_repeat('../', substr_count(dirname($_SERVER['PHP_SELF']), '/')); ?>store/index.php">Store</a></li>
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) === '/' ? '/' : str_repeat('../', substr_count(dirname($_SERVER['PHP_SELF']), '/')); ?>store/categories.php">Categories</a></li>
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
    <script src="<?php echo dirname($_SERVER['PHP_SELF']) === '/' ? '/' : str_repeat('../', substr_count(dirname($_SERVER['PHP_SELF']), '/')); ?>site_layout_and_assets/script.js"></script>
</body>
</html>
