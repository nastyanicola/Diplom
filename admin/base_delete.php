<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$stmt = $pdo->prepare("DELETE FROM base WHERE id_base = ?");
$stmt->execute([$_GET['id']]);

header("Location: dashboard.php?tab=bases");
?>