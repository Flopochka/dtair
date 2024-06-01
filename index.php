<?php
    include_once "db.php";
    $_SESSION['popup'] = null;
    if (isset($_SESSION['password'])) {
        $query = $con->prepare("SELECT * FROM users WHERE login = ?");
        $query->execute([validate_input($_SESSION['login'])]);
        $data = $query->fetch();
        if (!password_verify($_SESSION['password'], $data['password'])) {
            $_SESSION = null;
            session_start();
            $_SESSION['popup'] = "Ошибочка, войдите в аккаунт снова!";
            header("location: logout.php");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница - DT Airlines</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="header-container">
                <h1>DT Airlines</h1>
                <nav>
                    <?
                        if (isset($_SESSION['login'])) {
                            echo '<a href="/user/" class="link ico_link">
                            <img src="" alt="Фото профиля" class="user_ico">
                        </a>';   
                        } else{
                            echo '<a href="login/" class="sign-up-button">Sign Up</a>';
                        }
                    ?>
                </nav>
            </div>
        </header>

        <main>
            <section class="hero">
                <h2>Удобный поиск авиабилетов</h2>
                <button class="search-button">Поиск билетов</button>
                <div class="search-filters">
                    <input type="text" placeholder="Откуда...">
                    <input type="text" placeholder="Куда...">
                    <input type="text" placeholder="Когда...">
                    <input type="text" placeholder="Обратно...">
                </div>
            </section>

            <section class="popular-routes">
                <h2>Популярные рейсы</h2>
                <div class="routes-grid">
                    <div class="route-card">
                        <img src="img/mumbai.png" alt="Mumbai - Delhi">
                        <div class="route-info">
                            <h3>Mumbai - Delhi</h3>
                            <p>Из Mumbai в обратно от 1500 ₽</p>
                            <button class="details-button">Подробнее</button>
                        </div>
                    </div>
                    <div class="route-card">
                        <img src="img/delhi.png" alt="Bangalore - Chennai">
                        <div class="route-info">
                            <h3>Bangalore - Chennai</h3>
                            <p>Из Bangalore в обратно от 1500 ₽</p>
                            <button class="details-button">Подробнее</button>
                        </div>
                    </div>
                    <div class="route-card">
                        <img src="img/hyderad.png" alt="Hyderabad - Delhi">
                        <div class="route-info">
                            <h3>Hyderabad - Delhi</h3>
                            <p>Из Hyderabad в обратно от 1500 ₽</p>
                            <button class="details-button">Подробнее</button>
                        </div>
                    </div>
                    <div class="route-card">
                        <img src="img/kolkata.png" alt="Kolkata - Bangalore">
                        <div class="route-info">
                            <h3>Kolkata - Bangalore</h3>
                            <p>Из Kolkata в обратно от 1500 ₽</p>
                            <button class="details-button">Подробнее</button>
                        </div>
                    </div>
                    <div class="route-card">
                        <img src="img/delhi-chenhall.png" alt="Delhi - Chennai">
                        <div class="route-info">
                            <h3>Delhi - Chennai</h3>
                            <p>Из Delhi в обратно от 1500 ₽</п>
                            <button class="details-button">Подробнее</button>
                        </div>
                    </div>
                    <div class="route-card">
                        <img src="img/chenhall-mumbai.png" alt="Chennai - Mumbai">
                        <div class="route-info">
                            <h3>Chennai - Mumbai</h3>
                            <p>Из Chennai в обратно от 1500 ₽</п>
                            <button class="details-button">Подробнее</button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="popular-places">
                <h2>Популярные места</h2>
                <div class="places-grid">
                    <div class="place-card">
                        <img src="img/img.png" alt="Mumbai">
                        <div class="place-info">
                            <h3>Mumbai</h3>
                            <p>Самый западный, многонациональный и крупный город Индии</п>
                            <button class="details-button">Подробнее</button>
                        </div>
                    </div>
                    <div class="place-card">
                        <img src="img/delhi3.png" alt="Delhi">
                        <div class="place-info">
                            <h3>Delhi</h3>
                            <p>Столица Индии и второй по величине город страны</п>
                            <button class="details-button">Подробнее</button>
                        </div>
                    </div>
                    <div class="place-card">
                        <img src="img/kolkata2.png" alt="Kolkata">
                        <div class="place-info">
                            <h3>Kolkata</h3>
                            <п>Культурное сердце современной Индии</п>
                            <button class="details-button">Подробнее</button>
                        </div>
                    </div>
                </div>
            </section>

            <section class="contacts">
                <h2>Контакты</h2>
                <p>+7 (800) 000-00-00</п>
                <п>info@sitename.ru</п>
            </section>
        </main>

        <footer>
            <div class="footer-container">
                <div class="footer-column">
                    <h3>Сервис</h3>
                    <ul>
                        <li><a href="#">Оплата</a></ли>
                        <ли><a href="#">Контакты</a></ли>
                        <ли><a href="#">Реквизиты</a></ли>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Наши услуги</h3>
                    <ul>
                        <ли><a href="#">Заказ удобного рейса</а></ли>
                        <ли><а href="#">Бронирование онлайн</а></ли>
                        <ли><а href="#">Выбор маршрута</а></ли>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Контакты</h3>
                    <п>+7 (800) 000-00-00<br>Консультации по телефону</п>
                    <п>Электронная почта: info@sitename.ru</п>
                </div>
            </div>
        </footer>
    </div>
    <script src="js/main.js"></script>
</body>
</html>