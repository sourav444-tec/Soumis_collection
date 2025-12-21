<?php
session_start();
$pageTitle = 'Best Sellers - Soumis Gems';

// Get products in best sellers section
$allProducts = isset($_SESSION['products']) ? $_SESSION['products'] : [];
$bestSellers = [];

foreach ($allProducts as $product) {
  if (isset($product['sections']) && in_array('best-sellers', $product['sections'])) {
    $bestSellers[] = $product;
  }
}

// Sort by price (highest first as best sellers)
usort($bestSellers, function($a, $b) {
  return $b['retail_price'] - $a['retail_price'];
});

include 'includes/header.php';
include 'includes/nav.php';
?>

<style>
  .section-hero {
    background: linear-gradient(135deg, rgba(212,175,55,0.1) 0%, rgba(232,200,81,0.1) 100%);
    padding: 60px 20px;
    text-align: center;
    margin-bottom: 40px;
  }
  
  .section-hero h1 {
    font-size: 3rem;
    color: #2a2a2a;
    margin-bottom: 15px;
  }
  
  .section-hero p {
    font-size: 1.2rem;
    color: #7b776f;
    max-width: 600px;
    margin: 0 auto 30px;
  }
  
  .section-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px 60px;
  }
  
  .products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
  }
  
  .product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
  }
  
  .product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.2);
  }
  
  .product-image-box {
    width: 100%;
    height: 320px;
    background: #f7f5f2;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
  }
  
  .product-image-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .product-image-box.no-image {
    font-size: 4rem;
    color: #d4af37;
  }
  
  .bestseller-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(90deg, #e74c3c, #c0392b);
    color: white;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .product-info {
    padding: 24px;
  }
  
  .product-name {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2a2a2a;
    margin-bottom: 10px;
  }
  
  .product-description {
    font-size: 0.95rem;
    color: #7b776f;
    margin-bottom: 16px;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  
  .product-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #d4af37;
    margin-bottom: 16px;
  }
  
  .product-colors {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
    flex-wrap: wrap;
  }
  
  .color-swatch {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 1px solid #ccc;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .btn-add-cart {
    width: 100%;
    padding: 14px;
    background: linear-gradient(90deg, #d4af37, #e8c851);
    color: #2a2a2a;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: opacity 0.2s;
  }
  
  .btn-add-cart:hover {
    opacity: 0.9;
  }
  
  .no-products {
    text-align: center;
    padding: 80px 20px;
    color: #7b776f;
  }
  
  .no-products h3 {
    font-size: 1.8rem;
    color: #2a2a2a;
    margin-bottom: 15px;
  }
  
  .btn-all-products {
    display: inline-block;
    margin-top: 20px;
    padding: 14px 32px;
    background: linear-gradient(90deg, #d4af37, #e8c851);
    color: #2a2a2a;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: opacity 0.2s;
  }
  
  .btn-all-products:hover {
    opacity: 0.9;
  }
  
  /* Dark Mode */
  body.dark-mode .section-hero h1,
  body.dark-mode .product-name,
  body.dark-mode .no-products h3 {
    color: var(--dm-text-primary);
  }
  
  body.dark-mode .product-card {
    background: var(--dm-card-bg);
    border-color: var(--dm-border);
  }
  
  body.dark-mode .product-image-box {
    background: var(--dm-bg-secondary);
  }
  
  body.dark-mode .product-card:hover {
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.3);
  }
</style>

<div class="section-hero">
  <h1>🔥 Best Sellers</h1>
  <p>Pieces our clients love the most, tried and trusted for every occasion</p>
  <a href="products.php" class="btn-all-products">Browse All Products</a>
</div>

<div class="section-content">
  <?php if (empty($bestSellers)): ?>
    <div class="no-products">
      <h3>Coming Soon</h3>
      <p>Best selling products will appear here when added by admin</p>
      <a href="products.php" class="btn-all-products">Browse All Products</a>
    </div>
  <?php else: ?>
    <div class="products-grid">
      <?php foreach ($bestSellers as $product): 
        $colors = json_decode($product['colors'], true) ?: [];
      ?>
        <div class="product-card">
          <div class="product-image-box <?php echo empty($product['image']) ? 'no-image' : ''; ?>">
            <?php if (!empty($product['image'])): ?>
              <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
            <?php else: ?>
              💎
            <?php endif; ?>
            <div class="bestseller-badge">🔥 BEST SELLER</div>
          </div>
          <div class="product-info">
            <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
            <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
            
            <?php if (!empty($colors)): ?>
              <div class="product-colors">
                <?php foreach (array_slice($colors, 0, 6) as $color): ?>
                  <div class="color-swatch" style="background-color: <?php echo $color; ?>;" title="<?php echo $color; ?>"></div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            
            <div class="product-price">
              ₹<?php echo number_format($product['retail_price'], 2); ?>
            </div>
            
            <button class="btn-add-cart" onclick="addToCart('<?php echo $product['id']; ?>')">
              🛒 Add to Cart
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<script>
  function addToCart(productId) {
    alert('Product added to cart! (Cart functionality coming soon)');
  }
</script>

<?php include 'includes/footer.php'; ?>
