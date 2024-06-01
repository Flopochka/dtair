<?
include_once "db.php";
$password = validate_input($_POST['password']);
$newpassword = validate_input($_POST['newpassword']);
$username = validate_input($_POST['username']);

if (!(isset($_SESSION['login'])&&isset($_SESSION['password']))) {
    $_SESSION['popup'] = "Упс, тебе сюда нельзя!";
} else{
    $query = $con->prepare("SELECT * FROM users WHERE login = ?");
    $query->execute([validate_input($_SESSION['login'])]);
    $data = $query->fetch();
    if (!password_verify($_SESSION['password'], $data['password'])) {
        $_SESSION = null;
        session_start();
        $_SESSION['popup'] = "Ошибочка, войдите в аккаунт снова!";
        echo "1";
        // header("location: logout.php");
        // exit;
    }else{
        if (isset($password)&&$password!=null) {
            if (!password_verify($_POST['password'], $data['password'])) {
                $_SESSION['popup'] = "Неверный пароль";
                echo "2";
                // header("location: logout.php");
                // exit;
            }else{
                $query = $con->prepare("UPDATE users SET `password` = ? WHERE login = ?");
                $query->execute([password_hash($newpassword, PASSWORD_DEFAULT), validate_input($_SESSION['login'])]);
                session_start();
                $_SESSION['password'] = $newpassword;
            }
        }
        if ($username != null) {
            $query = $con->prepare("UPDATE users SET  `username` = ? WHERE login = ?");
            $query->execute([$username, validate_input($_SESSION['login'])]);  
        }   
        if (isset($_FILES['file'])&&$_FILES['file']['tmp_name']!=null) {
            $uploadDir = 'img/profile/useravatars/';
            if (!is_dir('../'.$uploadDir)) {
                mkdir('../'.$uploadDir, 0777, true);
            }
            $uploadFile = $uploadDir . basename($_FILES['file']['name']);
            move_uploaded_file($_FILES['file']['tmp_name'], '../'.$uploadFile);
            $query = $con->prepare("UPDATE users SET `profile_pic` = ? WHERE login = ?");
            $query->execute([$uploadFile, validate_input($_SESSION['login'])]);
        }
    }
}
header("location: ../");
exit;