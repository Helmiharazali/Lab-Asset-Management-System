<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

// Check if the account is locked
if ($user && $user['account_locked']) {
    header('Location: ../public/index.php?page=login&error=account_locked');
    exit();
}

if ($user && password_verify($password, $user['password'])) {
    // Reset failed attempts on successful login
    $stmt = $pdo->prepare('UPDATE user SET failed_attempts = 0 WHERE username = ?');
    $stmt->execute([$username]);

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['role_id'] = $user['role_id'];
    addAuditLog($pdo, $user['user_id'], 'LOGIN', 'User', $user['user_id'], 'User logged in');
    header('Location: ../index.php?page=dashboard');
} else {
    if ($user) {
        // Handle failed login attempts
        $failed_attempts = $user['failed_attempts'] + 1;
        if ($failed_attempts >= 3) {
            $stmt = $pdo->prepare('UPDATE user SET account_locked = 1, failed_attempts = ? WHERE username = ?');
            $stmt->execute([$failed_attempts, $username]);
            header('Location: ../index.php?page=login&error=account_locked');
        } else {
            $stmt = $pdo->prepare('UPDATE user SET failed_attempts = ? WHERE username = ?');
            $stmt->execute([$failed_attempts, $username]);
            header('Location: ../index.php?page=login&error=invalid_credentials');
        }
    } else {
        // If the username is not found in the database
        header('Location: ../index.php?page=login&error=invalid_credentials');
    }
}
?>
