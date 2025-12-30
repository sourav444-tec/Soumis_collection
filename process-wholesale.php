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

// Save to database
$sql = "INSERT INTO wholesale_applications (company_name, contact_name, email, phone, product_interest, order_quantity, purchase_amount, message, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssisds', $company, $contact, $email, $phone, $product_interest, $quantity, $purchase_amount, $message);

if ($stmt->execute()) {
  header('Location: wholesale.php?order_status=success');
  exit;
} else {
  header('Location: wholesale.php?status=error&message=database');
  exit;
}
?>
