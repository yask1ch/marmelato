<?php
session_start();

// Параметры базы данных
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'marmelato_db'; // Новое имя БД

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Путь к папке с изображениями товаров
$products_img_path = "assets/img/products/";

// Функции для проверки прав (пригодятся в шапке)
function isLogged() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
?>