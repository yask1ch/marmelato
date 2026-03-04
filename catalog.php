<?php
session_start();
require_once 'db.php';

// 1. Получаем параметры из URL
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

// 2. Строим базовый SQL запрос
$sql = "SELECT * FROM products WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
}

if (!empty($category)) {
    $sql .= " AND category = '$category'";
}

// 3. Добавляем сортировку
switch ($sort) {
    case 'price_asc':
        $sql .= " ORDER BY price ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY price DESC";
        break;
    default:
        $sql .= " ORDER BY id DESC";
        break;
}
$products = $conn->query($sql);
$page_title = "Каталог мармелада - MarmeLato";
include 'header.php';
?>
<main>
    <div class="section catalog-wrapper" style="margin-top: 100px; padding: 20px;">
        <h1 class="section-title">Наш мармелад 🍬</h1>

        <div class="glass-panel filter-panel" style="margin-bottom: 30px;">
            <form action="catalog.php" method="GET" class="filter-form">
                <div class="filter-item search-box">
                    <input type="text" name="search" placeholder="Поиск сладостей..." value="<?= htmlspecialchars($search) ?>" class="input-field">
                </div>

                <div class="filter-item">
                    <select name="category" class="input-field">
                        <option value="">Все категории</option>
                        <option value="Классика" <?= $category == 'Классика' ? 'selected' : '' ?>>Классика</option>
                        <option value="Кислые" <?= $category == 'Кислые' ? 'selected' : '' ?>>Кислые</option>
                        <option value="Фруктовые" <?= $category == 'Фруктовые' ? 'selected' : '' ?>>Фруктовые</option>
                    </select>
                </div>

                <div class="filter-item">
                    <select name="sort" class="input-field">
                        <option value="default">Новинки</option>
                        <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Сначала дешевле</option>
                        <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Сначала дороже</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-apply">Применить</button>
                    <?php if(!empty($search) || !empty($category) || $sort !== 'default'): ?>
                        <a href="catalog.php" class="btn btn-reset">Сбросить</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="products-grid">
            <?php if ($products->num_rows > 0): ?>
                <?php while($item = $products->fetch_assoc()): ?>
                    <div class="glass-panel product-card">
                        <div class="product-img">
                            <img src="assets/img/products/<?= $item['image'] ?: 'no-photo.png' ?>" alt="<?= $item['title'] ?>">
                        </div>
                        <div class="product-info">
                            <span class="category-tag"><?= $item['category'] ?></span>
                            <h3><?= htmlspecialchars($item['title']) ?></h3>
                            <p class="price"><?= number_format($item['price'], 0, '', ' ') ?> ₽</p>
                            
                            <form action="add_to_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-buy">Выбрать</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>К сожалению, ничего не нашлось... 🍭</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="product-modal" id="product-modal">
    <div class="modal-content glass-panel">
        <span class="close-modal">&times;</span>
        
        <div class="modal-body">
            <div class="modal-image">
                <img id="modal-img" src="" alt="">
            </div>
            
            <div class="modal-details">
                <span id="modal-category" class="category-tag"></span>
                <h2 id="modal-title"></h2>
                <p id="modal-desc" class="product-description"></p>
                <p class="modal-price"><span id="modal-price"></span> ₽</p>
                
                <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                    <input type="hidden" name="product_id" id="modal-product-id">
                    
                    <div class="counter">
                        <button type="button" class="count-btn minus">-</button>
                        <input type="number" name="quantity" value="1" min="1" id="product-count" readonly>
                        <button type="button" class="count-btn plus">+</button>
                    </div>
                    
                    <button type="submit" class="btn btn-main">Добавить в корзину</button>
                </form>
            </div>
        </div>
    </div>
</div>
</main>

<?php include 'footer.php'; ?>