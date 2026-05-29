<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'] ?? '';
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$is_confirmed = $_POST['is_confirmed'];

$stmt = $pdo->prepare("
    INSERT INTO users (name, email, phone, password, is_confirmed, created_at)
    VALUES (?, ?, ?, ?, ?, NOW())
");
$stmt->execute([$name, $email, $phone, $password, $is_confirmed]);

header("Location: dashboard.php?tab=users");
?>