<?php
session_start();
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {echo json_encode(['status'=>'error','message'=>'Invalid method']);exit;}
$email = trim($_POST['email'] ?? '');
if ($email === '') {echo json_encode(['status'=>'error','message'=>'Email required']);exit;}
$otp = random_int(100000, 999999);
// Store OTP with expiry (5 minutes)
$_SESSION['otp_store'] = $_SESSION['otp_store'] ?? [];
$_SESSION['otp_store'][$email] = ['code'=>$otp,'expires'=>time()+300];
// In production you would send email/SMS here.
// For demo, return success (do not expose code publicly ideally) but we include it for transparency.
echo json_encode(['status'=>'ok','otp_demo'=>$otp]);
