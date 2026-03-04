<?php
session_start();
$page_title = "О нас - MarmeLato";
include 'header.php';
?>

<main>
    <div class="container about-page" style="margin-top: 120px; padding-bottom: 60px;">
        <div class="glass-panel about-hero">
            <div class="about-text">
                <span class="category-tag">Наша история</span>
                <h1>MarmeLato — это <br><span>магия в каждой упаковке</span></h1>
                <p>Мы верим, что счастье можно попробовать на вкус. С 2026 года мы собираем лучшие виды мармелада со всего мира, чтобы ваш день стал чуточку ярче и слаще.</p>
            </div>
            <div class="about-image">
                <img src="assets/img/marmalade-3.png" alt="Мармелад" style="width: 100%; border-radius: 30px;">
            </div>
        </div>

        <div class="about-grid">
            <div class="glass-panel feature-card">
                <div class="feature-icon">🌿</div>
                <h3>Натурально</h3>
                <p>Только натуральные соки и природные красители в каждом кусочке.</p>
            </div>
            <div class="glass-panel feature-card">
                <div class="feature-icon">✈️</div>
                <h3>Весь мир</h3>
                <p>Прямые поставки эксклюзивных сладостей из Европы и Азии.</p>
            </div>
            <div class="glass-panel feature-card">
                <div class="feature-icon">❤️</div>
                <h3>С любовью</h3>
                <p>Каждый заказ мы упаковываем вручную, добавляя капельку заботы.</p>
            </div>
        </div>

        <div class="glass-panel cta-section">
            <h2>Готовы к сладкому приключению?</h2>
            <p>Загляните в наш каталог и найдите свой идеальный вкус.</p>
            <a href="catalog.php" class="btn btn-main">Перейти к покупкам</a>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>