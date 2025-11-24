<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: wholesale.php');
  exit;
}
$company = trim($_POST['company'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');
if (!$company || !$contact || !$phone || !$email) {
  header('Location: wholesale.php?status=error');
  exit;
}
// Store application locally (demo). In production, persist to DB and notify staff.
$dir = __DIR__ . DIRECTORY_SEPARATOR . 'wholesale_applications';
if (!is_dir($dir)) { @mkdir($dir); }
$id = date('Ymd_His') . '_' . substr(md5($email . microtime(true)),0,8);
$data = [
  'id' => $id,
  'company' => $company,
  'contact' => $contact,
  'phone' => $phone,
  'email' => $email,
  'message' => $message,
  'created' => time()
];
file_put_contents($dir . DIRECTORY_SEPARATOR . $id . '.json', json_encode($data, JSON_PRETTY_PRINT));
header('Location: wholesale.php?status=sent');
