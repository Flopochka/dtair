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
        if ((int)$typeFavorite == 1) {
             // Проверяем, существует ли лайк для этого пользователя и места
             $query = $con->prepare("SELECT * FROM favorite_locations WHERE user_id = ? AND destination_id = ?");
             $query->execute([$data['id'], $idFavorite]);
             $favorite = $query->fetch();
 
             if ($favorite) {
                 // Лайк уже существует, удаляем его
                 $query = $con->prepare("DELETE FROM favorite_locations WHERE user_id = ? AND destination_id = ?");
                 $query->execute([$data['id'], $idFavorite]);
             } else {
                 // Лайк не существует, добавляем его
                 $query = $con->prepare("INSERT INTO favorite_locations (user_id, destination_id) VALUES (?, ?)");
                 $query->execute([$data['id'], $idFavorite]);
             }
             echo "true";
             exit;
        }else{
            echo "false";
            exit;
        }
    }
}
header("location: ../");
exit;