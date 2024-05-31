<?php
    include_once "db.php";
    var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?
    if (isset($session_temp['login'])) {
        
        echo '<a href="logout.php">logout</a><form action="userupdate.php">
        <input type="text" name="password" placeholder="oldpass">
        <input type="text" name="newpassword" placeholder="newpass">
        <input type="text" name="username" placeholder="username" value="">
        <input type="submit" value="go">
    </form>';
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