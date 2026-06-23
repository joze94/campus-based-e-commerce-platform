# Campus E-Commerce Platform

A complete, production-ready PHP/MySQL e-commerce platform designed for campus-based vendors and students.

## Features

### Student Features
- ✅ User registration and authentication
- ✅ Browse products by category
- ✅ Product search functionality
- ✅ Shopping cart management
- ✅ Secure checkout process
- ✅ Order history and tracking
- ✅ User profile management
- ✅ Password recovery

### Vendor Features
- ✅ Vendor dashboard
- ✅ Product management (CRUD)
- ✅ Sales reporting
- ✅ Profile management
- ✅ Inventory tracking
- ✅ Order management

### Admin Features
- ✅ Admin dashboard with statistics
- ✅ User management
- ✅ Product management
- ✅ Category management
- ✅ Order management
- ✅ Vendor oversight

## Project Structure

```
campus_based_e_commerce_platform/
├── index.php                           # Homepage/landing page
├── DATABASE_SETUP.sql                  # Database schema and sample data used by the app
├── authentication/
│   ├── config.php                      # Database connection & helper functions
│   ├── login.php                       # User login
│   ├── register.php                    # User registration
│   ├── logout.php                      # Session logout
│   ├── profile.php                     # User profile management
│   └── forgot-password.php             # Password recovery
├── store/
│   ├── index.php                       # Product homepage
│   ├── categories.php                  # Browse categories
│   ├── products_browse_by_category.php # Category filtered products
│   └── product_details.php             # Individual product page
├── shopping cart/
│   ├── cart.php                        # Shopping cart
│   ├── checkout.php                    # Checkout process
│   ├── order_confirmation.php          # Order confirmation
│   ├── orders.php                      # Order history
│   └── order_details.php               # Individual order details
├── admin_vendor management/
│   ├── add-product.php                 # Add products (admin)
│   ├── adit-product.php                # Edit products (admin)
│   ├── admin/
│   │   ├── login.php                   # Admin login
│   │   ├── dashboard.php               # Admin dashboard
│   │   ├── users.php                   # Manage users
│   │   ├── products.php                # Manage products
│   │   ├── categories.php              # Manage categories
│   │   └── orders.php                  # View orders
│   └── vendor/
│       ├── login.php                   # Vendor login
│       ├── dashboard.php               # Vendor dashboard
│       ├── products.php                # Vendor products
│       ├── add-product.php             # Vendor add product
│       ├── edit-product.php            # Vendor edit product
│       ├── sales.php                   # Vendor sales report
│       └── profile.php                 # Vendor profile
├── pages/
│   ├── about.php                       # About page
│   ├── contact.php                     # Contact page
│   └── search.php                      # Product search
└── site_layout_and_assets/
    ├── header.php                      # Navigation header
    ├── footer.php                      # Site footer
    ├── style.css                       # Responsive CSS styling
    └── script.js                       # JavaScript utilities
```

## Setup Instructions

### Prerequisites
- XAMPP or similar PHP/MySQL server
- PHP 7.4+
- MySQL 5.7+
- Modern web browser

### Installation

1. **Move files to XAMPP**
   ```bash
   Move the campus_based_e_commerce_platform folder to:
   C:\xampp\htdocs\
   ```

2. **Create Database**
   - Open phpMyAdmin: `http://localhost/phpmyadmin/`
   - Create a new database: `campus_based_e_commerce_platform`
   - Import `DATABASE_SETUP.sql`:
     - Select the database
     - Go to Import
     - Choose `DATABASE_SETUP.sql` file
     - Click Import

3. **Update Database Configuration** (if needed)
   Edit `authentication/config.php`:
   ```php
   $dbHost = 'localhost';
   $dbUser = 'root';      // Your MySQL user
   $dbPass = '';          // Your MySQL password
   $dbName = 'campus_based_e_commerce_platform';
   ```

4. **Access the Application**
   - Homepage: `http://localhost/campus_based_e_commerce_platform/`
   - Store: `http://localhost/campus_based_e_commerce_platform/store/`

## Test Accounts

### Default Admin Account
- **URL:** `http://localhost/campus_based_e_commerce_platform/admin_vendor%20management/admin/login.php`
- **Username:** admin
- **Password:** admin123

### Default Student Account
- **URL:** `http://localhost/campus_based_e_commerce_platform/authentication/login.php`
- **Username:** student1
- **Password:** password123

### Default Vendor Account
- **URL:** `http://localhost/campus_based_e_commerce_platform/admin_vendor%20management/vendor/login.php`
- **Username:** vendor1
- **Password:** vendor123

## Database Schema

The platform includes the following main tables:

- **users** - User accounts with authentication
- **user_profiles** - Extended user information
- **categories** - Product categories
- **products** - Product inventory
- **orders** - Customer orders
- **order_items** - Individual items in orders
- **support_tickets** - Customer support system

## API/Helper Functions

### Authentication Functions
```php
getPDOConnection()        // Get database connection
loginUser($username, $password)    // Authenticate user
registerUser(...)         // Register new user
```

### Data Functions
```php
fetchRow($query, $params)        // Fetch single row
fetchAll($query, $params)        // Fetch multiple rows
getAllCategories()               // Get all product categories
getAllVendors()                  // Get all vendors
getProductDetails($id)           // Get product with relationships
```

### Order Functions
```php
createOrder($userId, $total, $address, $items)  // Create new order
```

## Security Features

- ✅ Password hashing with bcrypt
- ✅ SQL prepared statements (PDO)
- ✅ Session-based authentication
- ✅ Input validation and sanitization
- ✅ XSS protection via htmlspecialchars()
- ✅ CSRF protection via session management

## Responsive Design

- Mobile-first approach
- Works on phones, tablets, and desktops
- Flexible grid layouts
- Touch-friendly buttons and inputs

## Browser Compatibility

- Chrome/Chromium
- Firefox
- Safari
- Edge
- Mobile browsers

## File Sizes

- **HTML files:** 2-4 KB each
- **CSS:** ~12 KB (minifiable)
- **JavaScript:** ~3 KB (utilities)
- **Database:** ~500 KB with sample data

## Performance Optimization Tips

1. **Database Indexing** - Indexes on frequently queried columns
2. **Query Optimization** - Use JOINs efficiently
3. **Caching** - Implement PHP caching for static content
4. **Asset Optimization** - Minify CSS/JS for production

## Future Enhancements

- Payment gateway integration (Stripe, PayPal)
- Email notifications
- Advanced analytics
- Product reviews and ratings
- Wishlist functionality
- Promotional codes/discounts
- Multi-language support
- REST API
- Mobile app

## Troubleshooting

### Database Connection Error
- Verify MySQL is running
- Check credentials in `config.php`
- Ensure database exists

### Session Issues
- Clear browser cookies
- Check PHP session settings
- Verify write permissions on temp folder

### File Not Found
- Check file paths match your installation
- Use absolute paths in require statements
- Verify folder permissions

## Support

For issues or questions:
- Email: support@campusshop.edu
- Phone: +1-800-CAMPUS-1
- Contact form: `/pages/contact.php`

## License

This project is provided as-is for educational purposes.

## Version

**Version:** 1.0.0
**Last Updated:** 2026-06-20
**PHP Version:** 7.4+
**MySQL Version:** 5.7+

---

**Built with:** PHP, MySQL, HTML5, CSS3, JavaScript
