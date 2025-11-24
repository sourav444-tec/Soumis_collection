<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: forgot-password.php');
  exit;
}
$email = trim($_POST['email'] ?? '');
if ($email === '') {
  header('Location: forgot-password.php?status=error');
  exit;
}
// Demo token generation & storage (NOT secure/persistent for production)
$token = bin2hex(random_bytes(16));
$tokenFile = __DIR__ . DIRECTORY_SEPARATOR . 'tokens' . DIRECTORY_SEPARATOR . $token . '.txt';
file_put_contents($tokenFile, json_encode([
  'email' => $email,
  'created' => time()
]));
// Normally you'd email the link. Here we store token in session to display on reset page for demo.
$_SESSION['last_reset_token'] = $token;
header('Location: reset-password.php?token=' . urlencode($token));
exit;
