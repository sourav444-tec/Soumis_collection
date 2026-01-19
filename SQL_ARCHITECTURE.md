# SQL Database Architecture - Soumis Collections

## System Architecture Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                    SOUMIS COLLECTIONS                       │
│                   E-Commerce Platform                       │
└─────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                    WEB PAGES (PHP)                          │
├─────────────────────────────────────────────────────────────┤
│ Public Pages          │ Admin Panel        │ Backend         │
│ ─────────────────     │ ─────────────────  │ ──────────────  │
│ • index.php           │ • products.php     │ • db_config.php │
│ • products.php        │ • index.php        │ • process-*.php │
│ • new-arrivals.php    │ • wholesale.php    │                 │
│ • best-sellers.php    │                    │                 │
│ • login.php           │                    │                 │
│ • signup.php          │                    │                 │
└─────────────────────────────────────────────────────────────┘
                              │
                              │ SQL Queries
                              ▼
┌─────────────────────────────────────────────────────────────┐
│                   DATABASE (MySQL)                          │
├─────────────────────────────────────────────────────────────┤
│ soumis_collection                                           │
│                                                             │
│ ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│ │  PRODUCTS    │  │    USERS     │  │   ORDERS     │      │
│ ├──────────────┤  ├──────────────┤  ├──────────────┤      │
│ │ id           │  │ id           │  │ id           │      │
│ │ name         │  │ email        │  │ user_id  (FK)│      │
│ │ category     │  │ password     │  │ total        │      │
│ │ retail_price │  │ is_admin     │  │ status       │      │
│ │ stock        │  │ phone        │  │ items (JSON) │      │
│ │ colors (JSON)│  │ address      │  │ created_at   │      │
│ │ image        │  │ created_at   │  └──────────────┘      │
│ │ created_at   │  └──────────────┘                         │
│ └──────────────┘                                           │
│                                                             │
│ ┌──────────────────┐  ┌────────────┐  ┌──────────────┐    │
│ │ WHOLESALE_APPS   │  │   CART     │  │  WISHLIST    │    │
│ ├──────────────────┤  ├────────────┤  ├──────────────┤    │
│ │ id               │  │ id         │  │ id           │    │
│ │ company_name     │  │ user_id    │  │ user_id      │    │
│ │ quantity         │  │ product_id │  │ product_id   │    │
│ │ purchase_amount  │  │ color      │  │ added_at     │    │
│ │ status           │  │ added_at   │  └──────────────┘    │
│ │ created_at       │  └────────────┘                       │
│ └──────────────────┘                                       │
│                                                             │
│ ┌──────────────┐  ┌──────────────┐                        │
│ │   REVIEWS    │  │ STOCK_ALERTS │                        │
│ ├──────────────┤  ├──────────────┤                        │
│ │ id           │  │ id           │                        │
│ │ product_id   │  │ product_id   │                        │
│ │ user_id      │  │ alert_type   │                        │
│ │ rating       │  │ created_at   │                        │
│ │ review_text  │  └──────────────┘                        │
│ │ created_at   │                                          │
│ └──────────────┘                                           │
└─────────────────────────────────────────────────────────────┘
```

---

## Data Flow Diagram

### Adding a Product (Admin)

```
┌──────────────┐
│  Admin Fill  │
│ Form + Image │
└──────┬───────┘
       │
       ▼
┌──────────────────────┐
│ admin/products.php   │
│ Validate Form Data   │
│ Upload Image File    │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│  db_config.php       │
│ Prepare SQL Query    │
│ Bind Parameters      │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│   MySQL Database     │
│  INSERT into         │
│   products table     │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│   Redirect to        │
│ products.php         │
│ Show Success Message │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│  User Sees New       │
│  Product on Website  │
└──────────────────────┘
```

### Viewing Products (Public)

```
┌──────────────┐
│ User Visits  │
│ Website     │
└──────┬───────┘
       │
       ▼
┌──────────────────────┐
│  products.php        │
│  new-arrivals.php    │
│  etc.                │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│  db_config.php       │
│ Execute SELECT Query │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│   MySQL Database     │
│   SELECT * FROM      │
│   products WHERE...  │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│  Return Product Data │
│  As Array            │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│  Display Products    │
│  in HTML (foreach)   │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│  Browser Shows       │
│  Products to User    │
└──────────────────────┘
```

---

## User Registration Flow

```
┌──────────────┐
│  User Visits │
│  signup.php  │
└──────┬───────┘
       │
       ▼
┌──────────────────────┐
│  Fill Signup Form    │
│  name, email, pwd    │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│ process-signup.php   │
│ Validate Input       │
│ Hash Password        │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│  Check Email Exists  │
│  SELECT from users   │
└──────┬───────────────┘
       │
       ├─ Yes → Redirect (exists)
       │
       └─ No ↓
┌──────────────────────┐
│   db_config.php      │
│  INSERT into users   │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│   MySQL Database     │
│  Save New User       │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│  Set Session         │
│  user_id, email      │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│  Redirect to Home    │
│  User is Logged In   │
└──────────────────────┘
```

---

## Login Flow

```
┌──────────────┐
│  User Visits │
│  login.php   │
└──────┬───────┘
       │
       ▼
┌──────────────────────┐
│  Enter Email & Pwd   │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│ process-login.php    │
│ Get Email & Password │
└──────┬───────────────┘
       │
       ▼
┌──────────────────────┐
│  Query User Table    │
│  SELECT WHERE email  │
└──────┬───────────────┘
       │
       ├─ Not Found → Error
       │
       └─ Found ↓
┌──────────────────────┐
│ Verify Password      │
│ password_verify()    │
└──────┬───────────────┘
       │
       ├─ Wrong → Error
       │
       └─ Correct ↓
┌──────────────────────┐
│  Set Session         │
│  user_id, email      │
│  is_admin flag       │
└──────┬───────────────┘
       │
       ├─ Admin → /admin/index.php
       │
       └─ User → /index.php
```

---

## Table Relationships

```
USERS
  │
  ├─ ORDERS (1:many) ─────┐
  │                        │
  ├─ WISHLIST (1:many) ────┤
  │                        │
  ├─ CART (1:many) ────────┼─ PRODUCTS (1:many)
  │                        │    │
  └─ REVIEWS (1:many) ─────┤    │
                           │    │
                      STOCK_ALERTS
```

---

## Database Query Examples

### Get All Products

```sql
SELECT * FROM products
ORDER BY created_at DESC
```

### Filter by Category

```sql
SELECT * FROM products
WHERE category = 'earrings'
ORDER BY created_at DESC
```

### Get New Arrivals (Last 10 products)

```sql
SELECT * FROM products
WHERE JSON_CONTAINS(sections, '"new-arrivals"')
ORDER BY created_at DESC
LIMIT 10
```

### Count Products

```sql
SELECT COUNT(*) as total FROM products
```

### Get User Orders

```sql
SELECT * FROM orders
WHERE user_id = ?
ORDER BY created_at DESC
```

### Get Pending Wholesale Apps

```sql
SELECT * FROM wholesale_applications
WHERE status = 'pending'
ORDER BY created_at DESC
```

---

## File Structure with Database

```
Soumis_collection/
│
├── db_config.php ..................... Database connection & helpers
├── database.sql ....................... SQL schema file
│
├── admin/
│   ├── products.php .................. Saves products to DB
│   ├── index.php ..................... Shows DB statistics
│   └── ...
│
├── Process Files (Backend)
│   ├── process-login.php ............. Query users table
│   ├── process-signup.php ............ Insert into users table
│   ├── process-wholesale.php ......... Save to wholesale_applications
│   └── ...
│
├── Public Pages (Frontend)
│   ├── products.php .................. Query products table
│   ├── new-arrivals.php .............. Query products with filter
│   ├── best-sellers.php .............. Query products with filter
│   ├── unique-collections.php ........ Query products with filter
│   ├── earring-collection.php ........ Query products with filter
│   └── ...
│
├── Documentation
│   ├── DATABASE_SETUP.md ............. Complete setup guide
│   ├── SQL_COMMANDS.sql .............. Useful SQL queries
│   ├── SQL_SETUP_CHECKLIST.md ........ Quick start checklist
│   ├── SQL_INTEGRATION_SUMMARY.md .... Overview document
│   └── SQL_ARCHITECTURE.md ........... This file
│
└── includes/, images/, etc.
```

---

## Performance Notes

✅ **Indexing**

- category column indexed
- retail_price indexed for filtering
- user_id indexed for quick lookups

✅ **Query Optimization**

- Uses prepared statements (prevents SQL injection)
- Selects only needed columns
- Limits results where appropriate

✅ **JSON Storage**

- Colors stored as JSON array
- Sections stored as JSON array
- Orders items stored as JSON
- Flexible and queryable

---

## Security Features

🔒 **Password Security**

- Uses `password_hash()` with bcrypt
- Uses `password_verify()` for login
- Passwords never stored in plain text

🔒 **SQL Injection Prevention**

- All queries use prepared statements
- Parameters bound safely
- User input escaped

🔒 **Access Control**

- Admin flag in users table
- Session-based authentication
- Admin routes protected

---

_Architecture Diagram - Soumis Collections SQL Database System_
