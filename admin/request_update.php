<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$stmt = $pdo->prepare("
    UPDATE requests 
    SET id_user = ?, id_base = ?, date_start = ?, date_end = ?
    WHERE id = ?
");

$stmt->execute([
    $_POST['id_user'],
    $_POST['id_base'],
    $_POST['date_start'],
    $_POST['date_end'],
    $_POST['id']
]);

header("Location: dashboard.php?tab=requests");
?>