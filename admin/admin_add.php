<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$login = $_POST['login'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO admins (login, password) VALUES (?, ?)");
$stmt->execute([$login, $password]);

header("Location: dashboard.php?tab=admins");
?>