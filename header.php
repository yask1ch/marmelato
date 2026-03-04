<?php require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'MarmeLato'; ?> - Магазин мармелада</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="decor-marmalade">
        <div class="marmalade-item" style="top: 10%; left: 5%; width: 150px; height: 150px; background-image: url('assets/img/marmalade-4.png'); filter: blur(2px);"></div>
        <div class="marmalade-item" style="top: 20%; right: 3%; width: 200px; height: 200px; background-image: url('assets/img/marmalade-3.png');"></div>
        <div class="marmalade-item" style="bottom: 15%; left: 10%; width: 120px; height: 120px; background-image: url('assets/img/marmalade-2.png');"></div>
        <div class="marmalade-item" style="bottom: 30%; right: 12%; width: 180px; height: 180px; background-image: url('assets/img/marmalade-1.png'); filter: blur(4px);"></div>
    </div>


<header>
    <nav class="navbar">
        <a href="index.php" class="logo">MarmeLato</a>
        
        <ul class="nav-menu-desktop">
            <li><a href="index.php">Главная</a></li>
            <li><a href="catalog.php">Каталог</a></li>
            <li><a href="about.php">О нас</a></li>
            <li><a href="contacts.php">Контакты</a></li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="profile.php">Профиль</a></li>
                <li><a href="logout.php">Выход</a></li>
            <?php else: ?>
                <li><a href="login.php">Вход</a></li>
            <?php endif; ?>
        </ul>

        <div class="burger" id="burger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <div class="menu-modal" id="menu-modal">
        <div class="modal-content">
            <ul class="nav-menu-mobile">
                <li><a href="index.php">Главная</a></li>
                <li><a href="catalog.php">Каталог</a></li>
                <li><a href="about.php">О нас</a></li>
                <li><a href="contacts.php">Контакты</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="profile.php">Профиль</a></li>
                    <li><a href="logout.php">Выход</a></li>
                <?php else: ?>
                    <li><a href="login.php">Вход</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>