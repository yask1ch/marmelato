<?php
session_start();
$page_title = "Контакты - MarmeLato";
include 'header.php';
?>

<main>
    <div class="container contacts-page" style="margin-top: 120px; padding-bottom: 60px;">
        <div class="contacts-header" style="text-align: center; margin-bottom: 50px;">
            <span class="category-tag">Свяжитесь с нами</span>
            <h1 style="font-size: 3rem; margin-top: 10px;">Мы всегда <br><span>на связи</span></h1>
        </div>

        <div class="contacts-grid">
            <div class="glass-panel contact-card">
                <div class="contact-icon">📱</div>
                <h3>Мессенджеры</h3>
                <p>Пишите нам в любое время, отвечаем быстро!</p>
                <div class="contact-links">
                    <a href="https://t.me/your_link" class="contact-link tg">Telegram</a>
                    <a href="https://wa.me/your_number" class="contact-link wa">WhatsApp</a>
                </div>
            </div>

            <div class="glass-panel contact-card">
                <div class="contact-icon">✉️</div>
                <h3>Почта</h3>
                <p>Для предложений и деловых вопросов</p>
                <a href="mailto:hello@marmelato.ru" class="email-text">hello@marmelato.ru</a>
            </div>

            <div class="glass-panel contact-card">
                <div class="contact-icon">📸</div>
                <h3>Соцсети</h3>
                <p>Следите за новинками и акциями в нашем профиле</p>
                <a href="https://instagram.com/your_link" class="contact-link insta">Instagram</a>
            </div>
        </div>

        <div class="glass-panel schedule-banner">
            <div class="schedule-info">
                <span class="status-dot"></span>
                <p>Принимаем заказы на сайте <strong>24/7</strong>. Обработка менеджером: Пн-Пт с 10:00 до 20:00</p>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>