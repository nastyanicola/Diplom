<?php
require 'db.php';
require 'security.php';
header('Content-Type: application/json');

if (!isset($_SESSION['id_user'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Необходимо авторизоваться'
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Неверный запрос'
    ]);
    exit;
}

$date_start = trim($_POST['date_start'] ?? '');
$date_end = trim($_POST['date_end'] ?? '');
$base_name = trim($_POST['base'] ?? ''); 

function convertDate($date) {
    if (empty($date)) return null;
    $parts = explode('.', $date);
    if (count($parts) == 3) {
        return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
    }
    return $date;
}

$date_start = convertDate($date_start);
$date_end = convertDate($date_end);
$id_user = $_SESSION['id_user'];

if (!$date_start || !$date_end || !$base_name) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Заполните все поля'
    ]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id_base FROM base WHERE name = ?");
    $stmt->execute([$base_name]);
    $base = $stmt->fetch();
    
    if (!$base) {
        echo json_encode([
            'status' => 'error',
            'message' => 'База не найдена'
        ]);
        exit;
    }
    
    $id_base = $base['id_base'];
    
    $stmt = $pdo->prepare("
        INSERT INTO requests (date_start, date_end, id_base, id_user)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$date_start, $date_end, $id_base, $id_user]);
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Заявка успешно отправлена, с вами скоро свяжутся!'
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка базы данных: ' . $e->getMessage()
    ]);
}
?>