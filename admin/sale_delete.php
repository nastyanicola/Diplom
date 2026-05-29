<?php
require '../db.php';
session_start();

if ($_SESSION['role'] !== 'admin') exit;

$stmt = $pdo->prepare("DELETE FROM sale WHERE id=?");
$stmt->execute([$_GET['id']]);

header("Location: dashboard.php?tab=sale");