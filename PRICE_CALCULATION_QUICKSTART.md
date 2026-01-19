# ⚡ Quick Reference - Price Calculation System

## What Changed?

The wholesale and retail pricing system now includes **automatic calculations** where:

- **Wholesale Price = 50% off Retail Price**
- **Auto-calculates** as you enter prices
- **Shows discount** in real-time

---

## For Admins - Adding Products

### Step-by-Step (Admin Panel)

1. **Go to:** `/admin/products.php`
2. **Fill in:**
   - Product Name: "Gold Earrings"
   - Description: Product details
   - Category: Select from dropdown
   - Sections: Check where to display
   - Colors: Add available colors
3. **Enter Pricing:**

   - **Retail Price:** 2999 ➜ (type and move to next field)
   - **Wholesale Price:** Auto-fills as 1499.50
   - **Discount Display:** Shows "50% off (saves ₹1499.50)"

4. **OR** Enter wholesale first:

   - **Wholesale Price:** 1499.50 ➜ (type and move to next field)
   - **Retail Price:** Auto-fills as 2999
   - **Discount Display:** Shows "50% off (saves ₹1499.50)"

5. **Click:** "Save Product"

---

## For Customers - Viewing Products

### Regular Customers

Visit `/products.php` → See **Retail Price** only (e.g., ₹2999)

### Wholesale Buyers

Visit `/wholesale.php` → See:

- All products listed
- Retail price
- Wholesale price (50% off)
- Discount percentage (50%)
- Amount saved

**Example Table Row:**

```
Gold Earrings | ₹2999 | ₹1499.50 | ₹1499.50 | 50%
```

---

## Pricing Formula

```
Wholesale Price = Retail Price × 0.5

Example:
Retail: ₹2000
Wholesale: ₹2000 × 0.5 = ₹1000 ✓
```

---

## Bulk Order Discounts (On Top of Wholesale)

When customers order in bulk:

| Quantity     | Tier         | Discount | Example                      |
| ------------ | ------------ | -------- | ---------------------------- |
| 10-49 units  | Starter      | 10%      | ₹1000 × 10% = ₹100 extra off |
| 50-199 units | Professional | 20%      | ₹1000 × 20% = ₹200 extra off |
| 200+ units   | Enterprise   | 30%      | ₹1000 × 30% = ₹300 extra off |

---

## Database Check

### Verify Pricing in Database

```sql
-- Check all products
SELECT name, retail_price, wholesale_price FROM products;

-- Check if calculation is correct (should be 50% or 0.5)
SELECT name,
       retail_price,
       wholesale_price,
       ROUND(wholesale_price / retail_price * 100, 2) as percentage
FROM products;
```

Expected output: `percentage` should be **50** for all products

---

## Files Modified

1. **db_config.php**

   - Added `calculateWholesalePrice()` function
   - Added `calculateRetailPrice()` function
   - Added `getDiscountPercentage()` function
   - Added `formatPrice()` function

2. **admin/products.php**

   - Added auto-calculation JavaScript
   - Real-time discount display
   - Live preview box

3. **products.php**

   - Shows both retail and wholesale prices
   - Displays discount percentage badge

4. **wholesale.php**

   - New product pricing table
   - Shows all products with calculations
   - Explains the 50% discount

5. **process-wholesale.php**
   - Enhanced with tier-based pricing logic
   - Calculates additional discounts

---

## Common Tasks

### Add a Product with Auto-Pricing

1. Go to Admin → Products
2. Fill name, description, category, colors
3. Enter **Retail Price only**
4. Wholesale auto-calculates
5. Save

### Check Wholesale Prices

1. Go to `/wholesale.php`
2. Scroll to "Current Product Pricing" table
3. See all products with 50% discount

### Calculate Custom Price

Use the formula:

```
Wholesale = Retail × 0.5
Retail = Wholesale × 2
```

### Troubleshoot Wrong Price

Check if:

- Retail price was entered correctly
- Wholesale = Retail × 0.5
- No manual edits changed the relationship

---

## Testing Checklist

- [ ] Added product with retail price 1000
- [ ] Verified wholesale auto-filled as 500
- [ ] Checked discount shows 50%
- [ ] Visited wholesale.php
- [ ] Verified all products show in pricing table
- [ ] Submitted test wholesale order
- [ ] Confirmed order saved in database

---

## Support

**Problem:** Wholesale price not auto-calculating
**Solution:**

- Refresh the page
- Check browser console (F12) for errors
- Verify both input fields exist

**Problem:** Discount shows wrong percentage
**Solution:**

- Clear both price fields
- Re-enter values
- Discount should update automatically

**Problem:** Products not showing on wholesale page
**Solution:**

- Verify products are added in admin panel
- Check database for product entries
- Reload wholesale.php

---

**Last Updated:** January 10, 2026
