<?php
    include_once "db.php";
    var_dump($_SESSION);
    $_SESSION['popup'] = null;
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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT Air</title>
</head>
<body>
    <?
    if (isset($_SESSION['login'])) {
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
            echo '<a href="logout.php">logout</a><form action="userupdate.php" method="post">
            <input type="text" name="password" placeholder="oldpass">
            <input type="text" name="newpassword" placeholder="newpass">
            <input type="text" name="username" placeholder="username" value="'.$data['username'].'">
            <input type="submit" value="go">
            </form>';   
        }
    } else{
        echo '<form action="singup.php" method="post">
        <input type="password" name="password" id="password">
        <input type="text" name="login" id="login">
        <input type="submit" value="reg">
    </form>
    <form action="login.php" method="post">
        <input type="password" name="password" id="password">
        <input type="text" name="login" id="login">
        <input type="submit" value="log">
    </form>';
    }
    ?>
    
</body>
</html>