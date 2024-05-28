<?php
namespace Helpers;

function addAuditLog($pdo, $user_id, $action_type, $entity_type, $entity_id, $details) {
    $stmt = $pdo->prepare('INSERT INTO log (user_id, action_type, entity_type, entity_id, details) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$user_id, $action_type, $entity_type, $entity_id, $details]);
}
?>
