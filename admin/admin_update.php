<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$id = $_POST['id'];
$login = $_POST['login'];

if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE admins SET login = ?, password = ? WHERE id = ?");
    $stmt->execute([$login, $password, $id]);
} else {
    $stmt = $pdo->prepare("UPDATE admins SET login = ? WHERE id = ?");
    $stmt->execute([$login, $id]);
}

header("Location: dashboard.php?tab=admins");
?>