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
          
          <!-- Cart Summary & Checkout -->
          <div style="background: white; border-radius: 12px; padding: 28px; max-width: 420px; margin-left: auto; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
            <h3 style="color: #2a2a2a; margin-bottom: 20px; font-size: 1.5rem; letter-spacing: 1px;">📋 Order Summary</h3>
            
            <!-- Price Breakdown -->
            <div style="background: #f7f5f2; padding: 16px; border-radius: 8px; margin-bottom: 20px;">
              <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #666;">Subtotal:</span>
                <span style="color: #2a2a2a; font-weight: 600;">₹<?php echo number_format($cartTotal, 2); ?></span>
              </div>
              <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #666;">Shipping:</span>
                <span style="color: #2e7d32; font-weight: 600;">FREE ✓</span>
              </div>
              <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                <span style="color: #666;">Tax (est.):</span>
                <span style="color: #2a2a2a;">₹<?php echo number_format($cartTotal * 0.18, 2); ?></span>
              </div>
              <div style="border-top: 2px solid #e6e2dc; padding-top: 12px; display: flex; justify-content: space-between;">
                <span style="color: #2a2a2a; font-weight: 700; font-size: 1.1rem;">Total:</span>
                <span style="color: #d4af37; font-weight: 700; font-size: 1.2rem;">₹<?php echo number_format($cartTotal * 1.18, 2); ?></span>
              </div>
            </div>

            <!-- Shipping Options -->
            <div style="margin-bottom: 20px;">
              <label style="display: block; font-size: 13px; color: #7b776f; margin-bottom: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Shipping Option</label>
              <select style="width: 100%; padding: 10px 12px; border: 1px solid #e6e2dc; border-radius: 6px; font-size: 13px; background: white;">
                <option value="standard">🚚 Standard (5-7 days) - FREE</option>
                <option value="express">⚡ Express (2-3 days) - ₹99</option>
                <option value="overnight">🏃 Overnight - ₹299</option>
              </select>
            </div>

            <!-- Payment Methods -->
            <div style="margin-bottom: 20px;">
              <label style="display: block; font-size: 13px; color: #7b776f; margin-bottom: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Payment Method</label>
              <div style="display: grid; gap: 8px;">
                <label style="display: flex; align-items: center; padding: 10px 12px; border: 2px solid #d4af37; border-radius: 6px; cursor: pointer; background: #faf8f5;">
                  <input type="radio" name="payment" value="card" checked style="margin-right: 8px;" />
                  <span style="font-size: 13px;">💳 Credit/Debit Card</span>
                </label>
                <label style="display: flex; align-items: center; padding: 10px 12px; border: 1px solid #e6e2dc; border-radius: 6px; cursor: pointer;">
                  <input type="radio" name="payment" value="upi" style="margin-right: 8px;" />
                  <span style="font-size: 13px;">📱 UPI</span>
                </label>
                <label style="display: flex; align-items: center; padding: 10px 12px; border: 1px solid #e6e2dc; border-radius: 6px; cursor: pointer;">
                  <input type="radio" name="payment" value="cod" style="margin-right: 8px;" />
                  <span style="font-size: 13px;">🚚 Cash on Delivery</span>
                </label>
              </div>
            </div>

            <!-- Promo Code -->
            <div style="margin-bottom: 20px;">
              <div style="display: flex; gap: 8px;">
                <input type="text" placeholder="Enter promo code" style="flex: 1; padding: 10px 12px; border: 1px solid #e6e2dc; border-radius: 6px; font-size: 13px;" />
                <button type="button" style="padding: 10px 16px; background: #e6e2dc; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600;">Apply</button>
              </div>
            </div>

            <!-- Checkout Button -->
            <button class="btn btn-primary" style="width: 100%; padding: 14px; font-size: 15px; margin-bottom: 12px; font-weight: 700; border: none; border-radius: 8px; background: linear-gradient(90deg, #d4af37, #e8c851); color: #2a2a2a; cursor: pointer; transition: opacity 0.3s;" onclick="proceedCheckout()">Proceed to Checkout</button>
            
            <!-- Continue Shopping -->
            <a href="index.php" style="display: block; text-align: center; color: #d4af37; text-decoration: none; padding: 10px; font-weight: 600; font-size: 13px;">← Continue Shopping</a>

            <!-- Trust Badge -->
            <div style="margin-top: 20px; padding: 12px; background: #f7f5f2; border-radius: 6px; text-align: center; border-left: 3px solid #d4af37;">
              <p style="font-size: 12px; color: #666; margin: 0;">✓ Secure Payment | ✓ 100% Authentic | ✓ 7-Day Returns</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <script>
      function proceedCheckout() {
        const paymentMethod = document.querySelector('input[name="payment"]:checked');
        if (!paymentMethod) {
          alert('Please select a payment method');
          return;
        }
        
        const selectedPayment = paymentMethod.value;
        alert('Processing ' + selectedPayment.toUpperCase() + ' payment...\n\nCheckout feature coming soon!');
        
        // Future: Redirect to payment gateway
        // window.location.href = 'checkout.php?method=' + selectedPayment;
      }
    </script>

<?php include 'includes/footer.php'; ?>
