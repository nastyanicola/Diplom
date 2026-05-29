<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$stmt = $pdo->prepare("
    INSERT INTO bookings (id_user, id_base, date_start, date_end, price, created_at)
    VALUES (?, ?, ?, ?, ?, NOW())
");

$stmt->execute([
    $_POST['id_user'],
    $_POST['id_base'],
    $_POST['date_start'],
    $_POST['date_end'],
    $_POST['price']
]);

header("Location: dashboard.php?tab=bookings");
?>