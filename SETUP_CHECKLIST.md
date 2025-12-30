# ✅ SQL Integration Setup Checklist

## Pre-Setup Verification

- [ ] XAMPP is installed
- [ ] MySQL is available in XAMPP
- [ ] Apache is available in XAMPP
- [ ] You have admin access to your computer
- [ ] You are in the correct folder: `C:\xampp\htdocs\Soumis_collection\`

---

## Step 1: Start MySQL

- [ ] Open XAMPP Control Panel
- [ ] Find the MySQL row
- [ ] Click "Start" button
- [ ] Wait for it to show "Running" in green
- [ ] Verify port is 3306

---

## Step 2: Create Database

- [ ] Open XAMPP Control Panel
- [ ] Click "Admin" button next to MySQL
- [ ] phpMyAdmin opens in browser
- [ ] Look for the input field at top
- [ ] Type: `soumis_collection`
- [ ] Click "Create" button
- [ ] Database created successfully

**Alternative Method:**

- [ ] Use MySQL command line if above fails
- [ ] Command: `CREATE DATABASE soumis_collection;`

---

## Step 3: Import Database Schema

- [ ] In phpMyAdmin, click on `soumis_collection` database
- [ ] Click the "Import" tab at top
- [ ] Click "Choose File" button
- [ ] Browse to: `database.sql` in project folder
- [ ] Select the file
- [ ] Click "Import" button
- [ ] Wait for import to complete
- [ ] Success message appears
- [ ] Check that all tables are created (8 tables should exist)

**Verify Tables Created:**

- [ ] Click on `soumis_collection` database
- [ ] Check "Tables" section shows:
  - [ ] products
  - [ ] users
  - [ ] orders
  - [ ] cart
  - [ ] wishlist
  - [ ] wholesale_applications
  - [ ] reviews
  - [ ] stock_alerts

---

## Step 4: Create Admin User

- [ ] In phpMyAdmin, click "SQL" tab
- [ ] Copy this command:

```sql
INSERT INTO users (name, email, password, is_admin)
VALUES ('Admin', 'admin@soumis.local', 'password123', 1);
```

- [ ] Paste into SQL textarea
- [ ] Click "Go" button
- [ ] Verify "1 row inserted" message

**Verify Admin User Created:**

- [ ] Click on `users` table
- [ ] Check that one row exists with:
  - [ ] name = 'Admin'
  - [ ] email = 'admin@soumis.local'
  - [ ] is_admin = 1

---

## Step 5: Verify Database Configuration

- [ ] Open `db_config.php` in text editor
- [ ] Check line 3 values:
  - [ ] DB_HOST = 'localhost'
  - [ ] DB_USER = 'root'
  - [ ] DB_PASS = '' (empty - correct for XAMPP default)
  - [ ] DB_NAME = 'soumis_collection'
- [ ] If your MySQL has a password, update DB_PASS line
- [ ] Save the file

---

## Step 6: Start Apache

- [ ] Open XAMPP Control Panel
- [ ] Find the Apache row
- [ ] Click "Start" button
- [ ] Wait for it to show "Running" in green
- [ ] Verify port is 80

---

## Step 7: Test the Website

- [ ] Open web browser
- [ ] Visit: `http://localhost/Soumis_collection/`
- [ ] Homepage loads successfully
- [ ] No error messages appear

---

## Step 8: Test Admin Login

- [ ] Click on "Admin Panel" or navigate to:
      `http://localhost/Soumis_collection/admin/index.php`
- [ ] You should see a login or dashboard (if using session)
- [ ] If asked to login:
  - [ ] Email: `admin@soumis.local`
  - [ ] Password: `password123`
- [ ] Click Submit
- [ ] Dashboard loads successfully

---

## Step 9: Add Test Product

- [ ] In admin panel, click "Products" or similar
- [ ] Fill in the form:
  - [ ] Product Name: "Test Product"
  - [ ] Description: "Test Description"
  - [ ] Category: Select any category
  - [ ] Resail Price: 999.99
  - [ ] Wholesale Price: 799.99
  - [ ] Stock: 10
  - [ ] Add colors: Select at least one color
  - [ ] Optionally upload image
- [ ] Click "Save" or "Submit" button
- [ ] Success message should appear

---

## Step 10: Verify Product on Website

- [ ] Go back to homepage: `http://localhost/Soumis_collection/`
- [ ] Click on product section (All Products, New Arrivals, etc.)
- [ ] Look for your test product
- [ ] Verify:
  - [ ] Product name appears
  - [ ] Price is displayed
  - [ ] Product image appears (if uploaded)
  - [ ] Colors show correctly

---

## Step 11: Test User Registration

- [ ] Click on "Sign Up" or "Register"
- [ ] Fill in registration form:
  - [ ] First Name: TestFirst
  - [ ] Last Name: TestLast
  - [ ] Email: test@example.com
  - [ ] Password: test123456
  - [ ] Confirm Password: test123456
- [ ] Click "Register" or "Sign Up"
- [ ] Success message appears
- [ ] You are logged in (or redirected to login)

**Verify in Database:**

- [ ] In phpMyAdmin, view `users` table
- [ ] Check that new user row exists with:
  - [ ] email = 'test@example.com'
  - [ ] is_admin = 0

---

## Step 12: Test User Login

- [ ] Logout from admin account
- [ ] Click "Login"
- [ ] Enter:
  - [ ] Email: test@example.com
  - [ ] Password: test123456
- [ ] Click "Login"
- [ ] Success - you are logged in

---

## Step 13: Test Wholesale System

- [ ] Navigate to: `http://localhost/Soumis_collection/wholesale.php`
- [ ] Fill in bulk order form:
  - [ ] Company: Test Company
  - [ ] Contact: Test Contact
  - [ ] Email: wholesale@test.com
  - [ ] Phone: 9999999999
  - [ ] Product Interest: Select any
  - [ ] Quantity: 10
  - [ ] Purchase Amount: 500
  - [ ] Notes: Optional
- [ ] Click "Submit"
- [ ] Success message appears

**Verify in Database:**

- [ ] In phpMyAdmin, view `wholesale_applications` table
- [ ] Check that new application row exists with:
  - [ ] company_name = 'Test Company'
  - [ ] order_quantity = 10
  - [ ] purchase_amount = 500

---

## Step 14: Final Verification

- [ ] Database is running
- [ ] All 8 tables exist
- [ ] Admin user created
- [ ] Apache is running
- [ ] Website loads
- [ ] Products work
- [ ] Admin login works
- [ ] User registration works
- [ ] User login works
- [ ] Wholesale works
- [ ] Database saves data

---

## ✅ Setup Complete!

If all checkboxes above are checked, your SQL integration is complete and working!

---

## 🆘 If Something Fails

### MySQL Won't Start

- [ ] Check if port 3306 is already in use
- [ ] Try: XAMPP Control Panel → Config → Service and Port Settings
- [ ] Change MySQL port to different number

### Can't Create Database

- [ ] Try command line instead of phpMyAdmin
- [ ] Open Command Prompt
- [ ] Run: `mysql -u root`
- [ ] Then: `CREATE DATABASE soumis_collection;`

### Import Fails

- [ ] Check file is named `database.sql`
- [ ] Check file is in project root folder
- [ ] Try uploading smaller portions if timeout occurs

### Products Don't Show

- [ ] Check MySQL is running
- [ ] Verify `db_config.php` settings
- [ ] Check browser console for JavaScript errors
- [ ] Verify database.sql was fully imported

### Login Doesn't Work

- [ ] Verify admin user exists: `SELECT * FROM users;`
- [ ] Check email matches exactly: `admin@soumis.local`
- [ ] Try creating another user manually in database

### Connection Error

- [ ] Verify MySQL is running
- [ ] Check `db_config.php` credentials
- [ ] Verify database name is `soumis_collection`
- [ ] Check MySQL username/password

---

## 📞 Need Help?

1. Check `DATABASE_SETUP.md` → Troubleshooting section
2. Review `SQL_SETUP_CHECKLIST.md` → Quick help
3. Check `START_HERE_SQL.md` → FAQ section
4. Consult `COMPLETE_FILE_CHANGES.md` → Understanding changes

---

## 📝 Notes

Write any issues you encounter here:

```
_________________________________________________________________

_________________________________________________________________

_________________________________________________________________
```

---

## ✨ Summary

**Total Setup Time:** 10-15 minutes
**Files Created:** 10
**Tables Created:** 8
**Status:** Production Ready ✅

**Once complete:** Your Soumis Collections has full SQL database support!

---

_SQL Database Integration Setup Checklist_
_Soumis Collections E-Commerce Platform_
