<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'campus_based_e_commerce_platform';

$pdo = null;

function getPDOConnection() {
    global $pdo, $dbHost, $dbUser, $dbPass, $dbName;
    if (!$pdo) {
        try {
            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    return $pdo;
}

function fetchRow($query, $params = []) {
    $stmt = getPDOConnection()->prepare($query);
    $stmt->execute($params);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function fetchAll($query, $params = []) {
    $stmt = getPDOConnection()->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function registerUser($studentId, $username, $firstName, $lastName, $email, $phone, $password) {
    try {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $pdo = getPDOConnection();
        
        // Create user account
        $stmt = $pdo->prepare('INSERT INTO users (student_id, username, email, password_hash, role) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$studentId, $username, $email, $hashedPassword, 'student']);
        $userId = $pdo->lastInsertId();
        
        // Create user profile
        $stmt = $pdo->prepare('INSERT INTO user_profiles (user_id, student_id, first_name, last_name, phone) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$userId, $studentId, $firstName, $lastName, $phone]);
        
        return $userId;
    } catch (PDOException $e) {
        return false;
    }
}

function loginUser($username, $password) {
    $user = fetchRow('SELECT * FROM users WHERE username = ?', [$username]);
    if ($user && password_verify($password, $user['password_hash'])) {
        return $user;
    }
    return false;
}

function getAllCategories() {
    return fetchAll('SELECT * FROM categories ORDER BY name');
}

function getAllVendors() {
    return fetchAll('SELECT * FROM users WHERE role = "vendor" ORDER BY username');
}

function getProductsByCategory($categoryId) {
    return fetchAll('SELECT * FROM products WHERE category_id = ? AND status = "active" ORDER BY title', [$categoryId]);
}

function getProductDetails($productId) {
    return fetchRow('SELECT p.*, u.username as vendor_name, c.name as category_name FROM products p 
                     LEFT JOIN users u ON p.vendor_id = u.id 
                     LEFT JOIN categories c ON p.category_id = c.id 
                     WHERE p.id = ?', [$productId]);
}

function createOrder($userId, $totalAmount, $shippingAddress, $items) {
    try {
        $pdo = getPDOConnection();
        
        $stmt = $pdo->prepare('INSERT INTO orders (user_id, total_amount, shipping_address, status) VALUES (?, ?, ?, ?)');
        $stmt->execute([$userId, $totalAmount, $shippingAddress, 'pending']);
        $orderId = $pdo->lastInsertId();
        
        foreach ($items as $item) {
            $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
            $stmt->execute([$orderId, $item['product_id'], $item['quantity'], $item['price']]);
        }
        
        return $orderId;
    } catch (PDOException $e) {
        return false;
    }
}
?>
