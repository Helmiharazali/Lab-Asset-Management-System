<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) { // Only admins
    header('Location: ../public/index.php?page=login');
    exit();
}

$request_id = $_GET['id'];

// Get the request details
$stmt = $pdo->prepare('SELECT * FROM registrationrequests WHERE request_id = ?');
$stmt->execute([$request_id]);
$request = $stmt->fetch();

if ($request) {
    // Approve the request and create the user
    $stmt = $pdo->prepare('INSERT INTO user (username, email, password, role_id, department_id) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$request['username'], $request['email'], $request['password'], $request['role_id'], $request['department_id']]);

    // Update the request status
    $stmt = $pdo->prepare('UPDATE registrationrequests SET approval_status = "Approved", approved_by = ?, approval_date = NOW() WHERE request_id = ?');
    $stmt->execute([$_SESSION['user_id'], $request_id]);

    // Log the approval action
    addAuditLog($pdo, $_SESSION['user_id'], 'INSERT', 'User', $request_id, 'Approved registration request and created user');

    echo 'Registration request approved successfully';
} else {
    echo 'Registration request not found';
}

header('Location: ../index.php?page=requests');
?>
