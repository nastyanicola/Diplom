<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$stmt = $pdo->prepare("
    INSERT INTO requests (id_user, id_base, date_start, date_end, created_at)
    VALUES (?, ?, ?, ?, NOW())
");

$stmt->execute([
    $_POST['id_user'],
    $_POST['id_base'],
    $_POST['date_start'],
    $_POST['date_end']
]);

header("Location: dashboard.php?tab=requests");
?>