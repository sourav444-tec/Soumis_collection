<?php
if (session_status() === PHP_SESSION_NONE) {
  @session_start();
}
$isAdmin = !empty($_SESSION['is_admin']);
$isLoggedIn = !empty($_SESSION['user_id']);
$userEmail = $_SESSION['user_email'] ?? '';
?>
    <nav class="navbar">
      <div class="nav-container">
        <div class="logo">SOUMIS COLLECTIONS</div>
        <ul class="nav-menu">
          <li><a href="index.php">Home</a></li>
          <li><a href="products.php">All Products</a></li>
          <li><a href="new-arrivals.php">New Arrivals</a></li>
          <li><a href="wholesale.php">Wholesale</a></li>
          <?php if ($isAdmin): ?>
            <li><a href="admin/index.php">Admin</a></li>
          <?php endif; ?>
        </ul>
        <div class="nav-icons">
          <a href="search.php" aria-label="Search">
            <svg viewBox="0 0 24 24" role="img" aria-hidden="true">
              <path d="M15.5 14h-.79l-.28-.27a6 6 0 1 0-.71.71l.27.28v.79l5 5 1.5-1.5-5-5zm-5.5 0a4 4 0 1 1 0-8 4 4 0 0 1 0 8z" />
            </svg>
          </a>
          
          <!-- User Account Icon with Dropdown -->
          <div class="user-menu-container" style="position: relative; display: inline-block;">
            <button id="user-icon-btn" aria-label="Account" style="background: none; border: none; cursor: pointer; padding: 8px; display: flex; align-items: center;">
              <svg viewBox="0 0 24 24" role="img" aria-hidden="true">
                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5z" />
              </svg>
            </button>
            
            <!-- Dropdown Menu -->
            <div id="user-dropdown" style="display: none; position: absolute; right: 0; top: 100%; background: white; border: 1px solid #e6e2dc; border-radius: 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); min-width: 200px; z-index: 1000; margin-top: 8px;">
              <?php if ($isLoggedIn): ?>
                <!-- Logged In Menu -->
                <div style="padding: 12px 16px; border-bottom: 1px solid #f0f0f0;">
                  <p style="margin: 0; font-size: 12px; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Logged in as</p>
                  <p style="margin: 4px 0 0 0; font-size: 13px; color: #2a2a2a; font-weight: 600; word-break: break-all;"><?php echo htmlspecialchars($userEmail); ?></p>
                </div>
                <a href="profile.php" style="display: block; padding: 12px 16px; color: #2a2a2a; text-decoration: none; font-size: 13px; border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">👤 My Profile</a>
                <a href="orders.php" style="display: block; padding: 12px 16px; color: #2a2a2a; text-decoration: none; font-size: 13px; border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">📦 My Orders</a>
                <a href="wishlist.php" style="display: block; padding: 12px 16px; color: #2a2a2a; text-decoration: none; font-size: 13px; border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">❤️ Wishlist</a>
                <a href="settings.php" style="display: block; padding: 12px 16px; color: #2a2a2a; text-decoration: none; font-size: 13px; border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">⚙️ Settings</a>
                <a href="admin/logout.php" style="display: block; padding: 12px 16px; color: #e74c3c; text-decoration: none; font-size: 13px; font-weight: 600; transition: background 0.2s;">🚪 Logout</a>
              <?php else: ?>
                <!-- Not Logged In Menu -->
                <a href="login.php" style="display: block; padding: 12px 16px; color: #d4af37; text-decoration: none; font-size: 13px; font-weight: 600; border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">🔑 Sign In</a>
                <a href="signup.php" style="display: block; padding: 12px 16px; color: #2a2a2a; text-decoration: none; font-size: 13px; border-bottom: 1px solid #f0f0f0; transition: background 0.2s;">📝 Create Account</a>
                <div style="padding: 12px 16px; background: #f7f5f2; border-radius: 0 0 8px 8px;">
                  <p style="margin: 0; font-size: 12px; color: #999;">Sign in to your account to view orders and manage wishlist.</p>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <a href="cart.php" aria-label="Cart" style="position: relative;">
            <svg viewBox="0 0 24 24" role="img" aria-hidden="true">
              <path d="M7 4h-2l-1 2v2h2l3.6 7.59-1.35 2.45A1 1 0 0 0 9.2 19h11v-2H10l.1-.18L11.55 14h7.9a1 1 0 0 0 .95-.68l2.5-7.32A1 1 0 0 0 21 4H7zm2 16a2 2 0 1 0 2 2 2 2 0 0 0-2-2zm10 0a2 2 0 1 0 2 2 2 2 0 0 0-2-2z" />
            </svg>
            <?php 
            $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
            if ($cartCount > 0): 
            ?>
              <span style="position: absolute; top: -5px; right: -8px; background: #d4af37; color: #2a2a2a; font-size: 0.7rem; font-weight: 600; padding: 2px 6px; border-radius: 10px; min-width: 18px; text-align: center;"><?php echo $cartCount; ?></span>
            <?php endif; ?>
          </a>
        </div>
      </div>
    </nav>

    <script>
      // User menu dropdown toggle
      const userIconBtn = document.getElementById('user-icon-btn');
      const userDropdown = document.getElementById('user-dropdown');

      if (userIconBtn && userDropdown) {
        userIconBtn.addEventListener('click', (e) => {
          e.preventDefault();
          userDropdown.style.display = userDropdown.style.display === 'none' ? 'block' : 'none';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
          if (!e.target.closest('.user-menu-container')) {
            userDropdown.style.display = 'none';
          }
        });
      }
    </script>
