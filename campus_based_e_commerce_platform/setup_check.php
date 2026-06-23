<?php
/**
 * Database Configuration Verification Script
 * Checks if the database is properly configured and accessible
 */

// Configuration
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'campus_based_e_commerce_platform';

// Display configuration
echo "===========================================\n";
echo "Campus E-Commerce Platform - Setup Check\n";
echo "===========================================\n\n";

echo "Database Configuration:\n";
echo "- Host: " . htmlspecialchars($dbHost) . "\n";
echo "- User: " . htmlspecialchars($dbUser) . "\n";
echo "- Database: " . htmlspecialchars($dbName) . "\n\n";

// Test database connection
echo "Testing Database Connection...\n";
echo "Status: ";

try {
    $pdo = new PDO("mysql:host=$dbHost;charset=utf8mb4", $dbUser, $dbPass);
    echo "✓ MySQL Connected\n\n";
    
    // Check if database exists
    echo "Checking Database: " . htmlspecialchars($dbName) . "\n";
    echo "Status: ";
    
    $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?");
    $stmt->execute([$dbName]);
    
    if ($stmt->fetch()) {
        echo "✓ Database Found\n\n";
        
        // Connect to the database
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
        
        // Check tables
        echo "Checking Database Tables:\n";
        $tables = ['users', 'user_profiles', 'categories', 'products', 'orders', 'order_items'];
        $allTablesExist = true;
        
        foreach ($tables as $table) {
            $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
            $stmt->execute([$table]);
            if ($stmt->fetch()) {
                echo "  ✓ Table: " . htmlspecialchars($table) . "\n";
            } else {
                echo "  ✗ Table: " . htmlspecialchars($table) . " (NOT FOUND)\n";
                $allTablesExist = false;
            }
        }
        
        echo "\n";
        
        if ($allTablesExist) {
            echo "✓ All Tables Found\n\n";
            
            // Check data
            echo "Checking Sample Data:\n";
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM users");
            $stmt->execute();
            $users = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "  - Users: " . $users . "\n";
            
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM categories");
            $stmt->execute();
            $categories = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "  - Categories: " . $categories . "\n";
            
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM products");
            $stmt->execute();
            $products = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "  - Products: " . $products . "\n";
            
            $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM orders");
            $stmt->execute();
            $orders = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
            echo "  - Orders: " . $orders . "\n\n";
            
            echo "===========================================\n";
            echo "✓ Setup Complete!\n";
            echo "===========================================\n\n";
            
            echo "Next Steps:\n";
            echo "1. Homepage: http://localhost/campus_based_e_commerce_platform/\n";
            echo "2. Store: http://localhost/campus_based_e_commerce_platform/store/\n";
            echo "3. Admin Login: http://localhost/campus_based_e_commerce_platform/admin_vendor%20management/admin/login.php\n";
            echo "   Username: admin\n";
            echo "   Password: admin123\n\n";
            
        } else {
            echo "✗ Some tables are missing\n\n";
            echo "Please import DATABASE_SETUP.sql:\n";
            echo "1. Open phpMyAdmin: http://localhost/phpmyadmin/\n";
            echo "2. Select database: " . htmlspecialchars($dbName) . "\n";
            echo "3. Go to Import tab\n";
            echo "4. Select DATABASE_SETUP.sql\n";
            echo "5. Click Import\n";
        }
        
    } else {
        echo "✗ Database Not Found\n\n";
        echo "Creating Database: " . htmlspecialchars($dbName) . "\n";
        
        try {
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . $dbName . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            echo "✓ Database Created\n\n";
            
            echo "Now import DATABASE_SETUP.sql:\n";
            echo "1. Open phpMyAdmin: http://localhost/phpmyadmin/\n";
            echo "2. Select database: " . htmlspecialchars($dbName) . "\n";
            echo "3. Go to Import tab\n";
            echo "4. Select DATABASE_SETUP.sql\n";
            echo "5. Click Import\n";
            
        } catch (PDOException $e) {
            echo "✗ Error creating database: " . htmlspecialchars($e->getMessage()) . "\n";
        }
    }
    
} catch (PDOException $e) {
    echo "✗ MySQL Connection Failed\n";
    echo "Error: " . htmlspecialchars($e->getMessage()) . "\n\n";
    echo "Troubleshooting:\n";
    echo "1. Ensure XAMPP is running (MySQL service active)\n";
    echo "2. Check MySQL credentials in config.php\n";
    echo "3. Verify localhost is the correct host\n";
}

?>
