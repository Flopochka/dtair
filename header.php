<header>
    <div class="container header_container">
        <a href="" class="link logo_link">
            <img src="" alt="логотип" class="logo">
        </a>
        <?
        if (isset($_SESSION['login'])) {
            echo '<a href="/user/" class="link ico_link">
            <img src="" alt="Фото профиля" class="user_ico">
        </a>';   
        } else{
            echo '<a href="/login/" class="link login_link">
            Войти
        </a>';
        }
        ?>
    </div>
</header>