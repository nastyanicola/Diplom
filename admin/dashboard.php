<?php
session_start();
require '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: Index.php");
    exit;
}

$tab = $_GET['tab'] ?? 'requests';

$admins = $pdo->query("SELECT * FROM admins ORDER BY id")->fetchAll();

$users = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();

$bases = $pdo->query("SELECT * FROM base ORDER BY id_base")->fetchAll();

$bookings = $pdo->query("
    SELECT b.*, u.name, u.email, u.phone, base.name as base_name
    FROM bookings b
    LEFT JOIN users u ON b.id_user = u.id
    LEFT JOIN base ON b.id_base = base.id_base
    ORDER BY b.created_at DESC
")->fetchAll();

$requests = $pdo->query("
    SELECT r.*, u.name, u.email, u.phone, base.name as base_name
    FROM requests r
    LEFT JOIN users u ON r.id_user = u.id
    LEFT JOIN base ON r.id_base = base.id_base
    ORDER BY r.created_at DESC
")->fetchAll();

$sales = $pdo->query("SELECT * FROM sale ORDER BY created_at DESC")->fetchAll();

$users_list = $pdo->query("SELECT id, name, email, phone FROM users ORDER BY name")->fetchAll();
$bases_list = $pdo->query("SELECT * FROM base ORDER BY id_base")->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Админ панель</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <div class="sidebar">
            <h1 class="title-hero">
                <span class="main-text-name">
                    ELITE<span class="accent">HOME</span>
                </span>
            </h1>
            <a href="?tab=admins" class="<?= $tab === 'admins' ? 'active' : '' ?>">Администраторы</a>
            <a href="?tab=users" class="<?= $tab === 'users' ? 'active' : '' ?>">Пользователи</a>
            <a href="?tab=bases" class="<?= $tab === 'bases' ? 'active' : '' ?>">Базы/Виллы</a>
            <a href="?tab=bookings" class="<?= $tab === 'bookings' ? 'active' : '' ?>">Бронирования</a>
            <a href="?tab=requests" class="<?= $tab === 'requests' ? 'active' : '' ?>">Заявки</a>
            <a href="?tab=sale" class="<?= $tab === 'sale' ? 'active' : '' ?>">Скидка</a>
            <hr style="border-color: rgba(212,175,55,0.2); margin: 15px 0;">
            <a href="Index.php">Выход</a>
        </div>

        <div class="main">
            <div class="card">
                <?php if ($tab === 'admins'): ?>
                    <button class="add-btn" onclick="openAdminAdd()">+ Добавить администратора</button>
                    <h2>Администраторы</h2>

                    <?php if (empty($admins)): ?>
                        <p>Нет данных об администраторах</p>
                    <?php else: ?>
                        <table class="crm-table">
                            <thead>
                                <tr>
                                    <th>Логин</th>
                                    <th>Пароль</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($admins as $a): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($a['login']) ?></td>
                                        <td>••••••</td>
                                        <td>
                                            <div class="actions">
                                                <button class="edit-btn" onclick="openAdminEdit(<?= $a['id'] ?>, '<?= addslashes($a['login']) ?>')">
                                                    <img src="../img/pencil.png" width="20" height="20">
                                                </button>
                                                <button class="delete-btn" onclick="deleteAdmin(<?= $a['id'] ?>)">
                                                    <img src="../img/close.png" width="20" height="20">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <div id="adminAddModal" class="modal">
                        <div class="modal-content">
                            <h3>Добавить администратора</h3>
                            <form method="POST" action="admin_add.php">
                                <input type="text" name="login" placeholder="Логин" required>
                                <input type="password" name="password" placeholder="Пароль" required>
                                <button type="submit">Добавить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                    <div id="adminEditModal" class="modal">
                        <div class="modal-content">
                            <h3>Редактировать администратора</h3>
                            <form method="POST" action="admin_update.php">
                                <input type="hidden" name="id" id="admin_id">
                                <input type="text" name="login" id="admin_login" placeholder="Логин" required>
                                <input type="password" name="password" id="admin_password" placeholder="Новый пароль (оставьте пустым, чтобы не менять)">
                                <button type="submit">Сохранить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                <?php elseif ($tab === 'users'): ?>
                    <button class="add-btn" onclick="openUserAdd()">+ Добавить пользователя</button>
                    <h2>Пользователи</h2>

                    <?php if (empty($users)): ?>
                        <p>Нет данных о пользователях</p>
                    <?php else: ?>
                        <table class="crm-table">
                            <thead>
                                <tr>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Телефон</th>
                                    <th>Подтверждён</th>
                                    <th>Дата регистрации</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $u): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($u['name']) ?></td>
                                        <td><?= htmlspecialchars($u['email']) ?></td>
                                        <td><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
                                        <td><?= $u['is_confirmed'] ? 'Подтверждён' : 'Не подтверждён' ?></td>
                                        <td><?= $u['created_at'] ?></td>
                                        <td>
                                            <div class="actions">
                                                <button class="edit-btn" onclick="openUserEdit(
                                                    <?= $u['id'] ?>,
                                                    '<?= addslashes($u['name']) ?>',
                                                    '<?= addslashes($u['email']) ?>',
                                                    '<?= addslashes($u['phone'] ?? '') ?>',
                                                    <?= $u['is_confirmed'] ?>
                                                )">
                                                    <img src="../img/pencil.png" width="20" height="20">
                                                </button>
                                                <button class="delete-btn" onclick="deleteUser(<?= $u['id'] ?>)">
                                                    <img src="../img/close.png" width="20" height="20">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <div id="userAddModal" class="modal">
                        <div class="modal-content">
                            <h3>Добавить пользователя</h3>
                            <form method="POST" action="user_add.php">
                                <input type="text" name="name" placeholder="Имя" required>
                                <input type="email" name="email" placeholder="Email" required>
                                <input type="tel" name="phone" placeholder="Телефон">
                                <input type="password" name="password" placeholder="Пароль" required>
                                <select name="is_confirmed">
                                    <option value="1">Подтверждён</option>
                                    <option value="0">Не подтверждён</option>
                                </select>
                                <button type="submit">Добавить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                    <div id="userEditModal" class="modal">
                        <div class="modal-content">
                            <h3>Редактировать пользователя</h3>
                            <form method="POST" action="user_update.php">
                                <input type="hidden" name="id" id="user_id">
                                <input type="text" name="name" id="user_name" placeholder="Имя" required>
                                <input type="email" name="email" id="user_email" placeholder="Email" required>
                                <input type="tel" name="phone" id="user_phone" placeholder="Телефон" oninput="maskPhoneForAdmin(this)">
                                <input type="password" name="password" id="user_password" placeholder="Новый пароль (оставьте пустым, чтобы не менять)">
                                <select name="is_confirmed" id="user_confirmed">
                                    <option value="1">Подтверждён</option>
                                    <option value="0">Не подтверждён</option>
                                </select>
                                <button type="submit">Сохранить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                <?php elseif ($tab === 'bases'): ?>
                    <button class="add-btn" onclick="openBaseAdd()">+ Добавить базу/виллу</button>
                    <h2>Базы отдыха и виллы</h2>

                    <?php if (empty($bases)): ?>
                        <p>Нет данных о базах/виллах</p>
                    <?php else: ?>
                        <table class="crm-table">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bases as $base): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($base['name']) ?></td>
                                        <td>
                                            <div class="actions">
                                                <button class="edit-btn" onclick="openBaseEdit(<?= $base['id_base'] ?>, '<?= addslashes($base['name']) ?>')">
                                                    <img src="../img/pencil.png" width="20" height="20">
                                                </button>
                                                <button class="delete-btn" onclick="deleteBase(<?= $base['id_base'] ?>)">
                                                    <img src="../img/close.png" width="20" height="20">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <div id="baseAddModal" class="modal">
                        <div class="modal-content">
                            <h3>Добавить базу/виллу</h3>
                            <form method="POST" action="base_add.php">
                                <input type="text" name="name" placeholder="Название" required>
                                <button type="submit">Добавить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                    <div id="baseEditModal" class="modal">
                        <div class="modal-content">
                            <h3>Редактировать базу/виллу</h3>
                            <form method="POST" action="base_update.php">
                                <input type="hidden" name="id_base" id="base_id">
                                <input type="text" name="name" id="base_name" placeholder="Название" required>
                                <button type="submit">Сохранить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                <?php elseif ($tab === 'bookings'): ?>
                    <button class="add-btn" onclick="openBookingAdd()">+ Добавить бронирование</button>
                    <h2>Бронирования</h2>

                    <?php if (empty($bookings)): ?>
                        <p>Нет данных о бронированиях</p>
                    <?php else: ?>
                        <table class="crm-table">
                            <thead>
                                <tr>
                                    <th>Пользователь</th>
                                    <th>База/Вилла</th>
                                    <th>Дата заезда</th>
                                    <th>Дата выезда</th>
                                    <th>Цена</th>
                                    <th>Дата создания</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookings as $b): ?>
                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($b['name'] ?? 'Не указан') ?><br>
                                            <small><?= htmlspecialchars($b['email'] ?? '') ?></small><br>
                                            <small><?= htmlspecialchars($b['phone'] ?? '') ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($b['base_name'] ?? 'Не указана') ?></td>
                                        <td><?= date('d.m.Y', strtotime($b['date_start'])) ?></td>
                                        <td><?= date('d.m.Y', strtotime($b['date_end'])) ?></td>
                                        <td><?= htmlspecialchars($b['price'] ?? '—') ?></td>
                                        <td><?= $b['created_at'] ?></td>
                                        <td>
                                            <div class="actions">
                                                <button class="edit-btn" onclick="openBookingEdit(
                                                    <?= $b['id_booking'] ?>,
                                                    <?= $b['id_user'] ?? 'null' ?>,
                                                    <?= $b['id_base'] ?? 'null' ?>,
                                                    '<?= $b['date_start'] ?>',
                                                    '<?= $b['date_end'] ?>',
                                                    '<?= addslashes($b['price'] ?? '') ?>'
                                                )">
                                                    <img src="../img/pencil.png" width="20" height="20">
                                                </button>
                                                <button class="delete-btn" onclick="deleteBooking(<?= $b['id_booking'] ?>)">
                                                    <img src="../img/close.png" width="20" height="20">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <div id="bookingAddModal" class="modal">
                        <div class="modal-content">
                            <h3>Добавить бронирование</h3>
                            <form method="POST" action="booking_add.php">
                                <select name="id_user" required>
                                    <option value="">Выберите пользователя</option>
                                    <?php foreach ($users_list as $u): ?>
                                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?> (<?= htmlspecialchars($u['email']) ?>) — <?= htmlspecialchars($u['phone'] ?? 'нет телефона') ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="id_base" required>
                                    <option value="">Выберите базу/виллу</option>
                                    <?php foreach ($bases_list as $base): ?>
                                        <option value="<?= $base['id_base'] ?>"><?= htmlspecialchars($base['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" name="date_start" placeholder="Дата заезда" required oninput="maskDate(this)">
                                <input type="text" name="date_end" placeholder="Дата выезда" required oninput="maskDate(this)">
                                <input type="text" name="price" placeholder="Цена">
                                <button type="submit">Добавить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                    <div id="bookingEditModal" class="modal">
                        <div class="modal-content">
                            <h3>Редактировать бронирование</h3>
                            <form method="POST" action="booking_update.php">
                                <input type="hidden" name="id_booking" id="b_id">
                                <select name="id_user" id="b_id_user" required>
                                    <option value="">Выберите пользователя</option>
                                    <?php foreach ($users_list as $u): ?>
                                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?> (<?= htmlspecialchars($u['email']) ?>) — <?= htmlspecialchars($u['phone'] ?? 'нет телефона') ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="id_base" id="b_id_base" required>
                                    <option value="">Выберите базу/виллу</option>
                                    <?php foreach ($bases_list as $base): ?>
                                        <option value="<?= $base['id_base'] ?>"><?= htmlspecialchars($base['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" name="date_start" id="b_date_start" placeholder="Дата заезда" required oninput="maskDate(this)">
                                <input type="text" name="date_end" id="b_date_end" placeholder="Дата выезда" required oninput="maskDate(this)">
                                <input type="text" name="price" id="b_price" placeholder="Цена">
                                <button type="submit">Сохранить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                <?php elseif ($tab === 'requests'): ?>
                    <button class="add-btn" onclick="openRequestAdd()">+ Добавить заявку</button>
                    <h2>Заявки</h2>

                    <?php if (empty($requests)): ?>
                        <p>Нет данных о заявках</p>
                    <?php else: ?>
                        <table class="crm-table">
                            <thead>
                                <tr>
                                    <th>Пользователь</th>
                                    <th>База/Вилла</th>
                                    <th>Дата заезда</th>
                                    <th>Дата выезда</th>
                                    <th>Дата создания</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($requests as $r): ?>
                                    <tr>
                                        <td>
                                            <?= htmlspecialchars($r['name'] ?? 'Не указан') ?><br>
                                            <small><?= htmlspecialchars($r['email'] ?? '') ?></small><br>
                                            <small><?= htmlspecialchars($r['phone'] ?? '') ?></small>
                                        </td>
                                        <td><?= htmlspecialchars($r['base_name'] ?? 'Не указана') ?></td>
                                        <td><?= date('d.m.Y', strtotime($r['date_start'])) ?></td>
                                        <td><?= date('d.m.Y', strtotime($r['date_end'])) ?></td>
                                        <td><?= $r['created_at'] ?></td>
                                        <td>
                                            <div class="actions">
                                                <button class="edit-btn" onclick="openRequestEdit(
                                                    <?= $r['id'] ?>,
                                                    <?= $r['id_user'] ?? 'null' ?>,
                                                    <?= $r['id_base'] ?? 'null' ?>,
                                                    '<?= $r['date_start'] ?>',
                                                    '<?= $r['date_end'] ?>'
                                                )">
                                                    <img src="../img/pencil.png" width="20" height="20">
                                                </button>
                                                <button class="delete-btn" onclick="deleteRequest(<?= $r['id'] ?>)">
                                                    <img src="../img/close.png" width="20" height="20">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <div id="requestAddModal" class="modal">
                        <div class="modal-content">
                            <h3>Добавить заявку</h3>
                            <form method="POST" action="request_add.php">
                                <select name="id_user" required>
                                    <option value="">Выберите пользователя</option>
                                    <?php foreach ($users_list as $u): ?>
                                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?> (<?= htmlspecialchars($u['email']) ?>) — <?= htmlspecialchars($u['phone'] ?? 'нет телефона') ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="id_base" required>
                                    <option value="">Выберите базу/виллу</option>
                                    <?php foreach ($bases_list as $base): ?>
                                        <option value="<?= $base['id_base'] ?>"><?= htmlspecialchars($base['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" name="date_start" id="r_date_start" placeholder="Дата заезда" required oninput="maskDate(this)">
                                <input type="text" name="date_end" id="r_date_end" placeholder="Дата выезда" required oninput="maskDate(this)">
                                <button type="submit">Добавить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                    <div id="requestEditModal" class="modal">
                        <div class="modal-content">
                            <h3>Редактировать заявку</h3>
                            <form method="POST" action="request_update.php">
                                <input type="hidden" name="id" id="r_id">
                                <select name="id_user" id="r_id_user" required>
                                    <option value="">Выберите пользователя</option>
                                    <?php foreach ($users_list as $u): ?>
                                        <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?> (<?= htmlspecialchars($u['email']) ?>) — <?= htmlspecialchars($u['phone'] ?? 'нет телефона') ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <select name="id_base" id="r_id_base" required>
                                    <option value="">Выберите базу/виллу</option>
                                    <?php foreach ($bases_list as $base): ?>
                                        <option value="<?= $base['id_base'] ?>"><?= htmlspecialchars($base['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="text" name="date_start" id="r_date_start" placeholder="Дата заезда" required oninput="maskDate(this)">
                                <input type="text" name="date_end" id="r_date_end" placeholder="Дата выезда" required oninput="maskDate(this)">
                                <button type="submit">Сохранить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                <?php elseif ($tab === 'sale'): ?>
                    <button class="add-btn" onclick="openSaleAdd()">+ Добавить скидку</button>
                    <h2>Подписчики на скидку</h2>

                    <?php if (empty($sales)): ?>
                        <p>Нет подписчиков</p>
                    <?php else: ?>
                        <table class="crm-table">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Дата подписки</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sales as $s): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($s['email']) ?></td>
                                        <td><?= $s['created_at'] ?></td>
                                        <td>
                                            <div class="actions">
                                                <button class="edit-btn" onclick="openSaleEdit(<?= $s['id'] ?>, '<?= addslashes($s['email']) ?>')">
                                                    <img src="../img/pencil.png" width="20" height="20">
                                                </button>
                                                <button class="delete-btn" onclick="deleteSale(<?= $s['id'] ?>)">
                                                    <img src="../img/close.png" width="20" height="20">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>

                    <div id="saleAddModal" class="modal">
                        <div class="modal-content">
                            <h3>Добавить подписчика</h3>
                            <form method="POST" action="sale_add.php">
                                <input type="email" name="email" placeholder="Email" required>
                                <button type="submit">Добавить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>

                    <div id="saleEditModal" class="modal">
                        <div class="modal-content">
                            <h3>Редактировать подписчика</h3>
                            <form method="POST" action="sale_update.php">
                                <input type="hidden" name="id" id="s_id">
                                <input type="email" name="email" id="s_email" required>
                                <button type="submit">Сохранить</button>
                            </form>
                            <button onclick="closeModal()">Закрыть</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function closeModal() {
            document.querySelectorAll('.modal').forEach(modal => {
                modal.style.display = 'none';
            });
        }

        window.onclick = function(e) {
            if (e.target.classList.contains('modal')) {
                closeModal();
            }
        };

        function openAdminAdd() {
            document.getElementById('adminAddModal').style.display = 'block';
        }

        function openAdminEdit(id, login) {
            document.getElementById('admin_id').value = id;
            document.getElementById('admin_login').value = login;
            document.getElementById('admin_password').value = '';
            document.getElementById('adminEditModal').style.display = 'block';
        }

        function deleteAdmin(id) {
            if (confirm('Удалить администратора?')) {
                window.location.href = 'admin_delete.php?id=' + id;
            }
        }

        function openUserAdd() {
            document.getElementById('userAddModal').style.display = 'block';
        }

        function openUserEdit(id, name, email, phone, is_confirmed) {
            document.getElementById('user_id').value = id;
            document.getElementById('user_name').value = name;
            document.getElementById('user_email').value = email;
            document.getElementById('user_phone').value = phone;
            document.getElementById('user_password').value = '';
            document.getElementById('user_confirmed').value = is_confirmed;
            document.getElementById('userEditModal').style.display = 'block';
        }

        function deleteUser(id) {
            if (confirm('Удалить пользователя?')) {
                window.location.href = 'user_delete.php?id=' + id;
            }
        }

        function openBaseAdd() {
            document.getElementById('baseAddModal').style.display = 'block';
        }

        function openBaseEdit(id, name) {
            document.getElementById('base_id').value = id;
            document.getElementById('base_name').value = name;
            document.getElementById('baseEditModal').style.display = 'block';
        }

        function deleteBase(id) {
            if (confirm('Удалить базу/виллу?')) {
                window.location.href = 'base_delete.php?id=' + id;
            }
        }

        function openBookingAdd() {
            document.getElementById('bookingAddModal').style.display = 'block';
        }

        function openBookingEdit(id, id_user, id_base, date_start, date_end, price) {
            document.getElementById('b_id').value = id;
            document.getElementById('b_date_start').value = date_start;
            document.getElementById('b_date_end').value = date_end;
            document.getElementById('b_price').value = price;
            setSelectValue('b_id_user', id_user);
            setSelectValue('b_id_base', id_base);
            document.getElementById('bookingEditModal').style.display = 'block';
        }

        function deleteBooking(id) {
            if (confirm('Удалить бронирование?')) {
                window.location.href = 'booking_delete.php?id=' + id;
            }
        }

        function openRequestAdd() {
            document.getElementById('requestAddModal').style.display = 'block';
        }

        function openRequestEdit(id, id_user, id_base, date_start, date_end) {
            document.getElementById('r_id').value = id;
            document.getElementById('r_date_start').value = date_start;
            document.getElementById('r_date_end').value = date_end;
            setSelectValue('r_id_user', id_user);
            setSelectValue('r_id_base', id_base);
            document.getElementById('requestEditModal').style.display = 'block';
        }

        function deleteRequest(id) {
            if (confirm('Удалить заявку?')) {
                window.location.href = 'request_delete.php?id=' + id;
            }
        }

        function openSaleAdd() {
            document.getElementById('saleAddModal').style.display = 'block';
        }

        function openSaleEdit(id, email) {
            document.getElementById('s_id').value = id;
            document.getElementById('s_email').value = email;
            document.getElementById('saleEditModal').style.display = 'block';
        }

        function deleteSale(id) {
            if (confirm('Удалить подписчика?')) {
                window.location.href = 'sale_delete.php?id=' + id;
            }
        }

        function setSelectValue(id, value) {
            const select = document.getElementById(id);
            if (!select) return;
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].value == value) {
                    select.selectedIndex = i;
                    break;
                }
            }
        }

        function maskDate(input) {
            if (!input) return;

            input.addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '');
                let formatted = '';

                if (value.length > 8) {
                    value = value.substring(0, 8);
                }

                if (value.length >= 1) {
                    formatted += value.substring(0, 2);
                }
                if (value.length >= 3) {
                    formatted += '.' + value.substring(2, 4);
                }
                if (value.length >= 5) {
                    formatted += '.' + value.substring(4, 8);
                }

                this.value = formatted;
            });
        }

        function convertDateForSQL(dateString) {
            if (!dateString) return '';

            var parts = dateString.split('.');
            if (parts.length !== 3) return dateString;

            return parts[2] + '-' + parts[1] + '-' + parts[0];
        }

        function setupDateConversion() {
            const forms = document.querySelectorAll('.modal-content form');

            forms.forEach(form => {
                form.removeEventListener('submit', convertDatesOnSubmit);
                form.addEventListener('submit', convertDatesOnSubmit);
            });
        }

        function convertDatesOnSubmit(e) {
            const dateFields = this.querySelectorAll('input[name="date_start"], input[name="date_end"]');

            dateFields.forEach(field => {
                if (field.value && field.value.includes('.')) {
                    field.value = convertDateForSQL(field.value);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupDateConversion();

            const observer = new MutationObserver(() => {
                setupDateConversion();
            });
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });

        function maskPhoneForAdmin(input) {
            if (!input) return;

            input.addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '');

                if (value.startsWith('8')) {
                    value = '7' + value.substring(1);
                }
                if (!value.startsWith('7')) {
                    value = '7' + value;
                }

                let formatted = '+7';

                if (value.length > 1) {
                    formatted += ' (' + value.substring(1, 4);
                }
                if (value.length >= 5) {
                    formatted += ') ' + value.substring(4, 7);
                }
                if (value.length >= 8) {
                    formatted += '-' + value.substring(7, 9);
                }
                if (value.length >= 10) {
                    formatted += '-' + value.substring(9, 11);
                }

                this.value = formatted;
            });
        }

        function applyPhoneMasks() {

            const phoneFields = [
                'b_phone',
                'user_phone',
                'r_phone'
            ];

            phoneFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    maskPhoneForAdmin(field);
                }
            });

            document.querySelectorAll('.modal-content input[type="tel"], .modal-content input[name="phone"]').forEach(input => {
                maskPhoneForAdmin(input);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            applyPhoneMasks();
        });

        function openUserEditWithMask(id, name, email, phone, is_confirmed) {
            openUserEdit(id, name, email, phone, is_confirmed);
            setTimeout(() => {
                const phoneField = document.getElementById('user_phone');
                if (phoneField && phone) {
                    phoneField.value = phone;
                    maskPhoneForAdmin(phoneField);
                }
            }, 100);
        }

        function openBookingEditWithMask(id, id_user, id_base, date_start, date_end, price, phone) {
            openBookingEdit(id, id_user, id_base, date_start, date_end, price);
            setTimeout(() => {
                const phoneField = document.getElementById('b_phone');
                if (phoneField && phone) {
                    phoneField.value = phone;
                    maskPhoneForAdmin(phoneField);
                }
            }, 100);
        }
    </script>
</body>

</html>