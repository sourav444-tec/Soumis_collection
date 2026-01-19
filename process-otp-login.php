<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: login.php');
  exit;
}

$email = trim($_POST['email'] ?? '');
$otp = trim($_POST['otp'] ?? '');

// Validate inputs
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header('Location: login.php?otp=invalid_email');
  exit;
}

if ($otp === '' || !preg_match('/^\d{6}$/', $otp)) {
  header('Location: login.php?otp=invalid_format');
  exit;
}

// Check if OTP exists
$store = $_SESSION['otp_store'][$email] ?? null;
if (!$store) {
  header('Location: login.php?otp=notfound');
  exit;
}

// Check if OTP expired
if ($store['expires'] < time()) {
  unset($_SESSION['otp_store'][$email]);
  header('Location: login.php?otp=expired');
  exit;
}

// Verify OTP code
if ($store['code'] != $otp) {
  header('Location: login.php?otp=invalid');
  exit;
}

// Success: Clean up and authenticate user
unset($_SESSION['otp_store'][$email]);
unset($_SESSION['otp_requests'][$email]);

// Set user session
$_SESSION['user_id'] = md5($email);
$_SESSION['user_email'] = $email;
$_SESSION['is_admin'] = in_array(strtolower($email), array_map('strtolower', ['admin@example.com']), true);

header('Location: index.php?login=success');
exit;
?>
