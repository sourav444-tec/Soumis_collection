<?php
session_start();
require_once __DIR__ . '/config.php';
// Placeholder signup processing (no persistence).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['password_confirm'] ?? '');

    if ($first && $last && $email && $password && $password === $confirm) {
        $_SESSION['user_id'] = md5($email);
        $_SESSION['user_email'] = $email;
        $_SESSION['is_admin'] = in_array(strtolower($email), array_map('strtolower', $ADMIN_EMAILS), true);
        header('Location: index.php?signup=success');
        exit;
    } else {
        header('Location: signup.php?error=validation');
        exit;
    }
}
header('Location: signup.php');
