# SQL Database Setup Guide - Soumis Collections

## Overview

Your project now uses MySQL database for complete data persistence. This guide shows you how to set up and use it.

## Prerequisites

- XAMPP installed (includes MySQL/MariaDB)
- PHP 7.4+
- Web server (Apache)

---

## Step 1: Start MySQL Server

1. Open **XAMPP Control Panel**
2. Click **Start** next to **MySQL**
3. You should see "Running" in green

---

## Step 2: Create the Database

### Method A: Using phpMyAdmin (Recommended)

1. Open XAMPP Control Panel
2. Click **Admin** next to MySQL (or go to `http://localhost/phpmyadmin`)
3. In left sidebar, look for the input field at the top
4. Type: `soumis_collection`
5. Click **Create**

### Method B: Using Command Line

```bash
mysql -u root -p
# Press Enter (no password by default)

CREATE DATABASE soumis_collection;
USE soumis_collection;
```

---

## Step 3: Import the Database Schema

### Method A: Using phpMyAdmin (Easiest)

1. Go to `http://localhost/phpmyadmin`
2. Click on **soumis_collection** database (left sidebar)
3. Click **Import** tab
4. Click **Choose File**
5. Select `database.sql` from your project folder
6. Click **Import**

### Method B: Using Command Line

```bash
cd C:\xampp\htdocs\Soumis_collection
mysql -u root soumis_collection < database.sql
```

---

## Step 4: Create Default Admin Account

After importing the database, create an admin user by running this SQL in phpMyAdmin:

```sql
INSERT INTO users (name, email, password, is_admin) VALUES
('Admin', 'admin@soumis.local', 'password123', 1);
```

Or use a hashed password (recommended):

```sql
INSERT INTO users (name, email, password, is_admin) VALUES
('Admin', 'admin@soumis.local', '$2y$10$kWDa3p2gAYbKJr5kZJgFZ.QJ9d.kF.YCXJ2yl0k8K.Q6OzN6VGjuu', 1);
```

**Login Credentials:**

- Email: `admin@soumis.local`
- Password: `password123`

---

## Step 5: Configure Your Project

The database configuration is already set in `db_config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');  // No password by default
define('DB_NAME', 'soumis_collection');
```

If your MySQL root password is different, update `db_config.php`:

```php
define('DB_PASS', 'your_password_here');
```

---

## Step 6: Test the Setup

1. Start Apache in XAMPP Control Panel
2. Go to `http://localhost/Soumis_collection/`
3. Test adding a product from admin panel
4. Check if it appears on the website

---

## Database Tables Overview

### products

- Stores all products
- Fields: id, name, description, category, sections, prices, stock, colors, image

### users

- Stores customer and admin accounts
- Fields: id, email, password, name, phone, address, is_admin

### orders

- Stores customer orders
- Fields: id, order_number, user_id, total_amount, status, items

### wishlist

- Stores product favorites
- Fields: id, user_id, product_id

### wholesale_applications

- Stores bulk order applications
- Fields: id, company_name, contact_name, email, quantity, purchase_amount, status

### cart

- Stores shopping cart items
- Fields: id, user_id, product_id, quantity, color

### reviews

- Stores product reviews and ratings
- Fields: id, product_id, user_id, rating, review_text

### stock_alerts

- Tracks low stock warnings
- Fields: id, product_id, alert_type

---

## Common Database Operations

### Add a New Product (SQL)

```sql
INSERT INTO products (id, name, description, category, retail_price, wholesale_price, stock, image)
VALUES ('prod_123', 'Product Name', 'Description', 'earrings', 999.99, 799.99, 10, 'images/products/image.jpg');
```

### View All Products

```sql
SELECT * FROM products;
```

### Update Product Stock

```sql
UPDATE products SET stock = 20 WHERE id = 'prod_123';
```

### View All Users

```sql
SELECT * FROM users;
```

### View Wholesale Applications

```sql
SELECT * FROM wholesale_applications WHERE status = 'pending';
```

---

## Troubleshooting

### "Connection failed" Error

- Make sure MySQL is running in XAMPP Control Panel
- Check if `db_config.php` has correct credentials
- Verify database name is `soumis_collection`

### "Table doesn't exist" Error

- Re-import `database.sql` (may have missed a step)
- Delete existing database and create fresh one

### Admin Can't Login

- Verify admin user exists: `SELECT * FROM users WHERE is_admin = 1;`
- Check email matches exactly
- Create new admin user if needed

### Products Not Showing

- Check if products exist: `SELECT COUNT(*) FROM products;`
- Verify `db_config.php` is included in product pages
- Check browser console for JavaScript errors

---

## Next Steps

1. **Add Products**: Use admin panel to create products with images
2. **Manage Users**: Monitor user registrations
3. **View Orders**: Check orders once customers purchase
4. **Monitor Wholesale**: Review wholesale applications
5. **Backup Database**: Regular backups recommended

---

## Security Recommendations

For production use:

1. Change all default passwords
2. Use strong password hashing (already implemented with `password_hash()`)
3. Implement SSL/HTTPS
4. Regular database backups
5. Validate all user input
6. Use environment variables for sensitive data

---

## Support

For issues:

1. Check XAMPP Control Panel - ensure MySQL is running
2. Review `db_config.php` for correct settings
3. Use phpMyAdmin to verify database and tables exist
4. Check PHP error logs in XAMPP folder
