<?php
include_once "handlers/db.php";
if (isset($_SESSION['popup'])&&$_SESSION['popup']!=null) {
    echo '<div class="popup">'.$_SESSION['popup'].'<div class="popup-close"></div></div>';
    session_start();
    $_SESSION['popup'] = null;
    session_write_close();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="дешёвые авиабилеты">
    <title>DT Air - дешёвые авиабилеты</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/plane.svg" type="image/x-icon">
</head>
<body>
    <header>
        <div class="section header_section">
           <div class="container header_container">
                <a href="/" class="link logo_link">
                    <img class="logo" src="img/plane.svg" alt="Логотип">
                </a>
                <nav class="header_nav">
                    <?php
                    if (!(isset($_SESSION['login'])&&isset($_SESSION['password']))) {
                        echo '<a href="login/" class="link nav-link">Войти</a>
                        <a href="singup/" class="link nav-btn">Зарегестироватся</a>';
                    } else{
                        $query = $con->prepare("SELECT * FROM users WHERE login = ?");
                        $query->execute([validate_input($_SESSION['login'])]);
                        $data = $query->fetch();
                        if (!password_verify($_SESSION['password'], $data['password'])) {
                            $_SESSION = null;
                            session_start();
                            $_SESSION['popup'] = "Ошибочка, войдите в аккаунт снова!";
                            header("location: handlers/logout.php");
                            exit;
                        }else{
                            echo '<a href="user/" class="link nav-link"><img class="user-ico" src="'.$data['profile_pic'].'" alt="Профиль пользователя"></a>';  
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
                <h1>Удобный поиск авиабилетов</h1>
                <form action="search/" class="search_form" method="GET">
                    <div class="search_box">
                        <label class="form-label"><input name="from_dest" type="text" list="destanations" class="form-input" placeholder="Откуда"></label>
                        <label class="form-label"><input name="to_dest" type="text" list="destanations" class="form-input" placeholder="Куда"></label>
                        <label class="form-label"><input name="from_date" type="date" class="form-input" placeholder="Когда"></label>
                        <label class="form-label"><input name="to_date" type="date" class="form-input" placeholder="Обратно"></label>
                    </div>
                    <input class="form-butn" type="submit" value="Найти">
                    <datalist id="destanations">
                        <?php
                        $query = $con->prepare("SELECT * FROM destinations");
                        $query->execute();
                        $data = $query->fetchAll();
                        foreach ($data as $opt) {
                            echo '<option value="'.$opt['title'].'">';
                        }
                        ?>
                    </datalist>
                </form>
            </div>
        </section>
        <section class="section destinations_section">
            <div class="container destinations_container">
                <h2>Популярные направления</h2>
                <div class="destinations_box">
                    <?php
                    if (!(isset($_SESSION['login']) && isset($_SESSION['password']))) {
                        $query = $con->prepare("SELECT * FROM favorite_locations");
                        $query->execute();
                        $data = $query->fetchAll();
                        $favorites = [];
                        foreach ($data as $row) {
                            $favorites[$row['destination_id']] = $row['favorites'];
                        }
                        arsort($favorites);
                        $topDestinations = array_slice(array_keys($favorites), 0, 3, true);

                        $placeholders = implode(',', array_fill(0, count($topDestinations), '?'));
                        $query = $con->prepare("SELECT * FROM destinations WHERE id IN ($placeholders)");
                        $query->execute($topDestinations);
                        $topDestinationsInfo = $query->fetchAll();
                        foreach ($topDestinationsInfo as $destination) {
                            echo '<div class="destination-card" style="background-image:url('.$destination["img"].')">
                            <div class="destination-shadow"></div>
                            <div class="destination-info">
                                <h3 class="destination-title">'.$destination["title"].'</h3>
                                <p class="destination-text">В '.$destination["title"].' и обратно</p>
                                <p class="destination-price">от '.$destination["price"].'р</p>
                                <a href="?destination='.$destination["id"].'" class="destination-btn">Подробнее</a>
                            </div>
                            <img src="img/non-favorite.svg" alt="" class="destination-favorite">
                            <input type="text" hidden value="'.$destination["id"].'" class="hdndata">
                            </div>';
                        }
                    } else {
                        $query = $con->prepare("SELECT * FROM users WHERE login = ?");
                        $query->execute([validate_input($_SESSION['login'])]);
                        $userdata = $query->fetch();
                        if (!password_verify($_SESSION['password'], $userdata['password'])) {
                            $_SESSION = null;
                            session_start();
                            $_SESSION['popup'] = "Ошибочка, войдите в аккаунт снова!";
                            echo "false";
                            exit;
                            header("location: logout.php");
                            exit;
                        } else {
                            $query = $con->prepare("SELECT * FROM favorite_locations");
                            $query->execute();
                            $data = $query->fetchAll();
                            $mylike = [];
                            foreach ($data as $row) {
                                if ($row['user_id']==$userdata['id']) {
                                    $mylike[$row['destination_id']] = 1;
                                }
                            }

                            $favorites = [];
                            foreach ($data as $row) {
                                $favorites[$row['destination_id']] = $row['favorites'];
                            }
                            arsort($favorites);
                            $topDestinations = array_slice(array_keys($favorites), 0, 3, true);
                            $placeholders = implode(',', array_fill(0, count($topDestinations), '?'));
                            $query = $con->prepare("SELECT * FROM destinations WHERE id IN ($placeholders)");
                            $query->execute($topDestinations);
                            $topDestinationsInfo = $query->fetchAll();
                            foreach ($topDestinationsInfo as $destination) {
                                echo '  <div class="destination-card" style="background-image:url('.$destination["img"].')">
                                            <div class="destination-shadow"></div>
                                            <div class="destination-info">
                                                <h3 class="destination-title">'.$destination["title"].'</h3>
                                                <p class="destination-text">В '.$destination["title"].' и обратно</p>
                                                <p class="destination-price">от '.$destination["price"].'р</p>
                                                <a href="?destination='.$destination["id"].'" class="destination-btn">Подробнее</a>
                                            </div>';
                                if ($mylike[$destination['id']]!= null) {
                                    echo '<img src="img/its-favorite.svg" alt="" class="destination-favorite favorited">';
                                } else {
                                    echo '<img src="img/non-favorite.svg" alt="" class="destination-favorite">';
                                }
                                echo '<input type="text" hidden value="'.$destination["id"].'" class="hdndata"></div>';
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
        <section class="section places_section">
            <div class="container places_container">
                <h2>Популярные места</h2>
                <div class="places_box">
                <?php
                    if (!(isset($_SESSION['login']) && isset($_SESSION['password']))) {
                        $destination = (int)$_GET['destination'];
                        if ($destination == null) {
                            $destination = rand(1, 6);
                        }
                        $query = $con->prepare("SELECT * FROM places WHERE destination_id = ?");
                        $query->execute([$destination]);
                        $placesData = $query->fetchAll(PDO::FETCH_ASSOC);
                        
                        $placeIds = array_column($placesData, 'id');
                        
                        $placeholders = implode(',', array_fill(0, count($placeIds), '?'));
                        
                        $query = $con->prepare("SELECT * FROM favorite_places WHERE place_id IN ($placeholders)");
                        $query->execute($placeIds);
                        $favoritesData = $query->fetchAll(PDO::FETCH_ASSOC);
                        
                        $favorites = [];
                        foreach ($favoritesData as $row) {
                            $favorites[$row['place_id']] = $row['favorites'];
                        }
                        arsort($favorites);
                        
                        
                        // Получение топ-3 мест
                        $topPlaceIds = array_slice(array_keys($favorites), 0, 3);
                        
                        
                        // Формирование плейсхолдеров для IN-условия для топ-3 мест
                        $topPlacePlaceholders = implode(',', array_fill(0, count($topPlaceIds), '?'));
                        
                        // Запрос информации о топ-3 местах из таблицы places
                        $query = $con->prepare("SELECT * FROM places WHERE id IN ($topPlacePlaceholders)");
                        // var_dump($query);
                        $query->execute($topPlaceIds);
                        $topPlacesInfo = $query->fetchAll(PDO::FETCH_ASSOC);
                        
                        // Вывод информации о топ-3 местах
                        foreach ($topPlacesInfo as $place) {
                            echo '<div class="place-card">
                            <img src="'.$place['img'].'" alt="" class="place-img">
                            <div class="place-info">
                            <h3 class="place-title">'.$place['title'].'</h3>
                            <p class="place-text">'.$place['subtitle'].'</p>
                            <button class="place-btn">В избранное</button>
                            <input type="text" hidden value="'.$place['id'].'" class="hdndata">
                            </div>
                            </div>';
                        }
                    } else {
                        $query = $con->prepare("SELECT * FROM users WHERE login = ?");
                        $query->execute([validate_input($_SESSION['login'])]);
                        $userdata = $query->fetch();
                        if (!password_verify($_SESSION['password'], $userdata['password'])) {
                            $_SESSION = null;
                            session_start();
                            $_SESSION['popup'] = "Ошибочка, войдите в аккаунт снова!";
                            echo "false";
                            exit;
                            header("location: logout.php");
                            exit;
                        } else {
                            $destination = (int)$_GET['destination'];
                        if ($destination == null) {
                            $destination = rand(1, 6);
                        }
                        $query = $con->prepare("SELECT * FROM places WHERE destination_id = ?");
                        $query->execute([$destination]);
                        $placesData = $query->fetchAll(PDO::FETCH_ASSOC);

                        $placeIds = array_column($placesData, 'id');

                        $placeholders = implode(',', array_fill(0, count($placeIds), '?'));

                        $query = $con->prepare("SELECT * FROM favorite_places WHERE place_id IN ($placeholders)");
                        $query->execute($placeIds);
                        $favoritesData = $query->fetchAll(PDO::FETCH_ASSOC);
                        $mylike = [];
                            foreach ($favoritesData as $row) {
                                if ($row['user_id']==$userdata['id']) {
                                    $mylike[$row['place_id']] = 1;
                                }
                            }
                        $favorites = [];
                        foreach ($favoritesData as $row) {
                            $favorites[$row['place_id']] = $row['favorites'];
                        }
                        arsort($favorites);


                        // Получение топ-3 мест
                        $topPlaceIds = array_slice(array_keys($favorites), 0, 3);


                        // Формирование плейсхолдеров для IN-условия для топ-3 мест
                        $topPlacePlaceholders = implode(',', array_fill(0, count($topPlaceIds), '?'));

                        // Запрос информации о топ-3 местах из таблицы places
                        $query = $con->prepare("SELECT * FROM places WHERE id IN ($topPlacePlaceholders)");
                        // var_dump($query);
                        $query->execute($topPlaceIds);
                        $topPlacesInfo = $query->fetchAll(PDO::FETCH_ASSOC);

                        // Вывод информации о топ-3 местах
                        foreach ($topPlacesInfo as $place) {
                            echo '<div class="place-card">
                                    <img src="'.$place['img'].'" alt="" class="place-img">
                                    <div class="place-info">
                                        <h3 class="place-title">'.$place['title'].'</h3>
                                        <p class="place-text">'.$place['subtitle'].'</p>';

                            // Проверяем, есть ли лайк пользователя для данного места
                            if ($mylike[$place['id']]!=null) {
                                echo '<button class="place-btn">Избранное</button>';
                            } else {
                                echo '<button class="place-btn">В избранное</button>';
                            }

                            echo '<input type="text" hidden value="'.$place['id'].'" class="hdndata">
                                </div>
                                </div>';
                        }
                        }
                    }
                    ?>
                </div>
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
    <script src="js/main.js"></script>
</body>
</html>