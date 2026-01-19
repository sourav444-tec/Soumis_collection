<?php
/**
 * Admin Dashboard Utilities
 * Helper functions for the admin panel
 */

/**
 * Get admin statistics
 * @return array Statistics data
 */
function getAdminStats() {
  return [
    'total_products' => isset($_SESSION['products']) ? count($_SESSION['products']) : 0,
    'total_applications' => countWholesaleApplications(),
    'system_status' => 'Active',
    'last_updated' => date('Y-m-d H:i:s')
  ];
}

/**
 * Count wholesale applications
 * @return int Number of applications
 */
function countWholesaleApplications() {
  $dir = realpath(__DIR__ . '/../wholesale_applications');
  if (!$dir || !is_dir($dir)) {
    return 0;
  }
  return count(glob($dir . DIRECTORY_SEPARATOR . '*.json'));
}

/**
 * Get formatted price with currency
 * @param float $price Price value
 * @param string $currency Currency code (default: INR)
 * @return string Formatted price
 */
function formatPrice($price, $currency = '₹') {
  return $currency . number_format($price, 2);
}

/**
 * Get human-readable timestamp
 * @param int|string $timestamp Unix timestamp or date string
 * @return string Formatted date
 */
function getHumanDate($timestamp) {
  if (is_string($timestamp)) {
    $timestamp = strtotime($timestamp);
  }
  
  $now = time();
  $diff = $now - $timestamp;
  
  if ($diff < 60) {
    return 'Just now';
  } elseif ($diff < 3600) {
    return floor($diff / 60) . ' minutes ago';
  } elseif ($diff < 86400) {
    return floor($diff / 3600) . ' hours ago';
  } elseif ($diff < 604800) {
    return floor($diff / 86400) . ' days ago';
  } else {
    return date('M d, Y', $timestamp);
  }
}

/**
 * Validate color hex code
 * @param string $color Hex color code
 * @return bool Valid hex color
 */
function isValidColor($color) {
  return preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color) === 1;
}

/**
 * Sanitize product data
 * @param array $product Product array
 * @return array Sanitized product
 */
function sanitizeProduct($product) {
  return [
    'id' => htmlspecialchars($product['id'] ?? ''),
    'name' => htmlspecialchars($product['name'] ?? ''),
    'description' => htmlspecialchars($product['description'] ?? ''),
    'retail_price' => floatval($product['retail_price'] ?? 0),
    'wholesale_price' => floatval($product['wholesale_price'] ?? 0),
    'stock' => intval($product['stock'] ?? 0),
    'colors' => $product['colors'] ?? '[]',
    'created' => htmlspecialchars($product['created'] ?? date('Y-m-d H:i:s'))
  ];
}

/**
 * Get recent applications
 * @param int $limit Limit number of results
 * @return array Applications
 */
function getRecentApplications($limit = 5) {
  $dir = realpath(__DIR__ . '/../wholesale_applications');
  $applications = [];
  
  if ($dir && is_dir($dir)) {
    foreach (glob($dir . DIRECTORY_SEPARATOR . '*.json') as $file) {
      $data = json_decode(file_get_contents($file), true);
      if ($data) {
        $applications[] = $data;
      }
    }
  }
  
  usort($applications, function($a, $b) {
    return $b['created'] <=> $a['created'];
  });
  
  return array_slice($applications, 0, $limit);
}

/**
 * Export product to CSV
 * @param array $products Products to export
 * @return string CSV content
 */
function exportProductsCSV($products) {
  $csv = "ID,Name,Retail Price,Wholesale Price,Stock,Colors,Created\n";
  
  foreach ($products as $product) {
    $colors = json_decode($product['colors'], true);
    $colorString = implode('; ', $colors ?: []);
    
    $csv .= sprintf(
      '"%s","%s",%.2f,%.2f,%d,"%s","%s"' . "\n",
      $product['id'],
      str_replace('"', '""', $product['name']),
      $product['retail_price'],
      $product['wholesale_price'],
      $product['stock'],
      str_replace('"', '""', $colorString),
      $product['created']
    );
  }
  
  return $csv;
}

/**
 * Check if admin session is valid
 * @return bool Valid session
 */
function isValidAdminSession() {
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  
  return !empty($_SESSION['user_id']) && 
         !empty($_SESSION['is_admin']) && 
         $_SESSION['is_admin'] === true;
}
