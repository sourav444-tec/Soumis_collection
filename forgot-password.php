<?php
session_start();
// If logged in, redirect away – no need to reset
if (isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit;
}
$pageTitle = 'Soumis Collections — Forgot Password';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $pageTitle; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <header class="auth-header">
    <div class="auth-container">
      <div class="logo">SOUMIS COLLECTIONS</div>
      <nav class="auth-nav">
        <a href="index.php">Home</a>
        <a href="login.php">Sign In</a>
      </nav>
    </div>
  </header>
  <main class="auth-main">
    <div class="auth-card" style="max-width:460px;">
      <h1>Forgot password</h1>
      <p class="muted">Enter your email to receive a reset link.</p>
      <?php if (isset($_GET['status']) && $_GET['status']==='sent'): ?>
        <p style="color:green;font-size:14px">If the email exists, a reset link was generated (demo).</p>
      <?php endif; ?>
      <form class="auth-form" action="process-forgot.php" method="post">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required placeholder="you@example.com" />
        <button class="btn-primary" type="submit" style="margin-top:16px">Send Reset Link</button>
        <p class="signup" style="margin-top:18px">Remembered password? <a href="login.php">Sign In</a></p>
      </form>
    </div>
  </main>
  <footer class="auth-footer">
    <p>&copy; <?php echo date('Y'); ?> Soumis Collections</p>
  </footer>
</body>
</html>
