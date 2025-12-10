<?php
session_start();
// Block access if user already authenticated
if (isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit;
}
$pageTitle = 'Soumis Collections — Create Account';
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
      <h1>Create account</h1>
      <p class="muted">Join Soumis Collections for exclusive updates</p>
      <form class="auth-form" action="process-signup.php" method="post">
        <label for="first_name">First Name</label>
        <input id="first_name" name="first_name" type="text" required placeholder="First name" />
        <label for="last_name">Last Name</label>
        <input id="last_name" name="last_name" type="text" required placeholder="Last name" />
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required placeholder="you@example.com" />
        <label for="password">Password</label>
        <div class="password-wrapper">
          <input id="password" name="password" type="password" required placeholder="Create a password" />
          <button type="button" class="password-toggle-btn" id="password-toggle" title="Show/hide password">👁️</button>
        </div>
        <label for="password_confirm">Confirm Password</label>
        <div class="password-wrapper">
          <input id="password_confirm" name="password_confirm" type="password" required placeholder="Repeat password" />
          <button type="button" class="password-toggle-btn" id="password-confirm-toggle" title="Show/hide password">👁️</button>
        </div>
        <div style="margin-top:12px;font-size:12px;color:#7b776f;line-height:1.4">By creating an account you agree to our <a href="#" style="color:var(--accent);text-decoration:none">Terms</a> &amp; <a href="#" style="color:var(--accent);text-decoration:none">Privacy</a>.</div>
        <button class="btn-primary" type="submit" style="margin-top:16px">Create Account</button>
        <p class="signup" style="margin-top:18px">Already have an account? <a href="login.php">Sign In</a></p>
      </form>
    </div>
  </main>

  <footer class="auth-footer">
    <p>&copy; <?php echo date('Y'); ?> Soumis Collections</p>
  </footer>

  <script>
    // Password visibility toggle
    document.addEventListener('DOMContentLoaded', () => {
      const passwordToggle = document.getElementById('password-toggle');
      const passwordInput = document.getElementById('password');
      const passwordConfirmToggle = document.getElementById('password-confirm-toggle');
      const passwordConfirmInput = document.getElementById('password_confirm');

      if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener('click', (e) => {
          e.preventDefault();
          const isPassword = passwordInput.type === 'password';
          passwordInput.type = isPassword ? 'text' : 'password';
          passwordToggle.textContent = isPassword ? '👁️‍🗨️' : '👁️';
        });
      }

      if (passwordConfirmToggle && passwordConfirmInput) {
        passwordConfirmToggle.addEventListener('click', (e) => {
          e.preventDefault();
          const isPassword = passwordConfirmInput.type === 'password';
          passwordConfirmInput.type = isPassword ? 'text' : 'password';
          passwordConfirmToggle.textContent = isPassword ? '👁️‍🗨️' : '👁️';
        });
      }
    });
  </script>
