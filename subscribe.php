<?php
require 'db.php';

header('Content-Type: application/json; charset=utf-8');

$email = $_POST['email'] ?? '';

if (!$email) {
    echo json_encode([
        "status" => "error",
        "message" => "Введите email"
    ]);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM sale WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->fetch()) {
    echo json_encode([
        "status" => "error",
        "message" => "Этот email уже подписан на рассылку"
    ]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO sale (email) VALUES (?)");
$stmt->execute([$email]);

echo json_encode([
    "status" => "success",
    "message" => "Спасибо за подписку!"
]);
?>