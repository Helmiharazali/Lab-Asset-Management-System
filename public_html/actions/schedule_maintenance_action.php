<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 4) { // Only technicians
    header('Location: ../public/index.php?page=login');
    exit();
}

$asset_id = $_POST['asset_id'];
$maintenance_type = $_POST['maintenance_type'];
$details = $_POST['details'];
$next_maintenance_date = $_POST['next_maintenance_date'];
$maintenance_cost = $_POST['maintenance_cost'];
$parts_replaced = $_POST['parts_replaced'];
$technician_id = $_SESSION['user_id'];

// Check if the asset is available for maintenance
$stmt = $pdo->prepare('SELECT status FROM asset WHERE asset_id = ?');
$stmt->execute([$asset_id]);
$asset = $stmt->fetch();

if ($asset && $asset['status'] == 'In Use') {
    header('Location: ../public/index.php?page=schedule_maintenance&error=unavailable');
    exit();
}

// Insert maintenance record
$stmt = $pdo->prepare('INSERT INTO maintenance (asset_id, technician_id, maintenance_date, maintenance_type, details, next_maintenance_date, maintenance_cost, parts_replaced) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?)');
$stmt->execute([$asset_id, $technician_id, $maintenance_type, $details, $next_maintenance_date, $maintenance_cost, $parts_replaced]);

$maintenance_id = $pdo->lastInsertId();

// Notify admin
$admins = $pdo->query('SELECT user_id FROM user WHERE role_id = 1');
while ($admin = $admins->fetch()) {
    $stmt = $pdo->prepare('INSERT INTO notification (user_id, message, notification_date, status, priority) VALUES (?, ?, NOW(), "Unread", "Medium")');
    $stmt->execute([$admin['user_id'], 'Maintenance scheduled by technician ' . $technician_id]);
}

// Notify technician
$stmt = $pdo->prepare('INSERT INTO notification (user_id, message, notification_date, status, priority) VALUES (?, ?, NOW(), "Unread", "Medium")');
$stmt->execute([$technician_id, 'Technician ' . $technician_id . ' have scheduled a maintenance task for asset ' . $asset_id]);

// Log the maintenance scheduling action
addAuditLog($pdo, $technician_id, 'INSERT', 'Maintenance', $maintenance_id, json_encode($_POST));

header('Location: ../index.php?page=maintenance');
?>
