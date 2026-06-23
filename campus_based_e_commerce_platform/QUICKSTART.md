# Quick Start Guide - Campus E-Commerce Platform

## ⚡ Get Started in 5 Minutes

### Step 1: Database Setup (1 min)
1. Open `http://localhost/phpmyadmin/`
2. Create database: `campus_based_e_commerce_platform`
3. Import `DATABASE_SETUP.sql` file
4. ✅ Database ready!

### Step 2: Verify Configuration (30 sec)
Check `authentication/config.php`:
```php
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'campus_based_e_commerce_platform';
```

### Step 3: Access the Application (30 sec)

**Homepage:**
```
http://localhost/campus_based_e_commerce_platform/
```

**Store:**
```
http://localhost/campus_based_e_commerce_platform/store/
```

### Step 4: Login with Test Account (2 min)

#### Option A: Shop as Student
- URL: `http://localhost/campus_based_e_commerce_platform/authentication/login.php`
- Username: `student1`
- Password: `password123`
- Browse products → Add to cart → Checkout → Place order

#### Option B: Manage as Admin
- URL: `http://localhost/campus_based_e_commerce_platform/admin_vendor%20management/admin/login.php`
- Username: `admin`
- Password: `admin123`
- View dashboard → Manage users/products/orders

#### Option C: Sell as Vendor
- URL: `http://localhost/campus_based_e_commerce_platform/admin_vendor%20management/vendor/login.php`
- Username: `vendor1`
- Password: `vendor123`
- Add products → View sales → Manage inventory

### Step 5: Explore Features (1 min)
- ✅ Register new account
- ✅ Browse product categories
- ✅ Search for products
- ✅ Add items to cart
- ✅ Checkout and place order
- ✅ View order history
- ✅ Update profile

---

## 🎯 Key URLs

### Public Pages
| Page | URL |
|------|-----|
| Homepage | `/index.php` |
| Store | `/store/index.php` |
| Categories | `/store/categories.php` |
| Search | `/pages/search.php` |
| About | `/pages/about.php` |
| Contact | `/pages/contact.php` |

### Student Area
| Page | URL |
|------|-----|
| Login | `/authentication/login.php` |
| Register | `/authentication/register.php` |
| Profile | `/authentication/profile.php` |
| Cart | `/shopping%20chart/cart.php` |
| Orders | `/shopping%20chart/orders.php` |

### Admin Area
| Page | URL |
|------|-----|
| Admin Login | `/admin_vendor%20management/admin/login.php` |
| Dashboard | `/admin_vendor%20management/admin/dashboard.php` |
| Users | `/admin_vendor%20management/admin/users.php` |
| Products | `/admin_vendor%20management/admin/products.php` |
| Categories | `/admin_vendor%20management/admin/categories.php` |
| Orders | `/admin_vendor%20management/admin/orders.php` |

### Vendor Area
| Page | URL |
|------|-----|
| Vendor Login | `/admin_vendor%20management/vendor/login.php` |
| Dashboard | `/admin_vendor%20management/vendor/dashboard.php` |
| Products | `/admin_vendor%20management/vendor/products.php` |
| Add Product | `/admin_vendor%20management/vendor/add-product.php` |
| Sales | `/admin_vendor%20management/vendor/sales.php` |

---

## 🔧 Customization

### Change Brand Name
Edit `site_layout_and_assets/header.php`:
```php
<a href="...">Your Store Name</a>
```

### Update Colors
Edit `site_layout_and_assets/style.css`:
```css
:root {
    --primary-color: #2c3e50;    /* Change this */
    --secondary-color: #3498db;  /* And this */
}
```

### Add Sample Products
1. Go to Admin Dashboard
2. Click "Manage Categories"
3. Add categories (Books, Food, Services, etc.)
4. Click "Manage Products"
5. Add product details
6. Check Store to see products

---

## ⚠️ Common Issues & Solutions

### Issue: "Database connection failed"
**Solution:** 
- Ensure MySQL is running in XAMPP
- Check credentials in `config.php`
- Verify database exists in phpMyAdmin

### Issue: "File not found" error
**Solution:**
- Verify correct URL path
- Check file exists in directory
- Clear browser cache (Ctrl+F5)

### Issue: Login not working
**Solution:**
- Use test account credentials from Quick Start
- Check that DATABASE_SETUP.sql was imported
- Clear browser cookies

### Issue: Images not loading
**Solution:**
- Products use image URLs, not local uploads
- Enter valid image URLs when adding products
- Some products may not have images (OK)

---

## 📊 Database Credentials

**Database Name:** `campus_based_e_commerce_platform`
**Default MySQL User:** `root`
**Default MySQL Password:** (empty)
**Host:** `localhost`

---

## 🚀 Production Deployment

Before deploying to production:

1. **Security Updates**
   - Change database password
   - Update admin credentials
   - Enable HTTPS
   - Add CSRF tokens

2. **Performance**
   - Minify CSS/JS
   - Enable caching
   - Optimize images
   - Add CDN for assets

3. **Backup**
   - Export database regularly
   - Store backups securely
   - Test recovery procedures

---

## 📝 Test Data Included

The `DATABASE_SETUP.sql` includes:

- **Users:** 3 test accounts (admin, student, vendor)
- **Categories:** 5 sample categories
- **Products:** 10 sample products
- **Orders:** 2 sample orders

All ready to explore and test!

---

## 💡 Tips

- Use browser DevTools (F12) for debugging
- Check server logs in XAMPP for errors
- Test on mobile devices too
- Try different user roles to explore all features
- Modify sample data to test your workflows

---

## ✅ You're All Set!

Your campus e-commerce platform is ready to use. Start by:

1. **Browse** → Visit the store
2. **Register** → Create a new account
3. **Shop** → Add products to cart
4. **Checkout** → Complete an order
5. **Explore** → Check all features

Enjoy! 🎓🛒

---

**Need Help?** Check the full README.md for detailed documentation.
