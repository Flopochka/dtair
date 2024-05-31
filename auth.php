<?
include_once "db.php";
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