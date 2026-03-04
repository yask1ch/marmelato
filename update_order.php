<?php
session_start();
require_once 'db.php';

// Простая проверка на админа
if (!isset($_SESSION['user_id'])) { exit; }
$user_id = $_SESSION['user_id'];
$user = $conn->query("SELECT role FROM users WHERE id = '$user_id'")->fetch_assoc();
if ($user['role'] !== 'admin') { die("Доступ запрещен"); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = intval($_POST['order_id']);
    $anchor = "";

    if (isset($_POST['delete_order'])) {
        $conn->query("DELETE FROM orders WHERE id = $order_id");
        // При удалении якорь не нужен, так как карточки больше нет
    } elseif (isset($_POST['update_status'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $conn->query("UPDATE orders SET status = '$status' WHERE id = $order_id");
        $anchor = "#order-" . $order_id;
    }

    // Редирект обратно с сохранением позиции
    header("Location: profile.php" . $anchor);
    exit;
}