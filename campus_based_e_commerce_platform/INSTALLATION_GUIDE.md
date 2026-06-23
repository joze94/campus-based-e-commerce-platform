# Installation & Configuration Guide

## Database Information

**Database Name:** `campus_based_e_commerce_platform`
**MySQL Host:** `localhost`
**MySQL User:** `root`
**MySQL Password:** (empty by default)

## Step-by-Step Installation

### Step 1: Verify Database Configuration

Open `authentication/config.php` and verify:

```php
<?php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'campus_based_e_commerce_platform';
```

This is the **ONLY** configuration file you need to edit.

### Step 2: Create Database & Import Data

#### Option A: Using phpMyAdmin (Recommended)

1. **Start XAMPP**
   - Open XAMPP Control Panel
   - Click "Start" next to MySQL
   - Wait for MySQL to be running

2. **Open phpMyAdmin**
   - Go to: `http://localhost/phpmyadmin/`

3. **Create Database**
   - Right-click on "Databases" menu
   - Click "Create database"
   - Database name: `campus_based_e_commerce_platform`
   - Collation: `utf8mb4_unicode_ci`
   - Click "Create"

4. **Import Database Schema**
   - Select database: `campus_based_e_commerce_platform`
   - Click "Import" tab
   - Choose file: `DATABASE_SETUP.sql`
   - Click "Import"

#### Option B: Using Command Line

```bash
# Open Command Prompt
# Navigate to XAMPP MySQL directory
cd C:\xampp\mysql\bin

# Login to MySQL
mysql -u root

# Create database
CREATE DATABASE IF NOT EXISTS `campus_based_e_commerce_platform` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Use database
USE `campus_based_e_commerce_platform`;

# Import SQL file
SOURCE C:\xampp\htdocs\campus_based_e_commerce_platform\DATABASE_SETUP.sql;

# Exit
EXIT;
```

### Step 3: Verify Installation

1. **Run Setup Check**
   - Go to: `http://localhost/campus_based_e_commerce_platform/setup_check.php`
   - Should show: ✓ All systems operational

2. **Or Check phpMyAdmin**
   - Go to: `http://localhost/phpmyadmin/`
   - Verify database: `campus_based_e_commerce_platform`
   - Verify 6 tables exist

### Step 4: Access Application

**Homepage:**
```
http://localhost/campus_based_e_commerce_platform/
```

**Store:**
```
http://localhost/campus_based_e_commerce_platform/store/
```

---

## Default Test Accounts

All accounts are pre-configured in the database.

### Admin Account
- **URL:** `http://localhost/campus_based_e_commerce_platform/admin_vendor%20management/admin/login.php`
- **Username:** `admin`
- **Password:** `admin123`
- **Access:** Full platform management

### Student Account
- **URL:** `http://localhost/campus_based_e_commerce_platform/authentication/login.php`
- **Username:** `student1`
- **Password:** `password123`
- **Access:** Shopping features

### Vendor Account
- **URL:** `http://localhost/campus_based_e_commerce_platform/admin_vendor%20management/vendor/login.php`
- **Username:** `vendor1`
- **Password:** `vendor123`
- **Access:** Product management

---

## Database Schema Overview

### 6 Core Tables

| Table | Purpose | Records |
|-------|---------|---------|
| `users` | User accounts & authentication | 3 |
| `user_profiles` | User details (name, phone, etc) | 3 |
| `categories` | Product categories | 5 |
| `products` | Product inventory | 5 |
| `orders` | Customer orders | 2 |
| `order_items` | Individual order items | 3 |

### All Relationships

```
users (1) ──→ (many) user_profiles
users (1) ──→ (many) products (as vendor)
users (1) ──→ (many) orders (as customer)
categories (1) ──→ (many) products
products (1) ──→ (many) order_items
orders (1) ──→ (many) order_items
```

---

## Configuration Files

### Main Configuration
**File:** `authentication/config.php`
```php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'campus_based_e_commerce_platform';
```

This file contains:
- Database connection setup
- PDO initialization
- Helper functions
- Query methods
- Authentication functions

### All Files Using This Configuration
All PHP files include this config automatically:
```php
require_once __DIR__ . '/../authentication/config.php';
```

---

## Security Configuration

### Database User Security (Production)

For production, create a dedicated database user:

```sql
-- Create user
CREATE USER 'campusshop'@'localhost' IDENTIFIED BY 'strong_password_here';

-- Grant permissions
GRANT ALL PRIVILEGES ON campus_based_e_commerce_platform.* TO 'campusshop'@'localhost';

-- Apply changes
FLUSH PRIVILEGES;
```

Then update `config.php`:
```php
$dbUser = 'campusshop';
$dbPass = 'strong_password_here';
```

### Other Security Measures
- ✓ Password hashing (bcrypt)
- ✓ PDO prepared statements
- ✓ SQL injection prevention
- ✓ Session management
- ✓ Input validation

---

## Troubleshooting

### Error: "Connection refused"
**Cause:** MySQL not running
**Solution:**
- Open XAMPP Control Panel
- Click "Start" for MySQL
- Wait 30 seconds
- Try again

### Error: "Database does not exist"
**Cause:** DATABASE_SETUP.sql not imported
**Solution:**
- Go to phpMyAdmin
- Import DATABASE_SETUP.sql
- Verify 6 tables exist

### Error: "No tables in database"
**Cause:** SQL file imported but incomplete
**Solution:**
- Go to phpMyAdmin
- Select database
- Click "Drop" to delete
- Re-create and re-import DATABASE_SETUP.sql

### Error: "Login fails"
**Cause:** Database not set up correctly
**Solution:**
- Run setup_check.php
- Verify "✓ All Tables Found"
- Use correct credentials (see above)

### Error: "Products not showing"
**Cause:** Products table empty
**Solution:**
- Check phpMyAdmin → database → products
- Should have 5 sample products
- If empty, re-import DATABASE_SETUP.sql

---

## Database Maintenance

### Backup Database

```bash
# Command line backup
mysqldump -u root campus_based_e_commerce_platform > backup.sql

# Or use phpMyAdmin
# Right-click database → Export → Select all → Go
```

### Restore Database

```bash
# Command line restore
mysql -u root campus_based_e_commerce_platform < backup.sql

# Or use phpMyAdmin
# Select database → Import → Choose backup.sql
```

### Reset to Default

```sql
-- Delete all data but keep structure
DELETE FROM order_items;
DELETE FROM orders;
DELETE FROM products;
DELETE FROM categories;
DELETE FROM user_profiles;
DELETE FROM users;

-- Re-import DATABASE_SETUP.sql to restore sample data
```

---

## Post-Installation Checklist

- [x] XAMPP MySQL is running
- [x] Database `campus_based_e_commerce_platform` created
- [x] DATABASE_SETUP.sql imported
- [x] All 6 tables exist
- [x] Sample data loaded
- [x] config.php verified
- [x] Homepage loads
- [x] Login works
- [x] Products display
- [x] Admin panel accessible

---

## Next Steps

1. **Explore the Platform**
   - Visit homepage
   - Browse products
   - Create account
   - Place order

2. **Test Each Role**
   - Student login
   - Vendor login
   - Admin login

3. **Customize (Optional)**
   - Change brand name
   - Update colors
   - Add your categories
   - Add your products

4. **Deploy (When Ready)**
   - Set up domain
   - Enable HTTPS
   - Update config.php
   - Set strong passwords

---

## Support Files

### Setup Files
- `DATABASE_SETUP.sql` - Complete database with sample data
- `setup_check.php` - Verify installation

### Documentation
- `README.md` - Full documentation
- `QUICKSTART.md` - 5-minute setup
- `INSTALLATION_GUIDE.md` - This file

### Database Name
All references use: **`campus_based_e_commerce_platform`**

---

## Version Information

- **Platform:** Campus E-Commerce Platform v1.0
- **Database:** MySQL 5.7+
- **PHP:** 7.4+
- **Installation Date:** 2026-06-20

---

**Installation Complete!** 🎉

Your platform is ready to use. Start with the Quick Start Guide or dive into the documentation.
