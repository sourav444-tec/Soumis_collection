# 📊 Price Calculation System - Visual Guide

## System Overview Diagram

```
┌─────────────────────────────────────────────────────────────┐
│         SOUMIS COLLECTIONS PRICING SYSTEM                   │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  RETAIL CUSTOMERS (products.php)                             │
│  ┌─────────────────────────────────────┐                    │
│  │ Gold Earrings                       │                    │
│  │ Retail Price: ₹2999                 │                    │
│  │                                     │                    │
│  │ Add to Cart ➔ Pay ₹2999            │                    │
│  └─────────────────────────────────────┘                    │
│                        │                                     │
│  WHOLESALE BUYERS (wholesale.php)                            │
│  ┌─────────────────────────────────────────┐               │
│  │ Gold Earrings                           │               │
│  │ Retail Price: ₹2999                     │               │
│  │ Wholesale Price: ₹1499.50 (50% off)     │               │
│  │ You Save: ₹1499.50 [-50%]              │               │
│  │                                         │               │
│  │ Order Form ➔ Automatic Tier Discount    │               │
│  │  - 10+ units: +10% off                 │               │
│  │  - 50+ units: +20% off                 │               │
│  │  - 200+ units: +30% off                │               │
│  └─────────────────────────────────────────┘               │
│                                                               │
└─────────────────────────────────────────────────────────────┘
```

---

## Price Calculation Flow

### Step 1: Admin Adds Product

```
ADMIN PANEL (admin/products.php)
┌────────────────────────────────────┐
│ Product: Gold Earrings             │
│                                    │
│ Retail Price:     [2999]           │
│                        ↓           │
│ Wholesale Price:  [1499.50] ◄──┐  │
│ (Auto-calculated at 50%)          │
│                                    │
│ Discount: 50% off (saves ₹1499.50)│
│                                    │
│ [Save Product]                     │
└────────────────────────────────────┘
```

### Step 2: Customer Views Product

```
RETAIL CUSTOMER (products.php)
┌──────────────────────────┐
│ Gold Earrings            │
│                          │
│ Retail: ₹2999            │
│                          │
│ [Add to Cart]            │
└──────────────────────────┘

WHOLESALE BUYER (wholesale.php)
┌──────────────────────────────────┐
│ Gold Earrings                    │
│                                  │
│ Retail: ₹2999                    │
│ Wholesale: ₹1499.50 [-50%]       │
│ Savings: ₹1499.50                │
│                                  │
│ [Submit Wholesale Order]         │
└──────────────────────────────────┘
```

### Step 3: Order Processing

```
WHOLESALE ORDER (process-wholesale.php)
┌────────────────────────────────────┐
│ Order: 75 units                    │
│ Base Price: ₹1499.50 × 75          │
│         = ₹112,462.50              │
│                                    │
│ Tier: Professional (50-199 units)  │
│ Tier Discount: 20% off             │
│ Savings: ₹22,492.50                │
│                                    │
│ FINAL PRICE: ₹89,970              │
│ Per Unit: ₹1,199.60                │
└────────────────────────────────────┘
```

---

## Pricing Examples

### Simple Product Example

```
╔═══════════════════════════════════════╗
║ PRODUCT PRICING EXAMPLE               ║
╠═══════════════════════════════════════╣
║                                       ║
║  Retail Price:        ₹1000          ║
║  Wholesale Price:     ₹500 (50%)     ║
║  Customer Saves:      ₹500            ║
║                                       ║
║  Formula: Wholesale = Retail × 0.5   ║
║                                       ║
╚═══════════════════════════════════════╝
```

### Bulk Order Pricing Breakdown

```
╔════════════════════════════════════════════════╗
║ BULK ORDER PRICING EXAMPLE                     ║
╠════════════════════════════════════════════════╣
║                                                ║
║ Quantity Ordered: 100 units                   ║
║ Base Price per Unit: ₹500 (50% off retail)   ║
║ Base Total: ₹500 × 100 = ₹50,000             ║
║                                                ║
║ Tier Applied: Professional (50-199 units)    ║
║ Tier Discount: 20% additional                ║
║ Tier Savings: ₹50,000 × 20% = ₹10,000        ║
║                                                ║
║ ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━       ║
║ FINAL PRICE: ₹40,000                         ║
║ Final Price per Unit: ₹400                   ║
║                                                ║
║ TOTAL SAVINGS: ₹60,000 from retail prices    ║
║ (₹50,000 base + ₹10,000 tier discount)       ║
║                                                ║
╚════════════════════════════════════════════════╝
```

---

## Tier Discount Structure

```
┌─────────────────────────────────────────────────┐
│ WHOLESALE PRICING TIERS                          │
├─────────────────────────────────────────────────┤
│                                                  │
│  🎯 STARTER TIER                               │
│  ├─ Minimum: 10 units                          │
│  ├─ Base Discount: 50% (wholesale price)       │
│  └─ Tier Bonus: +10% additional                │
│     Total Savings: 55% from retail              │
│                                                  │
│  ⭐ PROFESSIONAL TIER (POPULAR)                │
│  ├─ Minimum: 50 units                          │
│  ├─ Base Discount: 50% (wholesale price)       │
│  └─ Tier Bonus: +20% additional                │
│     Total Savings: 60% from retail              │
│                                                  │
│  🏆 ENTERPRISE TIER                            │
│  ├─ Minimum: 200 units                         │
│  ├─ Base Discount: 50% (wholesale price)       │
│  └─ Tier Bonus: +30% additional                │
│     Total Savings: 65% from retail              │
│                                                  │
└─────────────────────────────────────────────────┘
```

### Tier Example Comparison

```
SAME PRODUCT: Retail Price ₹2000 (Wholesale ₹1000)

Order 25 Units:
├─ Base Cost: ₹1000 × 25 = ₹25,000
├─ Minimum Only (6+ units): ₹25,000
└─ Savings from Retail: ₹25,000

Order 75 Units (Professional):
├─ Base Cost: ₹1000 × 75 = ₹75,000
├─ Tier Discount (20%): ₹75,000 × 20% = ₹15,000
├─ Final Price: ₹60,000
└─ Savings from Retail: ₹90,000

Order 300 Units (Enterprise):
├─ Base Cost: ₹1000 × 300 = ₹300,000
├─ Tier Discount (30%): ₹300,000 × 30% = ₹90,000
├─ Final Price: ₹210,000
└─ Savings from Retail: ₹390,000
```

---

## Admin Panel Flow

```
┌──────────────────────────────────────────┐
│ ADMIN ADDS PRODUCT                       │
├──────────────────────────────────────────┤
│                                          │
│  Product Details                         │
│  ├─ Name: "Gold Earrings"               │
│  ├─ Category: "Earrings"                │
│  ├─ Description: "Beautiful design"      │
│  └─ Colors: [Gold, Silver]              │
│                                          │
│  💰 PRICING (Auto-Calculated)            │
│  ├─ Retail Price: [2999]               │
│  │  (type ₹2999, press Tab)            │
│  │         ↓↓↓                          │
│  ├─ Wholesale Price: [1499.50] ✓       │
│  │  (auto-fills: 2999 × 0.5)           │
│  │                                      │
│  └─ Discount Display:                   │
│     "50% off (saves ₹1499.50)" ✓       │
│                                          │
│  [Save Product] ➔ Saved to Database     │
│                                          │
└──────────────────────────────────────────┘
```

---

## Database Schema

```
PRODUCTS TABLE
┌───────────────────────────────────┐
│ id                                │
│ name              = "Gold Earrings"
│ description       = "..."         │
│ category          = "earrings"    │
│ retail_price      = 2999          │
│ wholesale_price   = 1499.50       │  ◄── Auto-calculated
│ stock             = 50            │
│ colors            = JSON array    │
│ image             = path/file     │
│ created_at        = timestamp     │
└───────────────────────────────────┘

CALCULATION IN DATABASE:
wholesale_price = retail_price × 0.5
```

---

## File Structure

```
Soumis_collection/
├── db_config.php                 ◄─── Functions Added
│   ├─ calculateWholesalePrice()
│   ├─ calculateRetailPrice()
│   ├─ getDiscountPercentage()
│   └─ formatPrice()
│
├── admin/products.php            ◄─── JavaScript Added
│   ├─ calculateWholesaleFromRetail()
│   ├─ calculateRetailFromWholesale()
│   └─ updateDiscountDisplay()
│
├── products.php                  ◄─── Display Updated
│   └─ Shows both prices with discount
│
├── wholesale.php                 ◄─── Table Added
│   └─ Product pricing table
│
├── process-wholesale.php         ◄─── Logic Enhanced
│   └─ Tier-based discounts
│
└── Documentation/
    ├── PRICE_CALCULATION_GUIDE.md
    ├── PRICE_CALCULATION_QUICKSTART.md
    └── PRICE_CALCULATION_IMPLEMENTATION.md
```

---

## Key Calculations

```
╔══════════════════════════════════════════╗
║ PRICE CALCULATION FORMULAS               ║
╠══════════════════════════════════════════╣
║                                          ║
║  Wholesale = Retail × 0.5               ║
║  Example: ₹2000 × 0.5 = ₹1000            ║
║                                          ║
║  Retail = Wholesale × 2                 ║
║  Example: ₹1000 × 2 = ₹2000              ║
║                                          ║
║  Savings = Retail - Wholesale           ║
║  Example: ₹2000 - ₹1000 = ₹1000          ║
║                                          ║
║  Discount % = (Savings / Retail) × 100  ║
║  Example: (₹1000 / ₹2000) × 100 = 50%   ║
║                                          ║
║  Tier Final = Base × (1 - Tier%)        ║
║  Example: ₹1000 × (1 - 0.20) = ₹800     ║
║                                          ║
╚══════════════════════════════════════════╝
```

---

## User Journey Maps

### Journey 1: Retail Customer

```
Visit Website
    ↓
Browse Products (products.php)
    ├─ See Retail Price: ₹2999
    ├─ See Wholesale: ₹1499.50
    │  (info shown but not primary)
    └─ Add to Cart at ₹2999
         ↓
    Checkout & Pay ₹2999
         ↓
    Order Confirmed
```

### Journey 2: Wholesale Buyer

```
Visit Website
    ↓
Click "Wholesale & Bulk Orders"
    ├─ See Pricing Tiers
    ├─ See Product Pricing Table
    │  ├─ All products listed
    │  ├─ Wholesale prices shown (50% off)
    │  └─ Exact savings displayed
    └─ Fill Wholesale Form
         ├─ Company details
         ├─ Contact info
         ├─ Quantity (min 6)
         └─ Purchase amount (min ₹500)
              ↓
    System Calculates:
    ├─ Determines tier
    ├─ Applies additional discount
    └─ Sends to admin
         ↓
    Confirmation Message
         ↓
    Admin Contacts with Final Quote
```

---

## Feature Checklist

```
✅ IMPLEMENTED FEATURES
├─ ✅ Auto-calculate wholesale (50% of retail)
├─ ✅ Bi-directional calculation (edit either field)
├─ ✅ Real-time discount display
├─ ✅ Visual feedback in admin panel
├─ ✅ Product display with both prices
├─ ✅ Wholesale pricing table
├─ ✅ Tier-based bulk discounts
├─ ✅ Database integration
├─ ✅ Order processing with pricing
└─ ✅ Complete documentation
```

---

**System Status:** ✅ COMPLETE & READY
**Last Updated:** January 10, 2026
