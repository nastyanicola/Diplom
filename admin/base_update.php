<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$stmt = $pdo->prepare("UPDATE base SET name = ? WHERE id_base = ?");
$stmt->execute([$_POST['name'], $_POST['id_base']]);

header("Location: dashboard.php?tab=bases");
?>