<?
include_once "../handlers/db.php";
var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT Air - вход</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="section header_section">
           <div class="container header_container">
                <a href="../" class="link logo_link">
                    <img src="" alt="Логотип">
                </a>
                <nav class="header_nav">
                    <?
                    if (!(isset($_SESSION['login'])&&isset($_SESSION['password']))) {
                        echo '<a href="login/" class="link nav-link">Войти</a>
                        <a href="" class="link nav-btn">Зарегестироватся</a>';
                    } else{
                        $query = $con->prepare("SELECT * FROM users WHERE login = ?");
                        $query->execute([validate_input($_SESSION['login'])]);
                        $data = $query->fetch();
                        if (!password_verify($_SESSION['password'], $data['password'])) {
                            $_SESSION = null;
                            session_start();
                            $_SESSION['popup'] = "Ошибочка, войдите в аккаунт снова!";
                            header("location: logout.php");
                            exit;
                        }else{
                            echo '<a href="" class="link nav-link"><img class="user-ico" src="" alt="Профиль пользователя"></a>';  
                        }
                    }
                    ?>
                </nav>
           </div>
        </div>
    </header>
    <main>
        <section class="section reg_section">
            <div class="container reg_container">
                <h1>Вход</h1>
                <form action="../handlers/login.php" class="reg_form" method="POST">
                    <label class="form-label"><input type="text" name="login" class="form-input" placeholder="Логин"></label>
                    <label class="form-label"><input type="password" name="password" class="form-input" placeholder="Пароль"></label>
                    <input class="form-butn" type="submit" value="Войти">
                </form>
            </div>
        </section>
    </main>
    <footer>
        <div class="section footer_section">
            <div class="footer_contacts">
                <h3 class="footer-title">Контакты</h3>
                <a href="" class="link nav-link">
                    +7 (800) 000-00-00
                    <p class="footer-text">Консультации по телефону</p>
                </a>
                <a href="" class="link nav-link">
                    infi@sitename.ru
                    <p class="footer-text">Электронная почта</p>
                </a>
            </div>
            <nav class="footer_nav">
                <a href="" class="link nav-link">Оплата</a>
                <a href="" class="link nav-link">Контакты</a>
                <a href="" class="link nav-link">Реквезиты</a>
                <a href="" class="link nav-link">Заказ удобного рейса</a>
                <a href="" class="link nav-link">Бронирование онлайн</a>
                <a href="" class="link nav-link">Выбор маршрута</a>
            </nav>
        </div>
    </footer>
</body>
</html>