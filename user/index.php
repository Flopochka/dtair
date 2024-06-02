<?php
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
                    <?php
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
        <section class="section user_section">
            <div class="container user_container">
                <h1>Личный кабинет</h1>
                <form action="../handlers/userupdate.php" class="user_form" method="POST" enctype="multipart/form-data">
                    <div class="user_data">
                        <label for="" class="user-line">
                            <input type="text" name="username" value="<? echo $data['username']; ?>" placeholder="Ваше имя">
                        </label>
                        <label for="" class="user-line">
                            <p class="user-text">Старый пароль</p>
                            <input type="password" name="password">
                        </label>
                        <label for="" class="user-line">
                            <p class="user-text">Новый пароль</p>
                            <input type="password" name="newpassword">
                        </label>
                    </div>
                    <div class="user_photo">
                        <img src="<?php echo '../'.$data['profile_pic']; ?>" alt="" class="user-pic">
                        <label class="input-file">
                            <input type="file" name="file" accept="image/*">		
                            <span>Выберите фото</span>
                        </label>
                        <input class="user-btn" type="submit" value="Обновить">
                    </div>
                </form>
            </div>
        </section>
        <section class="section favor_section">
            <div class="container favor_container">
                <h1>Избранное</h1>
                <?php
                // Предполагается, что у вас уже установлено соединение с базой данных $con и идентификатор пользователя доступен в $_SESSION['user_id']

                // Получаем идентификатор пользователя
                $user_id = $data['id'];

                // Получаем все лайкнутые пользователем места
                $query = $con->prepare("SELECT p.* FROM places p INNER JOIN favorite_places fp ON p.id = fp.place_id WHERE fp.user_id = ?");
                $query->execute([$user_id]);
                $favorite_places = $query->fetchAll(PDO::FETCH_ASSOC);

                echo '<div class="places_box">';
                // Выводим каждое место
                foreach ($favorite_places as $place) {
                    echo '<div class="place-card">
                            <img src="../'.$place['img'].'" alt="" class="place-img">
                            <div class="place-info">
                                <h3 class="place-title">'.$place['title'].'</h3>
                                <p class="place-text">'.$place['subtitle'].'</p>
                                <button class="place-btn">Избранное</button>
                                <input type="text" hidden value="'.$place['id'].'" class="hdndata">
                            </div>
                        </div>';
                }
                echo '</div>';

                // Получаем все лайкнутые пользователем достопримечательности
                $query = $con->prepare("SELECT d.* FROM destinations d INNER JOIN favorite_locations fl ON d.id = fl.destination_id WHERE fl.user_id = ?");
                $query->execute([$user_id]);
                $favorite_destinations = $query->fetchAll(PDO::FETCH_ASSOC);

                echo '<div class="destinations_box">';
                // Выводим каждую достопримечательность
                foreach ($favorite_destinations as $destination) {
                    echo '<div class="destination-card" style="background-image:url(../'.$destination["img"].')">
                            <div class="destination-shadow"></div>
                            <div class="destination-info">
                                <h3 class="destination-title">'.$destination["title"].'</h3>
                                <p class="destination-text">В '.$destination["title"].' и обратно</p>
                                <p class="destination-price">от '.$destination["price"].'р</p>
                                <a href="?destination='.$destination["id"].'" class="destination-btn">Подробнее</a>
                            </div>
                            <img src="../img/its-favorite.svg" alt="" class="destination-favorite">
                            <input type="text" hidden value="'.$destination["id"].'" class="hdndata">
                        </div>';
                }
                echo "</div>";
                ?>
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