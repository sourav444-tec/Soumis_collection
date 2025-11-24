<?php
session_start();
if (isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit;
}
$token = $_GET['token'] ?? '';
$tokenPath = __DIR__ . DIRECTORY_SEPARATOR . 'tokens' . DIRECTORY_SEPARATOR . basename($token) . '.txt';
$valid = $token && is_file($tokenPath);
$pageTitle = 'Soumis Collections — Reset Password';
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
    <?php if ($valid): ?>
      <h1>Reset password</h1>
      <p class="muted">Enter a new password for your account.</p>
      <form class="auth-form" action="process-reset.php" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token, ENT_QUOTES); ?>" />
        <label for="password">New Password</label>
        <input id="password" name="password" type="password" required placeholder="New password" />
        <label for="password_confirm">Confirm Password</label>
        <input id="password_confirm" name="password_confirm" type="password" required placeholder="Repeat password" />
        <button class="btn-primary" type="submit" style="margin-top:16px">Set New Password</button>
      </form>
    <?php else: ?>
      <h1>Invalid or expired link</h1>
      <p class="muted">Request a new password reset.</p>
      <p><a href="forgot-password.php">Return to Forgot Password</a></p>
    <?php endif; ?>
  </div>
</main>
<footer class="auth-footer">
  <p>&copy; <?php echo date('Y'); ?> Soumis Collections</p>
</footer>
</body>
</html>
