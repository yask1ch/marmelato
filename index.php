<?php 
$page_title = "Главная";
include 'header.php'; 
?>

<main>
    <section class="hero" style="padding: 100px 20px;">
        <div class="hero-glass glass-panel">
            <h1 style="font-size: 3.5rem; margin-bottom: 20px; color: #4A3F35;">MarmeLato</h1>
            <p style="font-size: 1.2rem; margin-bottom: 30px; color: #4A3F35;">
                Вкус, который невозможно забыть. <br> 
                Натуральный мармелад ручной работы с доставкой к вашему порогу.
            </p>
            <a class="btn" href="catalog.php">Открыть каталог</a>
        </div>
    </section>

    <section class="section">
        <h2 class="section-title">Почему MarmeLato?</h2>
        <div class="features-grid">
            <div class="feature-card glass-panel">
                <span class="feature-icon">🍓</span>
                <h3>100% Натурально</h3>
                <p>Только свежие фрукты, ягоды и никакого лишнего сахара.</p>
            </div>
            <div class="feature-card glass-panel">
                <span class="feature-icon">🚚</span>
                <h3>Быстрая доставка</h3>
                <p>Бережно упакуем и доставим ваш заказ за 24 часа по городу.</p>
            </div>
            <div class="feature-card glass-panel">
                <span class="feature-icon">✨</span>
                <h3>Авторские миксы</h3>
                <p>Уникальные сочетания вкусов, которые вы не найдете в магазине.</p>
            </div>
        </div>
    </section>

    
    <section class="section" style="background: rgba(255,255,255,0.1); border-radius: 50px 50px 0 0;">
        <h2 class="section-title">Хиты сезона</h2>
        <div class="products-preview">
            <div class="product-card glass-panel">
                <img src="assets/img/products/bears.jpg" alt="Мишки">
                <h3>Мишки Гамми</h3>
                <p style="font-weight: 600; font-size: 1.2rem; margin: 10px 0;">450 ₽</p>
                <a href="catalog.php" class="btn" style="padding: 10px 20px; font-size: 0.9rem;">Подробнее</a>
            </div>
            
            <div class="product-card glass-panel">
                <img src="assets/img/products/worms.jpg" alt="Червячки">
                <h3>ЛКислые червячки</h3>
                <p style="font-weight: 600; font-size: 1.2rem; margin: 10px 0;">390 ₽</p>
                <a href="catalog.php" class="btn" style="padding: 10px 20px; font-size: 0.9rem;">Подробнее</a>
            </div>

            <div class="product-card glass-panel">
                <img src="assets/img/products/rings.jpg" alt="Колечки">
                <h3>Мармеладные кольца</h3>
                <p style="font-weight: 600; font-size: 1.2rem; margin: 10px 0;">520 ₽</p>
                <a href="catalog.php" class="btn" style="padding: 10px 20px; font-size: 0.9rem;">Подробнее</a>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 50px;">
            <a href="catalog.php" class="btn">Смотреть весь каталог</a>
        </div>
    </section>

    <section class="section" style="text-align: center;">
        <div class="glass-panel" style="padding: 60px; background: linear-gradient(45deg, rgba(255,255,255,0.4), rgba(255,182,193,0.3));">
            <h2 style="margin-bottom: 20px;">Хотите собрать свой бокс?</h2>
            <p style="margin-bottom: 30px;">Напишите нам, и мы создадим уникальный набор под ваши предпочтения.</p>
            <a href="contacts.php" class="btn">Связаться с нами</a>
        </div>
    </section>
</main>


<?php include 'footer.php'; ?>