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
    <title>DT Air</title>
    <link rel="stylesheet" href="css/s.css">
</head>
<body>
<?
        if (isset($_SESSION['login'])) {
            echo '<a href="/user/" class="link ico_link">
            <img src="" alt="Фото профиля" class="user_ico">
        </a>';   
        } else{
            echo '<a href="/login/" class="link login_link">
            Войти
        </a>';
        }
        ?>
</body>
</html>