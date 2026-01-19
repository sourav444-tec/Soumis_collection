# 💰 Auto Price Calculation System - Implementation Guide

## Overview

The system now features **automatic price calculation** between wholesale and retail prices, with the wholesale price set at **50% off the retail price**.

---

## How It Works

### Price Relationship

- **Wholesale Price = Retail Price × 0.5** (50% off retail)
- **Retail Price = Wholesale Price × 2** (2x wholesale)
- **Discount % = ((Retail - Wholesale) / Retail) × 100** = 50%

### Example

If you set:

- **Retail Price: ₹2000**
- **Wholesale Price: ₹1000** (automatically calculated as 50% of retail)
- **Customer saves: ₹1000 (50% discount)**

---

## Updated Files

### 1. **db_config.php** - New Helper Functions

Added four new price calculation functions:

```php
// Calculate wholesale price from retail (50% off)
calculateWholesalePrice($retail_price)

// Calculate retail price from wholesale (2x)
calculateRetailPrice($wholesale_price)

// Get discount percentage
getDiscountPercentage($retail_price, $wholesale_price)

// Format price in Indian Rupees
formatPrice($price)
```

**Usage in your code:**

```php
require_once 'db_config.php';

// Auto-calculate wholesale from retail
$wholesale = calculateWholesalePrice(2000);  // Returns 1000

// Get discount info
$discount = getDiscountPercentage(2000, 1000);  // Returns 50
```

---

### 2. **admin/products.php** - Product Management

#### New Features:

- **Auto-calculation on input:** When you enter a retail price, wholesale is automatically calculated
- **Reverse calculation:** When you enter wholesale, retail is auto-calculated
- **Live discount display:** Shows exact savings and percentage in real-time
- **Visual feedback:** Green box shows the calculated discount amount

#### How to Use:

1. Enter **Retail Price** (e.g., 2999)
2. Wholesale Price **automatically fills** at 50% (e.g., 1499.50)
3. Discount display shows: "50% off (saves ₹1499.50)"
4. You can also edit either field and the other recalculates

#### JavaScript Functions Added:

```javascript
calculateWholesaleFromRetail(); // Auto-calc when retail changes
calculateRetailFromWholesale(); // Auto-calc when wholesale changes
updateDiscountDisplay(); // Update discount display
```

---

### 3. **products.php** - Product Display

#### Enhanced Display:

- Shows both **Retail Price** and **Wholesale Price**
- Displays **discount percentage** badge (50%)
- Shows savings amount in green

#### Example Display:

```
₹2999 (Retail)
Wholesale: ₹1499.50 [-50%]
```

---

### 4. **wholesale.php** - Wholesale/Bulk Orders

#### New Sections Added:

**A. Product Pricing Table**

- Displays all products with pricing
- Shows retail price, wholesale price, savings, and discount %
- Updates dynamically as products are added

**Table Columns:**
| Product Name | Retail Price | Wholesale Price | You Save | Discount % |
|---|---|---|---|---|
| Gold Earrings | ₹2999 | ₹1499.50 | ₹1499.50 | 50% |

#### Auto-Calculation Info Box:

- Explains that wholesale prices are 50% off retail
- Shows tier-based discounts on bulk orders

---

### 5. **process-wholesale.php** - Order Processing

#### Enhanced Features:

- Calculates tiered discounts based on order quantity:
  - **Starter (10-49 units):** 10% additional discount
  - **Professional (50-199 units):** 20% additional discount
  - **Enterprise (200+ units):** 30% additional discount

#### How Pricing Works:

```
Example Order Calculation:
- Base Order Total: ₹10,000 (wholesale prices - already 50% off)
- Tier Discount (Enterprise 30%): ₹10,000 × 30% = ₹3,000 savings
- Final Price: ₹7,000
```

---

## Business Logic Flow

### For Regular Customers (Retail)

```
1. Browse products at products.php
2. See Retail Price: ₹2999
3. Add to cart and checkout at full price
```

### For Wholesale Buyers

```
1. Visit wholesale.php
2. See all products with auto-calculated wholesale prices (50% off)
3. See products.php - displays both prices
4. Submit wholesale order form
5. System applies additional tier-based discount based on quantity
6. Our team contacts with final pricing confirmation
```

---

## Key Features

✅ **Automatic Calculation**

- No manual entry needed for wholesale prices
- Changes in retail price auto-update wholesale

✅ **Real-time Display**

- Live discount percentage updates
- Shows exact savings amount
- Updates as you type

✅ **Flexible Input**

- Enter retail price → wholesale auto-fills
- Enter wholesale price → retail auto-fills
- Edit either field anytime

✅ **Product Listing**

- All products show correct wholesale prices
- Discount clearly displayed
- Updated dynamically

✅ **Tier-Based Pricing**

- 10% additional discount for Starter (10+ units)
- 20% additional discount for Professional (50+ units)
- 30% additional discount for Enterprise (200+ units)

---

## Admin Console Changes

When adding products in `/admin/products.php`:

1. **Retail Price Input** - Type the selling price

   - Example: 2999

2. **Wholesale Price** - Auto-fills at 50% off

   - Example: 1499.50 (automatically calculated)

3. **Discount Display** - Shows real-time calculation
   - Example: "50% off (saves ₹1499.50)"

---

## Database Integration

The `products` table already has:

- `retail_price` - Regular customer price
- `wholesale_price` - Bulk order price (50% of retail)

### SQL Query Example

```sql
-- Get all products with pricing
SELECT name, retail_price, wholesale_price,
       (retail_price - wholesale_price) as savings,
       ROUND(((retail_price - wholesale_price) / retail_price * 100), 2) as discount_pct
FROM products;
```

---

## Testing the System

### Test Case 1: Add a Product

1. Go to `/admin/products.php`
2. Enter Product Name: "Test Earrings"
3. Enter Retail Price: 1500
4. Notice Wholesale auto-fills: 750 (50% off)
5. Discount display shows: "50% off (saves ₹750)"
6. Save and verify in products.php

### Test Case 2: View Wholesale Pricing

1. Visit `/wholesale.php`
2. Scroll to "Product Pricing Table"
3. Verify all products show:
   - Retail Price
   - Wholesale Price (exactly 50% of retail)
   - Savings amount
   - 50% discount badge

### Test Case 3: Submit Wholesale Order

1. Fill wholesale form with:
   - Company: Test Company
   - Contact: John Doe
   - Email: test@example.com
   - Phone: 9999999999
   - Quantity: 100 units
   - Purchase Amount: 5000
2. Submit and verify success message
3. Check database for order entry

---

## Price Calculation Examples

### Example 1: Basic Product

```
Retail: ₹2000
Wholesale: ₹1000 (2000 × 0.5)
Discount: 50%
Savings: ₹1000
```

### Example 2: Bulk Order (Professional Tier)

```
Product Base (wholesale): ₹1000 each × 50 units = ₹50,000
Tier Discount (20%): ₹50,000 × 0.20 = ₹10,000 savings
Final Price: ₹40,000

Price per unit: ₹800 (from ₹1000)
```

### Example 3: Large Order (Enterprise Tier)

```
Product Base (wholesale): ₹1000 each × 250 units = ₹250,000
Tier Discount (30%): ₹250,000 × 0.30 = ₹75,000 savings
Final Price: ₹175,000

Price per unit: ₹700 (from ₹1000)
```

---

## Important Notes

⚠️ **Key Points:**

1. **Wholesale = 50% of Retail** (This is fixed)
2. **Additional tier discounts** apply on top of wholesale pricing
3. **Minimum order:** 6 products, ₹500 purchase value
4. **Auto-calculation** works in admin panel only (front-end for display)
5. **All prices** are in Indian Rupees (₹)

---

## Support & Maintenance

If you need to:

**Add new price calculation:**

- Update functions in `db_config.php`
- Update JavaScript in `admin/products.php`

**Change wholesale percentage:**

- Current: 50% off (multiply retail by 0.5)
- To change: Update `calculateWholesalePrice()` function and JavaScript

**Modify tier discounts:**

- Edit `process-wholesale.php` for tier percentages
- Update `wholesale.php` descriptions

---

## FAQ

**Q: Can I set different wholesale percentages per product?**
A: Current system uses 50% globally. To make it per-product, add a `wholesale_percentage` column to products table.

**Q: How do I track which orders got what discount?**
A: Check `wholesale_applications` table - shows purchase_amount but not individual item details yet.

**Q: What if someone enters wholesale price higher than retail?**
A: The discount display will show negative percentage. You should add validation in admin panel if needed.

**Q: Are these prices shown to all customers?**
A: No! Retail price shows to regular customers. Wholesale only shows to bulk buyers on /wholesale.php

---

**Created:** January 10, 2026
**System:** Soumis Collections E-Commerce Platform
