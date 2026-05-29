<?php
require 'db.php';
session_start();

header('Content-Type: application/json');

$code = $_POST['code'] ?? '';

if (!isset($_SESSION['temp_user'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Сессия истекла"
    ]);
    exit;
}

$temp = $_SESSION['temp_user'];

if ($code != $temp['code']) {
    echo json_encode([
        "status" => "error",
        "message" => "Неверный код"
    ]);
    exit;
}

$stmt = $pdo->prepare("
    INSERT INTO users (name, email, phone, password, is_confirmed)
    VALUES (?, ?, ?, ?, 1)
");

$stmt->execute([
    $temp['name'],
    $temp['email'],
    $temp['phone'],
    $temp['password']
]);

unset($_SESSION['temp_user']);

$_SESSION['id_user'] = $pdo->lastInsertId();

echo json_encode([
    "status" => "success",
    "message" => "Успешная регистрация",
    "redirect" => "index.php?restore_form=1"
]);
