<?php
require_once __DIR__ . '/../config/database.php';

$user_id = $_GET['id'];

$stmt = $pdo->prepare('UPDATE user SET account_locked = 0, failed_attempts = 0 WHERE user_id = ?');
$stmt->execute([$user_id]);

header('Location: ../index.php?page=requests');
?>
