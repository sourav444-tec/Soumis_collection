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
  <link rel="stylesheet" href="../style.css" />
  <style>
    .wrap{max-width:1100px;margin:40px auto;padding:0 24px}
    table{width:100%;border-collapse:collapse;font-size:13px}
    th,td{padding:10px 12px;border-bottom:1px solid #eee;text-align:left;vertical-align:top}
    th{background:#f9f6f1;font-weight:600;letter-spacing:.5px}
    tr:hover td{background:#fafafa}
    .actions a{color:#d4af37;text-decoration:none;font-weight:600}
    .meta{color:#555;font-size:12px}
  </style>
</head>
<body>
  <div class="wrap">
    <h1 style="margin:0 0 14px 0;letter-spacing:1px">Wholesale Applications</h1>
    <p style="margin:0 0 24px 0"><a href="index.php" style="color:#d4af37;text-decoration:none">← Dashboard</a></p>
    <?php if (!$applications): ?>
      <p style="color:#555">No applications submitted yet.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Company</th>
            <th>Contact</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($applications as $app): ?>
          <tr>
            <td><?php echo htmlspecialchars($app['id']); ?></td>
            <td><?php echo htmlspecialchars($app['company']); ?></td>
            <td><?php echo htmlspecialchars($app['contact']); ?></td>
            <td><?php echo htmlspecialchars($app['email']); ?></td>
            <td><?php echo htmlspecialchars($app['phone']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($app['message'])); ?></td>
            <td class="meta"><?php echo date('Y-m-d H:i', $app['created']); ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>
