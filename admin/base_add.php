<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$stmt = $pdo->prepare("INSERT INTO base (name) VALUES (?)");
$stmt->execute([$_POST['name']]);

header("Location: dashboard.php?tab=bases");
?>