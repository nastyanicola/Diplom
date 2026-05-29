<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="header-catalog">
        <div class="header">

            <a href="./index.php" class="logo">
                <img src="./img/logo.svg" alt="logo">
            </a>

            <nav class="nav">
                <a href="catalog.php">Каталог</a>
                <a href="about.php">О компании</a>
                <a href="contact.php">Контакты</a>
            </nav>

            <?php if (isset($_SESSION['id_user'])): ?>

                <a href="profile.php" class="btn-login">
                    Профиль
                </a>

            <?php else: ?>

                <button onclick="openAuth()" class="btn-login">
                    Войти
                </button>

            <?php endif; ?>

        </div>
    </header>

    <div id="authModal" class="auth-modal">

        <div class="auth-modal__content">

            <button class="auth-modal__close" onclick="closeAuth()">×</button>

            <div id="loginBox">
                <h2 class="auth-modal__title">Вход</h2>

                <form method="POST" action="login.php">
                    <input class="auth-modal__input" type="email" name="email" placeholder="Email">
                    <input class="auth-modal__input" type="password" name="password" placeholder="Пароль">
                    <button class="auth-modal__btn" type="submit">Войти</button>
                </form>

                <p class="auth-modal__switch">
                    Нет аккаунта?
                    <a onclick="showRegister()">Регистрация</a>
                </p>
            </div>

            <div id="registerBox" style="display:none;">
                <h2 class="auth-modal__title">Регистрация</h2>

                <form method="POST" action="register.php">
                    <input class="auth-modal__input" type="text" name="name" placeholder="Имя">
                    <input class="auth-modal__input" type="email" name="email" placeholder="Email">
                    <input class="auth-modal__input" type="password" name="password" placeholder="Пароль">

                    <button class="auth-modal__btn" type="submit">Создать аккаунт</button>
                </form>

                <p class="auth-modal__switch">
                    Уже есть аккаунт?
                    <a onclick="showLogin()">Войти</a>
                </p>
            </div>

        </div>
    </div>

    <div class="hero container">
        <h1 class="title-hero">Прекрасный отдых с<br>
            <span class="main-text-name">
                ELITE<span class="accent">HOME</span>
            </span>
        </h1>
        <p class="subtitle">Найдите идеальное место для отдыха</p>
    </div>

    <div class="choice-country">
        <a href="#moscow" class="country-btn">Москва</a>
        <a href="#italy" class="country-btn">Италия</a>
        <a href="#spain" class="country-btn">Испания</a>
    </div>

    <div id="moscow" class="choice">
        <div class="choice-card">
            <img src="./img/moscow1.png" alt="">

            <div class="choice-content">
                <p class="title">База отдыха "Les"</p>
                <p class="location">
                    Московская область, Клин - деревня Анненка
                </p>

                <div class="choice-bottom">
                    <p class="price">25 000 ₽/ сутки</p>
                    <a href="les.php" class="choice-btn">Выбрать домик</a>
                </div>
            </div>
        </div>

        <div class="choice-card">
            <img src="./img/moscow2.png" alt="">

            <div class="choice-content">
                <p class="title">База отдыха "Altika"</p>
                <p class="location">
                    Московская область, Истра - деревня Лужки
                </p>

                <div class="choice-bottom">
                    <p class="price">35 000 ₽/ сутки</p>
                    <a href="altika.php" class="choice-btn">Выбрать домик</a>
                </div>
            </div>
        </div>

        <div class="choice-card">
            <img src="./img/moscow3.png" alt="">

            <div class="choice-content">
                <p class="title">База отдыха "ART"</p>
                <p class="location">
                    Московская область, Дмитров - деревня Костино
                </p>

                <div class="choice-bottom">
                    <p class="price">45 000 ₽/ сутки</p>
                    <a href="art.php" class="choice-btn">Выбрать домик</a>
                </div>
            </div>
        </div>
    </div>

    <div id="italy" class="choice">
        <div class="choice-card">
            <img src="./img/italy1.png" alt="">

            <div class="choice-content">
                <p class="title">Вилла</p>
                <p class="location">
                    Италия, Стреза, виа Ведаско
                </p>

                <div class="choice-bottom">
                    <p class="price">20 000 €/ сутки</p>
                    <a href="italy-Stresa.php" class="choice-btn">Посмотреть</a>
                </div>
            </div>
        </div>

        <div class="choice-card">
            <img src="./img/italy2.png" alt="">

            <div class="choice-content">
                <p class="title">Вилла</p>
                <p class="location">
                    Италия, Сан-Феличе-Чирчео
                </p>

                <div class="choice-bottom">
                    <p class="price">50 000 €/ сутки</p>
                    <a href="italy-San.php" class="choice-btn">Посмотреть</a>
                </div>
            </div>
        </div>

        <div class="choice-card">
            <img src="./img/italy3.png" alt="">

            <div class="choice-content">
                <p class="title">Вилла</p>
                <p class="location">
                    Италия, Форте деи Марми
                </p>

                <div class="choice-bottom">
                    <p class="price">70 000 €/ сутки</p>
                    <a href="italy-Forte.php" class="choice-btn">Посмотреть</a>
                </div>
            </div>
        </div>
    </div>

    <div id="spain" class="choice">
        <div class="choice-card">
            <img src="./img/spain1.png" alt="">

            <div class="choice-content">
                <p class="title">Вилла</p>
                <p class="location">
                    Испания, Кастель-Пладжа-де-Аро
                </p>

                <div class="choice-bottom">
                    <p class="price">2 350 €/ сутки</p>
                    <a href="spain-Costa.php" class="choice-btn">Посмотреть</a>
                </div>
            </div>
        </div>

        <div class="choice-card">
            <img src="./img/spain2.png" alt="">

            <div class="choice-content">
                <p class="title">Вилла</p>
                <p class="location">
                    Испания, Коста-Брава, Льорет-де-Мар
                </p>

                <div class="choice-bottom">
                    <p class="price">8 800 €/ сутки</p>
                    <a href="spain-Lloret.php" class="choice-btn">Посмотреть</a>
                </div>
            </div>
        </div>

        <div class="choice-card">
            <img src="./img/spain3.png" alt="">

            <div class="choice-content">
                <p class="title">Вилла</p>
                <p class="location">
                    Испания, Кальдас-де-Малавелья, Гольф курорт PGA
                </p>

                <div class="choice-bottom">
                    <p class="price">25 000 €/ сутки</p>
                    <a href="spain-Caldes.php" class="choice-btn">Посмотреть</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer">
            <a href="index.php" class="footer-logo">
                <img class="footer-logo" src="./img/logo.svg" alt="logo">
            </a>
            <nav class="nav-footer">
                <a href="catalog.php">Каталог</a>
                <a href="about.php">О компании</a>
                <a href="contact.php">Контакты</a>
            </nav>
            <div class="footer-info">
                <p>info@elitehome.com</p>
                <p>+7 (987) 123 - 45 -67</p>
            </div>
        </div>
    </footer>

    <script>
        function openAuth() {
            document.getElementById('authModal').style.display = 'flex';
            showLogin();
        }

        function closeAuth() {
            document.getElementById('authModal').style.display = 'none';
        }

        function showRegister() {
            document.getElementById('loginBox').style.display = 'none';
            document.getElementById('registerBox').style.display = 'block';
        }

        function showLogin() {
            document.getElementById('loginBox').style.display = 'block';
            document.getElementById('registerBox').style.display = 'none';
        }

        window.onclick = function(e) {
            if (e.target.id === 'authModal') {
                closeAuth();
            }
        }
    </script>

    <script src="script.js"></script>

</body>

</html>