<?php
if (session_status() === PHP_SESSION_NONE) {
  @session_start();
}

// Redirect if not logged in
if (empty($_SESSION['user_id'])) {
  header('Location: login.php?redirect=orders');
  exit;
}

$pageTitle = 'My Orders - Soumis Collections';
include 'includes/header.php';
include 'includes/nav.php';

$userEmail = $_SESSION['user_email'] ?? 'user@example.com';

// Initialize orders in session
if (!isset($_SESSION['orders'])) {
  $_SESSION['orders'] = [];
}

$orders = $_SESSION['orders'];
?>

<style>
  .orders-container {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 20px;
  }

  .orders-header {
    background: linear-gradient(135deg, #d4af37 0%, #e8c851 100%);
    padding: 40px;
    border-radius: 12px;
    color: #2a2a2a;
    margin-bottom: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  }

  .orders-header h1 {
    margin: 0 0 10px 0;
    font-size: 32px;
    letter-spacing: 1px;
  }

  .orders-header p {
    margin: 5px 0;
    font-size: 14px;
    opacity: 0.9;
  }

  .order-card {
    background: white;
    border: 1px solid #e6e2dc;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s;
  }

  .order-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
  }

  .order-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
  }

  .order-id {
    font-size: 14px;
    font-weight: 600;
    color: #2a2a2a;
  }

  .order-date {
    font-size: 12px;
    color: #7b776f;
  }

  .order-status {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
  }

  .status-processing {
    background: #fff3cd;
    color: #856404;
  }

  .status-shipped {
    background: #d1ecf1;
    color: #0c5460;
  }

  .status-delivered {
    background: #d4edda;
    color: #155724;
  }

  .order-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 15px;
  }

  .info-item {
    background: #f7f5f2;
    padding: 12px;
    border-radius: 8px;
    border-left: 3px solid #d4af37;
  }

  .info-label {
    font-size: 11px;
    color: #7b776f;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
    font-weight: 600;
  }

  .info-value {
    font-size: 14px;
    color: #2a2a2a;
    font-weight: 500;
  }

  .order-items {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #f0f0f0;
  }

  .order-items h4 {
    margin: 0 0 10px 0;
    font-size: 14px;
    color: #2a2a2a;
  }

  .item-list {
    background: #f7f5f2;
    padding: 12px;
    border-radius: 8px;
    font-size: 13px;
    color: #666;
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

  .action-buttons {
    display: flex;
    gap: 10px;
    margin-top: 15px;
  }

  .action-buttons button,
  .action-buttons a {
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s;
  }

  .btn-view {
    background: #d4af37;
    color: #2a2a2a;
  }

  .btn-view:hover {
    opacity: 0.9;
  }

  .btn-track {
    background: #e6e2dc;
    color: #2a2a2a;
  }

  .btn-track:hover {
    background: #d6d2cc;
  }

  @media (max-width: 768px) {
    .orders-header {
      padding: 30px;
    }

    .orders-header h1 {
      font-size: 24px;
    }

    .order-header {
      flex-direction: column;
      gap: 10px;
    }

    .order-info {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="orders-container">
  <div class="orders-header">
    <h1>📦 My Orders</h1>
    <p><?php echo htmlspecialchars($userEmail); ?></p>
  </div>

  <?php if (empty($orders)): ?>
    <div class="empty-state">
      <div class="empty-icon">🛍️</div>
      <p class="empty-text">You haven't placed any orders yet.</p>
      <a href="index.php" class="continue-shopping">Browse Products</a>
    </div>
  <?php else: ?>
    <?php foreach ($orders as $order): ?>
      <div class="order-card">
        <div class="order-header">
          <div>
            <div class="order-id">Order #<?php echo htmlspecialchars($order['id']); ?></div>
            <div class="order-date"><?php echo htmlspecialchars($order['date']); ?></div>
          </div>
          <span class="order-status status-<?php echo strtolower($order['status']); ?>"><?php echo htmlspecialchars($order['status']); ?></span>
        </div>

        <div class="order-info">
          <div class="info-item">
            <div class="info-label">Total Amount</div>
            <div class="info-value">₹<?php echo number_format($order['total'], 2); ?></div>
          </div>
          <div class="info-item">
            <div class="info-label">Items</div>
            <div class="info-value"><?php echo $order['items']; ?> item(s)</div>
          </div>
          <div class="info-item">
            <div class="info-label">Shipping Address</div>
            <div class="info-value"><?php echo htmlspecialchars($order['address']); ?></div>
          </div>
        </div>

        <div class="order-items">
          <h4>📋 Order Details</h4>
          <div class="item-list">
            <?php echo htmlspecialchars($order['description']); ?>
          </div>
        </div>

        <div class="action-buttons">
          <button class="btn-view" onclick="alert('View order details feature coming soon')">👁️ View Details</button>
          <button class="btn-track" onclick="alert('Order tracking feature coming soon')">📍 Track Order</button>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
