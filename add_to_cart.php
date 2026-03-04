<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($product_id > 0 && $quantity > 0) {
        // Если корзины еще нет, создаем её
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Если товар уже есть в корзине, прибавляем количество
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] += $quantity;
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
}

// Возвращаемся в каталог к тому же месту (якорь на модалку не нужен, просто на страницу)
header("Location: profile.php?#cart");
exit;