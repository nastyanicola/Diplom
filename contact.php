<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Контакты</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="header-contact">
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
        <h1 class="title-hero">Как забронировать в<br>
            <span class="main-text-name">
                ELITE<span class="accent">HOME</span>
            </span>
        </h1>
        <p class="subtitle">Свяжитесь с нами удобным способом</p>
    </div>

    <div class="choice-country">
        <button class="contact-btn active" data-country="moscow">Москва</button>
        <button class="contact-btn" data-country="italy">Италия</button>
        <button class="contact-btn" data-country="spain">Испания</button>
    </div>

    <div id="moscow" class="contact-item active">
        <div class="contact-image">
            <img src="./img/contact1.png" alt="">
            <div class="overlay">
                <p class="name-people">Илья Сергеев</p>
                <p class="name-country"> Москва</p>
            </div>
        </div>

        <div class="contact-info">
            <div class="info-block">
                <p class="country">МОСКВА</p>
                <p class="city">Подмосковье</p>

                <h3>Наше местоположение</h3>
                <p class="contact-data">Пресненская наб., 12, Башня Федерация, Москва</p>

                <h3>Номер телефона</h3>
                <p class="contact-data">+7 495 123 4567</p>

                <h3>Адрес электронной почты</h3>
                <p class="contact-data">moscow@elitehome.com</p>

                <h3>Часы работы</h3>
                <p class="contact-data">Пн-Пт: 9:00 - 18:00</p>
            </div>

            <div class="info-block">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?ll=37.537910%2C55.749574&z=16&pt=37.537910,55.749574,pm2blm"
                    width="100%"
                    height="150"
                    frameborder="0"
                    allowfullscreen="true"
                    style="border-radius:20px;">
                </iframe>
            </div>
        </div>
    </div>

    <div id="italy" class="contact-item">
        <div class="contact-image">
            <img src="./img/contact2.png" alt="">
            <div class="overlay">
                <p class="name-people">Лика Краснова</p>
                <p class="name-country">Италия</p>
            </div>
        </div>

        <div class="contact-info">
            <div class="info-block">
                <p class="country">ИТАЛИЯ</p>
                <p class="city">Милан</p>

                <h3>Наше местоположение</h3>
                <p class="contact-data">Via Monte Napoleone, 8, Milano</p>

                <h3>Номер телефона</h3>
                <p class="contact-data">+39 02 123 4567</p>

                <h3>Адрес электронной почты</h3>
                <p class="contact-data">milano@elitehome.com</p>

                <h3>Часы работы</h3>
                <p class="contact-data">Пн-Пт: 9:00 - 18:00</p>
            </div>

            <div class="info-block">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?ll=9.194230%2C45.468186&z=16&pt=9.194230,45.468186,pm2rdm"
                    width="100%"
                    height="150"
                    frameborder="0"
                    allowfullscreen="true"
                    style="border-radius:20px;">
                </iframe>
            </div>
        </div>
    </div>

    <div id="spain" class="contact-item">
        <div class="contact-image">
            <img src="./img/contact3.png" alt="">
            <div class="overlay">
                <p class="name-people">Виктория Самоделкина</p>
                <p class="name-country">Испания</p>
            </div>
        </div>

        <div class="contact-info">
            <div class="info-block">
                <p class="country">ИСПАНИЯ</p>
                <p class="city">Барселона</p>

                <h3>Наше местоположение</h3>
                <p class="contact-data">Passeig de Gràcia, 99, Barcelona</p>

                <h3>Номер телефона</h3>
                <p class="contact-data">+34 93 123 4567</p>

                <h3>Адрес электронной почты</h3>
                <p class="contact-data">barcelona@elitehome.com</p>

                <h3>Часы работы</h3>
                <p class="contact-data">Пн-Пт: 9:00 - 18:00</p>
            </div>

            <div class="info-block">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?ll=2.164873%2C41.397379&z=16&pt=2.164873,41.397379,pm2gnm"
                    width="100%"
                    height="150"
                    frameborder="0"
                    allowfullscreen="true"
                    style="border-radius:20px;">
                </iframe>
            </div>
        </div>
    </div>

    <section class="faq">
        <h1 class="faq-title">Часто задаваемые вопросы</h1>

        <div class="faq-grid">

            <div class="faq-item">
                <h3>Как забронировать объект?</h3>
                <p>Выберите понравившийся объект в каталоге, заполните форму бронирования и наш менеджер свяжется с вами
                    для подтверждения</p>
            </div>

            <div class="faq-item">
                <h3>Какие способы оплаты доступны?</h3>
                <p>Мы принимаем оплату банковскими картами, банковским переводом и электронными платежными системами</p>
            </div>

            <div class="faq-item">
                <h3>Можно ли отменить бронирование?</h3>
                <p>Да, условия отмены зависят от выбранного объекта. Подробную информацию уточняйте у менеджера</p>
            </div>

            <div class="faq-item">
                <h3>Включены ли дополнительные услуги?</h3>
                <p>Большинство объектов включают базовые услуги. Дополнительные опции можно заказать при бронировании
                </p>
            </div>
        </div>
    </section>

    <?php if (isset($_GET['success'])): ?>

        <div class="success-message">
            Ваш вопрос успешно отправлен.
        </div>

    <?php endif; ?>

    <section class="feedback-section">
        <div class="feedback-container">
            <div class="feedback-header">
                <p class="feedback-title">Остались вопросы?</p>
            </div>

            <form action="send_feedback.php" method="POST" class="feedback-form" id="feedbackForm">

                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="feedback-grid">
                    <div class="input-group">
                        <label>Ваше имя</label>
                        <input type="text" name="name" required>
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>
                </div>

                <div class="input-group full">
                    <label>Ваш вопрос</label>
                    <textarea name="message" rows="6" required></textarea>
                </div>

                <button type="submit" class="feedback-btn">
                    Отправить сообщение
                </button>
            </form>
            <div id="feedbackMessage" class="feedback-message"></div>
        </div>
    </section>

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

        window.onclick = function(e) {
            if (e.target.id === 'authModal') {
                closeAuth();
            }
        }

        document.getElementById('feedbackForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const messageBox = document.getElementById('feedbackMessage');

            const formData = new FormData(this);

            const response = await fetch('send_feedback.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            messageBox.classList.add('show');
            messageBox.innerText = data.message;

            setTimeout(() => {
                messageBox.classList.remove('show');
                messageBox.innerText = '';
            }, 3000);

            if (data.status === 'success') {
                messageBox.style.color = "#DCB483";
                this.reset();
            } else {
                messageBox.style.color = "red";
            }
        });
    </script>

    <script src="script.js"></script>
</body>

</html>