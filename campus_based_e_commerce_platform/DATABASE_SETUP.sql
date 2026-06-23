-- ============================================================================
-- Campus E-Commerce Platform - Database Setup Script
-- ============================================================================
-- Database Name: campus_based_e_commerce_platform
-- MySQL Version: 5.7+
-- ============================================================================

-- CREATE DATABASE
CREATE DATABASE IF NOT EXISTS `campus_based_e_commerce_platform` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- SELECT DATABASE
USE `campus_based_e_commerce_platform`;

-- ============================================================================
-- INSTALLATION STEPS:
-- ============================================================================
-- 1. Open phpMyAdmin: http://localhost/phpmyadmin/
-- 2. Create new database: campus_based_e_commerce_platform
-- 3. Go to Import tab
-- 4. Select the DATABASE_SETUP.sql file
-- 5. Click Import
-- 6. Application will be ready!
-- ============================================================================

-- Drop existing tables if they exist (in dependency order)
DROP TABLE IF EXISTS `product_analytics`;
DROP TABLE IF EXISTS `support_tickets`;
DROP TABLE IF EXISTS `notifications`;
DROP TABLE IF EXISTS `return_requests`;
DROP TABLE IF EXISTS `payments`;
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `order_coupon_usage`;
DROP TABLE IF EXISTS `cart_items`;
DROP TABLE IF EXISTS `reviews_ratings`;
DROP TABLE IF EXISTS `wishlists`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `coupons_discounts`;
DROP TABLE IF EXISTS `vendor_profiles`;
DROP TABLE IF EXISTS `user_profiles`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `addresses`;

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
  INDEX `idx_is_active` (`is_active`),
  INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User Profiles table
CREATE TABLE `user_profiles` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL UNIQUE,
  `student_id` VARCHAR(50),
  `first_name` VARCHAR(100),
  `last_name` VARCHAR(100),
  `phone` VARCHAR(20),
  `date_of_birth` DATE,
  `profile_picture` VARCHAR(500),
  `bio` TEXT,
  `campus_location` VARCHAR(100),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Categories table
CREATE TABLE `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL UNIQUE,
  `slug` VARCHAR(100) UNIQUE,
  `description` TEXT,
  `icon` VARCHAR(50),
  `image_url` VARCHAR(500),
  `is_active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_is_active` (`is_active`),
  INDEX `idx_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products table
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `vendor_id` INT NOT NULL,
  `category_id` INT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) UNIQUE,
  `description` LONGTEXT,
  `short_description` TEXT,
  `price` DECIMAL(10, 2) NOT NULL,
  `quantity` INT DEFAULT 0,
  `sku` VARCHAR(100) UNIQUE,
  `main_image` VARCHAR(500),
  `status` ENUM('active', 'inactive', 'discontinued') DEFAULT 'active',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`vendor_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL,
  INDEX `idx_vendor_id` (`vendor_id`),
  INDEX `idx_category_id` (`category_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_title` (`title`),
  INDEX `idx_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Orders table
CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `total_amount` DECIMAL(12, 2) NOT NULL,
  `shipping_address` TEXT NOT NULL,
  `billing_address` TEXT,
  `status` ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
  `payment_status` ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
  `shipping_method` VARCHAR(100),
  `tracking_number` VARCHAR(100),
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  INDEX `idx_user_id` (`user_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_created_at` (`created_at`),
  INDEX `idx_payment_status` (`payment_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Order Items table
CREATE TABLE `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `price` DECIMAL(10, 2) NOT NULL,
  `subtotal` DECIMAL(12, 2) GENERATED ALWAYS AS (quantity * price) STORED,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE,
  INDEX `idx_order_id` (`order_id`),
  INDEX `idx_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- SAMPLE DATA
-- ============================================================================

-- Insert sample categories
INSERT INTO `categories` (`name`, `slug`, `description`) VALUES
('Books & Stationery', 'books-stationery', 'College textbooks and supplies'),
('Electronics', 'electronics', 'Laptops, phones, and gadgets'),
('Food & Beverages', 'food-beverages', 'Snacks and drinks'),
('Services', 'services', 'Tutoring and other services'),
('Merchandise', 'merchandise', 'Campus merchandise and apparel');

-- Insert sample users (admin, student, vendor)
INSERT INTO `users` (`student_id`, `username`, `email`, `password_hash`, `role`) VALUES
('ADM001', 'admin', 'admin@campusshop.edu', '$2y$10$JlfbKWadcb667tgsDPPgiO4tISrT7y.Nhtu44GYEObQP/tl4HRtca', 'admin'),
('S001', 'student1', 'student1@example.edu', '$2y$10$GYhq2DygelQLk7CRTVINQOXTCO9equSvnC94IVkVd/WXHzWya57Im', 'student'),
('V001', 'vendor1', 'vendor1@example.edu', '$2y$10$GcYMBV/ig0fAmNJHU7XZ5ep585JEkF2ZGr2lFVmIbvjPNsluL0XEu', 'vendor');

-- Insert sample user profiles
INSERT INTO `user_profiles` (`user_id`, `student_id`, `first_name`, `last_name`, `phone`) VALUES
(1, 'ADM001', 'Campus', 'Admin', '+1-800-CAMPUS-1'),
(2, 'S001', 'John', 'Student', '+1-234-567-8901'),
(3, 'V001', 'Jane', 'Vendor', '+1-234-567-8902');

-- Insert sample products
INSERT INTO `products` (`vendor_id`, `category_id`, `title`, `slug`, `description`, `short_description`, `price`, `quantity`, `sku`, `main_image`, `status`) VALUES
(3, 1, 'Introduction to Computer Science', 'intro-cs', 'Comprehensive guide to programming basics', 'Perfect for beginners', 45.99, 10, 'BOOK-CS-001', 'https://via.placeholder.com/300x400?text=CS+Book', 'active'),
(3, 1, 'Calculus Textbook', 'calculus-textbook', 'Advanced calculus for college students', 'Essential for math majors', 89.99, 5, 'BOOK-MATH-001', 'https://via.placeholder.com/300x400?text=Calculus', 'active'),
(3, 2, 'USB-C Hub - 7 in 1', 'usb-hub-7', 'Multi-port USB hub with HDMI output', 'Great for laptops', 29.99, 15, 'ELEC-HUB-001', 'https://via.placeholder.com/300x400?text=USB+Hub', 'active'),
(3, 3, 'Campus Coffee Blend', 'coffee-blend', 'Premium coffee for students', 'Wake up and study', 12.99, 20, 'FOOD-COFFEE-001', 'https://via.placeholder.com/300x400?text=Coffee', 'active'),
(3, 5, 'Campus Hoodie - Blue', 'hoodie-blue', 'Official campus hoodie', 'Comfortable and stylish', 34.99, 25, 'MERCH-HOOD-001', 'https://via.placeholder.com/300x400?text=Hoodie', 'active');

-- Insert sample orders
INSERT INTO `orders` (`user_id`, `total_amount`, `shipping_address`, `status`, `payment_status`) VALUES
(2, 75.98, '123 Student St, Campus, City 12345', 'pending', 'completed'),
(2, 29.99, '123 Student St, Campus, City 12345', 'confirmed', 'completed');

-- Insert sample order items
INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 45.99),
(1, 4, 1, 29.99),
(2, 3, 1, 29.99);

-- ============================================================================
-- DATABASE CONFIGURATION SUMMARY
-- ============================================================================
-- Database Name: campus_based_e_commerce_platform
-- Tables: 6 core tables (users, user_profiles, categories, products, orders, order_items)
-- Sample Data: 3 users, 5 categories, 5 products, 2 orders
-- Ready for use!
-- ============================================================================
