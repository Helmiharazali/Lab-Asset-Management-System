<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role_id'], [2, 3])) {
    header('Location: ../public/index.php?page=login');
    exit();
}

$user_id = $_SESSION['user_id'];
$asset_id = $_POST['asset_id'];
$usage_purpose = $_POST['usage_purpose'];
$required_by_date = $_POST['required_by_date'];
$justification = $_POST['justification'];

$stmt = $pdo->prepare('INSERT INTO request (user_id, asset_id, request_date, approval_status, usage_purpose, required_by_date, justification) VALUES (?, ?, NOW(), "Pending", ?, ?, ?)');
$stmt->execute([$user_id, $asset_id, $usage_purpose, $required_by_date, $justification]);

$request_id = $pdo->lastInsertId();

// Log the request action
addAuditLog($pdo, $user_id, 'INSERT', 'Request', $request_id, json_encode($_POST));

// Notify admin
$admins = $pdo->query('SELECT user_id FROM user WHERE role_id = 1');
while ($admin = $admins->fetch()) {
    $stmt = $pdo->prepare('INSERT INTO notification (user_id, message, notification_date, status, priority) VALUES (?, ?, NOW(), "Unread", "High")');
    $stmt->execute([$admin['user_id'], 'New asset request from user ' . $user_id]);
}

header('Location: ../index.php?page=dashboard');
?>
