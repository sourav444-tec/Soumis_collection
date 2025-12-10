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
  <link rel="stylesheet" href="../style.css" />
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Playfair Display', Georgia, serif; background: #f7f5f2; }
    .admin-header { background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%); color: white; padding: 24px 32px; }
    .admin-header h1 { font-size: 28px; letter-spacing: 2px; margin-bottom: 8px; }
    .admin-header p { font-size: 14px; opacity: 0.9; }
    .admin-nav { display: flex; gap: 16px; margin-top: 16px; }
    .admin-nav a { color: #d4af37; text-decoration: none; font-weight: 600; transition: opacity 0.3s; }
    .admin-nav a:hover { opacity: 0.8; }
    .badge { display: inline-block; background: #d4af37; color: #2a2a2a; padding: 4px 12px; border-radius: 20px; font-size: 11px; letter-spacing: 1px; font-weight: 600; margin-left: 8px; }
    .admin-container { max-width: 1200px; margin: 0 auto; padding: 32px 24px; }
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 32px; }
    .stat-card { background: white; padding: 24px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); border-left: 4px solid #d4af37; }
    .stat-card h3 { font-size: 14px; color: #7b776f; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; }
    .stat-value { font-size: 32px; font-weight: 700; color: #2a2a2a; }
    .admin-section { margin-bottom: 32px; }
    .section-title { font-size: 20px; margin-bottom: 16px; color: #2a2a2a; letter-spacing: 1px; }
    .admin-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
    .admin-card { background: white; border-radius: 12px; padding: 24px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); border: 1px solid #e6e2dc; transition: transform 0.3s, box-shadow 0.3s; }
    .admin-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12); }
    .admin-card h3 { font-size: 18px; margin-bottom: 12px; color: #2a2a2a; }
    .admin-card p { color: #7b776f; font-size: 14px; margin-bottom: 16px; line-height: 1.5; }
    .admin-link { display: inline-block; background: linear-gradient(90deg, #d4af37, #e8c851); color: #2a2a2a; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 13px; transition: opacity 0.3s; }
    .admin-link:hover { opacity: 0.9; }
    .admin-link.secondary { background: #e6e2dc; color: #2a2a2a; }
    pre { background: #f7f5f2; padding: 16px; border-radius: 8px; font-size: 12px; overflow: auto; border: 1px solid #e6e2dc; }
    .feature-list { list-style: none; }
    .feature-list li { padding: 8px 0; color: #555; border-bottom: 1px solid #f0ede8; }
    .feature-list li:last-child { border-bottom: none; }
    .feature-list li::before { content: "✓ "; color: #d4af37; font-weight: 700; margin-right: 8px; }
  </style>
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
          <pre><?php echo htmlspecialchars(print_r(['user_id'=>substr($_SESSION['user_id'],0,8).'...','email'=>$_SESSION['user_email'],'is_admin'=>$_SESSION['is_admin']?'Yes':'No'],true)); ?></pre>
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
