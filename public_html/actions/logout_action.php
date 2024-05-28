<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

$user_id = $_SESSION['user_id'];
addAuditLog($pdo, $user_id, 'LOGOUT', 'User', $user_id, 'User logged out');

session_destroy();
header('Location: ../index.php?page=login');
?>
