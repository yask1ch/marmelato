<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['product_id']);
    
    if (isset($_POST['change_qty'])) {
        $action = $_POST['change_qty']; // 'plus' или 'minus'
        
        if ($action === 'plus') {
            $_SESSION['cart'][$id]++;
        } elseif ($action === 'minus') {
            $_SESSION['cart'][$id]--;
            // Если стало 0, удаляем товар
            if ($_SESSION['cart'][$id] <= 0) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }
    
    if (isset($_POST['remove_item'])) {
        unset($_SESSION['cart'][$id]);
    }
}

header("Location: profile.php#cart");
exit;