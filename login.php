<?php
require 'db.php';
require 'security.php';

header('Content-Type: application/json');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (
    !isset($_POST['csrf_token']) ||
    $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
    echo json_encode([
        'status' => 'error',
        'message' => 'CSRF detected'
    ]);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (!$email || !$password) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Заполните все поля'
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Некорректный email'
    ]);
    exit;
}

if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}

if ($_SESSION['login_attempts'] >= 5) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Слишком много попыток входа'
    ]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {

    if ($user['is_confirmed'] == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Аккаунт не подтвержден'
        ]);
        exit;
    }

    session_regenerate_id(true);

    $_SESSION['id_user'] = $user['id'];
    $_SESSION['login_attempts'] = 0;

    echo json_encode([
        'status' => 'success',
        'message' => 'Вход выполнен',
    ]);
    exit;
} else {
    $_SESSION['login_attempts']++;

    echo json_encode([
        'status' => 'error',
        'message' => 'Неверный логин или пароль'
    ]);
    exit;
}
