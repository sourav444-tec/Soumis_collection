<?php
$pageTitle = 'Search - Soumis Collections';
include 'includes/header.php';
include 'includes/nav.php';

$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
?>

    <!-- Search Section -->
    <section class="products-section" style="min-height: 60vh;">
      <div style="max-width: 800px; margin: 0 auto 3rem; text-align: center;">
        <h1 style="font-size: 2.5rem; margin-bottom: 2rem; color: #2a2a2a;">Search Products</h1>
        
        <form action="search.php" method="GET" style="display: flex; gap: 1rem; margin-bottom: 3rem;">
          <input 
            type="text" 
            name="q" 
            placeholder="Search for earrings, collections, designs..." 
            value="<?php echo htmlspecialchars($searchQuery); ?>"
            style="flex: 1; padding: 1rem; border: 2px solid #d4af37; border-radius: 4px; font-size: 1rem;"
            required
          >
          <button 
            type="submit" 
            class="btn btn-primary"
            style="padding: 1rem 2rem;"
          >
            Search
          </button>
        </form>

        <?php if (!empty($searchQuery)): ?>
          <h2 style="color: #666; margin-bottom: 2rem;">
            Search results for: "<?php echo htmlspecialchars($searchQuery); ?>"
          </h2>
        <?php endif; ?>
      </div>

      <?php if (!empty($searchQuery)): ?>
        <!-- Search Results -->
        <div class="products-container">
          <?php
          // Sample search results (in a real app, this would query a database)
          $allProducts = [
            ['name' => 'New Arrivals', 'description' => 'Explore our latest collection', 'url' => 'new-arrivals.php', 'keywords' => 'new latest fresh arrivals recent'],
            ['name' => 'Best Sellers', 'description' => 'Most loved pieces', 'url' => 'best-sellers.php', 'keywords' => 'best seller popular top trending favorite'],
            ['name' => 'Unique Collections', 'description' => 'Exclusive designs', 'url' => 'unique-collections.php', 'keywords' => 'unique exclusive special rare collection'],
            ['name' => 'Festive Special', 'description' => 'Celebrate in style with festive jewellery', 'url' => '#', 'keywords' => 'festive special festival celebration occasion wedding party diwali christmas'],
            ['name' => 'Necklaces', 'description' => 'Elegant necklaces and chains', 'url' => '#', 'keywords' => 'necklace necklaces chain choker pendant collar'],
            ['name' => 'Bangles', 'description' => 'Beautiful wrist ornaments', 'url' => '#', 'keywords' => 'bangles bangle bracelet wrist kada arm ornament'],
            ['name' => 'Silver Jewellery', 'description' => 'Classic silver designs', 'url' => '#', 'keywords' => 'silver metallic classic traditional'],
          ];

          $searchLower = strtolower($searchQuery);
          $results = [];
          
          foreach ($allProducts as $product) {
            $searchableText = strtolower($product['name'] . ' ' . $product['description'] . ' ' . $product['keywords']);
            if (strpos($searchableText, $searchLower) !== false) {
              $results[] = $product;
            }
          }

          if (count($results) > 0):
            foreach ($results as $product):
          ?>
            <a class="product-card" href="<?php echo $product['url']; ?>">
              <div class="product-image" style="background: linear-gradient(135deg, #f9f6f1 0%, #d4af37 100%); display: flex; align-items: center; justify-content: center;">
                <svg viewBox="0 0 24 24" style="width: 80px; height: 80px; fill: #d4af37;">
                  <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
              </div>
              <h3><?php echo htmlspecialchars($product['name']); ?></h3>
              <p><?php echo htmlspecialchars($product['description']); ?></p>
            </a>
          <?php 
            endforeach;
          else:
          ?>
            <div style="text-align: center; padding: 3rem; width: 100%;">
              <p style="font-size: 1.2rem; color: #666;">No products found matching "<?php echo htmlspecialchars($searchQuery); ?>"</p>
              <p style="margin-top: 1rem; color: #999;">Try searching with different keywords</p>
            </div>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <!-- Search Suggestions -->
        <div style="max-width: 600px; margin: 0 auto; text-align: center;">
          <h3 style="color: #666; margin-bottom: 1.5rem;">Popular Searches</h3>
          <div style="display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center;">
            <a href="search.php?q=earrings" style="padding: 0.5rem 1rem; background: #f9f6f1; border-radius: 20px; text-decoration: none; color: #2a2a2a;">Earrings</a>
            <a href="search.php?q=necklaces" style="padding: 0.5rem 1rem; background: #f9f6f1; border-radius: 20px; text-decoration: none; color: #2a2a2a;">Necklaces</a>
            <a href="search.php?q=festive" style="padding: 0.5rem 1rem; background: #f9f6f1; border-radius: 20px; text-decoration: none; color: #2a2a2a;">Festive Special</a>
            <a href="search.php?q=bangles" style="padding: 0.5rem 1rem; background: #f9f6f1; border-radius: 20px; text-decoration: none; color: #2a2a2a;">Bangles</a>
            <a href="search.php?q=new" style="padding: 0.5rem 1rem; background: #f9f6f1; border-radius: 20px; text-decoration: none; color: #2a2a2a;">New Arrivals</a>
            <a href="search.php?q=best" style="padding: 0.5rem 1rem; background: #f9f6f1; border-radius: 20px; text-decoration: none; color: #2a2a2a;">Best Sellers</a>
          </div>
        </div>
      <?php endif; ?>
    </section>

<?php include 'includes/footer.php'; ?>
