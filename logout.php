<?php
// Начинаем работу с сессией, чтобы было что закрывать
session_start();

// Полностью очищаем массив сессии
$_SESSION = array();

// Если использовались куки сессии, их тоже желательно "запросить" назад (удалить)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Уничтожаем саму сессию на сервере
session_destroy();

// Мгновенный редирект на главную страницу
header("Location: index.php");
exit;
?>