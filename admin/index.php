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
    .admin-grid{max-width:1100px;margin:40px auto;padding:0 24px;display:grid;gap:28px;grid-template-columns:repeat(auto-fit,minmax(280px,1fr))}
    .admin-card{background:#fff;border-radius:14px;padding:24px;box-shadow:0 12px 32px rgba(32,35,45,0.08);border:1px solid rgba(42,42,42,0.05);display:flex;flex-direction:column;gap:12px}
    .admin-card h2{margin:0;font-size:1.2rem;letter-spacing:1px}
    .admin-top{max-width:1100px;margin:0 auto;padding:24px 24px 0}
    .badge{display:inline-block;background:#d4af37;color:#2a2a2a;padding:4px 10px;border-radius:20px;font-size:12px;letter-spacing:.5px}
    a.admin-link{color:#d4af37;text-decoration:none;font-weight:600}
  </style>
</head>
<body>
  <div class="admin-top">
    <h1 style="margin:0 0 4px 0;letter-spacing:1px">Admin Dashboard</h1>
    <p style="color:#555">Welcome, <?php echo htmlspecialchars($_SESSION['user_email']); ?> <span class="badge">ADMIN</span></p>
    <p style="margin-top:8px"><a class="admin-link" href="logout.php">Logout</a> · <a class="admin-link" href="../index.php">Return to Site</a></p>
  </div>
  <div class="admin-grid">
    <div class="admin-card">
      <h2>Wholesale Applications</h2>
      <p>View submitted partnership requests.</p>
      <a class="admin-link" href="wholesale.php">Open</a>
    </div>
    <div class="admin-card">
      <h2>Users (Session)</h2>
      <p>Basic demo info for current logged user.</p>
      <pre style="background:#f7f5f2;padding:12px;border-radius:8px;font-size:12px;overflow:auto"><?php echo htmlspecialchars(print_r(['user_id'=>$_SESSION['user_id'],'email'=>$_SESSION['user_email']],true)); ?></pre>
    </div>
    <div class="admin-card">
      <h2>System Notes</h2>
      <ul style="margin:0;padding-left:18px;font-size:13px;color:#555">
        <li>Demo only: no DB persistence.</li>
        <li>Passwords not hashed (should use password_hash).</li>
        <li>OTP/email flows need real mail integration.</li>
      </ul>
    </div>
  </div>
</body>
</html>
