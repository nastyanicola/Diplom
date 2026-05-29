<?php
require '../db.php';
require '../security.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$stmt = $pdo->prepare("INSERT INTO sale (email, created_at) VALUES (?, NOW())");
$stmt->execute([$_POST['email']]);

header("Location: dashboard.php?tab=sale");