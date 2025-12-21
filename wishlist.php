<?php
if (session_status() === PHP_SESSION_NONE) {
  @session_start();
}

// Redirect if not logged in
if (empty($_SESSION['user_id'])) {
  header('Location: login.php?redirect=wishlist');
  exit;
}

$pageTitle = 'My Wishlist - Soumis Collections';
include 'includes/header.php';
include 'includes/nav.php';

$userEmail = $_SESSION['user_email'] ?? 'user@example.com';

// Initialize wishlist in session
if (!isset($_SESSION['wishlist'])) {
  $_SESSION['wishlist'] = [];
}

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
  $itemId = $_POST['item_id'];
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }
  $_SESSION['cart'][$itemId] = ($_SESSION['cart'][$itemId] ?? 0) + 1;
  
  // Remove from wishlist
  unset($_SESSION['wishlist'][$itemId]);
  $successMessage = "Item added to cart!";
}

// Handle remove from wishlist
if (isset($_GET['remove'])) {
  unset($_SESSION['wishlist'][$_GET['remove']]);
  header('Location: wishlist.php');
  exit;
}

$wishlist = $_SESSION['wishlist'];
?>

<style>
  .wishlist-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
  }

  .wishlist-header {
    background: linear-gradient(135deg, #d4af37 0%, #e8c851 100%);
    padding: 40px;
    border-radius: 12px;
    color: #2a2a2a;
    margin-bottom: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  }

  .wishlist-header h1 {
    margin: 0 0 10px 0;
    font-size: 32px;
    letter-spacing: 1px;
  }

  .wishlist-header p {
    margin: 5px 0;
    font-size: 14px;
    opacity: 0.9;
  }

  .wishlist-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
  }

  .wishlist-item {
    background: white;
    border: 1px solid #e6e2dc;
    border-radius: 12px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s;
  }

  .wishlist-item:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
  }

  .item-image {
    width: 100%;
    height: 180px;
    background: linear-gradient(135deg, #f7f5f2 0%, #f0ede8 100%);
    border-radius: 8px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
  }

  .item-name {
    font-size: 14px;
    color: #2a2a2a;
    margin: 0 0 8px 0;
    font-weight: 600;
  }

  .item-price {
    font-size: 16px;
    color: #d4af37;
    font-weight: 700;
    margin-bottom: 12px;
  }

  .item-actions {
    display: flex;
    gap: 8px;
  }

  .item-actions button,
  .item-actions a {
    flex: 1;
    padding: 8px;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s;
  }

  .btn-cart {
    background: linear-gradient(90deg, #d4af37, #e8c851);
    color: #2a2a2a;
  }

  .btn-cart:hover {
    opacity: 0.9;
  }

  .btn-remove {
    background: #e6e2dc;
    color: #2a2a2a;
  }

  .btn-remove:hover {
    background: #d6d2cc;
  }

  .empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #f7f5f2;
    border-radius: 12px;
  }

  .empty-icon {
    font-size: 48px;
    margin-bottom: 15px;
  }

  .empty-text {
    color: #7b776f;
    font-size: 16px;
    margin: 0 0 20px 0;
  }

  .continue-shopping {
    display: inline-block;
    background: linear-gradient(90deg, #d4af37, #e8c851);
    color: #2a2a2a;
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: opacity 0.3s;
  }

  .continue-shopping:hover {
    opacity: 0.9;
  }

  .alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid;
  }

  .alert.success {
    background: #d4edda;
    color: #155724;
    border-color: #28a745;
  }

  .wishlist-count {
    display: inline-block;
    background: white;
    color: #2a2a2a;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    margin-left: 10px;
  }

  @media (max-width: 768px) {
    .wishlist-header {
      padding: 30px;
    }

    .wishlist-header h1 {
      font-size: 24px;
    }

    .wishlist-grid {
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 15px;
    }
  }
</style>

<div class="wishlist-container">
  <div class="wishlist-header">
    <h1>❤️ My Wishlist <span class="wishlist-count"><?php echo count($wishlist); ?> item(s)</span></h1>
    <p><?php echo htmlspecialchars($userEmail); ?></p>
  </div>

  <?php if (isset($successMessage)): ?>
    <div class="alert success">✓ <?php echo $successMessage; ?></div>
  <?php endif; ?>

  <?php if (empty($wishlist)): ?>
    <div class="empty-state">
      <div class="empty-icon">💔</div>
      <p class="empty-text">Your wishlist is empty.</p>
      <p style="color: #999; margin: 0 0 20px 0; font-size: 13px;">Add items to your wishlist to save them for later!</p>
      <a href="index.php" class="continue-shopping">Start Shopping</a>
    </div>
  <?php else: ?>
    <div class="wishlist-grid">
      <?php foreach ($wishlist as $itemId => $item): ?>
        <div class="wishlist-item">
          <div class="item-image">
            <?php 
            $icons = ['💎', '✨', '👑', '💍', '🌟', '💫'];
            echo $icons[$itemId % count($icons)];
            ?>
          </div>
          <h3 class="item-name"><?php echo htmlspecialchars($item['name'] ?? 'Product'); ?></h3>
          <div class="item-price">₹<?php echo number_format($item['price'] ?? 2999, 2); ?></div>
          
          <form method="POST" style="display: none;" id="form-<?php echo $itemId; ?>">
            <input type="hidden" name="item_id" value="<?php echo $itemId; ?>">
          </form>

          <div class="item-actions">
            <button class="btn-cart" onclick="document.getElementById('form-<?php echo $itemId; ?>').submit();">🛒 Add to Cart</button>
            <a href="wishlist.php?remove=<?php echo $itemId; ?>" class="btn-remove">🗑️ Remove</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
