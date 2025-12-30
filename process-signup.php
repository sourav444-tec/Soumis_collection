<?php
session_start();
require_once __DIR__ . '/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['password_confirm'] ?? '');

    if ($first && $last && $email && $password && $password === $confirm) {
        // Check if email already exists
        $checkSql = "SELECT id FROM users WHERE email = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param('s', $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        
        if ($checkResult->num_rows > 0) {
            header('Location: signup.php?error=exists');
            exit;
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $name = $first . ' ' . $last;
        
        // Insert new user
        $sql = "INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $name, $email, $hashedPassword);
        
        if ($stmt->execute()) {
            // Set session
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            $_SESSION['is_admin'] = false;
            
            header('Location: index.php?signup=success');
            exit;
        } else {
            header('Location: signup.php?error=database');
            exit;
        }
    } else {
        header('Location: signup.php?error=validation');
        exit;
    }
}
header('Location: signup.php');
?>
