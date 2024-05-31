<header>
    <div class="container header_container">
        <a href="" class="link logo_link">
            <img src="" alt="логотип" class="logo">
        </a>
        <?
        if (isset($_SESSION['login'])) {
            
            echo '<a href="logout.php">logout</a><form action="userupdate.php" method="post">
                <input type="text" name="password" placeholder="oldpass">
                <input type="text" name="newpassword" placeholder="newpass">
                <input type="text" name="username" placeholder="username" value="'.$data['username'].'">
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
        <a href="" class="link login_link">
            Войти
        </a>
        <a href="" class="link ico_link">
            <img src="" alt="" class="user_ico">
        </a>
    </div>
</header>