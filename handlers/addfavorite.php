<?
include_once "db.php";
$typeFavorite = validate_input($_POST['type']);
$idFavorite = validate_input($_POST['id']);

if (isset($_SESSION['login'])&&isset($_SESSION['password'])) {
    $_SESSION['popup'] = "Упс, тебе сюда нельзя!";
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
        
    }
}
header("location: ../");
exit;