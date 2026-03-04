<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: catalog.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$total_price = 0;

// 1. Считаем общую сумму заказа
$ids = implode(',', array_keys($_SESSION['cart']));
$products_query = $conn->query("SELECT id, price FROM products WHERE id IN ($ids)");
$prices = [];
while ($row = $products_query->fetch_assoc()) {
    $prices[$row['id']] = $row['price'];
    $total_price += $row['price'] * $_SESSION['cart'][$row['id']];
}

// 2. Начинаем транзакцию (чтобы если одна таблица упадет, вторая не записалась криво)
$conn->begin_transaction();

try {
    // 3. Создаем запись в таблице orders
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'Новый')");
    $stmt->bind_param("id", $user_id, $total_price);
    $stmt->execute();
    
    // Получаем ID только что созданного заказа
    $order_id = $conn->insert_id;

    // 4. Записываем каждый товар в order_items
    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    
    foreach ($_SESSION['cart'] as $p_id => $qty) {
        $p_price = $prices[$p_id];
        $stmt_item->bind_param("iiii", $order_id, $p_id, $qty, $p_price);
        $stmt_item->execute();
    }

    // Если всё ок — сохраняем
    $conn->commit();
    unset($_SESSION['cart']);
    header("Location: profile.php?order=success#orders");

} catch (Exception $e) {
    // Если ошибка — откатываем всё назад
    $conn->rollback();
    echo "Ошибка при оформлении: " . $e->getMessage();
}