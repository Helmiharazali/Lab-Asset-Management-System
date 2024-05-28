<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) { // Only admins
    header('Location: ../public/index.php?page=login');
    exit();
}

$user_id = $_POST['user_id'];
$role_id = $_POST['role_id'];

// Update user role
$stmt = $pdo->prepare('UPDATE user SET role_id = ? WHERE user_id = ?');
$stmt->execute([$role_id, $user_id]);

// Log the role update action with detailed message
$message = 'Updated user (ID: ' . $user_id . ') to role ID ' . $role_id;
addAuditLog($pdo, $_SESSION['user_id'], 'UPDATE', 'User', $user_id, $message);

header('Location: ../index.php?page=role_management');
?>
