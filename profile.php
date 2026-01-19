<?php
if (session_status() === PHP_SESSION_NONE) {
  @session_start();
}

// Redirect if not logged in
if (empty($_SESSION['user_id'])) {
  header('Location: login.php?redirect=profile');
  exit;
}

$pageTitle = 'My Profile - Soumis Collections';
include 'includes/header.php';
include 'includes/nav.php';

$userEmail = $_SESSION['user_email'] ?? 'user@example.com';
$userId = substr($_SESSION['user_id'], 0, 8) . '...';

// Initialize profile data in session
if (!isset($_SESSION['profile'])) {
  $_SESSION['profile'] = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'phone' => '+91 98765 43210',
    'address' => '123 Main St, City, State 12345',
    'country' => 'India',
    'joined_date' => date('M d, Y', time() - 86400 * 30)
  ];
}

$profile = $_SESSION['profile'];

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
  $_SESSION['profile']['first_name'] = htmlspecialchars($_POST['first_name']);
  $_SESSION['profile']['last_name'] = htmlspecialchars($_POST['last_name']);
  $_SESSION['profile']['phone'] = htmlspecialchars($_POST['phone']);
  $_SESSION['profile']['address'] = htmlspecialchars($_POST['address']);
  $_SESSION['profile']['country'] = htmlspecialchars($_POST['country']);
  $profile = $_SESSION['profile'];
  $successMessage = "Profile updated successfully!";
}
?>

<style>
  .profile-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 0 20px;
  }

  .profile-header {
    background: linear-gradient(135deg, #d4af37 0%, #e8c851 100%);
    padding: 40px;
    border-radius: 12px;
    color: #2a2a2a;
    text-align: center;
    margin-bottom: 30px;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  }

  .profile-header h1 {
    margin: 0 0 10px 0;
    font-size: 32px;
    letter-spacing: 1px;
  }

  .profile-header p {
    margin: 5px 0;
    font-size: 14px;
    opacity: 0.9;
  }

  .profile-section {
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

  .profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
  }

  .profile-field {
    margin-bottom: 20px;
  }

  .profile-field label {
    display: block;
    font-size: 12px;
    color: #7b776f;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
  }

  .profile-field input,
  .profile-field textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #e6e2dc;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    background: #f7f5f2;
  }

  .profile-field input:focus,
  .profile-field textarea:focus {
    outline: none;
    border-color: #d4af37;
    background: white;
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
  }

  .profile-display {
    background: #f7f5f2;
    padding: 12px;
    border-radius: 8px;
    border-left: 3px solid #d4af37;
  }

  .profile-display p {
    margin: 0;
    color: #2a2a2a;
    font-size: 14px;
  }

  .profile-display label {
    display: block;
    font-size: 11px;
    color: #7b776f;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
  }

  .edit-btn {
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

  .edit-btn:hover {
    opacity: 0.9;
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
    margin-right: 10px;
  }

  .cancel-btn {
    background: #e6e2dc;
    color: #2a2a2a;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.3s;
  }

  .cancel-btn:hover {
    background: #d6d2cc;
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

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
  }

  .stat-card {
    background: #f7f5f2;
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    border-left: 3px solid #d4af37;
  }

  .stat-label {
    font-size: 12px;
    color: #7b776f;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
  }

  .stat-value {
    font-size: 24px;
    font-weight: 700;
    color: #d4af37;
  }

  @media (max-width: 768px) {
    .profile-grid {
      grid-template-columns: 1fr;
    }

    .profile-header {
      padding: 30px;
    }

    .profile-header h1 {
      font-size: 24px;
    }
  }
</style>

<div class="profile-container">
  <div class="profile-header">
    <h1>👤 My Profile</h1>
    <p><?php echo htmlspecialchars($userEmail); ?></p>
    <p>Member since <?php echo $profile['joined_date']; ?></p>
  </div>

  <?php if (isset($successMessage)): ?>
    <div class="alert success">✓ <?php echo $successMessage; ?></div>
  <?php endif; ?>

  <!-- Account Statistics -->
  <div class="profile-section">
    <h2 class="section-title">📊 Account Statistics</h2>
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-label">Total Orders</div>
        <div class="stat-value">0</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Wishlist Items</div>
        <div class="stat-value">0</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Account Age</div>
        <div class="stat-value">30d</div>
      </div>
      <div class="stat-card">
        <div class="stat-label">Loyalty Points</div>
        <div class="stat-value">0</div>
      </div>
    </div>
  </div>

  <!-- Personal Information -->
  <div class="profile-section">
    <h2 class="section-title">ℹ️ Personal Information</h2>
    <form method="POST">
      <div class="profile-grid">
        <div class="profile-field">
          <label for="first_name">First Name</label>
          <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($profile['first_name']); ?>" />
        </div>
        <div class="profile-field">
          <label for="last_name">Last Name</label>
          <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($profile['last_name']); ?>" />
        </div>
      </div>

      <div class="profile-field">
        <label for="email">Email Address</label>
        <div class="profile-display">
          <p><?php echo htmlspecialchars($userEmail); ?></p>
        </div>
      </div>

      <div class="profile-field">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($profile['phone']); ?>" />
      </div>

      <div class="profile-field">
        <label for="address">Street Address</label>
        <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($profile['address']); ?></textarea>
      </div>

      <div class="profile-field">
        <label for="country">Country</label>
        <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($profile['country']); ?>" />
      </div>

      <div>
        <button type="submit" name="update_profile" class="save-btn">💾 Save Changes</button>
        <button type="reset" class="cancel-btn">↺ Reset</button>
      </div>
    </form>
  </div>

  <!-- Account Security -->
  <div class="profile-section">
    <h2 class="section-title">🔒 Account Security</h2>
    <div class="profile-field">
      <label>Password</label>
      <div class="profile-display">
        <p>••••••••••</p>
      </div>
    </div>
    <button class="edit-btn">🔑 Change Password</button>
  </div>

  <!-- Danger Zone -->
  <div class="profile-section" style="border-left: 4px solid #e74c3c;">
    <h2 class="section-title" style="color: #e74c3c;">⚠️ Danger Zone</h2>
    <p style="color: #666; margin-bottom: 15px; font-size: 14px;">Be careful with these actions. They cannot be undone.</p>
    <button onclick="if(confirm('Are you sure you want to delete your account? This cannot be undone.')) { alert('Delete account feature coming soon'); }" style="background: #e74c3c; color: white; padding: 12px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">🗑️ Delete Account</button>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
