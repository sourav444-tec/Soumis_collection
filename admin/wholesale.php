<?php
require_once __DIR__ . '/_auth.php';
$pageTitle = 'Admin – Wholesale Applications';
$dir = realpath(__DIR__ . '/../wholesale_applications');
$applications = [];
if ($dir && is_dir($dir)) {
  foreach (glob($dir . DIRECTORY_SEPARATOR . '*.json') as $file) {
    $data = json_decode(file_get_contents($file), true);
    if ($data) { $applications[] = $data; }
  }
}
usort($applications,function($a,$b){return $b['created'] <=> $a['created'];});
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $pageTitle; ?></title>
  <link rel="stylesheet" href="admin.css" />
  <style>
    .application-card {
      background: white;
      border: 1px solid #e6e2dc;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
      transition: all 0.3s;
    }

    .application-card:hover {
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
      transform: translateY(-2px);
    }

    .app-header {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 16px;
      align-items: start;
      margin-bottom: 16px;
      padding-bottom: 16px;
      border-bottom: 1px solid #f0ede8;
    }

    .app-title {
      margin: 0;
      font-size: 18px;
      color: #2a2a2a;
    }

    .app-id {
      font-size: 12px;
      color: #999;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-top: 4px;
    }

    .app-status {
      display: inline-block;
      background: #d4edda;
      color: #155724;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    .app-meta {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 16px;
      margin-bottom: 16px;
    }

    .meta-item {
      background: #f7f5f2;
      padding: 12px;
      border-radius: 8px;
      border-left: 3px solid #d4af37;
    }

    .meta-label {
      font-size: 11px;
      color: #7b776f;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      font-weight: 600;
      margin-bottom: 4px;
    }

    .meta-value {
      color: #2a2a2a;
      font-size: 14px;
      word-break: break-all;
    }

    .app-message {
      background: #f7f5f2;
      padding: 14px;
      border-radius: 8px;
      border-left: 4px solid #d4af37;
      color: #555;
      font-size: 14px;
      line-height: 1.6;
      margin-bottom: 16px;
      font-style: italic;
    }

    .app-date {
      font-size: 12px;
      color: #999;
      text-align: right;
      margin-top: 12px;
      padding-top: 12px;
      border-top: 1px solid #f0ede8;
    }

    .app-actions {
      display: flex;
      gap: 8px;
      margin-top: 12px;
    }

    .app-actions a,
    .app-actions button {
      flex: 1;
      padding: 10px;
      text-align: center;
      border-radius: 6px;
      border: none;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      text-decoration: none;
    }

    .action-btn-primary {
      background: linear-gradient(90deg, #d4af37, #e8c851);
      color: #2a2a2a;
    }

    .action-btn-primary:hover {
      opacity: 0.9;
    }

    .action-btn-secondary {
      background: #e6e2dc;
      color: #2a2a2a;
    }

    .action-btn-secondary:hover {
      background: #d6d2cc;
    }

    .action-btn-danger {
      background: #e74c3c;
      color: white;
    }

    .action-btn-danger:hover {
      background: #c0392b;
    }

    .empty-state {
      text-align: center;
      padding: 60px 20px;
      background: #f7f5f2;
      border-radius: 12px;
      margin-bottom: 24px;
    }

    .empty-state-icon {
      font-size: 48px;
      margin-bottom: 16px;
    }

    .empty-state-text {
      color: #7b776f;
      font-size: 16px;
      margin: 0;
    }

    .filter-bar {
      display: flex;
      gap: 12px;
      margin-bottom: 24px;
      flex-wrap: wrap;
    }

    .filter-btn {
      padding: 8px 16px;
      border-radius: 6px;
      border: 1px solid #e6e2dc;
      background: white;
      color: #2a2a2a;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
    }

    .filter-btn.active {
      background: #d4af37;
      color: #2a2a2a;
      border-color: #d4af37;
    }

    .filter-btn:hover {
      border-color: #d4af37;
    }

    .stats-bar {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 16px;
      margin-bottom: 24px;
    }

    .stats-item {
      background: white;
      padding: 16px;
      border-radius: 8px;
      border-left: 4px solid #d4af37;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .stats-label {
      font-size: 12px;
      color: #7b776f;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .stats-value {
      font-size: 28px;
      font-weight: 700;
      color: #d4af37;
      margin-top: 8px;
    }
  </style>
</head>
<body>
  <div class="admin-header">
    <h1>Wholesale Applications</h1>
    <p>Manage partnership requests and inquiries</p>
    <div class="admin-nav">
      <a href="index.php">← Dashboard</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="admin-container">
    <!-- Statistics -->
    <div class="stats-bar">
      <div class="stats-item">
        <div class="stats-label">Total Applications</div>
        <div class="stats-value"><?php echo count($applications); ?></div>
      </div>
      <div class="stats-item">
        <div class="stats-label">Pending Review</div>
        <div class="stats-value"><?php echo count($applications); ?></div>
      </div>
    </div>

    <!-- Filter/Search Bar -->
    <div class="filter-bar">
      <button class="filter-btn active" onclick="filterApplications('all')">All</button>
      <button class="filter-btn" onclick="filterApplications('today')">Today</button>
      <button class="filter-btn" onclick="filterApplications('week')">This Week</button>
    </div>

    <!-- Applications List -->
    <?php if (!$applications): ?>
      <div class="empty-state">
        <div class="empty-state-icon">📭</div>
        <p class="empty-state-text">No wholesale applications yet.<br>Applications will appear here once submitted.</p>
      </div>
    <?php else: ?>
      <div id="applicationsContainer">
        <?php foreach ($applications as $app): ?>
          <div class="application-card">
            <div class="app-header">
              <div>
                <h3 class="app-title"><?php echo htmlspecialchars($app['company']); ?></h3>
                <div class="app-id">ID: <?php echo htmlspecialchars($app['id']); ?></div>
              </div>
              <span class="app-status">✓ NEW</span>
            </div>

            <div class="app-meta">
              <div class="meta-item">
                <div class="meta-label">👤 Contact Name</div>
                <div class="meta-value"><?php echo htmlspecialchars($app['contact']); ?></div>
              </div>
              <div class="meta-item">
                <div class="meta-label">📧 Email</div>
                <div class="meta-value"><a href="mailto:<?php echo htmlspecialchars($app['email']); ?>" style="color: #d4af37; text-decoration: none;"><?php echo htmlspecialchars($app['email']); ?></a></div>
              </div>
              <div class="meta-item">
                <div class="meta-label">📞 Phone</div>
                <div class="meta-value"><a href="tel:<?php echo htmlspecialchars($app['phone']); ?>" style="color: #d4af37; text-decoration: none;"><?php echo htmlspecialchars($app['phone']); ?></a></div>
              </div>
            </div>

            <div class="app-message">
              <strong>Message:</strong><br>
              <?php echo nl2br(htmlspecialchars($app['message'])); ?>
            </div>

            <div class="app-actions">
              <a href="mailto:<?php echo htmlspecialchars($app['email']); ?>" class="action-btn-primary">✉️ Email Reply</a>
              <a href="tel:<?php echo htmlspecialchars($app['phone']); ?>" class="action-btn-secondary">📞 Call</a>
              <button class="action-btn-danger" onclick="deleteApplication('<?php echo htmlspecialchars($app['id']); ?>')">🗑️ Delete</button>
            </div>

            <div class="app-date">
              📅 Submitted: <?php echo date('M d, Y at H:i', $app['created']); ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

  <script>
    function deleteApplication(id) {
      if (confirm('Are you sure you want to delete this application?')) {
        // This would require a delete endpoint
        alert('Delete functionality coming soon');
        // Future: window.location.href = 'delete-application.php?id=' + id;
      }
    }

    function filterApplications(type) {
      // Update active button
      document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      event.target.classList.add('active');

      // Filtering logic would go here
      console.log('Filter by:', type);
    }
  </script>
</body>
</html>
