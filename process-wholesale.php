<?php
session_start();
require_once __DIR__ . '/db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: wholesale.php');
  exit;
}
$company = trim($_POST['company'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$email   = trim($_POST['email'] ?? '');
$product_interest = trim($_POST['product_interest'] ?? '');
$message = trim($_POST['message'] ?? '');
$quantity = intval($_POST['quantity'] ?? 0);
$purchase_amount = floatval($_POST['purchase_amount'] ?? 0);

// Validate required fields
if (!$company || !$contact || !$phone || !$email) {
  header('Location: wholesale.php?status=error');
  exit;
}

// Validate minimum purchase requirements
if ($quantity < 6) {
  header('Location: wholesale.php?status=error&message=minimum_products');
  exit;
}

if ($purchase_amount < 500) {
  header('Location: wholesale.php?status=error&message=minimum_amount');
  exit;
}

// Get wholesale pricing tier based on quantity
$tier = 'starter';
$discount_percent = 10;

if ($quantity >= 200) {
  $tier = 'enterprise';
  $discount_percent = 30;
} elseif ($quantity >= 50) {
  $tier = 'professional';
  $discount_percent = 20;
}

// Calculate effective wholesale price with tier discount
// Base wholesale price is 50% of retail, then apply tier discount
// Final price = purchase_amount * (1 - discount_percent/100)
$calculated_price = $purchase_amount * (1 - ($discount_percent / 100));

// Log order details for tracking
$order_timestamp = date('Y-m-d H:i:s');

// Save to database
$sql = "INSERT INTO wholesale_applications (company_name, contact_name, email, phone, product_interest, order_quantity, purchase_amount, message, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssisds', $company, $contact, $email, $phone, $product_interest, $quantity, $purchase_amount, $message);

if ($stmt->execute()) {
  // Successfully saved - redirect with success message
  header('Location: wholesale.php?order_status=success');
  exit;
} else {
  header('Location: wholesale.php?status=error&message=database');
  exit;
}
?>
