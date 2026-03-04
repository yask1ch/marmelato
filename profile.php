<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Получаем полные данные текущего пользователя
$stmt = $conn->prepare("SELECT name, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();

$is_admin = ($user_data['role'] === 'admin');

$page_title = "Личный кабинет - MarmeLato";
include 'header.php';
?>

<div class="section profile-wrapper" style="margin-top: 100px; padding: 20px;">
    <h1 class="section-title">Привет, <?= htmlspecialchars($user_data['name']); ?>! 🍬</h1>

    <div class="profile-grid">
        <div class="glass-panel profile-info">
            <h3>Мои данные</h3>
            <div class="info-item">
                <span class="label">Имя:</span>
                <span class="value"><?= htmlspecialchars($user_data['name']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Email:</span>
                <span class="value"><?= htmlspecialchars($user_data['email']); ?></span>
            </div>
            <div class="info-item">
                <span class="label">Статус:</span>
                <?php if ($is_admin): ?>
                    <span class="value status-badge admin">Админ 👑</span>
                <?php else: ?>
                    <span class="value status-badge">Любитель мармелада</span>
                <?php endif; ?>
            </div>
            <a href="logout.php" class="btn" style="margin-top: 20px; background: rgba(231, 76, 60, 0.2); border: 1px solid #e74c3c; color: #4A3F35;">Выйти из аккаунта</a>
        </div>

        <?php if (!$is_admin): ?>
        <div class="glass-panel cart-section" id="cart">
                <h3>Моя корзина 🛒</h3>
                
                <?php if (!empty($_SESSION['cart'])): ?>
                    <div class="cart-items">
                        <?php 
                        $total_sum = 0;
                        $ids = implode(',', array_keys($_SESSION['cart']));
                        $cart_products = $conn->query("SELECT * FROM products WHERE id IN ($ids)");
                        
                        while ($item = $cart_products->fetch_assoc()): 
                            $qty = $_SESSION['cart'][$item['id']];
                            $subtotal = $item['price'] * $qty;
                            $total_sum += $subtotal;
                        ?>
                            <div class="cart-item-row" style="display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.2);">
                                <div style="flex: 1;">
                                    <strong><?= htmlspecialchars($item['title']) ?></strong><br>
                                    <small><?= number_format($item['price'], 0, '', ' ') ?> ₽ / шт.</small>
                                </div>

                                <form action="update_cart.php" method="POST" style="display: flex; align-items: center; gap: 10px;">
                                    <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                    
                                    <button type="submit" name="change_qty" value="minus" class="count-btn-small">-</button>
                                    <span style="min-width: 20px; text-align: center; font-weight: bold;"><?= $qty ?></span>
                                    <button type="submit" name="change_qty" value="plus" class="count-btn-small">+</button>
                                    
                                    <button type="submit" name="remove_item" style="background:none; border:none; cursor:pointer; margin-left:10px;">🗑️</button>
                                </form>

                                <div style="min-width: 80px; text-align: right; font-weight: bold;">
                                    <?= number_format($subtotal, 0, '', ' ') ?> ₽
                                </div>
                            </div>
                        <?php endwhile; ?>
                        
                        <div class="cart-total" style="margin-top: 20px; text-align: right; font-size: 1.3rem;">
                            <strong>Итого: <?= number_format($total_sum, 0, '', ' ') ?> ₽</strong>
                        </div>

                        <form action="checkout.php" method="POST" style="margin-top: 15px;">
                            <button type="submit" class="btn" style="width: 100%; background: #4CAF50; color: white;">Оформить заказ</button>
                        </form>
                    </div>
                <?php else: ?>
                    <p style="text-align: center; padding: 20px;">Корзина пуста 🍬</p>
                    <a href="catalog.php" class="btn" style="display: block; text-align: center;">Перейти в каталог</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="glass-panel orders-section" style="margin-top: 30px;">
        <h3><?= $is_admin ? "Управление заказами (Все пользователи)" : "Моя история заказов" ?></h3>
        <div class="orders-list">
            <?php
            // Если админ — тянем всё, если юзер — только его
            $query = $is_admin 
                ? "SELECT orders.*, users.name as customer FROM orders JOIN users ON orders.user_id = users.id ORDER BY created_at DESC"
                : "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY created_at DESC";
            
            $orders_res = $conn->query($query);
            
            if ($orders_res && $orders_res->num_rows > 0):
                while($order = $orders_res->fetch_assoc()):
            ?>
                <div class="order-card" id="order-<?= $order['id'] ?>" style="display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.3); padding: 15px; border-radius: 15px; margin-bottom: 10px; transition: 0.3s;">
                    <div>
                        <strong>Заказ №<?= $order['id']; ?></strong> 
                        <?php if($is_admin) echo " | Клиент: " . htmlspecialchars($order['customer']); ?>
                        <br>
                        <small>От: <?= date('d.m.Y H:i', strtotime($order['created_at'])); ?></small>
                    </div>
                    
                    <div class="order-actions">
                        <?php if ($is_admin): ?>
                            <form method="POST" action="update_order.php" style="display: flex; gap: 10px; align-items: center;">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                
                                <select name="status" style="padding: 5px; border-radius: 10px; border: none; background: rgba(255,255,255,0.8);">
                                    <option value="Новый" <?= $order['status'] == 'Новый' ? 'selected' : '' ?>>Новый</option>
                                    <option value="Подтверждено" <?= $order['status'] == 'Подтверждено' ? 'selected' : '' ?>>Подтверждено</option>
                                    <option value="Отменено" <?= $order['status'] == 'Отменено' ? 'selected' : '' ?>>Отменено</option>
                                </select>

                                <button type="submit" name="update_status" class="btn" style="padding: 5px 10px; font-size: 0.8rem;">Ок</button>
                                <button type="submit" name="delete_order" class="btn" style="background: rgba(231,76,60,0.5); padding: 5px 10px; font-size: 0.8rem;" onclick="return confirm('Точно удалить?')">❌</button>
                            </form>
                        <?php else: ?>
                            <span class="status-badge" style="background: #fff;"><?= $order['status']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php 
                endwhile;
            else: ?>
                <div class="empty-state" style="padding: 40px 0; text-align: center;">
                    <img src="assets/img/empty-box.png" alt="" style="width: 80px; opacity: 0.5;">
                    <p><?= $is_admin ? "Заказов в базе пока нет." : "Вы еще не совершали заказов. Пора это исправить!" ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Перед тем как страница закроется (при нажатии на кнопку), сохраняем позицию скролла
    window.onbeforeunload = function() {
        localStorage.setItem('scrollPos', window.scrollY);
    };

    // Когда страница загрузилась заново, проверяем, есть ли сохраненная позиция
    window.onload = function() {
        if (localStorage.getItem('scrollPos')) {
            window.scrollTo(0, localStorage.getItem('scrollPos'));
            localStorage.removeItem('scrollPos'); // Очищаем, чтобы не скроллило всегда
        }
    };
</script>

<?php include 'footer.php'; ?>