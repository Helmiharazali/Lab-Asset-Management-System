<?php

namespace Helpers;

// Function to add an audit log entry
function addAuditLog($pdo, $user_id, $action_type, $entity_type, $entity_id, $details) {
    $stmt = $pdo->prepare('INSERT INTO log (user_id, action_type, entity_type, entity_id, details) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$user_id, $action_type, $entity_type, $entity_id, $details]);
}

$host = 'localhost';
$db   = 'id22231342_lab_asset_management_2';
$user = 'id22231342_helmiharazali';
$pass = 'Hantu001@';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new \PDO($dsn, $user, $pass, $options); // Notice the backslash before PDO
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>
