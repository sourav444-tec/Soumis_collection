-- Soumis Collections - Quick SQL Commands Reference

-- View all products
SELECT * FROM products;

-- View all users
SELECT * FROM users;

-- Create admin user (password: password123)
INSERT INTO users (name, email, password, is_admin) VALUES 
('Admin', 'admin@soumis.local', 'password123', 1);

-- Create admin user (hashed password - recommended)
-- Use the command: php -r "echo password_hash('password123', PASSWORD_DEFAULT);"
INSERT INTO users (name, email, password, is_admin) VALUES 
('Admin', 'admin@soumis.local', '$2y$10$kWDa3p2gAYbKJr5kZJgFZ.QJ9d.kF.YCXJ2yl0k8K.Q6OzN6VGjuu', 1);

-- View all wholesale applications
SELECT * FROM wholesale_applications;

-- Update application status
UPDATE wholesale_applications SET status = 'contacted' WHERE id = 1;

-- View product count
SELECT COUNT(*) as total_products FROM products;

-- View low stock products (less than 5)
SELECT id, name, stock FROM products WHERE stock < 5;

-- Update product stock
UPDATE products SET stock = 20 WHERE id = 'prod_123';

-- Delete a product
DELETE FROM products WHERE id = 'prod_123';

-- View user registration dates
SELECT name, email, created_at FROM users ORDER BY created_at DESC;

-- View admin users only
SELECT * FROM users WHERE is_admin = 1;

-- Reset database (WARNING: Deletes all data!)
-- DROP DATABASE soumis_collection;
-- CREATE DATABASE soumis_collection;

-- View wholesale applications pending review
SELECT company_name, contact_name, email, order_quantity, purchase_amount, created_at 
FROM wholesale_applications 
WHERE status = 'pending'
ORDER BY created_at DESC;

-- Count products by category
SELECT category, COUNT(*) as count FROM products GROUP BY category;

-- Get average product price
SELECT AVG(retail_price) as avg_price FROM products;

-- Find expensive products (over 5000)
SELECT name, retail_price FROM products WHERE retail_price > 5000 ORDER BY retail_price DESC;

-- Archive old products (example: older than 6 months)
-- UPDATE products SET archived = 1 WHERE created_at < DATE_SUB(NOW(), INTERVAL 6 MONTH);

-- View table structure
DESCRIBE products;
DESCRIBE users;
DESCRIBE wholesale_applications;
DESCRIBE orders;
DESCRIBE cart;
DESCRIBE wishlist;
