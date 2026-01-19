<?php
session_start();
// If already authenticated, redirect away from login (placeholder logic)
if (isset($_SESSION['user_id'])) {
  header('Location: index.php');
  exit;
}
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
  <style>
    /* Admin mode visual effects */
    #admin-banner {display:none;background:linear-gradient(135deg,#d4af37,#f0c850);color:#2a2a2a;padding:10px 14px;border-radius:10px;font-size:12px;letter-spacing:1px;font-weight:600;margin-bottom:14px;animation:pulseGold 1.6s infinite}
    .auth-card.admin-active {box-shadow:0 0 0 3px rgba(212,175,55,0.6),0 20px 40px rgba(22,22,22,0.08);position:relative}
    .auth-card.admin-active::after {content:'ADMIN MODE';position:absolute;top:-10px;right:12px;background:#2a2a2a;color:#d4af37;font-size:10px;padding:4px 8px;border-radius:6px;letter-spacing:1px}
    @keyframes pulseGold {0%{box-shadow:0 0 0 0 rgba(212,175,55,0.6)}70%{box-shadow:0 0 0 10px rgba(212,175,55,0)}100%{box-shadow:0 0 0 0 rgba(212,175,55,0)}}
    #admin-mode-btn.admin-on {filter:brightness(1.05);transform:translateY(-2px);}
    #admin-mode-btn {transition:all .25s ease}
  </style>
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
    <div class="auth-card" id="auth-card" style="max-width:520px;">
      <?php
      $adminDenied = isset($_GET['admin']) && $_GET['admin']==='denied';
      $error       = isset($_GET['error']);
      ?>
      <h1 id="login-title">Welcome back</h1>
      <p class="muted" id="login-sub">Sign in to continue to Soumis Collections</p>
      <div id="admin-banner">Admin mode enabled – you will be redirected to dashboard after login.</div>
      <?php if ($adminDenied): ?>
        <div style="background:#ffe8e2;color:#b8432e;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:12px">Admin access denied for this email.</div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div style="background:#ffe8e2;color:#b8432e;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:12px">Invalid credentials (demo requires non-empty fields).</div>
      <?php endif; ?>

      <!-- Password Login Form -->
      <form class="auth-form" id="password-form" action="process-login.php" method="post">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required placeholder="you@example.com" />
        <label for="password">Password</label>
        <div class="password-wrapper">
          <input id="password" name="password" type="password" required placeholder="Enter your password" />
          <button type="button" class="password-toggle-btn" id="password-toggle" title="Show/hide password">👁️</button>
        </div>
        <div class="form-row">
          <label class="remember">
            <input type="checkbox" name="remember"> Remember me
          </label>
          <a class="forgot" href="forgot-password.php">Forgot password?</a>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px">
          <button class="btn-primary" type="submit">Sign In</button>
          <button type="button" id="admin-mode-btn" class="btn btn-primary" style="padding:1rem 1.5rem;font-size:.8rem">Admin Login</button>
        </div>
        <div class="divider"><span>or</span></div>
        <div class="socials">
          <button class="btn-social btn-google" type="button">Continue with Google</button>
          <button class="btn-social btn-apple" type="button">Continue with Apple</button>
        </div>
        <p style="margin-top:18px;font-size:13px">Prefer a one-time code? <a href="#" id="show-otp">Use OTP login</a></p>
        <p class="signup">New here? <a href="signup.php">Create an account</a></p>
        <input type="hidden" name="admin" id="admin-flag" value="0" />
      </form>
  <input type="hidden" name="admin" value="0" />

      <!-- OTP Login Form -->
      <form class="auth-form" id="otp-form" action="process-otp-login.php" method="post" style="display:none">
        <label for="otp_email">Email</label>
        <input id="otp_email" name="email" type="email" required placeholder="you@example.com" />
        
        <!-- OTP Status Messages -->
        <div id="otp-status" style="margin-top:10px;font-size:13px;padding:12px;border-radius:6px;display:none">
          <span id="otp-status-text"></span>
        </div>

        <div style="display:flex;align-items:flex-end;gap:8px;margin-top:12px">
          <div style="flex:1">
            <label for="otp_code">OTP Code</label>
            <input id="otp_code" name="otp" type="text" pattern="[0-9]{6}" inputmode="numeric" required placeholder="6-digit code" maxlength="6" />
            <small style="color:#999;font-size:12px;display:block;margin-top:4px">Enter the 6-digit code sent to your email</small>
          </div>
          <button type="button" id="request-otp" class="btn-social" style="white-space:nowrap;cursor:pointer">📧 Send OTP</button>
        </div>

        <button class="btn-primary" type="submit" style="margin-top:16px">Login with OTP</button>
        
        <p style="margin-top:18px;font-size:13px">Have your password? <a href="#" id="show-password">Use password login</a></p>
        <p class="signup">New here? <a href="signup.php">Create an account</a></p>
      </form>
    </div>
  </main>
  <script>
  (function(){
    const passwordForm = document.getElementById('password-form');
    const otpForm = document.getElementById('otp-form');
    const showOtp = document.getElementById('show-otp');
    const showPassword = document.getElementById('show-password');
    const requestOtpBtn = document.getElementById('request-otp');
    const otpStatus = document.getElementById('otp-status');
    const title = document.getElementById('login-title');
    const sub = document.getElementById('login-sub');
    function swap(toOtp){
      if(toOtp){
        passwordForm.style.display='none';
        otpForm.style.display='block';
        title.textContent='OTP Login';
        sub.textContent='Use a one-time passcode sent to your email.';
      } else {
        otpForm.style.display='none';
        passwordForm.style.display='block';
        title.textContent='Welcome back';
        sub.textContent='Sign in to continue to Soumis Collections';
      }
    }
    showOtp && showOtp.addEventListener('click',e=>{e.preventDefault();swap(true);});
    showPassword && showPassword.addEventListener('click',e=>{e.preventDefault();swap(false);});
    requestOtpBtn && requestOtpBtn.addEventListener('click',async ()=>{
      const statusDiv = document.getElementById('otp-status');
      const statusText = document.getElementById('otp-status-text');
      const emailInput = document.getElementById('otp_email');
      const email = emailInput.value.trim();
      
      // Validate email
      if(!email){
        statusDiv.style.display='block';
        statusDiv.style.background='#ffebee';
        statusDiv.style.color='#c62828';
        statusDiv.style.border='1px solid #ffcdd2';
        statusText.textContent='❌ Please enter your email address';
        return;
      }
      
      // Validate email format
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if(!emailRegex.test(email)){
        statusDiv.style.display='block';
        statusDiv.style.background='#ffebee';
        statusDiv.style.color='#c62828';
        statusDiv.style.border='1px solid #ffcdd2';
        statusText.textContent='❌ Please enter a valid email address';
        return;
      }

      statusDiv.style.display='block';
      statusDiv.style.background='#fff3cd';
      statusDiv.style.color='#856404';
      statusDiv.style.border='1px solid #ffeaa7';
      statusText.textContent='⏳ Sending OTP to ' + email + '...';
      
      try {
        const response = await fetch('process-otp-request.php',{
          method:'POST',
          headers:{'Content-Type':'application/x-www-form-urlencoded'},
          body:'email='+encodeURIComponent(email)
        });
        const data = await response.json();
        
        if(data.status==='ok'){
          statusDiv.style.background='#e8f5e9';
          statusDiv.style.color='#2e7d32';
          statusDiv.style.border='1px solid #c8e6c9';
          statusText.innerHTML='✓ OTP sent successfully!<br><small style="font-size:11px;margin-top:4px;display:block">Check your email for the 6-digit code. It will expire in 10 minutes.</small>';
          emailInput.disabled = true;
          requestOtpBtn.disabled = true;
          requestOtpBtn.style.opacity = '0.5';
        } else {
          statusDiv.style.background='#ffebee';
          statusDiv.style.color='#c62828';
          statusDiv.style.border='1px solid #ffcdd2';
          statusText.textContent='❌ ' + (data.message || 'Failed to send OTP');
        }
      } catch(err){
        statusDiv.style.background='#ffebee';
        statusDiv.style.color='#c62828';
        statusDiv.style.border='1px solid #ffcdd2';
        statusText.textContent='❌ Network error. Please try again.';
      }
    });
    // Admin mode toggle
    const adminBtn = document.getElementById('admin-mode-btn');
    const adminFlag = document.getElementById('admin-flag');
    const adminBanner = document.getElementById('admin-banner');
    const authCard = document.getElementById('auth-card');
    function setAdminUI(active){
      adminFlag.value = active ? '1' : '0';
      adminBtn.textContent = active ? 'Admin Mode On' : 'Admin Login';
      adminBtn.classList.toggle('admin-on', active);
      adminBanner.style.display = active ? 'block' : 'none';
      authCard.classList.toggle('admin-active', active);
    }
    adminBtn && adminBtn.addEventListener('click',()=>{
      const active = adminFlag.value !== '1';
      setAdminUI(active);
    });
    // If denied parameter present, ensure UI shows off state
    if (<?php echo $adminDenied ? 'true':'false'; ?>){ setAdminUI(false); }
    
    // Password visibility toggle
    const passwordToggle = document.getElementById('password-toggle');
    const passwordInput = document.getElementById('password');
    if (passwordToggle && passwordInput) {
      passwordToggle.addEventListener('click', (e) => {
        e.preventDefault();
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        passwordToggle.textContent = isPassword ? '👁️‍🗨️' : '👁️';
      });
    }
  })();
  </script>

  <footer class="auth-footer">
    <p>&copy; <?php echo date('Y'); ?> Soumis Collections</p>
  </footer>
</body>
</html>
