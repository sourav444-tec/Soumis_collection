<?php
if (session_status() === PHP_SESSION_NONE) {
  @session_start();
}

// Redirect if not logged in
if (empty($_SESSION['user_id'])) {
  header('Location: login.php?redirect=settings');
  exit;
}

$pageTitle = 'Settings - Soumis Collections';
include 'includes/header.php';
include 'includes/nav.php';

$userEmail = $_SESSION['user_email'] ?? 'user@example.com';

// Initialize settings in session
if (!isset($_SESSION['settings'])) {
  $_SESSION['settings'] = [
    'newsletter' => true,
    'order_updates' => true,
    'promotions' => false,
    'language' => 'English',
    'theme' => 'light',
    'currency' => 'INR',
    'two_factor' => false
  ];
}

$settings = $_SESSION['settings'];
$successMessage = '';

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update_notifications'])) {
    $_SESSION['settings']['newsletter'] = isset($_POST['newsletter']);
    $_SESSION['settings']['order_updates'] = isset($_POST['order_updates']);
    $_SESSION['settings']['promotions'] = isset($_POST['promotions']);
    $successMessage = "Notification preferences updated!";
  } elseif (isset($_POST['update_preferences'])) {
    $_SESSION['settings']['language'] = htmlspecialchars($_POST['language']);
    $_SESSION['settings']['theme'] = htmlspecialchars($_POST['theme']);
    $_SESSION['settings']['currency'] = htmlspecialchars($_POST['currency']);
    $successMessage = "Preferences updated! Theme changes will apply instantly.";
    
    // Apply theme change
    if ($_SESSION['settings']['theme'] === 'dark') {
      echo "<script>localStorage.setItem('theme', 'dark'); location.reload();</script>";
    } else {
      echo "<script>localStorage.setItem('theme', 'light'); location.reload();</script>";
    }
  } elseif (isset($_POST['update_security'])) {
    $_SESSION['settings']['two_factor'] = isset($_POST['two_factor']);
    $successMessage = "Security settings updated!";
  }
  $settings = $_SESSION['settings'];
}
?>

<style>
  .settings-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 0 20px;
  }

  .settings-header {
    background: linear-gradient(135deg, #d4af37 0%, #e8c851 100%);
    padding: 40px;
    border-radius: 12px;
    color: #2a2a2a;
    margin-bottom: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  }

  .settings-header h1 {
    margin: 0 0 10px 0;
    font-size: 32px;
    letter-spacing: 1px;
  }

  .settings-header p {
    margin: 5px 0;
    font-size: 14px;
    opacity: 0.9;
  }

  .settings-section {
    background: white;
    border: 1px solid #e6e2dc;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
  }

  .section-title {
    font-size: 20px;
    color: #2a2a2a;
    margin: 0 0 20px 0;
    padding-bottom: 15px;
    border-bottom: 2px solid #d4af37;
    letter-spacing: 1px;
  }

  .setting-group {
    margin-bottom: 25px;
  }

  .setting-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #f0f0f0;
  }

  .setting-item:last-child {
    border-bottom: none;
  }

  .setting-label {
    flex: 1;
  }

  .setting-name {
    font-size: 14px;
    color: #2a2a2a;
    font-weight: 600;
    margin-bottom: 4px;
  }

  .setting-description {
    font-size: 12px;
    color: #7b776f;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    font-size: 12px;
    color: #7b776f;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
  }

  .form-group input[type="text"],
  .form-group select {
    width: 100%;
    padding: 12px;
    border: 1px solid #e6e2dc;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    background: #f7f5f2;
  }

  .form-group input:focus,
  .form-group select:focus {
    outline: none;
    border-color: #d4af37;
    background: white;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
  }

  .checkbox-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .checkbox-wrapper input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: #d4af37;
  }

  .toggle-switch {
    position: relative;
    width: 50px;
    height: 28px;
    background: #e6e2dc;
    border-radius: 14px;
    cursor: pointer;
    transition: background 0.3s;
  }

  .toggle-switch input {
    display: none;
  }

  .toggle-switch input:checked + .toggle-slider {
    background: #d4af37;
  }

  .toggle-switch input:checked + .toggle-slider:before {
    transform: translateX(22px);
  }

  .toggle-slider {
    position: absolute;
    top: 2px;
    left: 2px;
    bottom: 2px;
    width: 24px;
    background: white;
    border-radius: 12px;
    transition: all 0.3s;
  }

  .toggle-slider:before {
    content: '';
    position: absolute;
    height: 20px;
    width: 20px;
    left: 2px;
    bottom: 2px;
    background: white;
    border-radius: 50%;
    transition: 0.3s;
  }

  .save-btn {
    background: linear-gradient(90deg, #d4af37, #e8c851);
    color: #2a2a2a;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: opacity 0.3s;
  }

  .save-btn:hover {
    opacity: 0.9;
  }

  .alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    border-left: 4px solid;
  }

  .alert.success {
    background: #d4edda;
    color: #155724;
    border-color: #28a745;
  }

  .info-box {
    background: #d1ecf1;
    color: #0c5460;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #17a2b8;
    margin-top: 15px;
    font-size: 13px;
  }

  @media (max-width: 768px) {
    .settings-header {
      padding: 30px;
    }

    .settings-header h1 {
      font-size: 24px;
    }

    .setting-item {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
    }
  }
</style>

<div class="settings-container">
  <div class="settings-header">
    <h1>⚙️ Settings</h1>
    <p><?php echo htmlspecialchars($userEmail); ?></p>
  </div>

  <?php if ($successMessage): ?>
    <div class="alert success">✓ <?php echo $successMessage; ?></div>
  <?php endif; ?>

  <!-- Notification Settings -->
  <div class="settings-section">
    <h2 class="section-title">🔔 Notification Preferences</h2>
    <form method="POST">
      <div class="setting-group">
        <div class="setting-item">
          <div class="setting-label">
            <div class="setting-name">Newsletter</div>
            <div class="setting-description">Receive our weekly newsletter with new collections</div>
          </div>
          <div class="checkbox-wrapper">
            <input type="checkbox" id="newsletter" name="newsletter" <?php echo $settings['newsletter'] ? 'checked' : ''; ?>>
            <label for="newsletter" style="margin: 0; text-transform: none; text-transform: none; font-weight: normal; color: #2a2a2a;">Enabled</label>
          </div>
        </div>

        <div class="setting-item">
          <div class="setting-label">
            <div class="setting-name">Order Updates</div>
            <div class="setting-description">Get notified about your order status</div>
          </div>
          <div class="checkbox-wrapper">
            <input type="checkbox" id="order_updates" name="order_updates" <?php echo $settings['order_updates'] ? 'checked' : ''; ?>>
            <label for="order_updates" style="margin: 0; text-transform: none; font-weight: normal; color: #2a2a2a;">Enabled</label>
          </div>
        </div>

        <div class="setting-item">
          <div class="setting-label">
            <div class="setting-name">Promotional Offers</div>
            <div class="setting-description">Receive exclusive deals and discounts</div>
          </div>
          <div class="checkbox-wrapper">
            <input type="checkbox" id="promotions" name="promotions" <?php echo $settings['promotions'] ? 'checked' : ''; ?>>
            <label for="promotions" style="margin: 0; text-transform: none; font-weight: normal; color: #2a2a2a;">Enabled</label>
          </div>
        </div>
      </div>
      <button type="submit" name="update_notifications" class="save-btn">💾 Save Preferences</button>
    </form>
  </div>

  <!-- General Preferences -->
  <div class="settings-section">
    <h2 class="section-title">🎨 General Preferences</h2>
    <form method="POST">
      <div class="form-group">
        <label for="language">Language</label>
        <select id="language" name="language">
          <option value="English" <?php echo $settings['language'] === 'English' ? 'selected' : ''; ?>>🇬🇧 English</option>
          <option value="Bengali" <?php echo $settings['language'] === 'Bengali' ? 'selected' : ''; ?>>🇧🇩 Bengali (বাংলা)</option>
          <option value="Hindi" <?php echo $settings['language'] === 'Hindi' ? 'selected' : ''; ?>>🇮🇳 Hindi (हिंदी)</option>
          <option value="Gujarati" <?php echo $settings['language'] === 'Gujarati' ? 'selected' : ''; ?>>🇮🇳 Gujarati (ગુજરાતી)</option>
          <option value="Tamil" <?php echo $settings['language'] === 'Tamil' ? 'selected' : ''; ?>>🇮🇳 Tamil (தமிழ்)</option>
        </select>
      </div>

      <div class="form-group">
        <label for="currency">Currency</label>
        <select id="currency" name="currency">
          <option value="INR" <?php echo $settings['currency'] === 'INR' ? 'selected' : ''; ?>>₹ Indian Rupee (INR)</option>
          <option value="USD" <?php echo $settings['currency'] === 'USD' ? 'selected' : ''; ?>>$ US Dollar (USD)</option>
          <option value="EUR" <?php echo $settings['currency'] === 'EUR' ? 'selected' : ''; ?>>€ Euro (EUR)</option>
          <option value="GBP" <?php echo $settings['currency'] === 'GBP' ? 'selected' : ''; ?>>£ British Pound (GBP)</option>
        </select>
      </div>

      <div class="form-group">
        <label for="theme">Theme</label>
        <select id="theme" name="theme">
          <option value="light" <?php echo $settings['theme'] === 'light' ? 'selected' : ''; ?>>☀️ Light Mode</option>
          <option value="dark" <?php echo $settings['theme'] === 'dark' ? 'selected' : ''; ?>>🌙 Dark Mode</option>
          <option value="auto" <?php echo $settings['theme'] === 'auto' ? 'selected' : ''; ?>>⚙️ Auto (System)</option>
        </select>
        <div class="info-box" style="margin-top: 12px;">
          ℹ️ Dark mode reduces eye strain and saves battery life. Changes apply instantly across the website.
        </div>
      </div>

      <button type="submit" name="update_preferences" class="save-btn">💾 Save Preferences</button>
    </form>
  </div>

  <!-- Security Settings -->
  <div class="settings-section">
    <h2 class="section-title">🔒 Security</h2>
    <form method="POST">
      <div class="setting-group">
        <div class="setting-item">
          <div class="setting-label">
            <div class="setting-name">Two-Factor Authentication (2FA)</div>
            <div class="setting-description">Add an extra layer of security to your account</div>
          </div>
          <div class="checkbox-wrapper">
            <input type="checkbox" id="two_factor" name="two_factor" <?php echo $settings['two_factor'] ? 'checked' : ''; ?>>
            <label for="two_factor" style="margin: 0; text-transform: none; font-weight: normal; color: #2a2a2a;">Enabled</label>
          </div>
        </div>
      </div>
      <button type="submit" name="update_security" class="save-btn">💾 Save Settings</button>
      
      <div class="info-box">
        ℹ️ Two-factor authentication adds an extra verification step when you sign in. You'll need to verify your identity using an authenticator app.
      </div>
    </form>
  </div>

  <!-- Privacy Settings -->
  <div class="settings-section">
    <h2 class="section-title">🔐 Privacy</h2>
    <div class="setting-group">
      <div class="setting-item">
        <div class="setting-label">
          <div class="setting-name">Data & Privacy</div>
          <div class="setting-description">View and manage your personal data</div>
        </div>
        <button onclick="alert('Data privacy management feature coming soon')" style="background: #e6e2dc; color: #2a2a2a; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 13px;">Manage →</button>
      </div>

      <div class="setting-item">
        <div class="setting-label">
          <div class="setting-name">Download Your Data</div>
          <div class="setting-description">Download a copy of your account data</div>
        </div>
        <button onclick="alert('Download data feature coming soon')" style="background: #e6e2dc; color: #2a2a2a; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 13px;">Download →</button>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
