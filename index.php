<?php
$pageTitle = 'Soumis Gems - Stunning every Ear';
include 'includes/header.php';
include 'includes/nav.php';
?>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <h1>Stunning every Ear</h1>
        <div class="hero-buttons">
          <a class="btn btn-primary" href="#products">SHOP RETAIL</a>
          <a class="btn btn-secondary" href="wholesale.php">EXPLORE WHOLESALE</a>
        </div>
      </div>
    </section>

    <!-- Featured Products Section -->
    <section class="products-section" id="products">
      <div class="products-container">
        <div class="product-card">
          <a href="new-arrivals.php">
            <div class="product-image new-arrivals"></div>
            <h3>NEW ARRIVALS</h3>
            <p>Explore our latest collection</p>
          </a>
        </div>
        <div class="product-card">
          <a href="best-sellers.php">
            <div class="product-image best-sellers"></div>
            <h3>BEST SELLERS</h3>
            <p>Most loved pieces</p>
          </a>
        </div>
        <div class="product-card">
          <a href="unique-collections.php">
            <div class="product-image unique-collections"></div>
            <h3>UNIQUE COLLECTIONS</h3>
            <p>Exclusive designs</p>
          </a>
        </div>
      </div>
      
      <!-- View All Products Button -->
      <div style="text-align: center; margin-top: 40px;">
        <a href="products.php" class="btn btn-primary" style="padding: 14px 32px; font-size: 1rem;">
          🛍️ View All Products
        </a>
      </div>
    </section>

    <!-- Tagline Section -->
    <section class="tagline-section">
      <h2>ETHICAL BEAUTY & CRAFTSMANSHIP</h2>
      <p>
        Responsibly sourced materials and expert craftsmanship in every piece
      </p>
    </section>

    <!-- About Section -->
    <section class="about-section">
      <div class="about-content">
        <h2>ETHICAL BEAUTY</h2>
        <p>
          We are dedicated to creating exquisite jewellery that reflects our
          commitment to ethical sourcing and timeless elegance. Each piece is
          carefully crafted with attention to detail and quality.
        </p>
        <p>
          Discover jewellery that tells a story of beauty, sustainability, and
          craftsmanship.
        </p>
      </div>
    </section>

<?php include 'includes/footer.php'; ?>
