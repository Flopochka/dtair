<?
include_once "../db.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в личный кабинет - DT Airlines</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="header-container">
                <h1>DT Airlines</h1>
                <nav>
                    <a href="#">главная</a>
                    <a href="#" class="sign-up-button">Sign Up</a>
                </nav>
            </div>
        </header>

        <main>
            <div class="login-container">
                <h2>Вход в личный кабинет</h2>
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="login">Введите ваш телефон, логин или e-mail</label>
                        <input type="text" id="login" name="login" placeholder="Телефон/e-mail/логин" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Введите пароль</label>
                        <input type="password" id="password" name="password" placeholder="Пароль" required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="login-button">Войти</button>
                        <button type="button" class="register-button">Зарегистрироваться</button>
                    </div>
                </form>
            </div>
        </main>

        <footer>
            <div class="footer-container">
                <div class="footer-column">
                    <h3>Сервис</h3>
                    <ul>
                        <li><a href="#">Оплата</a></li>
                        <li><a href="#">Контакты</a></li>
                        <li><a href="#">Реквизиты</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Наши услуги</h3>
                    <ul>
                        <li><a href="#">Заказ удобного рейса</a></li>
                        <li><a href="#">Бронирование онлайн</a></li>
                        <li><a href="#">Выбор маршрута</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Контакты</h3>
                    <p>+7 (800) 000-00-00<br>Консультации по телефону</p>
                    <p>Электронная почта: info@sitename.ru</p>
                </div>
            </div>
        </footer>
    </div>
    <script src="/js/main.js"></script>
</body>
</html>