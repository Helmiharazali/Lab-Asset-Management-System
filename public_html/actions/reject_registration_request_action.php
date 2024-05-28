<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) { // Only admins
    header('Location: ../public/index.php?page=login');
    exit();
}

$request_id = $_GET['id'];

// Update the request status
$stmt = $pdo->prepare('UPDATE RegistrationRequests SET approval_status = "Rejected", approved_by = ?, approval_date = NOW() WHERE request_id = ?');
$stmt->execute([$_SESSION['user_id'], $request_id]);

// Log the rejection action
addAuditLog($pdo, $_SESSION['user_id'], 'UPDATE', 'RegistrationRequests', $request_id, 'Rejected registration request');

echo 'Registration request rejected successfully';
header('Location: ../index.php?page=requests');
?>
