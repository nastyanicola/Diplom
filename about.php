<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="header-about">
        <div class="header">
            <a href="./index.php" class="logo">
                <img src="./img/logo.svg" alt="logo">
            </a>

            <nav class="nav">
                <a href="catalog.php">Каталог</a>
                <a href="about.php">О компании</a>
                <a href="contact.php">Контакты</a>
            </nav>

            <?php if(isset($_SESSION['id_user'])): ?>

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
        <h1 class="title-hero">Немного о компании<br>
            <span class="main-text-name">
                ELITE<span class="accent">HOME</span>
            </span>
        </h1>
        <p class="subtitle">Создаем незабываемые впечатления с 2020 года</p>
    </div>

    <section class="about">
        <div class="about-inner">
            <div class="about-text reveal">
                <h1>
                    Добро пожаловать в<br>
                    <span class="main-text-name">
                        ELITE<span class="accent">HOME</span>
                    </span>
                </h1>

                <p>
                    ELITEHOME — это современная платформа для бронирования премиальных вилл и баз отдыха в лучших
                    локациях мира. Мы объединяем изысканную архитектуру, высокий уровень сервиса и уникальные
                    направления, чтобы каждый ваш отдых становился особенным.<br><br>

                    Мы предлагаем тщательно отобранные объекты в таких странах, как Италия, Испания и Россия, где каждая
                    локация отличается своим характером — от солнечных вилл у моря до уютных домов в окружении
                    природы.<br><br>

                    Наша цель — создать пространство, в котором пользователь может легко и удобно найти идеальное место
                    для отдыха, не тратя время на долгий поиск.
                </p>

            </div>

            <div class="about-image parallax reveal">
                <img src="./img/house.svg" alt="">
            </div>

        </div>
    </section>

    <div class="contact-img">

        <a href="contact.php#moscow" class="about-card">
            <img src="./img/contact1.png" alt="">
            <div class="card-overlay">
                <p class="name-people">Илья <br>
                    Сергеев</p>
            </div>
        </a>

        <a href="contact.php#italy" class="about-card">
            <img src="./img/contact2.png" alt="">
            <div class="card-overlay">
                <p class="name-people">Лика <br>
                    Краснова</p>
            </div>
        </a>

        <a href="contact.php#spain" class="about-card">
            <img src="./img/contact3.png" alt="">
            <div class="card-overlay">
                <p class="name-people">Виктория <br>
                    Самоделкина</p>
            </div>
        </a>
    </div>

    <footer>
        <div class="footer">
            <a href="./index.php" class="footer-logo">
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

        window.onclick = function (e) {
            if (e.target.id === 'authModal') {
                closeAuth();
            }
        }
    </script>

    <script src="script.js"></script>
</body>

</html>