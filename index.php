<?php
require 'security.php';

$restore_form = isset($_GET['restore_form']) ? true : false;
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELITEHOME</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    $success = false;
    ?>

    <header class="header-main">
        <div class="header">
            <a class="header-logo" href="./index.php" class="logo">
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

                <form id="loginForm">
                    <input class="auth-modal__input" type="email" name="email" placeholder="Email">
                    <input class="auth-modal__input" type="password" name="password" placeholder="Пароль">
                    <button class="auth-modal__btn" type="submit">Войти</button>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                </form>

                <div id="loginMessage" class="auth-modal__error" style="display: none; color: #DCB483; text-align: center; margin-top: 10px; font-size: 14px;"></div>

                <p class="auth-modal__switch">
                    Нет аккаунта?
                    <a onclick="showRegister()">Регистрация</a>
                </p>
            </div>

            <div id="registerBox" style="display:none;">
                <h2 class="auth-modal__title">Регистрация</h2>

                <form id="registerForm">
                    <input class="auth-modal__input" type="text" name="name" placeholder="Имя">
                    <input class="auth-modal__input" type="email" name="email" placeholder="Email">
                    <input class="auth-modal__input" type="tel" name="phone" id="reg_phone" placeholder="Телефон" required>
                    <input class="auth-modal__input" type="password" name="password" placeholder="Пароль">
                    <button type="submit" class="auth-modal__btn">Отправить код</button>
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                </form>

                <div id="registerMessage" class="auth-modal__error" style="display: none;"></div>


                <p class="auth-modal__switch">
                    Уже есть аккаунт?
                    <a onclick="showLogin()">Войти</a>
                </p>
            </div>
            <div id="confirmBox" style="display:none;">
                <h2 class="auth-modal__title">Подтверждение</h2>

                <input class="auth-modal__input" type="text" id="confirm_code" placeholder="Код из почты">

                <button class="auth-modal__btn" onclick="confirmCode()">Подтвердить</button>
            </div>
        </div>
    </div>

    <div class="hero container">
        <h1 class="title-hero">Откройте для себя<br>
            <span class="main-text-name">
                ELITE<span class="accent">HOME</span>
            </span>
        </h1>
        <p class="subtitle">Ваше путешествие к роскошной жизни начинается здесь</p>
        <a href="catalog.php" class="catalog-btn">Смотреть каталог</a>
    </div>

    <div class="request">
        <div class="left">
            <img class="request-1" src="./img/request1.png" alt="">
            <div class="request-forma">
                <h1>Оставить заявку</h1>
                <p>Каждый проект - это гармония функциональности, эстетики, утверждающая новые<br>
                    стандарты статуса и безупречного вкуса</p>

                <form class="request-form" id="requestForm" action="send_request.php" method="POST">
                    <div class="form-row">
                        <div class="form-group dropdown">
                            <div class="dropdown-selected">Выберите дом</div>
                            <div class="dropdown-list">
                                <div class="dropdown-item">База отдыха Les - Misty Forest</div>
                                <div class="dropdown-item">База отдыха Les - Emerald Woods</div>
                                <div class="dropdown-item">База отдыха Altika - Forest Hill</div>
                                <div class="dropdown-item">База отдыха Altika - Golden Meadow</div>
                                <div class="dropdown-item">База отдыха ART - Pine Grove</div>
                                <div class="dropdown-item">База отдыха ART - Silver Birch</div>
                                <div class="dropdown-item">Вилла Италия, Стреза, виа Ведаско</div>
                                <div class="dropdown-item">Вилла Италия, Сан-Феличе-Чирчео</div>
                                <div class="dropdown-item">Вилла Италия, Форте деи Марми</div>
                                <div class="dropdown-item">Вилла Испания, Кастель-Пладжа-де-Аро</div>
                                <div class="dropdown-item">Вилла Испания, Коста-Брава, Ллорет-де-Мар</div>
                                <div class="dropdown-item">Вилла Испания, Кальдас-де-Малавелья, Гольф курорт PGA</div>
                            </div>
                            <input type="hidden" name="base" id="base">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" id="date_start" name="date_start" required>
                            <label>Дата заезда</label>
                        </div>

                        <div class="form-group">
                            <input type="text" id="date_end" name="date_end" required>
                            <label>Дата выезда</label>
                        </div>
                    </div>

                    <button type="submit" class="submit-btn">Отправить заявку</button>
                    <div id="success-message" class="success-message"></div>
                    <div id="formNotification" class="form-notification">
                        <span class="text"></span>
                        <span class="close" onclick="hideFormNotification()">×</span>
                    </div>
                </form>
            </div>
        </div>
        <img class="request-2" src="./img/request2.png" alt="">
    </div>

    <div class="country-img">
        <a href="./catalog.php" class="country-card">
            <img src="./img/moscow.png" alt="">
            <div class="country-overlay">
                <p>МОСКВА</p>
            </div>
        </a>

        <a href="./catalog.php" class="country-card">
            <img src="./img/italy.png" alt="">
            <div class="country-overlay">
                <p>ИТАЛИЯ</p>
            </div>
        </a>

        <a href="./catalog.php" class="country-card">
            <img src="./img/spain.png" alt="">
            <div class="country-overlay">
                <p>ИСПАНИЯ</p>
            </div>
        </a>
    </div>

    <div class="email">
        <p class="email-title">Проведите отдых с нами</p>
        <p class="email-subtitle">Подпишитесь на рассылку и получите скидку 10% на первую бронь</p>

        <form class="get-email" id="newsletterForm">
            <input type="email" name="email" placeholder="Ваш email" required>
            <button type="submit" class="subscribe-btn">Подписаться</button>
        </form>

        <p class="agreement">
            Нажимая кнопку, вы соглашаетесь с политикой конфиденциальности
        </p>

        <div id="newsletter-message" class="success-message"></div>
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
        document.addEventListener('DOMContentLoaded', function() {

            function setupDateMask(inputId) {
                const input = document.getElementById(inputId);
                if (!input) return;
                input.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length > 2) {
                        value = value.slice(0, 2) + '.' + value.slice(2);
                    }
                    if (value.length > 5) {
                        value = value.slice(0, 5) + '.' + value.slice(5, 9);
                    }
                    this.value = value;
                });
            }

            setupDateMask('date_start');
            setupDateMask('date_end');

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('restore_form')) {
                restoreFormData();
            }

            function saveFormData() {
                const formData = {
                    date_start: document.getElementById('date_start').value,
                    date_end: document.getElementById('date_end').value,
                    base: document.getElementById('base').value
                };
                sessionStorage.setItem('pendingRequest', JSON.stringify(formData));
            }

            function restoreFormData() {
                const savedData = sessionStorage.getItem('pendingRequest');
                if (savedData) {
                    const formData = JSON.parse(savedData);
                    if (formData.date_start) document.getElementById('date_start').value = formData.date_start;
                    if (formData.date_end) document.getElementById('date_end').value = formData.date_end;
                    if (formData.base) {
                        document.getElementById('base').value = formData.base;
                        const dropdownSelected = document.querySelector('.dropdown-selected');
                        if (dropdownSelected) {
                            dropdownSelected.textContent = formData.base;
                        }
                    }
                    sessionStorage.removeItem('pendingRequest');
                }
            }

            const form = document.getElementById('requestForm');
            const msg = document.getElementById('success-message');

            if (form && msg) {
                msg.classList.remove('show');

                form.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;

                    if (!isLoggedIn) {
                        saveFormData();
                        showFormNotification('Чтобы отправить заявку, пожалуйста', true, true);
                        return;
                    }

                    const formData = new FormData(form);

                    try {
                        const response = await fetch('send_request.php', {
                            method: 'POST',
                            body: formData
                        });
                        const result = await response.json();

                        msg.textContent = result.message;
                        msg.classList.add('show');

                        if (result.status === 'success') {
                            form.reset();
                        }

                        setTimeout(() => {
                            msg.classList.remove('show');
                        }, 1800);
                    } catch (error) {
                        msg.textContent = 'Ошибка соединения';
                        msg.classList.add('show');
                        setTimeout(() => {
                            msg.classList.remove('show');
                        }, 2000);
                    }
                });
            }

            const newsletterForm = document.getElementById('newsletterForm');
            const newsletterMsg = document.getElementById('newsletter-message');

            if (newsletterForm && newsletterMsg) {
                newsletterForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);

                    try {
                        const response = await fetch('subscribe.php', {
                            method: 'POST',
                            body: formData
                        });
                        const result = await response.json();

                        newsletterMsg.textContent = result.message;
                        newsletterMsg.classList.add('show');

                        if (result.status === 'success') {
                            this.reset();
                        }

                        setTimeout(() => {
                            newsletterMsg.classList.remove('show');
                        }, 2000);
                    } catch (error) {
                        newsletterMsg.textContent = "Ошибка соединения";
                        newsletterMsg.classList.add('show');
                    }
                });
            }
        });

        function openAuth() {
            document.getElementById('authModal').style.display = 'flex';
            showLogin();
        }

        function closeAuth() {
            document.getElementById('authModal').style.display = 'none';
        }

        function showLogin() {
            document.getElementById('loginBox').style.display = 'block';
            document.getElementById('registerBox').style.display = 'none';
            document.getElementById('confirmBox').style.display = 'none';
        }

        function showRegister() {
            document.getElementById('loginBox').style.display = 'none';
            document.getElementById('registerBox').style.display = 'block';
            document.getElementById('confirmBox').style.display = 'none';
        }

        function showConfirm() {
            document.getElementById('loginBox').style.display = 'none';
            document.getElementById('registerBox').style.display = 'none';
            document.getElementById('confirmBox').style.display = 'block';
        }

        const registerForm = document.getElementById('registerForm');
        const registerMessage = document.getElementById('registerMessage');

        if (registerForm) {
            registerForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (registerMessage) {
                    registerMessage.style.display = 'none';
                    registerMessage.textContent = '';
                }

                const phoneInput = document.getElementById('reg_phone');
                const phoneDigits = phoneInput.value.replace(/\D/g, '');

                if (phoneDigits.length < 11) {
                    if (registerMessage) {
                        registerMessage.textContent = 'Введите корректный номер телефона (10 цифр после +7)';
                        registerMessage.style.display = 'block';
                        registerMessage.style.color = '#DCB483';
                        phoneInput.style.borderColor = '#DCB483';
                        setTimeout(() => {
                            registerMessage.style.display = 'none';
                        }, 5000);
                    }
                    return;
                }
                phoneInput.style.borderColor = 'rgba(220, 180, 131, 0.3)';

                const formData = new FormData(this);

                try {
                    const response = await fetch('register.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await response.json();

                    if (data.status === 'success') {
                        showConfirm();
                    } else {
                        if (registerMessage) {
                            registerMessage.textContent = data.message;
                            registerMessage.style.display = 'block';
                            registerMessage.style.color = '#DCB483';
                            setTimeout(() => {
                                registerMessage.style.display = 'none';
                            }, 5000);
                        }
                    }
                } catch (error) {
                    if (registerMessage) {
                        registerMessage.textContent = 'Ошибка соединения с сервером';
                        registerMessage.style.display = 'block';
                        registerMessage.style.color = '#ff6b6b';
                        setTimeout(() => {
                            registerMessage.style.display = 'none';
                        }, 5000);
                    }
                }
            });
        }

        function confirmCode() {
            const code = document.getElementById('confirm_code').value;

            fetch('confirm.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'code=' + encodeURIComponent(code)
                })
                .then(res => res.json())
                .then(data => {

                    if (data.status === 'success') {
                        closeAuth();
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                });
        }

        const loginForm = document.getElementById('loginForm');
        const loginMessage = document.getElementById('loginMessage');

        if (loginForm) {
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (loginMessage) {
                    loginMessage.style.display = 'none';
                    loginMessage.textContent = '';
                }

                const formData = new FormData(this);

                try {
                    const response = await fetch('login.php', {
                        method: 'POST',
                        body: formData
                    });
                    const data = await response.json();

                    if (data.status === 'success') {
                        closeAuth();
                        window.location.reload();
                    } else if (data.status === 'error') {
                        if (loginMessage) {
                            loginMessage.textContent = data.message;
                            loginMessage.style.display = 'block';

                            if (data.message === 'Слишком много попыток входа') {
                                loginMessage.style.color = '#ff6b6b';
                            } else {
                                loginMessage.style.color = '#DCB483';
                            }

                            setTimeout(() => {
                                loginMessage.style.display = 'none';
                            }, 3000);
                        }
                    }
                } catch (error) {
                    if (loginMessage) {
                        loginMessage.textContent = 'Ошибка соединения с сервером';
                        loginMessage.style.display = 'block';
                        loginMessage.style.color = '#ff6b6b';
                        setTimeout(() => {
                            loginMessage.style.display = 'none';
                        }, 5000);
                    }
                }
            });
        }

        function showFormNotification(message, showLoginLink = true, showRegisterLink = true) {
            const notification = document.getElementById('formNotification');
            if (!notification) return;

            const textSpan = notification.querySelector('.text');

            let html = message;
            if (showLoginLink) {
                html += ' <span class="link" onclick="closeAuth(); openAuth(); showLogin();">Войти</span>';
            }
            if (showRegisterLink) {
                html += ' <span class="link" onclick="closeAuth(); openAuth(); showRegister();">Зарегистрироваться</span>';
            }

            textSpan.innerHTML = html;
            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }

        function hideFormNotification() {
            const notification = document.getElementById('formNotification');
            if (notification) {
                notification.classList.remove('show');
            }
        }

        function updateAuthButton() {
            const authButton = document.querySelector('.btn-login');
            const header = document.querySelector('.header');

            fetch('check_auth.php')
                .then(res => res.json())
                .then(data => {
                    if (data.logged_in) {
                        if (authButton && authButton.tagName === 'BUTTON') {
                            const newLink = document.createElement('a');
                            newLink.href = 'profile.php';
                            newLink.className = 'btn-login';
                            newLink.textContent = 'Профиль';
                            authButton.parentNode.replaceChild(newLink, authButton);
                        }
                    }
                });
        }

        window.onclick = function(e) {
            if (e.target.id === 'authModal') {
                closeAuth();
            }
        };

        function maskPhoneForRegister(input) {
            input.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');

                if (value.startsWith('7') || value.startsWith('8')) {
                    value = value.substring(1);
                }

                let formatted = '+7';

                if (value.length > 0) formatted += ' (' + value.substring(0, 3);
                if (value.length >= 4) formatted += ') ' + value.substring(3, 6);
                if (value.length >= 7) formatted += '-' + value.substring(6, 8);
                if (value.length >= 9) formatted += '-' + value.substring(8, 10);

                this.value = formatted;
            });
        }

        const regPhoneInput = document.getElementById('reg_phone');
        if (regPhoneInput) {
            maskPhoneForRegister(regPhoneInput);
        }
    </script>
    <script src="script.js"></script>
</body>

</html>