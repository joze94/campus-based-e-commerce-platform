-- ============================================================================
-- Campus E-Commerce Platform - Comprehensive Database Schema
-- ============================================================================
-- Supports: Users, Products, Cart, Orders, Reviews, Payments, Returns, 
-- Notifications, Coupons, Wishlist, Support Tickets, and Analytics
-- ============================================================================

-- Drop dependent routines/views first so re-importing this file is repeatable.
DROP VIEW IF EXISTS `vw_return_requests`;
DROP VIEW IF EXISTS `vw_vendor_sales`;
DROP VIEW IF EXISTS `vw_coupon_usage`;
DROP VIEW IF EXISTS `vw_product_stock`;
DROP VIEW IF EXISTS `vw_order_summary`;
DROP TRIGGER IF EXISTS `trg_order_item_before_insert`;
DROP TRIGGER IF EXISTS `trg_order_item_after_insert`;
DROP TRIGGER IF EXISTS `trg_order_item_after_delete`;
DROP TRIGGER IF EXISTS `trg_order_item_after_update`;
DROP TRIGGER IF EXISTS `trg_order_coupon_usage_after_insert`;
DROP TRIGGER IF EXISTS `trg_order_coupon_usage_after_delete`;
DROP PROCEDURE IF EXISTS `sp_place_order`;
DROP PROCEDURE IF EXISTS `sp_process_payment`;
DROP PROCEDURE IF EXISTS `sp_create_return_request`;
DROP PROCEDURE IF EXISTS `sp_create_support_ticket`;
DROP PROCEDURE IF EXISTS `sp_add_support_reply`;

-- Drop existing tables if they exist (in dependency order)
DROP TABLE IF EXISTS `product_analytics`;
DROP TABLE IF EXISTS `support_ticket_replies`;
DROP TABLE IF EXISTS `support_tickets`;
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `return_requests`;
DROP TABLE IF EXISTS `payments`;
DROP TABLE IF EXISTS `reviews_ratings`;
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `order_coupon_usage`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `cart_items`;
DROP TABLE IF EXISTS `wishlists`;
DROP TABLE IF EXISTS `product_images`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `coupons_discounts`;
DROP TABLE IF EXISTS `vendor_profiles`;
DROP TABLE IF EXISTS `user_profiles`;
DROP TABLE IF EXISTS `addresses`;
DROP TABLE IF EXISTS `users`;

-- ============================================================================
-- CORE TABLES
-- ============================================================================

-- Users table (Core authentication)
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` VARCHAR(50) UNIQUE NOT NULL,
  `username` VARCHAR(50) UNIQUE DEFAULT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` ENUM('student', 'vendor', 'admin') DEFAULT 'student',
  `is_active` TINYINT(1) DEFAULT 1,
  `email_verified` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` DATETIME NULL,
  UNIQUE KEY `uk_email` (`email`),
  UNIQUE KEY `uk_student_id` (`student_id`),
  UNIQUE KEY `uk_username` (`username`),
  INDEX `idx_role` (`role`),
  INDEX `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User Profiles table (Extended user information)
CREATE TABLE `user_profiles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNIQUE NOT NULL,
  `student_id` VARCHAR(50),
  `first_name` VARCHAR(100),
  `last_name` VARCHAR(100),
  `phone` VARCHAR(20),
  `campus_location` VARCHAR(100),
  `department` VARCHAR(100),
  `year_of_study` INT,
  `profile_picture` VARCHAR(255),
  `bio` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Vendor Profiles table (Seller-specific information)
CREATE TABLE `vendor_profiles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNIQUE NOT NULL,
  `shop_name` VARCHAR(150),
  `shop_description` TEXT,
  `shop_logo` VARCHAR(255),
  `bank_account` VARCHAR(50),
  `bank_name` VARCHAR(100),
  `commission_rate` DECIMAL(5, 2) DEFAULT 10.00,
  `is_verified` TINYINT(1) DEFAULT 0,
  `rating` DECIMAL(3, 2) DEFAULT 0.00,
  `total_sales` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_is_verified` (`is_verified`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Addresses table (Multiple delivery addresses per user)
CREATE TABLE `addresses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `type` ENUM('home', 'hostel', 'office', 'other') DEFAULT 'home',
  `recipient_name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `street_address` TEXT NOT NULL,
  `city` VARCHAR(100) NOT NULL,
  `state` VARCHAR(100),
  `postal_code` VARCHAR(20),
  `is_default` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_is_default` (`is_default`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- PRODUCT MANAGEMENT TABLES
-- ============================================================================

-- Categories table
CREATE TABLE `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `slug` VARCHAR(100) UNIQUE,
  `description` TEXT,
  `icon` VARCHAR(255),
  `image` VARCHAR(255),
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_name` (`name`),
  INDEX `idx_is_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products table
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `vendor_id` INT NOT NULL,
  `category_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255),
  `description` LONGTEXT,
  `short_description` VARCHAR(500),
  `price` DECIMAL(12, 2) NOT NULL,
  `discount_price` DECIMAL(12, 2),
  `quantity` INT DEFAULT 0,
  `main_image` VARCHAR(255),
  `status` ENUM('draft', 'active', 'inactive', 'archived') DEFAULT 'draft',
  `rating` DECIMAL(3, 2) DEFAULT 0.00,
  `total_reviews` INT DEFAULT 0,
  `total_sales` INT DEFAULT 0,
  `sku` VARCHAR(100) UNIQUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`vendor_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE RESTRICT,
  INDEX `idx_vendor_id` (`vendor_id`),
  INDEX `idx_category_id` (`category_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_rating` (`rating`),
  FULLTEXT INDEX `ft_search` (`title`, `description`, `short_description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Product Images table (Gallery for each product)
CREATE TABLE `product_images` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `alt_text` VARCHAR(255),
  `sort_order` INT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
  INDEX `idx_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- SHOPPING & CART TABLES
-- ============================================================================

-- Cart Items table
CREATE TABLE `cart_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT DEFAULT 1,
  `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_cart_item` (`user_id`, `product_id`),
  INDEX `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Wishlist table
CREATE TABLE `wishlists` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_wishlist_item` (`user_id`, `product_id`),
  INDEX `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- ORDER TABLES
-- ============================================================================

-- Coupons & Discounts table
CREATE TABLE `coupons_discounts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(50) UNIQUE NOT NULL,
  `discount_type` ENUM('percentage', 'fixed') DEFAULT 'percentage',
  `discount_value` DECIMAL(10, 2) NOT NULL,
  `min_purchase_amount` DECIMAL(12, 2) DEFAULT 0,
  `max_usage_limit` INT,
  `current_usage` INT DEFAULT 0,
  `usage_per_user` INT DEFAULT 1,
  `is_active` TINYINT(1) DEFAULT 1,
  `valid_from` DATETIME,
  `valid_until` DATETIME,
  `created_by` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uk_code` (`code`),
  INDEX `idx_is_active` (`is_active`),
  INDEX `idx_valid_from` (`valid_from`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Orders table
CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_number` VARCHAR(50) UNIQUE,
  `user_id` INT NOT NULL,
  `vendor_id` INT,
  `address_id` INT,
  `coupon_id` INT,
  `subtotal` DECIMAL(12, 2) NOT NULL DEFAULT 0,
  `discount_amount` DECIMAL(12, 2) DEFAULT 0,
  `tax_amount` DECIMAL(12, 2) DEFAULT 0,
  `shipping_cost` DECIMAL(12, 2) DEFAULT 0,
  `total_amount` DECIMAL(12, 2) NOT NULL,
  `shipping_address` TEXT,
  `billing_address` TEXT,
  `status` ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
  `order_status` ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
  `payment_status` ENUM('unpaid', 'paid', 'partial', 'refunded') DEFAULT 'unpaid',
  `delivery_address` TEXT,
  `delivery_phone` VARCHAR(20),
  `delivery_notes` TEXT,
  `tracking_number` VARCHAR(100),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delivered_at` DATETIME NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`vendor_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`address_id`) REFERENCES `addresses`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`coupon_id`) REFERENCES `coupons_discounts`(`id`) ON DELETE SET NULL,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_vendor_id` (`vendor_id`),
  INDEX `idx_order_status` (`order_status`),
  INDEX `idx_payment_status` (`payment_status`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Order Items table
CREATE TABLE `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `product_title` VARCHAR(255),
  `product_image` VARCHAR(255),
  `quantity` INT NOT NULL,
  `price` DECIMAL(12, 2),
  `unit_price` DECIMAL(12, 2),
  `subtotal` DECIMAL(12, 2),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
  INDEX `idx_order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Order Coupon Usage (for tracking coupon usage per order)
CREATE TABLE `order_coupon_usage` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `coupon_id` INT NOT NULL,
  `discount_applied` DECIMAL(12, 2),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`coupon_id`) REFERENCES `coupons_discounts`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- PAYMENT TABLES
-- ============================================================================

-- Payments table
CREATE TABLE `payments` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT UNIQUE NOT NULL,
  `user_id` INT NOT NULL,
  `payment_method` ENUM('credit_card', 'debit_card', 'net_banking', 'upi', 'wallet', 'cod') DEFAULT 'cod',
  `transaction_id` VARCHAR(100) UNIQUE,
  `amount` DECIMAL(12, 2) NOT NULL,
  `status` ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
  `gateway` VARCHAR(50),
  `response` LONGTEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- REVIEWS & RATINGS TABLES
-- ============================================================================

-- Reviews & Ratings table
CREATE TABLE `reviews_ratings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `order_id` INT,
  `rating` INT NOT NULL COMMENT '1-5 stars',
  `title` VARCHAR(255),
  `comment` TEXT,
  `is_verified_purchase` TINYINT(1) DEFAULT 1,
  `helpful_count` INT DEFAULT 0,
  `unhelpful_count` INT DEFAULT 0,
  `status` ENUM('pending', 'approved', 'rejected', 'flagged') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE SET NULL,
  UNIQUE KEY `unique_product_user_review` (`product_id`, `user_id`),
  INDEX `idx_product_id` (`product_id`),
  INDEX `idx_rating` (`rating`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- RETURNS & REFUNDS TABLES
-- ============================================================================

-- Return Requests table
CREATE TABLE `return_requests` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `return_reason` ENUM('defective', 'damaged', 'wrong_item', 'not_as_described', 'changed_mind', 'other') DEFAULT 'other',
  `reason_description` TEXT,
  `return_status` ENUM('pending', 'approved', 'shipped', 'received', 'refunded', 'rejected') DEFAULT 'pending',
  `refund_amount` DECIMAL(12, 2),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `approved_at` DATETIME NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_return_status` (`return_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- NOTIFICATION TABLES
-- ============================================================================

-- Notifications table
CREATE TABLE `notifications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `type` ENUM('order_update', 'payment', 'product_available', 'promotion', 'system', 'message') DEFAULT 'system',
  `title` VARCHAR(255) NOT NULL,
  `message` TEXT NOT NULL,
  `reference_id` INT COMMENT 'Product/Order ID',
  `reference_type` VARCHAR(50),
  `is_read` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_is_read` (`is_read`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- SUPPORT TABLES
-- ============================================================================

-- Support Tickets table
CREATE TABLE `support_tickets` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ticket_number` VARCHAR(50) UNIQUE NOT NULL,
  `user_id` INT NOT NULL,
  `order_id` INT,
  `subject` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `category` ENUM('product', 'order', 'payment', 'delivery', 'other') DEFAULT 'other',
  `priority` ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
  `status` ENUM('open', 'in_progress', 'waiting_customer', 'resolved', 'closed') DEFAULT 'open',
  `assigned_to` INT COMMENT 'Admin ID',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `resolved_at` DATETIME NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE SET NULL,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Support Ticket Replies table
CREATE TABLE `support_ticket_replies` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `ticket_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `message` TEXT NOT NULL,
  `attachment` VARCHAR(255),
  `is_admin_reply` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`ticket_id`) REFERENCES `support_tickets`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- ANALYTICS TABLES
-- ============================================================================

-- Product Analytics table
CREATE TABLE `product_analytics` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `date` DATE NOT NULL,
  `views` INT DEFAULT 0,
  `cart_adds` INT DEFAULT 0,
  `purchases` INT DEFAULT 0,
  `revenue` DECIMAL(12, 2) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `unique_product_date` (`product_id`, `date`),
  INDEX `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TRIGGERS, STORED PROCEDURES, AND VIEWS
-- ============================================================================

DELIMITER $$

CREATE TRIGGER `trg_order_item_before_insert`
BEFORE INSERT ON `order_items`
FOR EACH ROW
BEGIN
  IF NEW.`price` IS NULL THEN
    SET NEW.`price` = NEW.`unit_price`;
  END IF;

  IF NEW.`unit_price` IS NULL THEN
    SET NEW.`unit_price` = NEW.`price`;
  END IF;

  IF NEW.`subtotal` IS NULL THEN
    SET NEW.`subtotal` = NEW.`quantity` * NEW.`price`;
  END IF;

  IF NEW.`product_title` IS NULL THEN
    SET NEW.`product_title` = (
      SELECT `title`
      FROM `products`
      WHERE `id` = NEW.`product_id`
      LIMIT 1
    );
  END IF;
END$$

CREATE TRIGGER `trg_order_item_after_insert`
AFTER INSERT ON `order_items`
FOR EACH ROW
BEGIN
  UPDATE `products`
  SET `quantity` = GREATEST(`quantity` - NEW.`quantity`, 0),
      `total_sales` = `total_sales` + NEW.`quantity`
  WHERE `id` = NEW.`product_id`;

  INSERT INTO `product_analytics` (`product_id`, `date`, `purchases`, `revenue`)
  VALUES (NEW.`product_id`, CURDATE(), NEW.`quantity`, NEW.`subtotal`)
  ON DUPLICATE KEY UPDATE
    `purchases` = `purchases` + NEW.`quantity`,
    `revenue` = `revenue` + NEW.`subtotal`;
END$$

CREATE TRIGGER `trg_order_item_after_delete`
AFTER DELETE ON `order_items`
FOR EACH ROW
BEGIN
  UPDATE `products`
  SET `quantity` = `quantity` + OLD.`quantity`,
      `total_sales` = GREATEST(`total_sales` - OLD.`quantity`, 0)
  WHERE `id` = OLD.`product_id`;
END$$

CREATE TRIGGER `trg_order_item_after_update`
AFTER UPDATE ON `order_items`
FOR EACH ROW
BEGIN
  DECLARE delta INT;
  SET delta = NEW.`quantity` - OLD.`quantity`;

  UPDATE `products`
  SET `quantity` = GREATEST(`quantity` - delta, 0),
      `total_sales` = GREATEST(`total_sales` + delta, 0)
  WHERE `id` = NEW.`product_id`;

  IF delta <> 0 THEN
    INSERT INTO `product_analytics` (`product_id`, `date`, `purchases`, `revenue`)
    VALUES (NEW.`product_id`, CURDATE(), delta, NEW.`subtotal` - OLD.`subtotal`)
    ON DUPLICATE KEY UPDATE
      `purchases` = `purchases` + delta,
      `revenue` = `revenue` + NEW.`subtotal` - OLD.`subtotal`;
  END IF;
END$$

CREATE TRIGGER `trg_order_coupon_usage_after_insert`
AFTER INSERT ON `order_coupon_usage`
FOR EACH ROW
BEGIN
  UPDATE `coupons_discounts`
  SET `current_usage` = `current_usage` + 1
  WHERE `id` = NEW.`coupon_id`;
END$$

CREATE TRIGGER `trg_order_coupon_usage_after_delete`
AFTER DELETE ON `order_coupon_usage`
FOR EACH ROW
BEGIN
  UPDATE `coupons_discounts`
  SET `current_usage` = GREATEST(`current_usage` - 1, 0)
  WHERE `id` = OLD.`coupon_id`;
END$$

-- Stored procedures were removed from this install script because the PHP app
-- does not call them and the previous implementation required MySQL 8 JSON_TABLE.

DELIMITER ;

CREATE VIEW `vw_order_summary` AS
SELECT
  o.`id` AS order_id,
  o.`order_number`,
  u.`username`,
  u.`email`,
  o.`order_status`,
  o.`payment_status`,
  o.`total_amount`,
  o.`created_at`
FROM `orders` o
JOIN `users` u ON u.`id` = o.`user_id`;

CREATE VIEW `vw_product_stock` AS
SELECT
  p.`id` AS product_id,
  p.`title`,
  c.`name` AS category,
  p.`quantity`,
  p.`total_sales`,
  p.`status`
FROM `products` p
JOIN `categories` c ON c.`id` = p.`category_id`;

CREATE VIEW `vw_coupon_usage` AS
SELECT
  c.`id` AS coupon_id,
  c.`code`,
  c.`discount_type`,
  c.`discount_value`,
  c.`current_usage`,
  c.`max_usage_limit`,
  COUNT(ocu.`id`) AS orders_used
FROM `coupons_discounts` c
LEFT JOIN `order_coupon_usage` ocu ON ocu.`coupon_id` = c.`id`
GROUP BY c.`id`, c.`code`, c.`discount_type`, c.`discount_value`, c.`current_usage`, c.`max_usage_limit`;

CREATE VIEW `vw_vendor_sales` AS
SELECT
  p.`vendor_id`,
  u.`username` AS vendor_username,
  SUM(oi.`subtotal`) AS revenue,
  COUNT(DISTINCT oi.`order_id`) AS order_count,
  SUM(oi.`quantity`) AS units_sold
FROM `order_items` oi
JOIN `products` p ON p.`id` = oi.`product_id`
JOIN `users` u ON u.`id` = p.`vendor_id`
GROUP BY p.`vendor_id`, u.`username`;

CREATE VIEW `vw_return_requests` AS
SELECT
  rr.`id` AS return_id,
  rr.`order_id`,
  u.`username`,
  rr.`return_reason`,
  rr.`return_status`,
  rr.`refund_amount`,
  rr.`created_at`
FROM `return_requests` rr
JOIN `users` u ON u.`id` = rr.`user_id`;

-- ============================================================================
-- SAMPLE DATA
-- ============================================================================

-- Insert categories
INSERT INTO `categories` (`name`, `slug`, `description`, `is_active`) VALUES
('Books', 'books', 'Textbooks, novels, and study materials', 1),
('Electronics', 'electronics', 'Laptops, phones, and gadgets', 1),
('Clothing & Apparel', 'clothing', 'T-shirts, hoodies, and campus wear', 1),
('Furniture & Decor', 'furniture', 'Desks, chairs, and room decor', 1),
('Services', 'services', 'Tutoring, notes-taking, and more', 1),
('Sports & Recreation', 'sports', 'Sports equipment and recreational items', 1),
('Food & Beverages', 'food', 'Snacks, drinks, and meal preparations', 1),
('Stationery & Supplies', 'stationery', 'Pens, notebooks, and office supplies', 1);

-- Insert users (admin, vendor, students)
INSERT INTO `users` (`student_id`, `username`, `email`, `password_hash`, `role`, `is_active`, `email_verified`, `last_login`) VALUES
('ADM001', 'admin', 'admin@campusshop.edu', '$2y$10$JlfbKWadcb667tgsDPPgiO4tISrT7y.Nhtu44GYEObQP/tl4HRtca', 'admin', 1, 1, NOW()),
('V001', 'vendor1', 'vendor1@example.edu', '$2y$10$GcYMBV/ig0fAmNJHU7XZ5ep585JEkF2ZGr2lFVmIbvjPNsluL0XEu', 'vendor', 1, 1, NOW()),
('S001', 'student1', 'student1@example.edu', '$2y$10$GYhq2DygelQLk7CRTVINQOXTCO9equSvnC94IVkVd/WXHzWya57Im', 'student', 1, 1, NOW());

-- Insert user profiles
INSERT INTO `user_profiles` (`user_id`, `student_id`, `first_name`, `last_name`, `phone`, `campus_location`, `department`, `year_of_study`) VALUES
(1, 'ADM001', 'Campus', 'Admin', '+1-800-CAMPUS-1', 'Main Office', 'Administration', NULL),
(2, 'V001', 'Jane', 'Vendor', '+1-234-567-8902', 'Vendor Hall', 'Business', NULL),
(3, 'S001', 'John', 'Student', '+1-234-567-8901', 'North Campus', 'Computer Science', 3);

-- Insert vendor profile
INSERT INTO `vendor_profiles` (`user_id`, `shop_name`, `shop_description`, `is_verified`, `rating`) VALUES
(2, 'Campus Shop Pro', 'Your one-stop shop for all campus needs', 1, 4.5);

-- Insert addresses
INSERT INTO `addresses` (`user_id`, `type`, `recipient_name`, `phone`, `street_address`, `city`, `state`, `postal_code`, `is_default`) VALUES
(3, 'hostel', 'John Student', '+1-234-567-8901', 'Hostel Block A, Room 201', 'University City', 'State', '12345', 1);

-- Insert products
INSERT INTO `products` (`vendor_id`, `category_id`, `title`, `slug`, `description`, `short_description`, `price`, `quantity`, `status`, `sku`) VALUES
(2, 1, 'Data Structures & Algorithms', 'data-structures-algorithms', 'Comprehensive textbook covering all DSA concepts for CS students', 'DSA Textbook', 45.99, 10, 'active', 'BOOK001'),
(2, 2, 'USB-C Cable (2m)', 'usb-c-cable-2m', 'Durable and fast USB-C charging cable with reinforced connectors', 'Fast USB-C Cable', 12.99, 50, 'active', 'ELEC001'),
(2, 3, 'Campus Hoodie - Blue', 'campus-hoodie-blue', 'Official university hoodie in blue with embroidered logo', 'Official Campus Hoodie', 39.99, 25, 'active', 'CLOTH001'),
(2, 4, 'LED Desk Lamp with USB', 'led-desk-lamp-usb', 'Adjustable LED desk lamp with built-in USB charging port', 'Smart Desk Lamp', 29.99, 15, 'active', 'FURN001'),
(2, 6, 'Professional Basketball', 'professional-basketball', 'Professional grade outdoor basketball for sports activities', 'Official Basketball', 34.99, 8, 'active', 'SPORT001');

-- Insert sample coupon
INSERT INTO `coupons_discounts` (`code`, `discount_type`, `discount_value`, `min_purchase_amount`, `max_usage_limit`, `is_active`, `valid_from`, `valid_until`) VALUES
('WELCOME10', 'percentage', 10.00, 50.00, 100, 1, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
('SAVE50', 'fixed', 50.00, 200.00, 50, 1, NOW(), DATE_ADD(NOW(), INTERVAL 60 DAY));

-- ============================================================================
-- Optional: Create database user (uncomment and modify as needed)
-- ============================================================================
-- CREATE USER 'ecommerce_user'@'127.0.0.1' IDENTIFIED BY 'secure_password_here';
-- GRANT ALL PRIVILEGES ON campus_ecommerce.* TO 'ecommerce_user'@'127.0.0.1';
-- FLUSH PRIVILEGES;
