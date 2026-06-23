# Configuration Reference

## Database Configuration

### Database Name
```
campus_based_e_commerce_platform
```

### Connection Details
```
Host:     localhost
User:     root
Password: (empty)
Database: campus_based_e_commerce_platform
Charset:  utf8mb4
```

### Configuration File Location
```
File: authentication/config.php
```

### Configuration Content
```php
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
            $pdo = new PDO(
                "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
                $dbUser,
                $dbPass
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    return $pdo;
}
```

---

## File-by-File Database Usage

### Authentication Module
**Files Using Database:**
- `authentication/config.php` - Defines connection
- `authentication/login.php` - Query users table
- `authentication/register.php` - Insert into users, user_profiles
- `authentication/profile.php` - Query/update user_profiles
- `authentication/forgot-password.php` - Query users table

**Tables Accessed:**
- users
- user_profiles

### Store Module
**Files Using Database:**
- `store/index.php` - Query products, categories
- `store/categories.php` - Query categories
- `store/products_browse_by_category.php` - Query products by category
- `store/product_details.php` - Query product, categories, users

**Tables Accessed:**
- products
- categories
- users (for vendor info)

### Shopping Cart Module
**Files Using Database:**
- `shopping chart/cart.php` - Session-based (no DB query)
- `shopping chart/checkout.php` - Insert into orders, order_items
- `shopping chart/order_confirmation.php` - Query orders, order_items
- `shopping chart/orders.php` - Query orders table
- `shopping chart/order_details.php` - Query orders, order_items

**Tables Accessed:**
- orders
- order_items
- products (for details)

### Admin Module
**Files Using Database:**
- `admin_vendor management/admin/login.php` - Query users
- `admin_vendor management/admin/dashboard.php` - Query all tables (stats)
- `admin_vendor management/admin/users.php` - Query users, user_profiles
- `admin_vendor management/admin/products.php` - Query products, categories, users
- `admin_vendor management/admin/categories.php` - Query/insert categories
- `admin_vendor management/admin/orders.php` - Query orders, users, user_profiles

**Tables Accessed:**
- All 6 tables

### Vendor Module
**Files Using Database:**
- `admin_vendor management/vendor/login.php` - Query users
- `admin_vendor management/vendor/dashboard.php` - Query products, orders
- `admin_vendor management/vendor/products.php` - Query products (vendor's only)
- `admin_vendor management/vendor/add-product.php` - Insert into products
- `admin_vendor management/vendor/edit-product.php` - Update products
- `admin_vendor management/vendor/sales.php` - Query order_items, orders, products

**Tables Accessed:**
- products
- orders
- order_items

### Pages Module
**Files Using Database:**
- `pages/about.php` - No database queries
- `pages/contact.php` - No database queries (form only)
- `pages/search.php` - Query products, categories, users

**Tables Accessed:**
- products
- categories
- users (for vendor)

---

## Table Relationships

### users Table
```sql
id (PK)
↓
├─→ user_profiles.user_id (1:1)
├─→ products.vendor_id (1:many) [Foreign Key]
└─→ orders.user_id (1:many) [Foreign Key]
```

### categories Table
```sql
id (PK)
└─→ products.category_id (1:many) [Foreign Key]
```

### products Table
```sql
id (PK)
├─→ users.id via vendor_id (Foreign Key)
├─→ categories.id via category_id (Foreign Key)
└─→ order_items.product_id (1:many) [Foreign Key]
```

### orders Table
```sql
id (PK)
├─→ users.id via user_id (Foreign Key)
└─→ order_items.order_id (1:many) [Foreign Key]
```

### order_items Table
```sql
id (PK)
├─→ orders.id via order_id (Foreign Key)
└─→ products.id via product_id (Foreign Key)
```

---

## Connection Usage Examples

### Getting Connection
```php
$pdo = getPDOConnection();
```

### Querying Data
```php
// Fetch single row
$user = fetchRow('SELECT * FROM users WHERE id = ?', [$userId]);

// Fetch multiple rows
$products = fetchAll('SELECT * FROM products WHERE status = ?', ['active']);
```

### Creating Records
```php
// Register user
$userId = registerUser($studentId, $username, $firstName, $lastName, $email, $phone, $password);

// Create order
$orderId = createOrder($userId, $totalAmount, $shippingAddress, $items);
```

### Helper Functions
```php
// Authentication
loginUser($username, $password)
registerUser($studentId, $username, $firstName, $lastName, $email, $phone, $password)

// Data retrieval
fetchRow($query, $params)
fetchAll($query, $params)
getAllCategories()
getAllVendors()
getProductsByCategory($categoryId)
getProductDetails($productId)

// Order management
createOrder($userId, $totalAmount, $shippingAddress, $items)
```

---

## Environment Variables

### Development
```
Database Host:  localhost
Database Port:  3306
Database User:  root
Database Pass:  (empty)
Database Name:  campus_based_e_commerce_platform
```

### Production (Change These)
```
Database Host:  [Production server]
Database Port:  3306
Database User:  [Secure user]
Database Pass:  [Strong password]
Database Name:  campus_based_e_commerce_platform
```

---

## Charset Configuration

### Database Charset
```
utf8mb4 (Full UTF-8 support)
```

### Collation
```
utf8mb4_unicode_ci (Case-insensitive Unicode)
```

### Connection Charset
```php
"mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4"
```

---

## Error Handling

### Connection Errors
```php
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
```

### Query Errors
```php
try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    return false;
}
```

---

## Security Configuration

### Prepared Statements
All queries use prepared statements:
```php
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
```

### Password Hashing
```php
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
password_verify($password, $hashedPassword)
```

### Input Validation
```php
// Before database insert
$email = filter_var($email, FILTER_VALIDATE_EMAIL);
$username = trim(preg_replace('/[^a-zA-Z0-9_]/', '', $username));
```

### Output Escaping
```php
htmlspecialchars($value) // For HTML output
json_encode($value)      // For JSON output
```

---

## Session Configuration

### Session Variables
```php
$_SESSION['user'] = [
    'id' => $userId,
    'username' => $username,
    'email' => $email,
    'role' => 'student|vendor|admin',
    // ... other user data
];
```

### Cart Session
```php
$_SESSION['cart'] = [
    $productId => [
        'product_id' => $productId,
        'title' => $title,
        'price' => $price,
        'quantity' => $quantity
    ],
    // ... more products
];
```

---

## Testing Configuration

### Test Database
Use: `campus_based_e_commerce_platform`

### Test Accounts
```
Admin:    admin / admin123
Student:  student1 / password123
Vendor:   vendor1 / vendor123
```

### Sample Data
- 3 Users
- 5 Categories
- 5 Products
- 2 Orders

---

## Backup & Recovery

### Backup Command
```bash
mysqldump -u root campus_based_e_commerce_platform > backup.sql
```

### Restore Command
```bash
mysql -u root campus_based_e_commerce_platform < backup.sql
```

### Via phpMyAdmin
- Export: Right-click database → Export
- Import: Database → Import tab → Choose file

---

## Performance Optimization

### Indexes
All tables have indexes on frequently queried columns:
- `users.email` (UNIQUE)
- `users.username` (UNIQUE)
- `users.role` (INDEX)
- `products.vendor_id` (FOREIGN KEY)
- `products.category_id` (FOREIGN KEY)
- `orders.user_id` (FOREIGN KEY)
- `products.status` (INDEX)

### Query Optimization
- Use JOINs instead of multiple queries
- Select specific columns, not `SELECT *`
- Use LIMIT for large result sets
- Add indexes on frequently filtered columns

---

## Configuration Checklist

- [x] Database name: `campus_based_e_commerce_platform`
- [x] Host: `localhost`
- [x] User: `root`
- [x] Password: empty
- [x] Charset: `utf8mb4`
- [x] Collation: `utf8mb4_unicode_ci`
- [x] All 6 tables created
- [x] Sample data inserted
- [x] Helper functions working
- [x] Connection pooling ready
- [x] Error handling configured
- [x] Security measures in place

---

## Support & Documentation

- **README.md** - Full project documentation
- **QUICKSTART.md** - 5-minute setup
- **INSTALLATION_GUIDE.md** - Detailed installation
- **DATABASE_SETUP.sql** - Database schema
- **setup_check.php** - Verify installation

---

**Database Configuration Complete!** ✅

All files properly configured to use:
**`campus_based_e_commerce_platform`** database
