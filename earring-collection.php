<?php
session_start();
$pageTitle = 'Earring Collection - Soumis Gems';

// Get products in earring collection
$allProducts = isset($_SESSION['products']) ? $_SESSION['products'] : [];
$earringProducts = [];

foreach ($allProducts as $product) {
  // Show products that are in earring collection section OR are earrings category
  if ((isset($product['sections']) && in_array('earring-collection', $product['sections'])) || 
      $product['category'] === 'earrings') {
    $earringProducts[] = $product;
  }
}

include 'includes/header.php';
include 'includes/nav.php';
?>

<style>
  .collection-hero {
    background: linear-gradient(135deg, rgba(212,175,55,0.1) 0%, rgba(232,200,81,0.1) 100%);
    padding: 60px 20px;
    text-align: center;
    margin-bottom: 40px;
  }
  
  .collection-hero h1 {
    font-size: 3rem;
    color: #2a2a2a;
    margin-bottom: 15px;
  }
  
  .collection-hero p {
    font-size: 1.2rem;
    color: #7b776f;
    max-width: 600px;
    margin: 0 auto;
  }
  
  .collection-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px 60px;
  }
  
  .collection-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
  }
  
  .collection-item {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
  }
  
  .collection-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.2);
  }
  
  .collection-item-image {
    width: 100%;
    height: 320px;
    background: #f7f5f2;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }
  
  .collection-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .collection-item-image.no-image {
    font-size: 4rem;
    color: #d4af37;
  }
  
  .collection-item-info {
    padding: 24px;
  }
  
  .collection-item-name {
    font-size: 1.3rem;
    font-weight: 600;
    color: #2a2a2a;
    margin-bottom: 10px;
  }
  
  .collection-item-description {
    font-size: 0.95rem;
    color: #7b776f;
    margin-bottom: 16px;
    line-height: 1.5;
  }
  
  .collection-item-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #d4af37;
    margin-bottom: 16px;
  }
  
  .collection-colors {
    display: flex;
    gap: 8px;
    margin-bottom: 16px;
    flex-wrap: wrap;
  }
  
  .collection-color {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 1px solid #ccc;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .btn-view-details {
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
  
  .btn-view-details:hover {
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
  
  .btn-browse-all {
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
  
  .btn-browse-all:hover {
    opacity: 0.9;
  }
  
  /* Dark Mode */
  body.dark-mode .collection-hero h1,
  body.dark-mode .collection-item-name,
  body.dark-mode .no-products h3 {
    color: var(--dm-text-primary);
  }
  
  body.dark-mode .collection-item {
    background: var(--dm-card-bg);
    border-color: var(--dm-border);
  }
  
  body.dark-mode .collection-item-image {
    background: var(--dm-bg-secondary);
  }
  
  body.dark-mode .collection-item:hover {
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.3);
  }
</style>

<div class="collection-hero">
  <h1>💎 Earring Collection</h1>
  <p>Discover our exquisite collection of handcrafted earrings, from classic studs to statement pieces</p>
</div>

<div class="collection-content">
  <?php if (empty($earringProducts)): ?>
    <div class="no-products">
      <h3>No Earrings Available Yet</h3>
      <p>Our earring collection is being curated. Check back soon!</p>
      <a href="products.php" class="btn-browse-all">Browse All Products</a>
    </div>
  <?php else: ?>
    <div class="collection-grid">
      <?php foreach ($earringProducts as $product): 
        $colors = json_decode($product['colors'], true) ?: [];
      ?>
        <div class="collection-item">
          <div class="collection-item-image <?php echo empty($product['image']) ? 'no-image' : ''; ?>">
            <?php if (!empty($product['image'])): ?>
              <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
            <?php else: ?>
              💎
            <?php endif; ?>
          </div>
          <div class="collection-item-info">
            <h3 class="collection-item-name"><?php echo htmlspecialchars($product['name']); ?></h3>
            <p class="collection-item-description"><?php echo htmlspecialchars($product['description']); ?></p>
            
            <?php if (!empty($colors)): ?>
              <div class="collection-colors">
                <?php foreach ($colors as $color): ?>
                  <div class="collection-color" style="background-color: <?php echo $color; ?>;" title="<?php echo $color; ?>"></div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            
            <div class="collection-item-price">
              ₹<?php echo number_format($product['retail_price'], 2); ?>
            </div>
            
            <button class="btn-view-details" onclick="viewProduct('<?php echo $product['id']; ?>')">
              View Details & Add to Cart
            </button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<script>
  function viewProduct(productId) {
    alert('Product details page coming soon!\nProduct ID: ' + productId);
    // Future: window.location.href = 'product-details.php?id=' + productId;
  }
</script>

<?php include 'includes/footer.php'; ?>
