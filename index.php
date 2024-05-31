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
    <?php
    include_once "header.php";
    ?>
    <main>
        <section class="ticket_section">
            <div class="container ticket_container">
                <h1>Удобный поиск авиабилетов</h1>
                <form action="" class="ticket_form">
                    <div class="row"><input type="submit" value="Поиск билетов"></div>
                    <div class="row">
                        <label class="label-gliding">
                            <input type="text" class="input-gliding ticket_input" placeholder="Откуда">
                        </label>
                        <label class="label-gliding">
                            <input type="text" class="input-gliding ticket_input" placeholder="Куда">
                        </label>
                        <label class="label-gliding">
                            <input type="text" class="input-gliding ticket_input" placeholder="Когда">
                        </label>
                        <label class="label-gliding">
                            <input type="text" class="input-gliding ticket_input" placeholder="Обратно">
                        </label>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>