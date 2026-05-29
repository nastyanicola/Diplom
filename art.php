<?php
require 'security.php';
$restore_form = isset($_GET['restore_form']) ? true : false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ART</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header class="header-art">
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
                <a href="profile.php" class="btn-login">Профиль</a>
            <?php else: ?>
                <button onclick="openAuth()" class="btn-login">Войти</button>
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
        <h1 class="title-hero">База отдыха ART</h1>
        <p class="subtitle">Московская область, Дмитровский район,<br>
            деревня Костино</p>
    </div>

    <div class="house">
        <div class="house-inner">
            <div class="house-image">
                <img id="mainImage1" src="img/art1.png" alt="">
                <div class="thumbs">
                    <img src="img/art1.png" class="thumb active" data-target="mainImage1">
                    <img src="img/art2.png" class="thumb" data-target="mainImage1">
                    <img src="img/art3.png" class="thumb" data-target="mainImage1">
                    <img src="img/art4.png" class="thumb" data-target="mainImage1">
                    <img src="img/art5.png" class="thumb" data-target="mainImage1">
                    <img src="img/art6.png" class="thumb" data-target="mainImage1">
                </div>
            </div>

            <div class="house-text">
                <h2>Private House «Pine Grove»</h2>
                <ul class="house-list">
                    <li>Премиальная система климат-контроля для абсолютного комфорта</li>
                    <li>Дизайнерская кухня с современной встроенной техникой</li>
                    <li>Стильная ванная комната с продуманной эргономикой</li>
                    <li>Комплименты для гостей при заезде</li>
                    <li>Высокоскоростной интернет</li>
                    <li>Приватная парковка</li>
                </ul>
                <p class="house-subtitle">Развлечения</p>
                <ul class="house-list">
                    <li>Караоке-система — 2 000 ₽</li>
                    <li>Игровая приставка — 1 500 ₽</li>
                    <li>Кинопроектор — 2 500 ₽</li>
                    <li>Настольные игры (расширенный набор) — 500 ₽</li>
                    <li>Музыкальная колонка — 800 ₽</li>
                </ul>
                <p class="note">Отлично подойдёт для отдыха с друзьями и вечеринок</p>
                <div class="house-bottom">
                    <p class="house-price">45 000 ₽ / сутки</p>
                    <a href="#" class="house-btn" data-house="База отдыха ART - Pine Grove">Забронировать</a>
                </div>
            </div>
        </div>
    </div>

    <div class="house">
        <div class="house-inner">
            <div class="house-image">
                <img id="mainImage2" src="img/art7.png" alt="">
                <div class="thumbs">
                    <img src="img/art7.png" class="thumb active" data-target="mainImage2">
                    <img src="img/art8.png" class="thumb" data-target="mainImage2">
                    <img src="img/art9.png" class="thumb" data-target="mainImage2">
                    <img src="img/art10.png" class="thumb" data-target="mainImage2">
                    <img src="img/art11.png" class="thumb" data-target="mainImage2">
                    <img src="img/art12.png" class="thumb" data-target="mainImage2">
                </div>
            </div>

            <div class="house-text">
                <h2>Private House «Silver Birch»</h2>
                <ul class="house-list">
                    <li>Премиальная система климат-контроля для абсолютного комфорта</li>
                    <li>Дизайнерская кухня с современной встроенной техникой</li>
                    <li>Стильная ванная комната с продуманной эргономикой</li>
                    <li>Комплименты для гостей при заезде</li>
                    <li>Высокоскоростной интернет</li>
                    <li>Приватная парковка</li>
                </ul>
                <p class="house-subtitle">Развлечения</p>
                <ul class="house-list">
                    <li>Караоке-система — 2 000 ₽</li>
                    <li>Игровая приставка — 1 500 ₽</li>
                    <li>Кинопроектор — 2 500 ₽</li>
                    <li>Настольные игры (расширенный набор) — 500 ₽</li>
                    <li>Музыкальная колонка — 800 ₽</li>
                </ul>
                <p class="note">Отлично подойдёт для отдыха с друзьями и вечеринок</p>
                <div class="house-bottom">
                    <p class="house-price">45 000 ₽ / сутки</p>
                    <a href="#" class="house-btn" data-house="База отдыха ART - Silver Birch">Забронировать</a>
                </div>
            </div>
        </div>
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

    <div id="villaModal" class="villa-modal">
        <div class="villa-modal__box">
            <span class="villa-modal__close">&times;</span>
            <h2 class="villa-modal__title">Заявка на бронирование</h2>

            <form id="villaForm">
                <div class="form-row">
                    <div class="form-group dropdown">
                        <div class="dropdown-selected">Выберите дом</div>
                        <div class="dropdown-list">
                            <div class="dropdown-item">База отдыха ART - Pine Grove</div>
                            <div class="dropdown-item">База отдыха ART - Silver Birch</div>
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

                <button type="submit" class="villa-submit">Забронировать</button>
                <div class="form-message" id="villaMessage"></div>
                <div id="formNotification" class="form-notification">
                    <span class="text"></span>
                    <span class="close" onclick="hideFormNotification()">×</span>
                </div>
            </form>
        </div>
    </div>

    <div id="notificationModal" class="auth-modal">
        <div class="auth-modal__content" style="max-width: 400px; text-align: center;">
            <button class="auth-modal__close" onclick="closeNotificationModal()">×</button>
            <h3 style="color: #DCB483; margin-bottom: 15px;">Требуется авторизация</h3>
            <p style="margin-bottom: 25px;">Чтобы забронировать, пожалуйста, войдите или зарегистрируйтесь</p>
            <div style="display: flex; gap: 15px; justify-content: center;">
                <button onclick="closeNotificationModal(); openAuth(); showLogin();" class="auth-modal__btn" style="width: auto; padding: 10px 25px;">Войти</button>
                <button onclick="closeNotificationModal(); openAuth(); showRegister();" class="auth-modal__btn" style="width: auto; padding: 10px 25px;">Регистрация</button>
            </div>
        </div>
    </div>

    <script>
        <?php if ($restore_form): ?>
            sessionStorage.setItem('restoreForm', 'true');
        <?php endif; ?>

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

            const modal = document.getElementById('villaModal');
            const openBtns = document.querySelectorAll('.house-btn');
            const closeBtn = document.querySelector('.villa-modal__close');
            const form = document.getElementById('villaForm');
            const msg = document.getElementById('villaMessage');

            openBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const houseName = btn.getAttribute('data-house');
                    document.getElementById('base').value = houseName;
                    const dropdownSelected = document.querySelector('.dropdown-selected');
                    if (dropdownSelected) {
                        dropdownSelected.textContent = houseName;
                    }
                    modal.style.display = 'flex';
                });
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    modal.style.display = 'none';
                });
            }

            window.addEventListener('click', (e) => {
                if (e.target === modal) modal.style.display = 'none';
                const notificationModal = document.getElementById('notificationModal');
                if (e.target === notificationModal) {
                    closeNotificationModal();
                }
            });

            if (form && msg) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const isLoggedIn = <?php echo isset($_SESSION['id_user']) ? 'true' : 'false'; ?>;

                    const dateStart = document.getElementById('date_start').value;
                    const dateEnd = document.getElementById('date_end').value;
                    const base = document.getElementById('base').value;

                    if (!dateStart || !dateEnd || !base) {
                        msg.textContent = 'Заполните все поля';
                        msg.classList.add('form-message--visible');
                        setTimeout(() => {
                            msg.classList.remove('form-message--visible');
                        }, 3000);
                        return;
                    }

                    if (!isLoggedIn) {
                        saveFormData();
                        modal.style.display = 'none';
                        showNotificationModal();
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
                        msg.classList.add('form-message--visible');

                        if (result.status === 'success') {
                            form.reset();
                            const dropdownSelected = document.querySelector('.dropdown-selected');
                            if (dropdownSelected) {
                                dropdownSelected.textContent = 'Выберите дом';
                            }
                            setTimeout(() => {
                                modal.style.display = 'none';
                            }, 2000);
                        }

                        setTimeout(() => {
                            msg.classList.remove('form-message--visible');
                        }, 3000);
                    } catch (error) {
                        msg.textContent = 'Ошибка соединения';
                        msg.classList.add('form-message--visible');
                    }
                });
            }
        });

        function showNotificationModal() {
            const modal = document.getElementById('notificationModal');
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function closeNotificationModal() {
            const modal = document.getElementById('notificationModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

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

        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const phoneInput = document.getElementById('reg_phone');
            const phoneDigits = phoneInput.value.replace(/\D/g, '');

            if (phoneDigits.length < 11) {
                alert('Введите корректный номер телефона (10 цифр после +7)');
                phoneInput.style.borderColor = '#DCB483';
                return;
            }
            phoneInput.style.borderColor = 'rgba(220, 180, 131, 0.3)';

            const formData = new FormData(this);
            const res = await fetch('register.php', {
                method: 'POST',
                body: formData
            });
            const data = await res.json();

            if (data.status === 'success') {
                showConfirm();
            } else {
                alert(data.message);
            }
        });

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
        if (loginForm) {
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();

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
                        alert(data.message);
                    }
                } catch (error) {
                    alert('Ошибка соединения');
                }
            });
        }

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

        window.onclick = function(e) {
            if (e.target.id === 'authModal') {
                closeAuth();
            }
        };
    </script>
    <script src="script.js"></script>
</body>

</html>