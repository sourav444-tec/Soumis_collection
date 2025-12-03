<?php
session_start();

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get item details from POST
$itemId = isset($_POST['item_id']) ? $_POST['item_id'] : '';
$itemName = isset($_POST['item_name']) ? $_POST['item_name'] : '';
$itemPrice = isset($_POST['item_price']) ? floatval($_POST['item_price']) : 0;
$itemCategory = isset($_POST['item_category']) ? $_POST['item_category'] : '';
$quantity = isset($_POST['quantity']) ? max(1, intval($_POST['quantity'])) : 1;

if ($itemId && $itemName && $itemPrice > 0) {
    // Check if item already in cart
    if (isset($_SESSION['cart'][$itemId])) {
        // Update quantity
        $_SESSION['cart'][$itemId]['quantity'] += $quantity;
    } else {
        // Add new item
        $_SESSION['cart'][$itemId] = [
            'name' => $itemName,
            'price' => $itemPrice,
            'category' => $itemCategory,
            'quantity' => $quantity
        ];
    }
    
    // Redirect back with success message
    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header('Location: ' . $redirectUrl . '?added=1');
} else {
    // Redirect back with error
    $redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header('Location: ' . $redirectUrl . '?error=1');
}
exit;
?>
