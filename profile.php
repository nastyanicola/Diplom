<?php
session_start();
require 'db.php';
require 'security.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}


$stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$_SESSION['id_user']]);
$user = $stmt->fetch();
$stmt = $pdo->prepare("
    SELECT r.*, b.name as base_name 
    FROM requests r
    LEFT JOIN base b ON r.id_base = b.id_base
    WHERE r.id_user = ? 
    ORDER BY r.created_at DESC
");
$stmt->execute([$_SESSION['id_user']]);
$requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="header">
        <a href="./index.php" class="logo">
            <img src="./img/logo.svg" alt="logo">
        </a>

        <nav class="nav">
            <a href="catalog.php">Каталог</a>
            <a href="about.php">О компании</a>
            <a href="contact.php">Контакты</a>
        </nav>

        <a href="logout.php" class="btn-logout">Выйти</a>
    </div>

    <section class="profile-dashboard">
        <div class="dashboard-container">
            <div class="dashboard-left">
                <div class="profile-card">
                    <div class="profile-top">
                        <div>
                            <h1 class="profile-name">
                                <?= e($user['name']) ?>
                            </h1>
                        </div>
                    </div>

                    <div class="profile-info">
                        <div class="profile-item">
                            <span>Email</span>
                            <p><?= e($user['email']) ?></p>
                        </div>

                        <div class="profile-item">
                            <span>Телефон</span>
                            <p><?= e($user['phone'] ?? 'Не указан') ?></p>
                        </div>

                        <div class="profile-item">
                            <span>Дата регистрации</span>
                            <p><?= date('d.m.Y', strtotime($user['created_at'])) ?></p>
                        </div>

                        <div class="profile-item">
                            <span>Статус аккаунта</span>
                            <p class="status-active">Подтвержден</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="dashboard-right">
                <div class="requests-card">
                    <h2 class="requests-title">Мои заявки на бронирование</h2>
                    
                    <?php if (empty($requests)): ?>
                        <div class="requests-empty">
                            <p>У вас пока нет заявок на бронирование</p>
                            <a href="catalog.php" class="requests-empty-btn">Перейти в каталог</a>
                        </div>
                    <?php else: ?>
                        <div class="requests-table-wrapper">
                            <table class="requests-table">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Название объекта</th>
                                        <th>Дата заезда</th>
                                        <th>Дата выезда</th>
                                        <th>Дата заявки</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($requests as $index => $request): ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td><?= e($request['base_name']) ?></td>
                                            <td><?= date('d.m.Y', strtotime($request['date_start'])) ?></td>
                                            <td><?= date('d.m.Y', strtotime($request['date_end'])) ?></td>
                                            <td><?= date('d.m.Y H:i', strtotime($request['created_at'])) ?></td>
                                            <td>
                                                <span class="request-status request-status-new">Новая</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
    </section>

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

</body>

</html>