<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../public/index.php?page=login');
    exit();
}

$request_id = $_GET['id'];

// Approve the request
$stmt = $pdo->prepare('UPDATE request SET approval_status = "Approved", approved_by = ?, approval_date = NOW() WHERE request_id = ?');
$stmt->execute([$_SESSION['user_id'], $request_id]);

// Get the user ID who made the request
$stmt = $pdo->prepare('SELECT user_id FROM request WHERE request_id = ?');
$stmt->execute([$request_id]);
$user_id = $stmt->fetchColumn();

// Notify the user
$stmt = $pdo->prepare('INSERT INTO notification (user_id, message, notification_date, status, priority) VALUES (?, ?, NOW(), "Unread", "High")');
$stmt->execute([$user_id, 'User ' . $user_id . ' asset request has been approved.']);

// Mark the admin's notification as read
$stmt = $pdo->prepare('UPDATE notification SET status = "Read" WHERE user_id = ? AND message LIKE ?');
$stmt->execute([$_SESSION['user_id'], 'New asset request from user%']);

// Log the approval action
addAuditLog($pdo, $_SESSION['user_id'], 'UPDATE', 'Request', $request_id, 'Approved asset request');

header('Location: ../index.php?page=requests');
?>
