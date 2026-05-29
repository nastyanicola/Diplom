<?php
require '../db.php';
require '../security.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$stmt = $pdo->prepare("UPDATE sale SET email=? WHERE id=?");
$stmt->execute([$_POST['email'], $_POST['id']]);

header("Location: dashboard.php?tab=sale");