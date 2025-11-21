<?php
$pageTitle = 'Soumis Collections — Login';
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
        <a href="index.php#products">Products</a>
      </nav>
    </div>
  </header>

  <main class="auth-main">
    <div class="auth-card">
      <h1>Welcome back</h1>
      <p class="muted">Sign in to continue to Soumis Collections</p>

      <form class="auth-form" action="process-login.php" method="post">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required placeholder="you@example.com" />

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required placeholder="Enter your password" />

        <div class="form-row">
          <label class="remember">
            <input type="checkbox" name="remember"> Remember me
          </label>
          <a class="forgot" href="#">Forgot?</a>
        </div>

        <button class="btn-primary" type="submit">Sign In</button>

        <div class="divider"><span>or</span></div>

        <div class="socials">
          <button class="btn-social btn-google" type="button">Continue with Google</button>
          <button class="btn-social btn-apple" type="button">Continue with Apple</button>
        </div>

        <p class="signup">Don't have an account? <a href="signup.php">Create account</a></p>
      </form>
    </div>
  </main>

  <footer class="auth-footer">
    <p>&copy; <?php echo date('Y'); ?> Soumis Collections</p>
  </footer>
</body>
</html>
