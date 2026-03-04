<?php 
require_once 'db.php';
$error = '';
$success = '';
$form_type = 'login'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $form_type = 'register';
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $pass = $_POST['password'];
        $confirm = $_POST['confirm'];
        
        if ($pass !== $confirm) {
            $error = "Пароли не совпадают!";
        } else {
            $check = $conn->query("SELECT id FROM users WHERE email='$email'");
            if ($check->num_rows > 0) {
                $error = "Email уже занят!";
            } else {
                $hashed = password_hash($pass, PASSWORD_DEFAULT);
                $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed')");
                $success = "Готово! Теперь войдите.";
                $form_type = 'login';
            }
        }
    }
    
    if (isset($_POST['login'])) {
        $form_type = 'login';
        $email = $conn->real_escape_string($_POST['email']);
        $pass = $_POST['password'];
        $res = $conn->query("SELECT * FROM users WHERE email='$email'");
        $user = $res->fetch_assoc();
        if ($user && password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: profile.php"); exit;
        } else {
            $error = "Неправильно введен email или пароль";
        }
    }
}
$page_title = "MarmeLato - Вход";
include 'header.php'; 
?>

<div class="auth-wrapper" style="padding: 60px 20px;">
    <div class="auth-container glass-panel" id="main-container">
        
        <div id="login-box" class="auth-box <?= ($form_type == 'login') ? '' : 'hidden' ?>">
            <h2>Вход</h2>
            <?php if($form_type == 'login' && $error) echo "<p style='color:#e74c3c; text-align:center; margin-bottom:15px;'>$error</p>"; ?>
            <?php if($success) echo "<p style='color:#27ae60; text-align:center; margin-bottom:15px;'>$success</p>"; ?>
            
            <form class="auth-form" method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <button type="submit" name="login" class="btn">Войти</button>
            </form>
            <p class="toggle-link">Нет аккаунта? <b onclick="toggleForm('register')">Создать профиль</b></p>
        </div>

        <div id="register-box" class="auth-box <?= ($form_type == 'register') ? '' : 'hidden' ?>">
            <h2>Регистрация</h2>
            <?php if($form_type == 'register' && $error) echo "<p style='color:#e74c3c; text-align:center; margin-bottom:15px;'>$error</p>"; ?>
            
            <form class="auth-form" method="POST">
                <input type="text" name="name" placeholder="Имя" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <input type="password" name="confirm" placeholder="Повторите пароль" required>
                <button type="submit" name="register" class="btn">Зарегистрироваться</button>
            </form>
            <p class="toggle-link">Уже в MarmeLato? <b onclick="toggleForm('login')">Войти</b></p>
        </div>

    </div>
</div>

<script>
function toggleForm(type) {
    const loginBox = document.getElementById('login-box');
    const registerBox = document.getElementById('register-box');

    if (type === 'register') {
        // Прячем логин
        loginBox.classList.add('hidden');
        // Показываем регистрацию
        registerBox.classList.remove('hidden');
    } else {
        // Прячем регистрацию
        registerBox.classList.add('hidden');
        // Показываем логин
        loginBox.classList.remove('hidden');
    }
}
</script>

<?php include 'footer.php'; ?>