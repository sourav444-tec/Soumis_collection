# Quick Start Guide - Product System

## 🎯 For Admin: Adding Products

### Step 1: Access Admin Panel

1. Login at `login.php` with admin credentials
2. Navigate to Admin Panel
3. Click "Product Management"

### Step 2: Add Product

1. **Upload Product Image** (optional but recommended)

   - Click photo upload area
   - Select image (max 5MB)
   - Preview appears instantly

2. **Enter Product Details**

   - Product Name: e.g., "Golden Pearl Earrings"
   - Description: Detailed product description

3. **Select Category** (Required)
   Choose one:

   - 💎 Earrings
   - 📿 Necklace
   - ⭕ Bangles
   - 💍 Rings
   - 🔆 Pendants
   - 🔗 Bracelets
   - 👣 Anklets
   - 👃 Nose Rings

4. **Choose Display Sections** (Optional, can select multiple)

   - ☑️ New Arrivals - Shows on New Arrivals page
   - ☑️ Best Sellers - Shows on Best Sellers page
   - ☑️ Unique Collections - Shows on Unique Collections page
   - ☑️ Earring Collection - Shows on Earring Collection page

5. **Select Colors**

   - Click quick palette colors OR
   - Use custom color picker
   - Click "Add" for each color

6. **Set Prices**

   - Retail Price: Customer price
   - Wholesale Price: Bulk buyer price

7. **Set Stock Quantity**

   - Number of units available

8. **Save Product**

## 📍 Where Products Appear

### Automatic Placement

- **All Products Page** (`products.php`) - Shows ALL products
- **Category Pages** - Shows products from that category

### Section-Based Placement

Products appear on selected section pages:

- Checked "New Arrivals" → Shows on `new-arrivals.php`
- Checked "Best Sellers" → Shows on `best-sellers.php`
- Checked "Unique Collections" → Shows on `unique-collections.php`
- Checked "Earring Collection" → Shows on `earring-collection.php`

### Special Rules

- Earring Collection shows:
  - Products with "Earring Collection" section checked
  - OR products with category = "Earrings"

## 🔍 For Users: Finding Products

### Option 1: Browse All Products

1. Click "All Products" in navigation
2. Use filters:
   - **Category**: Select specific type
   - **Price Range**: Set min/max price with sliders
   - **Sort**: Choose how to order products
3. Click "Apply Filters"

### Option 2: Browse Sections

1. From homepage, click any section:
   - New Arrivals
   - Best Sellers
   - Unique Collections
   - Earring Collection
2. See curated products for that section

### Option 3: Browse Categories

1. Go to "All Products"
2. Select category from sidebar
3. See all products in that category

## 🎨 Filter Options Explained

### Category Filter

- **All Products**: Shows everything
- **Specific Category**: Shows only that type
- Example: Select "Earrings" to see only earrings

### Price Range Filter

- **Min Price**: Lowest price you want to see
- **Max Price**: Highest price you want to see
- Use sliders or type exact amounts
- Click "Apply Filters" to update

### Sort Options

- **Newest First**: Recently added products first
- **Price: Low to High**: Cheapest products first
- **Price: High to Low**: Most expensive products first
- **Name: A to Z**: Alphabetical order

## 💡 Pro Tips

### For Admin

1. **Always upload images** - Products with images sell better
2. **Check multiple sections** - More visibility = more sales
3. **Add 3-5 colors** - Shows variety to customers
4. **Set competitive wholesale prices** - Encourage bulk orders
5. **Keep stock updated** - Shows "Low Stock" or "Out of Stock" automatically

### For Users

1. **Use filters to narrow down** - Find exactly what you want
2. **Check "All Products"** - Don't miss hidden gems
3. **Browse by section** - Curated selections by admin
4. **Watch for badges** - "NEW", "BEST SELLER", "UNIQUE" tags

## 🌙 Dark Mode

All pages support dark mode:

- Toggle button: Bottom-right corner
- Settings: Change in user settings page
- Auto-saved: Preference remembered

## 📱 Mobile Friendly

- Filters: Stack vertically on mobile
- Product grid: Adapts to screen size
- Touch-friendly: Large buttons and links

## 🚀 Quick Links

| Page               | URL                      | Purpose                        |
| ------------------ | ------------------------ | ------------------------------ |
| All Products       | `products.php`           | Browse everything with filters |
| Earring Collection | `earring-collection.php` | Earrings only                  |
| New Arrivals       | `new-arrivals.php`       | Latest products                |
| Best Sellers       | `best-sellers.php`       | Popular products               |
| Unique Collections | `unique-collections.php` | Exclusive designs              |
| Admin Products     | `admin/products.php`     | Add/manage products            |

## ❓ Common Questions

**Q: Why isn't my product showing on Best Sellers page?**
A: Make sure you checked "Best Sellers" in the section checkboxes when adding the product.

**Q: Can a product be in multiple sections?**
A: Yes! Check multiple section boxes to show the product in all those places.

**Q: What's the difference between category and section?**
A:

- **Category** = Product type (Earrings, Necklace, etc.)
- **Section** = Where to display (New Arrivals, Best Sellers, etc.)

**Q: How do I edit a product?**
A: Currently, delete and re-add. Edit feature coming soon!

**Q: Where are product images stored?**
A: In `images/products/` folder on the server.

**Q: What happens if I don't upload an image?**
A: Product shows a default 💎 emoji placeholder.

**Q: How does stock status work?**
A:

- Stock > 10 = "In Stock" (green)
- Stock 1-10 = "Only X left" (orange)
- Stock = 0 = "Out of Stock" (red)

## 🎉 You're Ready!

Start adding products and watch them appear across your website automatically!
