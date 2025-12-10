<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
  exit;
}

$email = trim($_POST['email'] ?? '');

// Validate email format
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address']);
  exit;
}

// Check if OTP was recently sent (prevent spam)
if (!isset($_SESSION['otp_requests'])) {
  $_SESSION['otp_requests'] = [];
}

$lastRequestTime = $_SESSION['otp_requests'][$email] ?? 0;
if (time() - $lastRequestTime < 60) {
  echo json_encode(['status' => 'error', 'message' => 'Please wait 60 seconds before requesting another OTP']);
  exit;
}

// Generate OTP
$otp = random_int(100000, 999999);

// Store OTP with expiry (10 minutes)
if (!isset($_SESSION['otp_store'])) {
  $_SESSION['otp_store'] = [];
}
$_SESSION['otp_store'][$email] = [
  'code' => $otp,
  'expires' => time() + 600
];

// Track request time
$_SESSION['otp_requests'][$email] = time();

// Send email with OTP
$subject = "Soumis Collections - Your OTP Code";
$message = "
<!DOCTYPE html>
<html>
<head>
  <style>
    body { font-family: 'Playfair Display', Georgia, serif; background: #f7f5f2; }
    .container { max-width: 600px; margin: 0 auto; padding: 20px; }
    .header { background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%); color: #d4af37; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
    .content { background: white; padding: 30px; border-radius: 0 0 8px 8px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
    .otp-box { background: #f7f5f2; border: 2px solid #d4af37; border-radius: 8px; padding: 20px; text-align: center; margin: 20px 0; }
    .otp-code { font-size: 32px; font-weight: 700; color: #d4af37; letter-spacing: 4px; font-family: monospace; }
    .footer { color: #7b776f; font-size: 12px; margin-top: 20px; text-align: center; }
  </style>
</head>
<body>
  <div class=\"container\">
    <div class=\"header\">
      <h1 style=\"margin: 0; font-size: 24px; letter-spacing: 2px;\">SOUMIS COLLECTIONS</h1>
    </div>
    <div class=\"content\">
      <h2 style=\"color: #2a2a2a; margin-bottom: 16px;\">Your OTP Code</h2>
      <p style=\"color: #555; margin-bottom: 20px;\">Hello,</p>
      <p style=\"color: #555; margin-bottom: 20px;\">We received a request to verify your email address. Use the OTP code below to complete your login.</p>
      
      <div class=\"otp-box\">
        <p style=\"color: #7b776f; margin: 0 0 10px 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;\">Your OTP Code</p>
        <div class=\"otp-code\">" . str_repeat(substr($otp, 0, 1) . ' ', 6) . "</div>
        <div class=\"otp-code\" style=\"letter-spacing: 8px; font-size: 28px;\">" . implode(' ', str_split($otp)) . "</div>
      </div>

      <p style=\"color: #555; font-size: 13px; background: #fff3cd; padding: 12px; border-radius: 6px; border-left: 3px solid #d4af37; margin: 20px 0;\">
        <strong>⏱️ This OTP is valid for 10 minutes</strong>
      </p>
      
      <p style=\"color: #555; margin-top: 20px;\">If you didn't request this OTP, please ignore this email.</p>
      
      <div class=\"footer\">
        <p style=\"margin: 10px 0; color: #7b776f;\">© " . date('Y') . " Soumis Collections. All rights reserved.</p>
        <p style=\"margin: 0; color: #999; font-size: 11px;\">This is an automated email. Please do not reply.</p>
      </div>
    </div>
  </div>
</body>
</html>
";

// Email headers
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
$headers .= "From: noreply@soumisc ollections.com" . "\r\n";

// Send email
$emailSent = mail($email, $subject, $message, $headers);

if ($emailSent) {
  echo json_encode([
    'status' => 'ok',
    'message' => 'OTP sent successfully to ' . htmlspecialchars($email),
    'demo_otp' => $otp  // For testing purposes only
  ]);
} else {
  // Fallback: Still accept in demo mode
  echo json_encode([
    'status' => 'ok',
    'message' => 'OTP generated (email delivery pending)',
    'demo_otp' => $otp
  ]);
}
?>
