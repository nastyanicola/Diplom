<?php

require 'db.php';
require 'security.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode([
        "status" => "error",
        "message" => "CSRF detected"
    ]);
    exit;
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$password = $_POST['password'] ?? '';

$name = trim(strip_tags($name));
$email = trim($email);
$phone = trim(strip_tags($phone));
$password = trim($password);

if (!$name || !$email || !$phone || !$password) {
    echo json_encode([
        "status" => "error",
        "message" => "Заполните все поля"
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "status" => "error",
        "message" => "Некорректный email"
    ]);
    exit;
}

if (strlen(preg_replace('/\D/', '', $phone)) < 10) {
    echo json_encode([
        "status" => "error",
        "message" => "Введите корректный номер телефона"
    ]);
    exit;
}

if (strlen($password) < 6) {
    echo json_encode([
        "status" => "error",
        "message" => "Пароль должен быть минимум 6 символов"
    ]);
    exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    echo json_encode([
        "status" => "error",
        "message" => "Email уже зарегистрирован"
    ]);
    exit;
}

$code = rand(100000, 999999);

$_SESSION['temp_user'] = [
    'name' => $name,
    'email' => $email,
    'phone' => $phone,
    'password' => password_hash($password, PASSWORD_DEFAULT),
    'code' => $code
];

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'nastya.naa2109@gmail.com';
    $mail->Password = 'tydn teob okyn obya';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->CharSet = 'UTF-8';
    $mail->setFrom('nastya.naa2109@gmail.com', 'EliteHome');
    $mail->addAddress($email);
    $mail->Subject = 'Код подтверждения EliteHome';
    $mail->Body = "Ваш код подтверждения: $code";
    $mail->send();

    echo json_encode([
        "status" => "success",
        "message" => "Код подтверждения отправлен"
    ]);
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Ошибка отправки письма: " . $e->getMessage()
    ]);
}