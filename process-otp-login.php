<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: login.php');
  exit;
}
$email = trim($_POST['email'] ?? '');
$otp = trim($_POST['otp'] ?? '');
if ($email === '' || $otp === '') {
  header('Location: login.php?otp=missing');
  exit;
}
$store = $_SESSION['otp_store'][$email] ?? null;
if (!$store) {
  header('Location: login.php?otp=notfound');
  exit;
}
if ($store['expires'] < time()) {
  unset($_SESSION['otp_store'][$email]);
  header('Location: login.php?otp=expired');
  exit;
}
if ($store['code'] != $otp) {
  header('Location: login.php?otp=invalid');
  exit;
}
// Success: remove OTP and authenticate user
unset($_SESSION['otp_store'][$email]);
$_SESSION['user_id'] = md5($email);
$_SESSION['user_email'] = $email;
header('Location: index.php?login=otp');
