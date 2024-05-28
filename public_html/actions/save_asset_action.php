<?php
session_start();
require_once __DIR__ . '/../config/database.php';
use function Helpers\addAuditLog;

$user_id = $_SESSION['user_id'];
$action_type = 'INSERT';
$entity_type = 'Asset';
$details = json_encode($_POST);

$asset_id = $_POST['asset_id'];
$asset_name = $_POST['asset_name'];
$type_id = $_POST['type_id'];
$description = $_POST['description'];
$location = $_POST['location'];
$status = $_POST['status'];
$purchase_date = $_POST['purchase_date'];
$warranty_expiry_date = $_POST['warranty_expiry_date'];
$acquisition_cost = $_POST['acquisition_cost'];
$depreciation_rate = $_POST['depreciation_rate'];
$current_user_id = $_POST['current_user_id'] ?: null;
$department_id = $_POST['department_id'];
$supplier_id = $_POST['supplier_id'];
$asset_image = $_POST['asset_image'];

if ($asset_id) {
    // Update existing asset
    $stmt = $pdo->prepare('UPDATE asset SET asset_name = ?, type_id = ?, description = ?, location = ?, status = ?, purchase_date = ?, warranty_expiry_date = ?, acquisition_cost = ?, depreciation_rate = ?, current_user_id = ?, department_id = ?, supplier_id = ?, asset_image = ? WHERE asset_id = ?');
    $stmt->execute([$asset_name, $type_id, $description, $location, $status, $purchase_date, $warranty_expiry_date, $acquisition_cost, $depreciation_rate, $current_user_id, $department_id, $supplier_id, $asset_image, $asset_id]);
    $entity_id = $asset_id;
    $action_type = 'UPDATE';
} else {
    // Insert new asset
    $stmt = $pdo->prepare('INSERT INTO asset (asset_name, type_id, description, location, status, purchase_date, warranty_expiry_date, acquisition_cost, depreciation_rate, current_user_id, department_id, supplier_id, asset_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$asset_name, $type_id, $description, $location, $status, $purchase_date, $warranty_expiry_date, $acquisition_cost, $depreciation_rate, $current_user_id, $department_id, $supplier_id, $asset_image]);
    $entity_id = $pdo->lastInsertId();
}

addAuditLog($pdo, $user_id, $action_type, $entity_type, $entity_id, $details);

header('Location: ../index.php?page=assets');
?>
