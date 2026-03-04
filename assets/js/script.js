const burger = document.getElementById('burger');
const modal = document.getElementById('menu-modal');

if (burger && modal) {
    burger.addEventListener('click', () => {
        modal.classList.toggle('active');
        // Опционально: анимация бургера
        burger.classList.toggle('open');
    });

    // Закрываем, если кликнули по фону
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('active');
        }
    });
}

