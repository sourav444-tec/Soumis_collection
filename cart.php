<?php
session_start();
$pageTitle = 'Shopping Cart - Soumis Collections';
include 'includes/header.php';
include 'includes/nav.php';

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle remove item
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
    header('Location: cart.php');
    exit;
}

// Handle update quantity
if (isset($_POST['update_quantity'])) {
    $itemId = $_POST['item_id'];
    $quantity = max(1, intval($_POST['quantity']));
    if (isset($_SESSION['cart'][$itemId])) {
        $_SESSION['cart'][$itemId]['quantity'] = $quantity;
    }
    header('Location: cart.php');
    exit;
}

$cartItems = $_SESSION['cart'];
$cartTotal = 0;
?>

    <!-- Cart Section -->
    <section class="products-section" style="min-height: 60vh;">
      <div style="max-width: 1000px; margin: 0 auto;">
        <h1 style="font-size: 2.5rem; margin-bottom: 2rem; color: #2a2a2a; text-align: center;">Shopping Cart</h1>
        
        <?php if (empty($cartItems)): ?>
          <div style="text-align: center; padding: 3rem;">
            <svg viewBox="0 0 24 24" style="width: 100px; height: 100px; fill: #d4af37; margin-bottom: 1rem;">
              <path d="M7 4h-2l-1 2v2h2l3.6 7.59-1.35 2.45A1 1 0 0 0 9.2 19h11v-2H10l.1-.18L11.55 14h7.9a1 1 0 0 0 .95-.68l2.5-7.32A1 1 0 0 0 21 4H7zm2 16a2 2 0 1 0 2 2 2 2 0 0 0-2-2zm10 0a2 2 0 1 0 2 2 2 2 0 0 0-2-2z" />
            </svg>
            <h2 style="color: #666; margin-bottom: 1rem;">Your cart is empty</h2>
            <p style="color: #999; margin-bottom: 2rem;">Add some beautiful jewellery to get started!</p>
            <a href="index.php" class="btn btn-primary" style="text-decoration: none; display: inline-block;">Continue Shopping</a>
          </div>
        <?php else: ?>
          <!-- Cart Items -->
          <div style="background: white; border-radius: 8px; padding: 2rem; margin-bottom: 2rem;">
            <?php foreach ($cartItems as $itemId => $item): 
              $itemTotal = $item['price'] * $item['quantity'];
              $cartTotal += $itemTotal;
            ?>
              <div style="display: flex; gap: 2rem; padding: 1.5rem 0; border-bottom: 1px solid #f0f0f0; align-items: center;">
                <!-- Product Image -->
                <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #f9f6f1 0%, #d4af37 100%); border-radius: 8px; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                  <svg viewBox="0 0 24 24" style="width: 50px; height: 50px; fill: #d4af37;">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                  </svg>
                </div>
                
                <!-- Product Details -->
                <div style="flex: 1;">
                  <h3 style="color: #2a2a2a; margin-bottom: 0.5rem; font-size: 1.2rem;"><?php echo htmlspecialchars($item['name']); ?></h3>
                  <p style="color: #666; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($item['category']); ?></p>
                  <p style="color: #d4af37; font-weight: 600; font-size: 1.1rem;">₹<?php echo number_format($item['price'], 2); ?></p>
                </div>
                
                <!-- Quantity Update -->
                <form method="POST" style="display: flex; align-items: center; gap: 1rem;">
                  <input type="hidden" name="item_id" value="<?php echo $itemId; ?>">
                  <input 
                    type="number" 
                    name="quantity" 
                    value="<?php echo $item['quantity']; ?>" 
                    min="1" 
                    style="width: 70px; padding: 0.5rem; border: 2px solid #d4af37; border-radius: 4px; text-align: center;"
                  >
                  <button type="submit" name="update_quantity" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Update</button>
                </form>
                
                <!-- Item Total -->
                <div style="text-align: right; min-width: 120px;">
                  <p style="color: #2a2a2a; font-weight: 600; font-size: 1.2rem;">₹<?php echo number_format($itemTotal, 2); ?></p>
                </div>
                
                <!-- Remove Button -->
                <a href="cart.php?remove=<?php echo $itemId; ?>" style="color: #e74c3c; text-decoration: none; font-size: 1.5rem; padding: 0.5rem;" title="Remove item">×</a>
              </div>
            <?php endforeach; ?>
          </div>
          
          <!-- Cart Summary -->
          <div style="background: white; border-radius: 8px; padding: 2rem; max-width: 400px; margin-left: auto;">
            <h3 style="color: #2a2a2a; margin-bottom: 1rem; font-size: 1.5rem;">Order Summary</h3>
            <div style="border-top: 1px solid #f0f0f0; padding-top: 1rem;">
              <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                <span style="color: #666;">Subtotal:</span>
                <span style="color: #2a2a2a; font-weight: 600;">₹<?php echo number_format($cartTotal, 2); ?></span>
              </div>
              <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                <span style="color: #666;">Shipping:</span>
                <span style="color: #2a2a2a;">Free</span>
              </div>
              <div style="display: flex; justify-content: space-between; padding-top: 1rem; border-top: 2px solid #d4af37; margin-bottom: 2rem;">
                <span style="color: #2a2a2a; font-weight: 600; font-size: 1.2rem;">Total:</span>
                <span style="color: #d4af37; font-weight: 700; font-size: 1.3rem;">₹<?php echo number_format($cartTotal, 2); ?></span>
              </div>
              <button class="btn btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem; margin-bottom: 1rem;" onclick="alert('Checkout functionality coming soon!')">Proceed to Checkout</button>
              <a href="index.php" style="display: block; text-align: center; color: #666; text-decoration: none; padding: 0.5rem;">Continue Shopping</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </section>

<?php include 'includes/footer.php'; ?>
