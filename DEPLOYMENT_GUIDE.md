# 🚀 Deployment Guide - Hosting & Domain Setup

## Overview

This guide shows you how to deploy your Soumis Collections website to a web hosting service with a custom domain.

---

## 📋 What You Need

### Requirements

- ✅ Web hosting with PHP 7.4+ and MySQL support
- ✅ Domain name (purchased separately)
- ✅ FTP/SFTP access or File Manager
- ✅ phpMyAdmin or MySQL access
- ✅ All your project files ready

### Recommended Hosting Providers

**Budget-Friendly:**

- **Hostinger** - ₹79/month, free domain, cPanel
- **Bluehost** - $2.95/month, free domain first year
- **SiteGround** - $3.99/month, excellent support
- **NameCheap** - $1.58/month, affordable

**India-Specific:**

- **HostGator India** - ₹99/month
- **BigRock** - ₹99/month
- **ResellerClub** - ₹149/month

**Premium:**

- **A2 Hosting** - Fast, optimized for PHP
- **InMotion** - Great for e-commerce
- **Cloudways** - Cloud hosting, scalable

All these include:

- ✅ PHP & MySQL
- ✅ cPanel
- ✅ SSL certificate (free)
- ✅ Email accounts

---

## 🌐 Step 1: Get a Domain Name

### Option A: Buy Domain Separately

1. Go to domain registrar:

   - **GoDaddy** - Popular, easy to use
   - **NameCheap** - Affordable, good support
   - **Google Domains** - Simple, reliable
   - **BigRock** (India) - Local support

2. Search for your domain:

   ```
   Example: soumiscollections.com
   ```

3. Check availability and purchase
4. Cost: ₹500-₹1500/year (.com domain)

### Option B: Get Free Domain with Hosting

- Most hosting providers offer free domain for first year
- Usually includes .com, .net, .org
- Auto-renews with hosting

---

## 🖥️ Step 2: Choose & Purchase Hosting

### For Beginners (Recommended)

**Hostinger Shared Hosting:**

1. Visit hostinger.com
2. Choose "Premium Shared Hosting"
3. Select plan (₹79-₹299/month)
4. Add domain (or use free one)
5. Complete payment
6. Check email for login credentials

### What You'll Receive:

- cPanel login URL
- FTP credentials
- Database credentials
- Name servers (if domain separate)

---

## 📁 Step 3: Upload Your Files

### Method A: Using cPanel File Manager (Easiest)

1. **Login to cPanel**

   - URL: `https://yourdomain.com/cpanel`
   - Or: `https://yourhosting.com:2083`
   - Use credentials from hosting email

2. **Navigate to File Manager**

   - Click "File Manager" icon
   - Go to `public_html` folder (this is your website root)

3. **Delete Default Files**

   - Delete any default index.html or other files in public_html

4. **Upload Your Files**
   - Click "Upload" button
   - Drag and drop all your project files
   - OR zip your project locally, upload the .zip, then extract

**Files to Upload:**

```
public_html/
├── admin/
├── images/
├── includes/
├── database.sql
├── db_config.php
├── index.php
├── products.php
├── login.php
├── signup.php
├── wholesale.php
├── style.css
├── dark-mode.css
├── login.css
├── logic.js
└── [all other PHP files]
```

**DON'T Upload Documentation:**

- Skip: \*.md files (README, DATABASE_SETUP, etc.)
- Skip: SETUP\_\*.txt files
- These are for development only

### Method B: Using FTP (FileZilla)

1. **Download FileZilla**

   - Visit: filezilla-project.org
   - Download and install FileZilla Client

2. **Get FTP Credentials**

   - Check your hosting welcome email
   - Or find in cPanel → "FTP Accounts"

3. **Connect to Server**

   - Host: `ftp.yourdomain.com` or IP address
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21

4. **Upload Files**
   - Left side = Your computer
   - Right side = Server
   - Navigate to `public_html` on right
   - Drag files from left to right
   - Wait for upload to complete

---

## 🗄️ Step 4: Create Database on Hosting

### Using cPanel MySQL

1. **Login to cPanel**

2. **Create Database**

   - Click "MySQL Databases" icon
   - Under "Create New Database":
     - Database Name: `soumis_collection` (or any name)
     - Click "Create Database"
   - Note the full database name (usually: `username_soumis_collection`)

3. **Create Database User**

   - Under "MySQL Users" → "Add New User":
     - Username: `soumis_user` (or any name)
     - Password: Generate strong password
     - Click "Create User"
   - **SAVE THESE CREDENTIALS!**

4. **Add User to Database**

   - Under "Add User To Database":
     - User: Select user you created
     - Database: Select database you created
     - Click "Add"
   - On privileges page, select "ALL PRIVILEGES"
   - Click "Make Changes"

5. **Import Database Schema**

   - Click "phpMyAdmin" icon in cPanel
   - Select your database from left sidebar
   - Click "Import" tab
   - Click "Choose File"
   - Select `database.sql` from your computer
   - Click "Import"
   - Wait for success message

6. **Create Admin User**
   - In phpMyAdmin, click "SQL" tab
   - Run this command:
   ```sql
   INSERT INTO users (name, email, password, is_admin)
   VALUES ('Admin', 'admin@yourdomain.com', 'YourSecurePassword123', 1);
   ```
   - Click "Go"

---

## ⚙️ Step 5: Update Configuration Files

### Update db_config.php

1. **In cPanel File Manager**

   - Navigate to `public_html`
   - Right-click `db_config.php`
   - Click "Edit"

2. **Update These Lines:**

```php
// OLD (localhost):
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'soumis_collection');

// NEW (hosting):
define('DB_HOST', 'localhost');  // Usually stays localhost
define('DB_USER', 'username_soumis_user');  // Your database user
define('DB_PASS', 'your_db_password');  // Your database password
define('DB_NAME', 'username_soumis_collection');  // Your database name
```

3. **Save Changes**

**Important:** The database name is usually prefixed with your cPanel username:

- If cPanel username is `john123`
- Database becomes: `john123_soumis_collection`
- User becomes: `john123_soumis_user`

---

## 🔗 Step 6: Point Domain to Hosting

### If Domain and Hosting are Same Provider

- Usually auto-configured
- Domain works immediately or within 24 hours

### If Domain is Separate

1. **Get Name Servers from Hosting**

   - Login to hosting cPanel
   - Find "Server Information" or check welcome email
   - Copy name servers (usually 2):
     ```
     ns1.yourhosting.com
     ns2.yourhosting.com
     ```

2. **Update Domain Name Servers**

   - Login to domain registrar (GoDaddy, NameCheap, etc.)
   - Find "Manage DNS" or "Name Servers"
   - Change to "Custom Name Servers"
   - Enter the name servers from hosting
   - Save changes

3. **Wait for Propagation**
   - Takes 2-48 hours (usually 2-6 hours)
   - Check status: whatsmydns.net

---

## 🔒 Step 7: Setup SSL Certificate (HTTPS)

### Using cPanel (Free - Let's Encrypt)

1. **Login to cPanel**
2. **Find "SSL/TLS Status" or "Let's Encrypt SSL"**
3. **Select Your Domain**
4. **Click "Install" or "Issue"**
5. **Wait 1-2 minutes for installation**
6. **Test:** Visit `https://yourdomain.com`

### Force HTTPS (Recommended)

Create/edit `.htaccess` file in `public_html`:

```apache
# Force HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Force WWW (optional)
RewriteCond %{HTTP_HOST} !^www\. [NC]
RewriteRule ^(.*)$ https://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

---

## ✅ Step 8: Test Your Website

### Test Checklist

- [ ] **Homepage loads:** `https://yourdomain.com`
- [ ] **Products page:** `https://yourdomain.com/products.php`
- [ ] **Admin login:** `https://yourdomain.com/admin/`
- [ ] **User registration:** Works correctly
- [ ] **User login:** Works correctly
- [ ] **Add product (admin):** Saves to database
- [ ] **View products:** Shows on website
- [ ] **Wholesale form:** Submissions work
- [ ] **Images upload:** Works correctly
- [ ] **SSL certificate:** Shows padlock icon
- [ ] **Mobile responsive:** Test on phone

### Test URLs

```
https://yourdomain.com/
https://yourdomain.com/products.php
https://yourdomain.com/new-arrivals.php
https://yourdomain.com/best-sellers.php
https://yourdomain.com/login.php
https://yourdomain.com/signup.php
https://yourdomain.com/wholesale.php
https://yourdomain.com/admin/
```

---

## 🔧 Common Issues & Fixes

### Issue: "Database Connection Error"

**Fix:**

- Check `db_config.php` has correct credentials
- Verify database user has ALL PRIVILEGES
- Check database name includes username prefix

### Issue: "500 Internal Server Error"

**Fix:**

- Check file permissions (755 for folders, 644 for files)
- Check `.htaccess` file for errors
- Check PHP version (needs 7.4+)
- Check error logs in cPanel

### Issue: "Images Not Loading"

**Fix:**

- Upload images folder with correct structure
- Check file permissions on images folder (755)
- Verify image paths in database

### Issue: "Admin Can't Login"

**Fix:**

- Verify admin user exists in database
- Check email matches exactly
- Reset password in phpMyAdmin

### Issue: "Page Not Found (404)"

**Fix:**

- Check file names are correct (case-sensitive on Linux)
- Verify files are in `public_html`
- Check .htaccess for rewrite rules

---

## 📧 Step 9: Setup Email (Optional)

### Create Email Accounts

1. **In cPanel, click "Email Accounts"**
2. **Create accounts:**
   ```
   admin@yourdomain.com
   info@yourdomain.com
   orders@yourdomain.com
   wholesale@yourdomain.com
   ```
3. **Use webmail or setup in email client**

### Update Email References

- Update contact forms
- Update wholesale emails
- Update admin notification emails

---

## 🎯 Production Checklist

### Security

- [ ] Change admin password from default
- [ ] Use strong database password
- [ ] Enable SSL certificate
- [ ] Set proper file permissions
- [ ] Remove setup/test files
- [ ] Update admin email

### Configuration

- [ ] Update `db_config.php` with hosting credentials
- [ ] Test database connection
- [ ] Verify all pages work
- [ ] Test forms (contact, wholesale, etc.)
- [ ] Test user registration/login
- [ ] Test admin panel

### Content

- [ ] Add real products (remove test data)
- [ ] Upload product images
- [ ] Set correct prices
- [ ] Update contact information
- [ ] Add company details
- [ ] Update social media links

### Performance

- [ ] Enable gzip compression
- [ ] Optimize images
- [ ] Enable caching
- [ ] Test page load speed

---

## 💰 Estimated Costs

| Item                 | Cost (Annual)         |
| -------------------- | --------------------- |
| **Domain (.com)**    | ₹500 - ₹1,500         |
| **Hosting (Shared)** | ₹1,000 - ₹3,600       |
| **SSL Certificate**  | Free (Let's Encrypt)  |
| **Email Accounts**   | Included with hosting |
| **Total First Year** | **₹1,500 - ₹5,100**   |

---

## 📊 Deployment Methods Comparison

| Method                  | Difficulty | Time   | Best For        |
| ----------------------- | ---------- | ------ | --------------- |
| **cPanel File Manager** | Easy       | 30 min | Beginners       |
| **FTP (FileZilla)**     | Medium     | 20 min | Regular updates |
| **Git Deploy**          | Advanced   | 15 min | Developers      |

---

## 🚀 Quick Deployment Summary

1. **Buy hosting + domain** (₹1,500-5,000/year)
2. **Upload files** via cPanel or FTP (15 minutes)
3. **Create database** in cPanel MySQL (5 minutes)
4. **Import database.sql** via phpMyAdmin (2 minutes)
5. **Update db_config.php** with hosting credentials (2 minutes)
6. **Point domain** to hosting (if separate) (5 minutes, 2-48 hrs wait)
7. **Install SSL** certificate (2 minutes)
8. **Test website** (10 minutes)

**Total Active Time:** ~45 minutes
**Total Wait Time:** 2-48 hours for domain propagation

---

## 📞 Support Resources

### Hosting Support

- Most hosts have 24/7 live chat
- Check knowledge base/tutorials
- Submit support ticket if needed

### Common cPanel Locations

- **File Manager:** Files → File Manager
- **MySQL:** Databases → MySQL Databases
- **phpMyAdmin:** Databases → phpMyAdmin
- **SSL:** Security → SSL/TLS Status
- **Email:** Email → Email Accounts

---

## 🎓 Next Steps After Deployment

1. **Add Products:** Use admin panel
2. **Test Everything:** All features thoroughly
3. **SEO Setup:** Add meta tags, descriptions
4. **Google Analytics:** Track visitors
5. **Backup:** Regular database backups
6. **Marketing:** Promote your website
7. **Monitor:** Check error logs regularly

---

## ✅ Final Checklist

- [ ] Domain purchased and configured
- [ ] Hosting active and setup
- [ ] All files uploaded to public_html
- [ ] Database created and imported
- [ ] db_config.php updated
- [ ] Admin user created
- [ ] SSL certificate installed
- [ ] HTTPS working
- [ ] All pages tested
- [ ] Forms working
- [ ] Products displaying
- [ ] Admin panel accessible
- [ ] Wholesale system working
- [ ] Email configured
- [ ] Backups scheduled

---

**Your website is now LIVE! 🎉**

Visit: `https://yourdomain.com`

---

_Deployment Guide for Soumis Collections_
_Production-Ready E-Commerce Platform_
