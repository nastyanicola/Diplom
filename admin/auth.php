<?php
require '../db.php';
require '../security.php';

if (
    !isset($_POST['csrf_token']) ||
    $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
    die('CSRF detected');
}

$login = $_POST['login'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM admins WHERE login=?");
$stmt->execute([$login]);
$admin = $stmt->fetch();

if ($admin && password_verify($password, $admin['password'])) {

    session_regenerate_id(true);

    $_SESSION['role'] = 'admin';

    header("Location: dashboard.php");
} else {

    echo "Ошибка входа";
}
