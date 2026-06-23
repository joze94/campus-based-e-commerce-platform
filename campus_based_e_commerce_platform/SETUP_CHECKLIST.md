# Master Setup Checklist - Campus E-Commerce Platform

## Database Configuration

**Database Name:** `campus_based_e_commerce_platform`

### Pre-Installation
- [ ] XAMPP installed and running
- [ ] MySQL service started (XAMPP Control Panel)
- [ ] phpMyAdmin accessible at http://localhost/phpmyadmin/
- [ ] Project folder at: C:\xampp\htdocs\campus_based_e_commerce_platform\

### Installation Steps

#### Step 1: Create Database
- [ ] Open phpMyAdmin
- [ ] Click "New" database button
- [ ] Database name: `campus_based_e_commerce_platform`
- [ ] Collation: `utf8mb4_unicode_ci`
- [ ] Click "Create"

#### Step 2: Import Schema & Data
- [ ] Select database: `campus_based_e_commerce_platform`
- [ ] Click "Import" tab
- [ ] Select file: `DATABASE_SETUP.sql`
- [ ] Click "Import"
- [ ] Wait for completion

#### Step 3: Verify Installation
- [ ] Go to: http://localhost/campus_based_e_commerce_platform/setup_check.php
- [ ] Should show: ✓ MySQL Connected
- [ ] Should show: ✓ Database Found
- [ ] Should show: ✓ All Tables Found
- [ ] Should show sample data counts

### Configuration Verification

#### Database Configuration File
- [ ] File location: `authentication/config.php`
- [ ] Database host: `localhost`
- [ ] Database user: `root`
- [ ] Database password: (empty)
- [ ] Database name: `campus_based_e_commerce_platform`
- [ ] Charset: `utf8mb4`

#### Connection Test
- [ ] PDO connection working
- [ ] Helper functions available
- [ ] No errors in error log

### Database Tables Created

- [ ] `users` - User accounts (3 records)
- [ ] `user_profiles` - User details (3 records)
- [ ] `categories` - Product categories (5 records)
- [ ] `products` - Product inventory (5 records)
- [ ] `orders` - Customer orders (2 records)
- [ ] `order_items` - Order line items (3 records)

### Sample Data Verification

#### Users
- [ ] Admin account: admin / admin123
- [ ] Student account: student1 / password123
- [ ] Vendor account: vendor1 / vendor123

#### Categories
- [ ] Books & Stationery
- [ ] Electronics
- [ ] Food & Beverages
- [ ] Services
- [ ] Merchandise

#### Products
- [ ] 5 sample products loaded
- [ ] Products have prices, descriptions, images
- [ ] Products linked to categories and vendors

#### Orders
- [ ] 2 sample orders created
- [ ] Orders have items, totals, dates
- [ ] Order items linked to products

### Application Testing

#### Homepage
- [ ] http://localhost/campus_based_e_commerce_platform/ loads
- [ ] Navigation bar displays
- [ ] Featured products show
- [ ] Footer displays

#### Store Pages
- [ ] /store/index.php displays products
- [ ] /store/categories.php shows all categories
- [ ] Category pages filter products correctly
- [ ] Product details page loads with full info

#### Authentication
- [ ] Register page works
- [ ] Login page works
- [ ] Admin login: admin / admin123
- [ ] Student login: student1 / password123
- [ ] Vendor login: vendor1 / vendor123
- [ ] Logout functionality works
- [ ] Session management works

#### Shopping Cart
- [ ] Add products to cart
- [ ] Cart persists (session)
- [ ] View cart page works
- [ ] Update quantities work
- [ ] Remove items work
- [ ] Checkout page displays
- [ ] Orders created successfully

#### Admin Panel
- [ ] Admin login works
- [ ] Dashboard displays statistics
- [ ] User management page works
- [ ] Product management page works
- [ ] Category management page works
- [ ] Order management page works

#### Vendor Panel
- [ ] Vendor login works
- [ ] Vendor dashboard displays
- [ ] Vendor can add products
- [ ] Vendor can edit products
- [ ] Sales report shows orders
- [ ] Profile can be updated

### Database Queries Testing

#### User Queries
- [ ] User authentication query works
- [ ] User profile query works
- [ ] All users list works
- [ ] User search works

#### Product Queries
- [ ] All products query works
- [ ] Products by category query works
- [ ] Product detail query works
- [ ] Vendor products query works
- [ ] Product search query works

#### Order Queries
- [ ] Order creation query works
- [ ] Order history query works
- [ ] Order details query works
- [ ] Order items query works

#### Category Queries
- [ ] All categories query works
- [ ] Category add query works
- [ ] Product count by category works

### Security Verification

- [ ] Passwords are hashed (bcrypt)
- [ ] SQL prepared statements used
- [ ] No SQL injection possible
- [ ] Input validation present
- [ ] XSS protection via htmlspecialchars
- [ ] Session authentication working
- [ ] Role-based access control working
- [ ] Admin-only pages protected
- [ ] Vendor-only pages protected
- [ ] Student-only pages accessible

### Performance Checks

- [ ] Database indexes present
- [ ] Queries execute quickly
- [ ] No N+1 query problems
- [ ] Join queries optimized
- [ ] Foreign keys defined
- [ ] Cascading deletes configured

### File Integrity

#### Configuration Files
- [ ] authentication/config.php exists
- [ ] DATABASE_SETUP.sql exists
- [ ] setup_check.php exists

#### Documentation Files
- [ ] README.md exists
- [ ] QUICKSTART.md exists
- [ ] INSTALLATION_GUIDE.md exists
- [ ] CONFIGURATION_REFERENCE.md exists
- [ ] DATABASE_INTEGRATION_SUMMARY.md exists
- [ ] FILE_INVENTORY.md exists

#### PHP Files (28 total)
- [ ] All authentication files present (6)
- [ ] All store files present (4)
- [ ] All shopping cart files present (5)
- [ ] All admin files present (7)
- [ ] All vendor files present (7)
- [ ] All public page files present (3)
- [ ] Layout files present (4)

#### CSS & JavaScript
- [ ] style.css exists and loads
- [ ] script.js exists and loads
- [ ] Styles apply correctly
- [ ] Forms validate correctly

### Post-Installation

#### Backup
- [ ] Database backup created
- [ ] Backup stored securely
- [ ] Backup process documented

#### Maintenance
- [ ] Update regular backups scheduled
- [ ] Error logging configured
- [ ] Monitor database growth
- [ ] Review access logs

#### Customization (Optional)
- [ ] Brand name updated (if desired)
- [ ] Colors customized (if desired)
- [ ] Logo added (if desired)
- [ ] Custom categories added (if desired)
- [ ] Custom products added (if desired)

### Documentation Review

- [ ] README.md read and understood
- [ ] QUICKSTART.md reviewed
- [ ] INSTALLATION_GUIDE.md reviewed
- [ ] CONFIGURATION_REFERENCE.md reviewed
- [ ] DATABASE_INTEGRATION_SUMMARY.md reviewed
- [ ] setup_check.php results documented

### Troubleshooting

If any issues encountered:

**MySQL Not Running**
- [ ] Open XAMPP Control Panel
- [ ] Click "Start" for MySQL
- [ ] Wait 30 seconds
- [ ] Retry operation

**Database Not Found**
- [ ] Verify phpMyAdmin shows database
- [ ] Check DATABASE_SETUP.sql was imported
- [ ] Verify 6 tables exist
- [ ] Run setup_check.php

**Login Fails**
- [ ] Verify sample data loaded
- [ ] Check user exists in database
- [ ] Verify password is correct
- [ ] Clear browser cookies and try again

**Products Not Showing**
- [ ] Verify 5 products in database
- [ ] Check category links
- [ ] Clear browser cache
- [ ] Verify product status is "active"

**Cart Not Working**
- [ ] Verify sessions enabled
- [ ] Check browser cookies enabled
- [ ] Verify product quantities > 0
- [ ] Check PHP session directory writable

### Final Verification

Run through this final checklist:

```
[ ] Database: campus_based_e_commerce_platform exists
[ ] Tables: 6 tables created with proper structure
[ ] Data: Sample data (3 users, 5 categories, 5 products, 2 orders)
[ ] Config: authentication/config.php properly configured
[ ] Access: Homepage loads without errors
[ ] Login: Test all three roles (admin, student, vendor)
[ ] Shop: Products display and can be added to cart
[ ] Order: Can complete purchase flow
[ ] Admin: Admin panel accessible with admin account
[ ] Vendor: Vendor panel accessible with vendor account
[ ] Security: All security measures in place
[ ] Docs: All documentation files present and readable
```

### Go Live Checklist

**When ready to deploy:**

- [ ] Change admin password
- [ ] Change all test passwords
- [ ] Update database credentials for production
- [ ] Enable HTTPS
- [ ] Set up automated backups
- [ ] Configure error logging
- [ ] Set up monitoring
- [ ] Create admin documentation
- [ ] Train administrators
- [ ] Communicate to users

---

## Quick Reference

### Database
- **Name:** campus_based_e_commerce_platform
- **Host:** localhost
- **User:** root
- **Password:** (empty)
- **Charset:** utf8mb4

### Test Accounts
- **Admin:** admin / admin123
- **Student:** student1 / password123
- **Vendor:** vendor1 / vendor123

### Important URLs
- Homepage: http://localhost/campus_based_e_commerce_platform/
- Admin Login: http://localhost/campus_based_e_commerce_platform/admin_vendor\ management/admin/login.php
- Setup Check: http://localhost/campus_based_e_commerce_platform/setup_check.php
- phpMyAdmin: http://localhost/phpmyadmin/

### Key Files
- Config: authentication/config.php
- Database: DATABASE_SETUP.sql
- Setup: setup_check.php
- Docs: README.md, QUICKSTART.md, INSTALLATION_GUIDE.md

---

## Support Files Location

All files are in:
```
C:\xampp\htdocs\campus_based_e_commerce_platform\
```

All database references use:
```
campus_based_e_commerce_platform
```

---

**Setup Status:** Ready to begin installation
**Database Name:** campus_based_e_commerce_platform
**Last Updated:** 2026-06-20
**Version:** 1.0.0

✅ All code generated and ready to use!
