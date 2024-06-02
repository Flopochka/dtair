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
    <link rel="preload" href="/css/style.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="/css/style.css"></noscript>
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
                            header("location: handlers/logout.php");
                            exit;
                        }
                    }
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
                        echo '  <div class="destination-card lazy-load" data-bg="'.$destination["img"].'">
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
                        }
                    }
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
    <style>
        h1,h2{margin-bottom:var(--space8)}.header_container,body{display:-webkit-box;display:-ms-flexbox}body,footer,header,main{overflow-x:hidden;width:100%}.form-input,.nav-btn{border-radius:var(--rad1)}.logo,.user-ico{height:var(--space8)}.search_form,body{-webkit-box-orient:vertical;-webkit-box-direction:normal}@font-face{font-family:inter;src:url(/fonts/Inter-VariableFont_slnt\,wght.ttf)}:root{--font1:12px;--font2:14px;--font3:16px;--font4:18px;--font5:20px;--font6:24px;--font7:30px;--font8:36px;--font9:48px;--font10:60px;--space1:10px;--space2:15px;--space3:20px;--space4:25px;--space5:30px;--space6:40px;--space7:50px;--space8:60px;--space9:100px;--rad1:5px;--rad2:10px;--rad3:15px;--rad4:20px;--rad5:25px}*{margin:0;padding:0;-webkit-box-sizing:border-box;box-sizing:border-box;text-decoration:none;color:inherit;font-family:inter}h1{font-size:var(--font10);text-align:center}h2{font-size:var(--font9)}h3{font-size:var(--font8)}h4{font-size:var(--font7)}h5{font-size:var(--font6)}a,h6,p{font-size:var(--font5)}body{min-height:100vh;display:flex;-ms-flex-direction:column;flex-direction:column;background:#f8f8f8;color:#333}.nav-btn,footer{background:#000}header{-webkit-box-shadow:0 5px 10px rgba(0,0,0,.384);box-shadow:0 5px 10px rgba(0,0,0,.384)}.section{padding:var(--space5) var(--space8);width:100%}.header_section{padding:var(--space3) var(--space8)}.header_container{display:flex;-webkit-box-pack:justify;-ms-flex-pack:justify;justify-content:space-between;-webkit-box-align:center;-ms-flex-align:center;align-items:center}.link{color:#000}.form-butn,.nav-btn{color:#fff;font-size:var(--font4);-webkit-transition:-webkit-filter .2s,-webkit-transform .2s;outline:0}.logo{width:var(--space8)}.header_nav{display:-webkit-box;display:-ms-flexbox;display:flex;gap:var(--space3);-webkit-box-align:center;-ms-flex-align:center;align-items:center}.nav-btn{width:-webkit-fit-content;width:-moz-fit-content;width:fit-content;-ms-grid-column-align:center;justify-self:center;padding:var(--space2) var(--space5);border:2px solid #fff;transition:filter .2s,transform .2s,-webkit-filter .2s,-webkit-transform .2s;-o-transition:filter .2s,transform .2s;-webkit-transform:scale(1);-ms-transform:scale(1);transform:scale(1)}.nav-btn:hover{-webkit-transform:scale(1.1);-ms-transform:scale(1.1);transform:scale(1.1);-webkit-filter:invert(100%);filter:invert(100%)}.user-ico{width:var(--space8);border-radius:50%;display:block;border:1px solid #333;-o-object-fit:cover;object-fit:cover}.search_form{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;gap:var(--space5)}.search_box{display:-ms-grid;display:grid;width:100%;gap:var(--space5);grid-template-columns:repeat(auto-fit,minmax(100px,1fr))}.form-label{width:100%;padding:2px;z-index:1;position:relative}.form-input{width:100%;padding:var(--space2);background:#fff;border:1px solid #333;outline:0;font-size:var(--font4);position:relative;display:block;cursor:default;overflow:hidden;-webkit-transition:background .2s,-webkit-transform .2s;transition:background .2s,transform .2s,-webkit-transform .2s;-o-transition:background .2s,transform .2s;-webkit-transform:scale(1);-ms-transform:scale(1);transform:scale(1)}.destination-btn:hover,.form-input:hover{-webkit-transform:scale(1.1);-ms-transform:scale(1.1);transform:scale(1.1)}.form-input:active,.form-input:focus-visible{background:coral;-webkit-transform:scale(1);-ms-transform:scale(1);transform:scale(1)}.form-butn{padding:var(--space2) var(--space5);border-radius:var(--rad1);background:#000;border:2px solid #fff;transition:filter .2s,transform .2s,-webkit-filter .2s,-webkit-transform .2s;-o-transition:filter .2s,transform .2s;-webkit-transform:scale(1);-ms-transform:scale(1);transform:scale(1);-webkit-filter:none;filter:none}.form-butn:hover{-webkit-transform:scale(1.1);-ms-transform:scale(1.1);transform:scale(1.1);-webkit-filter:drop-shadow(0 0 5px coral) invert();filter:drop-shadow(0 0 5px coral) invert()}.destinations_box{width:100%;display:-ms-grid;display:grid;gap:var(--space5);grid-template-columns:repeat(auto-fill,minmax(350px,1fr))}.destination-card{width:100%;display:-ms-grid;display:grid;-ms-grid-rows:1fr 2fr;grid-template-rows:1fr 2fr;background:center/cover no-repeat #333;border-radius:var(--rad1);position:relative;border:1px solid #333}.destination-shadow{border-top-left-radius:var(--rad1);border-top-right-radius:var(--rad1);background:-webkit-gradient(linear,left top,left bottom,from(rgba(0,0,0,0)),to(rgba(255,255,255,.75)));background:-o-linear-gradient(top,rgba(0,0,0,0) 0,rgba(255,255,255,.75) 100%);background:linear-gradient(180deg,rgba(0,0,0,0) 0,rgba(255,255,255,.75) 100%)}.destination-info{background:rgba(255,255,255,.75);width:100%;padding:var(--space5);display:-ms-grid;display:grid;-ms-grid-rows:1fr var(--space2) 1fr var(--space2) auto var(--space2) 1fr;grid-template-rows:1fr 1fr auto 1fr;-ms-grid-columns:1fr;grid-template-columns:1fr;color:#333;text-align:start;-webkit-box-pack:start;-ms-flex-pack:start;justify-content:start;gap:var(--space2);border-bottom-left-radius:var(--rad1);border-bottom-right-radius:var(--rad1)}.destination-info>:first-child{-ms-grid-row:1;-ms-grid-column:1}.destination-info>:nth-child(2){-ms-grid-row:3;-ms-grid-column:1}.destination-info>:nth-child(3){-ms-grid-row:5;-ms-grid-column:1}.destination-info>:nth-child(4){-ms-grid-row:7;-ms-grid-column:1}.destination-price{font-size:var(--font7);font-weight:600;-ms-grid-column-align:end;justify-self:end}.destination-btn{width:-webkit-fit-content;width:-moz-fit-content;width:fit-content;-ms-grid-column-align:center;justify-self:center;padding:var(--space2) var(--space5);border-radius:var(--rad1);background:0 0;color:#333;border:2px solid #333;outline:0;font-size:var(--font4);-webkit-transition:-webkit-filter .2s,-webkit-transform .2s;transition:filter .2s,transform .2s,-webkit-filter .2s,-webkit-transform .2s;-o-transition:filter .2s,transform .2s;-webkit-transform:scale(1);-ms-transform:scale(1);transform:scale(1)}.destination-favorite{position:absolute;width:var(--space6);height:var(--space6);top:var(--space1);right:var(--space1);-o-object-fit:contain;object-fit:contain}
        @media (max-width:1440px){:root{--font1:10px;--font2:12px;--font3:14px;--font4:16px;--font5:18px;--font6:20px;--font7:24px;--font8:30px;--font9:36px;--font10:48px}.search_box{grid-template-columns:repeat(auto-fit,minmax(60px,1fr))}}@media (max-width:768px){.search_box,.user_photo{-ms-grid-columns:1fr 1fr}.place-img,.place-info,.user-pic,.user_data{width:100%}:root{--font1:8px;--font2:10px;--font3:12px;--font4:14px;--font5:16px;--font6:18px;--font7:20px;--font8:24px;--font9:30px;--font10:36px;--space1:5px;--space2:10px;--space3:15px;--space4:20px;--space5:25px;--space6:30px;--space7:40px;--space8:50px;--space9:60px}.search_box{grid-template-columns:1fr 1fr;-ms-grid-rows:1fr 1fr;grid-template-rows:1fr 1fr}.search_box>:first-child,.user_photo>:first-child{-ms-grid-row:1;-ms-grid-column:1}.search_box>:nth-child(2),.user_photo>:nth-child(2){-ms-grid-row:1;-ms-grid-column:2}.search_box>:nth-child(3),.user_photo>:nth-child(3){-ms-grid-row:2;-ms-grid-column:1}.search_box>:nth-child(4),.user_photo>:nth-child(4){-ms-grid-row:2;-ms-grid-column:2}.destinations_box{grid-template-columns:repeat(auto-fit,minmax(250px,1fr))}.place-card,.place-card:nth-child(2n),.user_form{-webkit-box-orient:vertical;-webkit-box-direction:normal;-ms-flex-direction:column;flex-direction:column}.place-btn{-ms-grid-column-align:end;justify-self:end}.footer_nav,.footer_section{-ms-flex-wrap:wrap;flex-wrap:wrap}.user_photo{width:100%;grid-template-columns:1fr 1fr;-ms-grid-rows:auto 1fr;grid-template-rows:auto 1fr}.user-pic{-ms-grid-row:1;-ms-grid-row-span:1;grid-row:1/2;-ms-grid-column:1;grid-column:1;height:calc(200% + var(--space3))}.user-btn{-ms-grid-row:2;grid-row:2;-ms-grid-column:2;grid-column:2}.input-file{-ms-grid-row:1;grid-row:1;-ms-grid-column:2;grid-column:2}}@media (max-width:320px){:root{--font1:6px;--font2:8px;--font3:10px;--font4:12px;--font5:14px;--font6:16px;--font7:18px;--font8:20px;--font9:24px;--font10:30px;--space1:2px;--space2:5px;--space3:10px;--space4:15px;--space5:20px;--space6:25px;--space7:30px;--space8:40px;--space9:50px}.user-pic{height:200%}}
    </style>
    <script src="js/main.js"></script>
</body>
</html>