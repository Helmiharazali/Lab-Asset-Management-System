<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

// Check if user is logged in and is a technician
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 4) {
    header('Location: ../public/index.php?page=login');
    exit();
}

if (!isset($_POST['maintenance_id'])) {
    header('Location: ../views/maintenance.php?error=no_id');
    exit();
}

$maintenance_id = $_POST['maintenance_id'];
$asset_id = $_POST['asset_id'];
$maintenance_type = $_POST['maintenance_type'];
$details = $_POST['details'];
$next_maintenance_date = $_POST['next_maintenance_date'];
$maintenance_cost = $_POST['maintenance_cost'];
$parts_replaced = $_POST['parts_replaced'];
$technician_id = $_SESSION['user_id'];

// Update maintenance record
$stmt = $pdo->prepare('UPDATE maintenance SET asset_id = ?, maintenance_type = ?, details = ?, next_maintenance_date = ?, maintenance_cost = ?, parts_replaced = ? WHERE maintenance_id = ?');
$stmt->execute([$asset_id, $maintenance_type, $details, $next_maintenance_date, $maintenance_cost, $parts_replaced, $maintenance_id]);

// Log the maintenance update action
addAuditLog($pdo, $technician_id, 'UPDATE', 'Maintenance', $maintenance_id, json_encode($_POST));

header('Location: ../index.php?page=maintenance');
exit();
?>
