<?php
require_once __DIR__ . '/_auth.php';
$pageTitle = 'Admin Dashboard';

// Get product statistics
$allProducts = isset($_SESSION['products']) ? $_SESSION['products'] : [];
$totalProducts = count($allProducts);

// Count by category
$categoryCounts = [
  'earrings' => 0,
  'necklace' => 0,
  'bangles' => 0,
  'rings' => 0,
  'pendants' => 0,
  'bracelets' => 0,
  'anklets' => 0,
  'nose-rings' => 0
];

// Count by section
$sectionCounts = [
  'new-arrivals' => 0,
  'best-sellers' => 0,
  'unique-collections' => 0
];

// Stock statistics
$totalStock = 0;
$lowStockProducts = 0;
$outOfStockProducts = 0;
$totalValue = 0;

// Recent products (last 5)
$recentProducts = [];

foreach ($allProducts as $product) {
  // Category count
  if (isset($product['category']) && isset($categoryCounts[$product['category']])) {
    $categoryCounts[$product['category']]++;
  }
  
  // Section count
  if (isset($product['sections'])) {
    foreach ($product['sections'] as $section) {
      if (isset($sectionCounts[$section])) {
        $sectionCounts[$section]++;
      }
    }
  }
  
  // Stock stats
  $stock = isset($product['stock']) ? intval($product['stock']) : 0;
  $totalStock += $stock;
  
  if ($stock === 0) {
    $outOfStockProducts++;
  } elseif ($stock <= 10) {
    $lowStockProducts++;
  }
  
  // Total inventory value
  $totalValue += ($product['retail_price'] ?? 0) * $stock;
  
  // Recent products
  $recentProducts[] = $product;
}

// Sort recent products by creation date
usort($recentProducts, function($a, $b) {
  return strcmp($b['created'] ?? '', $a['created'] ?? '');
});
$recentProducts = array_slice($recentProducts, 0, 5);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="admin.css" />
</head>
<body>
  <div class="admin-header">
    <h1>Admin Dashboard</h1>
    <p>Soumis Collections — Admin Control Panel</p>
    <p style="margin-top: 8px;">Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_email']); ?></strong><span class="badge">ADMIN</span></p>
    <div class="admin-nav">
      <a href="../index.php">← Return to Site</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="admin-container">
    <!-- Key Statistics Section -->
    <div class="admin-section">
      <div class="section-title">📊 Dashboard Overview</div>
      <div class="stats-grid">
        <div class="stat-card" style="background: linear-gradient(135deg, #d4af37 0%, #e8c851 100%); color: #2a2a2a;">
          <h3>Total Products</h3>
          <div class="stat-value"><?php echo $totalProducts; ?></div>
          <p style="font-size: 0.85rem; margin-top: 8px; opacity: 0.8;">Active in catalog</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white;">
          <h3>Total Stock</h3>
          <div class="stat-value"><?php echo number_format($totalStock); ?></div>
          <p style="font-size: 0.85rem; margin-top: 8px; opacity: 0.9;">Units available</p>
        </div>
        <div class="stat-card" style="background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%); color: white;">
          <h3>Inventory Value</h3>
          <div class="stat-value">₹<?php echo number_format($totalValue, 0); ?></div>
          <p style="font-size: 0.85rem; margin-top: 8px; opacity: 0.9;">Total retail value</p>
        </div>
        <Quick Actions -->
    <div class="admin-section">
      <div class="section-title">🚀 Quick Actions</div>
      <div class="admin-grid">
        <div class="admin-card" style="background: linear-gradient(135deg, #d4af37 0%, #e8c851 100%); color: #2a2a2a;">
          <h3 style="color: #2a2a2a;">➕ Add New Product</h3>
          <p style="color: #2a2a2a; opacity: 0.9;">Upload photos, set pricing, assign categories and sections.</p>
          <a class="admin-link" href="products.php" style="background: white; color: #2a2a2a;">Manage Products</a>
        </div>
        <div class="admin-card">
          <h3>📦 View All Products</h3>
          <p>Browse complete product catalog with filters and sorting.</p>
          <a class="admin-link" href="../products.php">All Products</a>
        </div>
        <div class="admin-card">
          <h3>🏪 Wholesale Applications</h3>
          <p>Review and manage wholesale partnership requests.</p>
          <a class="admin-link" href="wholesale.php">View Applications</a>
        </div>
        <div class="admin-card">
          <h3>🌐 Visit Website</h3>
          <p>View your store as customers see it.</p>
          <a class="admin-link" href="../index.php">View Site</a>
        </div>
      </div>
    </div>

    <!-- Site Pages -->
    <div class="admin-section">
      <div class="section-title">📄 Site Pages</div>
      <div class="admin-grid">
        <div class="admin-card">
          <h3>Homepage</h3>
          <p>Main landing page with featured sections.</p>
          <a class="admin-link" href="../index.php" target="_blank">View →</a>
        </div>
        <div class="admin-card">
          <h3>All Products</h3>
          <p>Complete catalog with filters and search.</p>
          <a class="admin-link" href="../products.php" target="_blank">View →</a>
        </div>
        <div class="admin-card">
          <h3>New Arrivals</h3>
          <p><?php echo $sectionCounts['new-arrivals']; ?> products marked as new.</p>
          <a class="admin-link" href="../new-arrivals.php" target="_blank">View →</a>
        </div>
        <div class="admin-card">
          <h3>Best Sellers</h3>
          <p><?php echo $sectionCounts['best-sellers']; ?> top selling products.</p>
          <a class="admin-link" href="../best-sellers.php" target="_blank">View →</a>
        </div>
        <div class="admin-card">
          <h3>Unique Collections</h3>
          <p><?php echo $sectionCounts['unique-collections']; ?> exclusive designs.</p>
          <a class="admin-link" href="../unique-collections.php" target="_blank">View →</a>
        </div>
        <div class="admin-card">
          <h3>Wholesale</h3>
          <p>Business partnership information.</p>
          <a class="admin-link" href="../wholesale.php" target="_blank">View →</a>
        </div>
      </div>
    </div>

    <!-- System Info -->
    <div class="admin-section">
      <div class="section-title">ℹ️ System Information</div>
      <div class="admin-grid">
        <div class="admin-card">
          <h3>Admin Details</h3>
          <div style="background: #f7f5f2; padding: 12px; border-radius: 6px; font-size: 0.9rem;">
            <p style="margin: 4px 0;"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
            <p style="margin: 4px 0;"><strong>Role:</strong> Administrator</p>
            <p style="margin: 4px 0;"><strong>Session:</strong> <?php echo substr($_SESSION['user_id'], 0, 8) . '...'; ?></p>
            <p style="margin: 4px 0;"><strong>Login Time:</strong> <?php echo date('M d, Y H:i'); ?></p>
          </div>
        </div>
        <div class="admin-card">
          <h3>Active Features</h3>
          <ul class="feature-list">
            <li>✅ Product Management (8 categories)</li>
            <li>✅ Section Management (4 sections)</li>
            <li>✅ Image Upload System</li>
            <li>✅ Color Management</li>
            <li>✅ Stock Tracking</li>
            <li>✅ Price Management</li>
            <li>✅ Dark Mode Support</li>
            <li>✅ Mobile Responsive</li>
          </ul>
        </div>
        <div class="admin-card">
          <h3>Storage</h3>
          <div style="background: #f7f5f2; padding: 12px; border-radius: 6px; font-size: 0.9rem;">
            <p style="margin: 4px 0;"><strong>Method:</strong> Session-based</p>
            <p style="margin: 4px 0;"><strong>Products:</strong> <?php echo $totalProducts; ?> stored</p>
            <p style="margin: 4px 0;"><strong>Images:</strong> /images/products/</p>
            <p style="margin: 4px 0; color: #e67e22;"><strong>Note:</strong> Data clears on logout</p>
          </div
    </div>

    <!-- Recent Products -->
    <?php if (!empty($recentProducts)): ?>
    <div class="admin-section">
      <div class="section-title">🕐 Recently Added Products</div>
      <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
        <table style="width: 100%; border-collapse: collapse;">
          <thead>
            <tr style="background: #f7f5f2; border-bottom: 2px solid #e6e2dc;">
              <th style="padding: 12px; text-align: left; font-size: 0.85rem; color: #7b776f; font-weight: 600;">Product</th>
              <th style="padding: 12px; text-align: left; font-size: 0.85rem; color: #7b776f; font-weight: 600;">Category</th>
              <th style="padding: 12px; text-align: left; font-size: 0.85rem; color: #7b776f; font-weight: 600;">Price</th>
              <th style="padding: 12px; text-align: left; font-size: 0.85rem; color: #7b776f; font-weight: 600;">Stock</th>
              <th style="padding: 12px; text-align: left; font-size: 0.85rem; color: #7b776f; font-weight: 600;">Added</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($recentProducts as $product): 
              $stockClass = $product['stock'] > 10 ? 'green' : ($product['stock'] > 0 ? 'orange' : 'red');
            ?>
            <tr style="border-bottom: 1px solid #f0f0f0;">
              <td style="padding: 12px;">
                <div style="display: flex; align-items: center; gap: 10px;">
                  <?php if (!empty($product['image'])): ?>
                    <img src="../<?php echo htmlspecialchars($product['image']); ?>" style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover;" />
                  <?php else: ?>
                    <div style="width: 40px; height: 40px; background: #f7f5f2; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">💎</div>
                  <?php endif; ?>
                  <div>
                    <div style="font-weight: 600; font-size: 0.9rem; color: #2a2a2a;"><?php echo htmlspecialchars($product['name']); ?></div>
                  </div>
                </div>
              </td>
              <td style="padding: 12px;">
                <span style="background: #f7f5f2; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; color: #7b776f; text-transform: uppercase;">
                  <?php echo htmlspecialchars(str_replace('-', ' ', $product['category'])); ?>
                </span>
              </td>
              <td style="padding: 12px;">
                <div style="font-weight: 600; color: #d4af37; font-size: 0.95rem;">₹<?php echo number_format($product['retail_price'], 2); ?></div>
                <div style="font-size: 0.75rem; color: #999;">WSL: ₹<?php echo number_format($product['wholesale_price'], 2); ?></div>
              </td>
              <td style="padding: 12px;">
                <span style="color: <?php echo $stockClass === 'green' ? '#27ae60' : ($stockClass === 'orange' ? '#e67e22' : '#e74c3c'); ?>; font-weight: 600; font-size: 0.9rem;">
                  <?php echo $product['stock']; ?> units
                </span>
              </td>
              <td style="padding: 12px; font-size: 0.85rem; color: #7b776f;">
                <?php echo date('M d, Y', strtotime($product['created'])); ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php endif; ?>

    <!-- Stock Alerts -->
    <?php if ($lowStockProducts > 0 || $outOfStockProducts > 0): ?>
    <div class="admin-section">
      <div class="section-title" style="color: #e74c3c;">⚠️ Stock Alerts</div>
      <div class="admin-grid">
        <?php foreach ($allProducts as $product): 
          if ($product['stock'] <= 10):
            $isOutOfStock = $product['stock'] === 0;
        ?>
        <div class="admin-card" style="border-left: 4px solid <?php echo $isOutOfStock ? '#e74c3c' : '#e67e22'; ?>;">
          <h3><?php echo htmlspecialchars($product['name']); ?></h3>
          <p style="color: <?php echo $isOutOfStock ? '#e74c3c' : '#e67e22'; ?>; font-weight: 600; font-size: 1.1rem; margin: 8px 0;">
            <?php echo $isOutOfStock ? '❌ OUT OF STOCK' : '⚠️ LOW STOCK: ' . $product['stock'] . ' units'; ?>
          </p>
          <p style="font-size: 0.85rem; color: #7b776f;">
            Category: <?php echo ucfirst(str_replace('-', ' ', $product['category'])); ?> | 
            Price: ₹<?php echo number_format($product['retail_price'], 2); ?>
          </p>
        </div>
        <?php 
          endif;
        endforeach; 
        ?>
      </div>
    </div>
    <?php endif; ?>

    <!-- Product Management Section -->
    <div class="admin-section">
      <div class="section-title">Product Management</div>
      <div class="admin-grid">
        <div class="admin-card">
          <h3>Add New Product</h3>
          <p>Upload product photos and configure pricing for retail and wholesale.</p>
          <a class="admin-link" href="products.php">Manage Products</a>
        </div>
      </div>
    </div>

    <!-- Main Features Section -->
    <div class="admin-section">
      <div class="section-title">Management Tools</div>
      <div class="admin-grid">
        <div class="admin-card">
          <h3>Wholesale Applications</h3>
          <p>Review and manage all wholesale partnership requests and inquiries.</p>
          <a class="admin-link" href="wholesale.php">View Applications</a>
        </div>
        <div class="admin-card">
          <h3>User Session Info</h3>
          <p>Current logged-in user session details and authentication status.</p>
          <div style="background: #f7f5f2; padding: 12px; border-radius: 6px; font-size: 12px; color: #555;">
            <strong>User:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?><br>
            <strong>Admin:</strong> <?php echo $_SESSION['is_admin'] ? 'Yes' : 'No'; ?><br>
            <strong>Session ID:</strong> <?php echo substr($_SESSION['user_id'], 0, 8) . '...'; ?>
          </div>
        </div>
        <div class="admin-card">
          <h3>Site Management</h3>
          <p>Quick access to main site and core administrative functions.</p>
          <a class="admin-link" href="../index.php">View Site</a>
          <a class="admin-link secondary" href="logout.php" style="margin-left: 8px;">Logout</a>
        </div>
      </div>
    </div>

    <!-- System Information Section -->
    <div class="admin-section">
      <div class="section-title">System Information</div>
      <div class="admin-grid">
        <div class="admin-card">
          <h3>Current Features</h3>
          <ul class="feature-list">
            <li>Wholesale Management</li>
            <li>Admin Authentication</li>
            <li>User Sessions</li>
            <li>Site Navigation</li>
            <li>Session Tracking</li>
          </ul>
        </div>
        <div class="admin-card">
          <h3>Development Notes</h3>
          <ul class="feature-list">
            <li>Demo Database Integration</li>
            <li>Basic Email OTP System</li>
            <li>Session-based Auth</li>
            <li>Responsive Design</li>
            <li>Security Improvements Needed</li>
          </ul>
        </div>
        <div class="admin-card">
          <h3>Recommended Next Steps</h3>
          <ul class="feature-list">
            <li>Implement Real Database</li>
            <li>Add Password Hashing</li>
            <li>Email Integration</li>
            <li>User Management</li>
            <li>Product Management</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
