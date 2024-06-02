<?
include_once $_SERVER['DOCUMENT_ROOT']."/handlers/db.php";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT Air - личный кабинет</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/plane.svg" type="image/x-icon">
</head>
<body>
    <header>
        <div class="section header_section">
           <div class="container header_container">
                <a href="../" class="link logo_link">
                    <img class="logo" src="../img/plane.svg" alt="Логотип">
                </a>
                <nav class="header_nav">
                    <?
                    if (!(isset($_SESSION['login'])&&isset($_SESSION['password']))) {
                        echo '<a href="..login/" class="link nav-link">Войти</a>
                        <a href="..singup/" class="link nav-btn">Зарегестироватся</a>';
                    } else{
                        $query = $con->prepare("SELECT * FROM users WHERE login = ?");
                        $query->execute([validate_input($_SESSION['login'])]);
                        $data = $query->fetch();
                        if (!password_verify($_SESSION['password'], $data['password'])) {
                            $_SESSION = null;
                            session_start();
                            $_SESSION['popup'] = "Ошибочка, войдите в аккаунт снова!";
                            header("location: ../handlers/logout.php");
                            exit;
                        }else{
                            echo '<a href="/" class="link nav-link"><img class="user-ico" src="../'.$data['profile_pic'].'" alt="Профиль пользователя"></a>';  
                        }
                    }
                    ?>
                </nav>
           </div>
        </div>
    </header>
    <main>
        <section class="section search_section">
            <div class="container search_container">
                <h1>Результаты поиска</h1>
                <table>
                <?php
                    // Получаем параметры из GET запроса
                    $from_dest = $_GET['from_dest'];
                    $to_dest = $_GET['to_dest'];
                    $from_date = $_GET['from_date'];
                    $to_date = $_GET['to_date'];
                    $query = $con->prepare("SELECT * FROM destinations");
                    $query->execute();
                    $data = $query->fetchAll();
                    foreach ($data as $opt) {
                        if ($from_dest == $opt['title']) {
                            $from_dest = $opt['id'];
                        }
                        if ($to_dest == $opt['title']) {
                            $to_dest = $opt['id'];
                        }
                    }

                    // Готовим SQL запрос для получения рейсов
                    $stmt = $con->prepare("SELECT * FROM flights WHERE date = ?");
                    
                    // Привязываем параметры к запросу
                    // Выполняем запрос
                    $stmt->execute([$from_date]);

                    // Получаем результат запроса
                    $result1 = $stmt->fetchAll();
                    var_dump($result1);

                    $stmt = $con->prepare("SELECT * FROM flights WHERE departure_destination = ? AND arrival_destination = ? AND date = ?");

                    // Привязываем параметры к запросу
                    // Выполняем запрос
                    $stmt->execute([$to_dest, $from_dest, $to_date]);

                    // Получаем результат запроса
                    $result2 = $stmt->fetchAll();
                    ?>
                </table>
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
    <script src="../js/main.js"></script>
</body>
</html>