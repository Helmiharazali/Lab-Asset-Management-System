<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Check if the user is logged in and if they have the appropriate role
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role_id'], [2, 3, 4])) { // Researchers, Students, and Technicians
    header('Location: ../public/index.php?page=login');
    exit();
}

$user_id = $_SESSION['user_id'];
$asset_id = $_POST['asset_id'];
$rating = $_POST['rating'];
$comments = $_POST['comments'];

// Insert feedback
$stmt = $pdo->prepare('INSERT INTO feedback (user_id, asset_id, feedback_date, rating, comments) VALUES (?, ?, NOW(), ?, ?)');
$stmt->execute([$user_id, $asset_id, $rating, $comments]);

// Set a session variable to indicate feedback submission
$_SESSION['feedback_submitted'] = true;

header('Location: ../index.php?page=submit_feedback');
?>
