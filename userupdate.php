<?
include_once "db.php";
include_once "auth.php";








if (!(isset($session_temp['login'])&&isset($session_temp['password']))) {
    $_SESSION['popup'] = "Упс, тебе сюда нельзя!";
    header("location: index.php");
    exit;
} else{
    $query = $con->prepare("SELECT * FROM users WHERE login = ?");
    $query->execute([$_SESSION['login']]);
    $data = $query->fetch();
    if ($_SESSION['password']!=$data['password']) {
        session_destroy();
        session_start();
        $_SESSION['popup'] = "Ошибочка, войдите в аккаунт снова!";
        echo "bad 2";
        header("location: index.php");
        exit;
    }
}
if (!(isset($_SESSION['login'])&&isset($_SESSION['password']))) {
    $login = validate_input($_POST['login']);
    $password = validate_input($_POST['password']);

    $query = $con->prepare("SELECT * FROM users WHERE login = ?");
    $query->execute([$login]);
    $data = $query->fetch();
    session_start();

    if (isset($data['id'])) {
        $_SESSION['popup'] = 'Данный логин уже используется, попробуйте другой';
        echo "Данный логин уже используется, попробуйте другой";
    }else{
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = $con->prepare("INSERT INTO users (login, password) VALUES (?, ?)");
        $query->execute([$login, $hashed_password]);
        $_SESSION['popup'] = 'Успешная регистрация!';
        echo "Успешная регистрация!";
    }
}else{
    $_SESSION['popup'] = 'Упс, тебе сюда нельзя!';
}
var_dump($_SESSION);
header("location: index.php");
exit;