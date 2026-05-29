<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'] ?? '';
$is_confirmed = $_POST['is_confirmed'];

if (!empty($_POST['password'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        UPDATE users SET name = ?, email = ?, phone = ?, password = ?, is_confirmed = ?
        WHERE id = ?
    ");
    $stmt->execute([$name, $email, $phone, $password, $is_confirmed, $id]);
} else {
    $stmt = $pdo->prepare("
        UPDATE users SET name = ?, email = ?, phone = ?, is_confirmed = ?
        WHERE id = ?
    ");
    $stmt->execute([$name, $email, $phone, $is_confirmed, $id]);
}

header("Location: dashboard.php?tab=users");
?>