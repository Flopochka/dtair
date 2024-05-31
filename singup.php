<?
include_once "db.php";
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