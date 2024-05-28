<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header('Location: ../public/index.php?page=login');
    exit();
}

$request_id = $_GET['id'];

// Reject the request
$stmt = $pdo->prepare('UPDATE Request SET approval_status = "Rejected", approved_by = ?, approval_date = NOW() WHERE request_id = ?');
$stmt->execute([$_SESSION['user_id'], $request_id]);

// Get the user ID who made the request
$stmt = $pdo->prepare('SELECT user_id FROM Request WHERE request_id = ?');
$stmt->execute([$request_id]);
$user_id = $stmt->fetchColumn();

// Notify the user
$stmt = $pdo->prepare('INSERT INTO Notification (user_id, message, notification_date, status, priority) VALUES (?, ?, NOW(), "Unread", "High")');
$stmt->execute([$user_id, 'User ID ' . $user_id . ' asset request has been rejected.']);

// Mark the admin's notification as read
$stmt = $pdo->prepare('UPDATE Notification SET status = "Read" WHERE user_id = ? AND message LIKE ?');
$stmt->execute([$_SESSION['user_id'], 'New asset request from user%']);

// Log the rejection action
addAuditLog($pdo, $_SESSION['user_id'], 'UPDATE', 'Request', $request_id, 'Rejected asset request');

header('Location: ../index.php?page=requests');
?>
