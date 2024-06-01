<?
include_once "db.php";
session_start();
$login = validate_input($_POST['login']);
$password = validate_input($_POST['password']);
if (!(isset($_SESSION['login'])&&isset($_SESSION['password']))) {
    $query = $con->prepare("SELECT * FROM users WHERE login = ?");
    $query->execute([$login]);
    $data = $query->fetch();
    if ($data && password_verify($password, $data['password'])) {
        $query = $con->prepare("UPDATE users SET `last_seens` = ? WHERE login = ?");
        $query->execute([date('Y-m-d H:i:s', time()), $login]);
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
    } else {
        $_SESSION['popup'] = "Неверный логин или пароль";
    }
}else{
    $_SESSION['popup'] = "Упс, тебе сюда нельзя!";
}
header("location: ../");
exit;