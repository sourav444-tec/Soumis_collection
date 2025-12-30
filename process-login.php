<?php
session_start();
require_once __DIR__ . '/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $adminRequested = isset($_POST['admin']) && $_POST['admin'] === '1';
    
    if ($email !== '' && $password !== '') {
        // Check if user exists in database
        $sql = "SELECT id, name, email, password, is_admin FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password (using password_hash in production)
            if ($password === $user['password'] || password_verify($password, $user['password'])) {
                if ($adminRequested && !$user['is_admin']) {
                    header('Location: login.php?admin=denied');
                    exit;
                }
                
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['is_admin'] = $user['is_admin'];
                
                header('Location: ' . ($user['is_admin'] ? 'admin/index.php' : 'index.php'));
                exit;
            } else {
                header('Location: login.php?error=invalid');
                exit;
            }
        } else {
            header('Location: login.php?error=notfound');
            exit;
        }
    } else {
        header('Location: login.php?error=1');
        exit;
    }
}
header('Location: login.php');
?>
