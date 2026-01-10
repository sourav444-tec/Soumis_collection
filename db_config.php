<?php
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'soumis_collection');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8
$conn->set_charset("utf8");

// Function to execute query
function executeQuery($sql, $params = []) {
  global $conn;
  
  $stmt = $conn->prepare($sql);
  if (!$stmt) {
    throw new Exception("Prepare failed: " . $conn->error);
  }
  
  if (!empty($params)) {
    $types = str_repeat('s', count($params)); // Default to string, modify as needed
    $stmt->bind_param($types, ...$params);
  }
  
  if (!$stmt->execute()) {
    throw new Exception("Execute failed: " . $stmt->error);
  }
  
  return $stmt;
}

// Function to fetch single row
function fetchRow($sql, $params = []) {
  $stmt = executeQuery($sql, $params);
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $stmt->close();
  return $row;
}

// Function to fetch all rows
function fetchAll($sql, $params = []) {
  $stmt = executeQuery($sql, $params);
  $result = $stmt->get_result();
  $rows = [];
  while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
  }
  $stmt->close();
  return $rows;
}

// Function to get last insert ID
function getLastInsertId() {
  global $conn;
  return $conn->insert_id;
}

// Function to escape string
function escapeString($string) {
  global $conn;
  return $conn->real_escape_string($string);
}

// ===== PRICE CALCULATION FUNCTIONS =====

/**
 * Calculate wholesale price from retail price
 * Wholesale = 50% off retail (wholesale = retail * 0.5)
 */
function calculateWholesalePrice($retail_price) {
  return round($retail_price * 0.5, 2);
}

/**
 * Calculate retail price from wholesale price
 * Retail = wholesale / 0.5 (or wholesale * 2)
 */
function calculateRetailPrice($wholesale_price) {
  return round($wholesale_price * 2, 2);
}

/**
 * Get discount percentage between wholesale and retail
 */
function getDiscountPercentage($retail_price, $wholesale_price) {
  if ($retail_price <= 0) return 0;
  return round(((($retail_price - $wholesale_price) / $retail_price) * 100), 2);
}

/**
 * Format price in Indian Rupees
 */
function formatPrice($price) {
  return '₹' . number_format($price, 2);
}
?>
