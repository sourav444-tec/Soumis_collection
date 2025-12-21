<?php
require_once __DIR__ . '/_auth.php';
$pageTitle = 'Admin Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="admin.css" />
</head>
<body>
  <div class="admin-header">
    <h1>Admin Dashboard</h1>
    <p>Soumis Collections — Admin Control Panel</p>
    <p style="margin-top: 8px;">Welcome, <strong><?php echo htmlspecialchars($_SESSION['user_email']); ?></strong><span class="badge">ADMIN</span></p>
    <div class="admin-nav">
      <a href="../index.php">← Return to Site</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="admin-container">
    <!-- Statistics Section -->
    <div class="admin-section">
      <div class="section-title">Dashboard Overview</div>
      <div class="stats-grid">
        <div class="stat-card">
          <h3>Total Admins</h3>
          <div class="stat-value">1</div>
        </div>
        <div class="stat-card">
          <h3>Wholesale Apps</h3>
          <div class="stat-value">View</div>
        </div>
        <div class="stat-card">
          <h3>System Status</h3>
          <div class="stat-value">✓ Active</div>
        </div>
      </div>
    </div>

    <!-- Product Management Section -->
    <div class="admin-section">
      <div class="section-title">Product Management</div>
      <div class="admin-grid">
        <div class="admin-card">
          <h3>Add New Product</h3>
          <p>Upload product photos and configure pricing for retail and wholesale.</p>
          <a class="admin-link" href="products.php">Manage Products</a>
        </div>
      </div>
    </div>

    <!-- Main Features Section -->
    <div class="admin-section">
      <div class="section-title">Management Tools</div>
      <div class="admin-grid">
        <div class="admin-card">
          <h3>Wholesale Applications</h3>
          <p>Review and manage all wholesale partnership requests and inquiries.</p>
          <a class="admin-link" href="wholesale.php">View Applications</a>
        </div>
        <div class="admin-card">
          <h3>User Session Info</h3>
          <p>Current logged-in user session details and authentication status.</p>
          <div style="background: #f7f5f2; padding: 12px; border-radius: 6px; font-size: 12px; color: #555;">
            <strong>User:</strong> <?php echo htmlspecialchars($_SESSION['user_email']); ?><br>
            <strong>Admin:</strong> <?php echo $_SESSION['is_admin'] ? 'Yes' : 'No'; ?><br>
            <strong>Session ID:</strong> <?php echo substr($_SESSION['user_id'], 0, 8) . '...'; ?>
          </div>
        </div>
        <div class="admin-card">
          <h3>Site Management</h3>
          <p>Quick access to main site and core administrative functions.</p>
          <a class="admin-link" href="../index.php">View Site</a>
          <a class="admin-link secondary" href="logout.php" style="margin-left: 8px;">Logout</a>
        </div>
      </div>
    </div>

    <!-- System Information Section -->
    <div class="admin-section">
      <div class="section-title">System Information</div>
      <div class="admin-grid">
        <div class="admin-card">
          <h3>Current Features</h3>
          <ul class="feature-list">
            <li>Wholesale Management</li>
            <li>Admin Authentication</li>
            <li>User Sessions</li>
            <li>Site Navigation</li>
            <li>Session Tracking</li>
          </ul>
        </div>
        <div class="admin-card">
          <h3>Development Notes</h3>
          <ul class="feature-list">
            <li>Demo Database Integration</li>
            <li>Basic Email OTP System</li>
            <li>Session-based Auth</li>
            <li>Responsive Design</li>
            <li>Security Improvements Needed</li>
          </ul>
        </div>
        <div class="admin-card">
          <h3>Recommended Next Steps</h3>
          <ul class="feature-list">
            <li>Implement Real Database</li>
            <li>Add Password Hashing</li>
            <li>Email Integration</li>
            <li>User Management</li>
            <li>Product Management</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
