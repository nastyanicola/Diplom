<?php
require 'db.php';
require 'security.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
if (
    !isset($_POST['csrf_token']) ||
    $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
    die('CSRF detected');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if (!$name || !$email || !$message) {
    die('Заполните все поля');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Некорректный email');
}

$mail = new PHPMailer(true);

try {

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'nastya.naa2109@gmail.com';
    $mail->Password = 'hvaf cbkj cdto kyhp';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->CharSet = 'UTF-8';

    $mail->setFrom('nastya.naa2109@gmail.com', 'EliteHome');
    $mail->addAddress('nastya.naa2109@gmail.com');

    $mail->Subject = 'Новый вопрос с сайта EliteHome';

    $mailBody = "
        <h2>Новое сообщение с сайта</h2>

        <p><strong>Имя:</strong> " . e($name) . "</p>
        <p><strong>Email:</strong> " . e($email) . "</p>
        <p><strong>Сообщение:</strong><br>" . nl2br(e($message)) . "</p>
    ";

    $mail->isHTML(true);
    $mail->Body = $mailBody;

    $mail->send();

    echo json_encode([
        "status" => "success",
        "message" => "Спасибо за ваш вопрос, с вами скоро свяжутся!"
    ]);
    exit;
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => $mail->ErrorInfo
    ]);
}
