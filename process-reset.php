<?php
session_start();
require_once __DIR__ . '/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: login.php');
  exit;
}
$token = $_POST['token'] ?? '';
$password = trim($_POST['password'] ?? '');
$confirm = trim($_POST['password_confirm'] ?? '');
$tokenPath = __DIR__ . DIRECTORY_SEPARATOR . 'tokens' . DIRECTORY_SEPARATOR . basename($token) . '.txt';
if (!$token || !is_file($tokenPath)) {
  header('Location: reset-password.php?token=' . urlencode($token) . '&status=invalid');
  exit;
}
if ($password === '' || $password !== $confirm) {
  header('Location: reset-password.php?token=' . urlencode($token) . '&status=nomatch');
  exit;
}
// In a real app: look up user by token/email and update hashed password in DB.
// Demo: read email, delete token, mark session logged in.
$data = json_decode(file_get_contents($tokenPath), true);
@unlink($tokenPath);
if (isset($data['email'])) {
  $email = $data['email'];
  $_SESSION['user_id'] = md5($email);
  $_SESSION['user_email'] = $email;
  $_SESSION['is_admin'] = in_array(strtolower($email), array_map('strtolower', $ADMIN_EMAILS), true);
  header('Location: index.php?reset=success');
  exit;
}
header('Location: login.php');
