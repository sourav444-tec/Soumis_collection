<?php
// Include on every admin page at top.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
if (empty($_SESSION['user_id']) || empty($_SESSION['is_admin'])) {
  header('Location: ../login.php?admin=denied');
  exit;
}
