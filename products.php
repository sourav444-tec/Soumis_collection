<?php
session_start();
$pageTitle = 'All Products - Soumis Gems';

// Get filter parameters
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'all';
$minPrice = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$maxPrice = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 100000;
$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

// Get all products
$allProducts = isset($_SESSION['products']) ? $_SESSION['products'] : [];

// Filter products
$filteredProducts = [];
foreach ($allProducts as $product) {
  // Category filter
  if ($selectedCategory !== 'all' && $product['category'] !== $selectedCategory) {
    continue;
  }
  
  // Price filter
  if ($product['retail_price'] < $minPrice || $product['retail_price'] > $maxPrice) {
    continue;
  }
  
  $filteredProducts[] = $product;
}

// Sort products
usort($filteredProducts, function($a, $b) use ($sortBy) {
  switch ($sortBy) {
    case 'price_low':
      return $a['retail_price'] - $b['retail_price'];
    case 'price_high':
      return $b['retail_price'] - $a['retail_price'];
    case 'name':
      return strcmp($a['name'], $b['name']);
    case 'newest':
    default:
      return strcmp($b['created'], $a['created']);
  }
});

// Calculate price range for slider
$allPrices = array_column($allProducts, 'retail_price');
$globalMinPrice = !empty($allPrices) ? min($allPrices) : 0;
$globalMaxPrice = !empty($allPrices) ? max($allPrices) : 100000;

include 'includes/header.php';
include 'includes/nav.php';
?>

<style>
  .products-page {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
  }
  
  .products-header {
    text-align: center;
    margin-bottom: 40px;
  }
  
  .products-header h1 {
    font-size: 2.5rem;
    color: #2a2a2a;
    margin-bottom: 10px;
  }
  
  .products-header p {
    color: #7b776f;
    font-size: 1.1rem;
  }
  
  .products-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 30px;
    align-items: start;
  }
  
  /* Filters Sidebar */
  .filters-sidebar {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    position: sticky;
    top: 20px;
  }
  
  .filter-section {
    margin-bottom: 28px;
    padding-bottom: 28px;
    border-bottom: 1px solid #e6e2dc;
  }
  
  .filter-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
  }
  
  .filter-section h3 {
    font-size: 0.95rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #2a2a2a;
    margin-bottom: 16px;
  }
  
  .category-filter label {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.2s;
    margin-bottom: 6px;
  }
  
  .category-filter label:hover {
    background: #faf8f5;
  }
  
  .category-filter input[type="radio"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #d4af37;
  }
  
  .category-filter span {
    font-size: 0.9rem;
    color: #2a2a2a;
  }
  
  /* Price Range Slider */
  .price-inputs {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 16px;
  }
  
  .price-input {
    position: relative;
  }
  
  .price-input input {
    width: 100%;
    padding: 8px 8px 8px 24px;
    border: 1px solid #e6e2dc;
    border-radius: 6px;
    font-size: 0.85rem;
  }
  
  .price-input::before {
    content: '₹';
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    font-size: 0.85rem;
  }
  
  .price-range-slider {
    margin: 16px 0;
  }
  
  .price-range-slider input[type="range"] {
    width: 100%;
    height: 6px;
    border-radius: 3px;
    background: linear-gradient(to right, #d4af37 0%, #d4af37 100%);
    outline: none;
    -webkit-appearance: none;
  }
  
  .price-range-slider input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #d4af37;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(212, 175, 55, 0.4);
  }
  
  .price-range-slider input[type="range"]::-moz-range-thumb {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #d4af37;
    cursor: pointer;
    border: none;
    box-shadow: 0 2px 6px rgba(212, 175, 55, 0.4);
  }
  
  .filter-actions {
    display: grid;
    gap: 10px;
  }
  
  .btn-apply-filter,
  .btn-reset-filter {
    padding: 10px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: opacity 0.2s;
  }
  
  .btn-apply-filter {
    background: linear-gradient(90deg, #d4af37, #e8c851);
    color: #2a2a2a;
  }
  
  .btn-apply-filter:hover {
    opacity: 0.9;
  }
  
  .btn-reset-filter {
    background: #f7f5f2;
    color: #2a2a2a;
  }
  
  /* Products Grid */
  .products-content {
    min-height: 400px;
  }
  
  .products-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    padding: 16px 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  }
  
  .products-count {
    font-size: 0.95rem;
    color: #7b776f;
  }
  
  .products-count strong {
    color: #2a2a2a;
    font-weight: 600;
  }
  
  .sort-dropdown select {
    padding: 8px 32px 8px 12px;
    border: 1px solid #e6e2dc;
    border-radius: 6px;
    font-size: 0.9rem;
    cursor: pointer;
    background: white;
  }
  
  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
  }
  
  .product-item {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
  }
  
  .product-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.2);
  }
  
  .product-item-image {
    width: 100%;
    height: 280px;
    background: #f7f5f2;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }
  
  .product-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .product-item-image.no-image {
    font-size: 3rem;
    color: #d4af37;
  }
  
  .product-item-info {
    padding: 20px;
  }
  
  .product-category-badge {
    display: inline-block;
    padding: 4px 12px;
    background: linear-gradient(90deg, #d4af37, #e8c851);
    color: #2a2a2a;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
  }
  
  .product-item-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2a2a2a;
    margin-bottom: 8px;
  }
  
  .product-item-description {
    font-size: 0.85rem;
    color: #7b776f;
    margin-bottom: 12px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  
  .product-item-price {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
  }
  
  .price-retail {
    font-size: 1.3rem;
    font-weight: 700;
    color: #d4af37;
  }
  
  .price-wholesale {
    font-size: 0.85rem;
    color: #7b776f;
  }
  
  .product-colors {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    margin-bottom: 12px;
  }
  
  .color-dot {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 1px solid #ccc;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .product-stock {
    font-size: 0.8rem;
    color: #7b776f;
    margin-bottom: 12px;
  }
  
  .product-stock.in-stock {
    color: #4caf50;
  }
  
  .product-stock.low-stock {
    color: #ff9800;
  }
  
  .product-stock.out-of-stock {
    color: #f44336;
  }
  
  .btn-add-to-cart {
    width: 100%;
    padding: 12px;
    background: linear-gradient(90deg, #d4af37, #e8c851);
    color: #2a2a2a;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.2s;
  }
  
  .btn-add-to-cart:hover {
    opacity: 0.9;
  }
  
  .no-products {
    text-align: center;
    padding: 60px 20px;
    color: #7b776f;
  }
  
  .no-products h3 {
    font-size: 1.5rem;
    color: #2a2a2a;
    margin-bottom: 10px;
  }
  
  /* Responsive */
  @media (max-width: 968px) {
    .products-layout {
      grid-template-columns: 1fr;
    }
    
    .filters-sidebar {
      position: static;
    }
    
    .products-grid {
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    }
  }
  
  /* Dark Mode */
  body.dark-mode .products-header h1 {
    color: var(--dm-text-primary);
  }
  
  body.dark-mode .products-header p {
    color: var(--dm-text-secondary);
  }
  
  body.dark-mode .filters-sidebar,
  body.dark-mode .products-toolbar,
  body.dark-mode .product-item {
    background: var(--dm-card-bg);
    border-color: var(--dm-border);
  }
  
  body.dark-mode .filter-section {
    border-color: var(--dm-border);
  }
  
  body.dark-mode .filter-section h3,
  body.dark-mode .category-filter span,
  body.dark-mode .product-item-name,
  body.dark-mode .products-count strong {
    color: var(--dm-text-primary);
  }
  
  body.dark-mode .category-filter label:hover {
    background: rgba(255,255,255,0.05);
  }
  
  body.dark-mode .price-input input,
  body.dark-mode .sort-dropdown select {
    background: var(--dm-bg-secondary);
    border-color: var(--dm-border);
    color: var(--dm-text-primary);
  }
  
  body.dark-mode .product-item-image {
    background: var(--dm-bg-secondary);
  }
  
  body.dark-mode .product-item:hover {
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.3);
  }
</style>

<div class="products-page">
  <div class="products-header">
    <h1>💎 All Products</h1>
    <p>Discover our complete collection of handcrafted jewelry</p>
  </div>
  
  <div class="products-layout">
    <!-- Filters Sidebar -->
    <aside class="filters-sidebar">
      <form method="GET" action="products.php" id="filterForm">
        <!-- Category Filter -->
        <div class="filter-section">
          <h3>Category</h3>
          <div class="category-filter">
            <label>
              <input type="radio" name="category" value="all" <?php echo $selectedCategory === 'all' ? 'checked' : ''; ?> />
              <span>All Products</span>
            </label>
            <label>
              <input type="radio" name="category" value="earrings" <?php echo $selectedCategory === 'earrings' ? 'checked' : ''; ?> />
              <span>💎 Earrings</span>
            </label>
            <label>
              <input type="radio" name="category" value="necklace" <?php echo $selectedCategory === 'necklace' ? 'checked' : ''; ?> />
              <span>📿 Necklace</span>
            </label>
            <label>
              <input type="radio" name="category" value="bangles" <?php echo $selectedCategory === 'bangles' ? 'checked' : ''; ?> />
              <span>⭕ Bangles</span>
            </label>
            <label>
              <input type="radio" name="category" value="rings" <?php echo $selectedCategory === 'rings' ? 'checked' : ''; ?> />
              <span>💍 Rings</span>
            </label>
            <label>
              <input type="radio" name="category" value="pendants" <?php echo $selectedCategory === 'pendants' ? 'checked' : ''; ?> />
              <span>🔆 Pendants</span>
            </label>
            <label>
              <input type="radio" name="category" value="bracelets" <?php echo $selectedCategory === 'bracelets' ? 'checked' : ''; ?> />
              <span>🔗 Bracelets</span>
            </label>
            <label>
              <input type="radio" name="category" value="anklets" <?php echo $selectedCategory === 'anklets' ? 'checked' : ''; ?> />
              <span>👣 Anklets</span>
            </label>
            <label>
              <input type="radio" name="category" value="nose-rings" <?php echo $selectedCategory === 'nose-rings' ? 'checked' : ''; ?> />
              <span>👃 Nose Rings</span>
            </label>
          </div>
        </div>
        
        <!-- Price Range Filter -->
        <div class="filter-section">
          <h3>Price Range</h3>
          <div class="price-inputs">
            <div class="price-input">
              <input type="number" name="min_price" id="minPrice" value="<?php echo $minPrice; ?>" min="0" placeholder="Min" />
            </div>
            <div class="price-input">
              <input type="number" name="max_price" id="maxPrice" value="<?php echo $maxPrice; ?>" min="0" placeholder="Max" />
            </div>
          </div>
          <div class="price-range-slider">
            <input type="range" id="priceRangeMin" min="<?php echo $globalMinPrice; ?>" max="<?php echo $globalMaxPrice; ?>" value="<?php echo $minPrice; ?>" step="100" />
            <input type="range" id="priceRangeMax" min="<?php echo $globalMinPrice; ?>" max="<?php echo $globalMaxPrice; ?>" value="<?php echo $maxPrice; ?>" step="100" />
          </div>
          <div style="font-size: 0.8rem; color: #7b776f; text-align: center; margin-top: 8px;">
            ₹<?php echo number_format($minPrice); ?> - ₹<?php echo number_format($maxPrice); ?>
          </div>
        </div>
        
        <!-- Sort By (Hidden, controlled by toolbar) -->
        <input type="hidden" name="sort" id="sortInput" value="<?php echo $sortBy; ?>" />
        
        <!-- Filter Actions -->
        <div class="filter-actions">
          <button type="submit" class="btn-apply-filter">Apply Filters</button>
          <button type="button" class="btn-reset-filter" onclick="resetFilters()">Reset All</button>
        </div>
      </form>
    </aside>
    
    <!-- Products Content -->
    <main class="products-content">
      <!-- Toolbar -->
      <div class="products-toolbar">
        <div class="products-count">
          Showing <strong><?php echo count($filteredProducts); ?></strong> of <strong><?php echo count($allProducts); ?></strong> products
        </div>
        <div class="sort-dropdown">
          <select onchange="updateSort(this.value)">
            <option value="newest" <?php echo $sortBy === 'newest' ? 'selected' : ''; ?>>Newest First</option>
            <option value="price_low" <?php echo $sortBy === 'price_low' ? 'selected' : ''; ?>>Price: Low to High</option>
            <option value="price_high" <?php echo $sortBy === 'price_high' ? 'selected' : ''; ?>>Price: High to Low</option>
            <option value="name" <?php echo $sortBy === 'name' ? 'selected' : ''; ?>>Name: A to Z</option>
          </select>
        </div>
      </div>
      
      <!-- Products Grid -->
      <?php if (empty($filteredProducts)): ?>
        <div class="no-products">
          <h3>No Products Found</h3>
          <p>Try adjusting your filters or browse all products</p>
        </div>
      <?php else: ?>
        <div class="products-grid">
          <?php foreach ($filteredProducts as $product): 
            $colors = json_decode($product['colors'], true) ?: [];
            $stockStatus = $product['stock'] > 10 ? 'in-stock' : ($product['stock'] > 0 ? 'low-stock' : 'out-of-stock');
            $stockText = $product['stock'] > 10 ? 'In Stock' : ($product['stock'] > 0 ? 'Only ' . $product['stock'] . ' left' : 'Out of Stock');
          ?>
            <div class="product-item">
              <div class="product-item-image <?php echo empty($product['image']) ? 'no-image' : ''; ?>">
                <?php if (!empty($product['image'])): ?>
                  <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                <?php else: ?>
                  💎
                <?php endif; ?>
              </div>
              <div class="product-item-info">
                <div class="product-category-badge"><?php echo ucfirst(str_replace('-', ' ', $product['category'])); ?></div>
                <h3 class="product-item-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                <p class="product-item-description"><?php echo htmlspecialchars($product['description']); ?></p>
                
                <?php if (!empty($colors)): ?>
                  <div class="product-colors">
                    <?php foreach (array_slice($colors, 0, 5) as $color): ?>
                      <div class="color-dot" style="background-color: <?php echo $color; ?>;" title="<?php echo $color; ?>"></div>
                    <?php endforeach; ?>
                    <?php if (count($colors) > 5): ?>
                      <span style="font-size: 0.8rem; color: #7b776f;">+<?php echo count($colors) - 5; ?> more</span>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                
                <div class="product-item-price">
                  <div>
                    <div class="price-retail">₹<?php echo number_format($product['retail_price'], 2); ?></div>
                    <div class="price-wholesale">Wholesale: ₹<?php echo number_format($product['wholesale_price'], 2); ?></div>
                  </div>
                </div>
                
                <div class="product-stock <?php echo $stockStatus; ?>">
                  <?php echo $stockText; ?>
                </div>
                
                <button class="btn-add-to-cart" onclick="addToCart('<?php echo $product['id']; ?>')">
                  🛒 Add to Cart
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </main>
  </div>
</div>

<script>
  // Price range sliders
  const minPriceInput = document.getElementById('minPrice');
  const maxPriceInput = document.getElementById('maxPrice');
  const priceRangeMin = document.getElementById('priceRangeMin');
  const priceRangeMax = document.getElementById('priceRangeMax');
  
  priceRangeMin.addEventListener('input', function() {
    minPriceInput.value = this.value;
  });
  
  priceRangeMax.addEventListener('input', function() {
    maxPriceInput.value = this.value;
  });
  
  minPriceInput.addEventListener('input', function() {
    priceRangeMin.value = this.value;
  });
  
  maxPriceInput.addEventListener('input', function() {
    priceRangeMax.value = this.value;
  });
  
  // Update sort
  function updateSort(value) {
    document.getElementById('sortInput').value = value;
    document.getElementById('filterForm').submit();
  }
  
  // Reset filters
  function resetFilters() {
    window.location.href = 'products.php';
  }
  
  // Add to cart
  function addToCart(productId) {
    alert('Product added to cart! (Cart functionality coming soon)');
    // Future: AJAX call to add-to-cart.php
  }
</script>

<?php include 'includes/footer.php'; ?>
