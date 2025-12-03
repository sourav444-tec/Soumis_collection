<?php
if (session_status() === PHP_SESSION_NONE) {
  @session_start();
}
$isAdmin = !empty($_SESSION['is_admin']);
?>
    <nav class="navbar">
      <div class="nav-container">
        <div class="logo">SOUMIS COLLECTIONS</div>
        <ul class="nav-menu">
          <li><a href="index.php">Home</a></li>
          <li><a href="#products">Products</a></li>
          <li><a href="#earrings">Earrings</a></li>
          <li><a href="#collections">Collections</a></li>
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
          <a href="login.php" aria-label="Account">
            <svg viewBox="0 0 24 24" role="img" aria-hidden="true">
              <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5z" />
            </svg>
          </a>
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
