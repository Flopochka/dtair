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
                            header("location: logout.php");
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
                        <img src="<? echo '../'.$data['profile_pic']; ?>" alt="" class="user-pic">
                        <label class="input-file">
                            <input type="file" name="file" accept="image/*">		
                            <span>Выберите фото</span>
                        </label>
                        <input class="user-btn" type="submit" value="Обновить">
                    </div>
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