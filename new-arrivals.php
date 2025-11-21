<?php
$pageTitle = 'Soumis Gems - New Arrivals';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body class="detail-page">
    <header class="detail-header">
      <a class="detail-back" href="index.php">&#8592; Back to home</a>
      <h1>New Arrivals</h1>
      <p class="detail-tagline">
        Fresh designs crafted for the latest trends in ethical jewelry.
      </p>
    </header>

    <main class="detail-content">
      <section class="detail-section">
        <h2>Highlights</h2>
        <ul>
          <li>Limited edition gemstone settings with recycled metals</li>
          <li>Seasonal color palettes inspired by nature</li>
          <li>Hand-finished pieces from our newest artisan partners</li>
        </ul>
      </section>

      <section class="detail-section">
        <h2>Lookbook</h2>
        <p>
          Browse our latest creations and discover matching sets curated by our
          stylists.
        </p>
        <a class="btn btn-primary" href="#" role="button"
          >View the full collection</a
        >
      </section>
    </main>

    <footer class="detail-footer">
      <p>&copy; <?php echo date('Y'); ?> Soumis Gems. All rights reserved.</p>
    </footer>
  </body>
</html>
