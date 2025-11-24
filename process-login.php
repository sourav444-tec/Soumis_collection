<?php
session_start();
require_once __DIR__ . '/config.php';
// Placeholder login processing.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $adminRequested = isset($_POST['admin']) && $_POST['admin'] === '1';
    if ($email !== '' && $password !== '') {
        $isAdmin = in_array(strtolower($email), array_map('strtolower', $ADMIN_EMAILS), true);
        if ($adminRequested && !$isAdmin) {
            header('Location: login.php?admin=denied');
            exit;
        }
        $_SESSION['user_id'] = md5($email);
        $_SESSION['user_email'] = $email;
        $_SESSION['is_admin'] = $isAdmin;
        header('Location: ' . ($isAdmin ? 'admin/index.php' : 'index.php'));
        exit;
    } else {
        header('Location: login.php?error=1');
        exit;
    }
}
header('Location: login.php');
