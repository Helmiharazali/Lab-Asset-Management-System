<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

$role_id = $_SESSION['role_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab Asset Management</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap');
        *
        {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Quicksand', sans-serif;
        }
        body 
        {
            background: #000;
            color: #fff;
        }
        nav 
        {
            background-color: #222;
            color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        nav ul 
        {
            list-style: none;
            display: flex;
            justify-content: space-around;
            padding: 0;
            margin: 0;
        }
        nav ul li 
        {
            margin: 0 10px;
        }
        nav ul li a 
        {
            color: #0f0;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        nav ul li a:hover 
        {
            background-color: #0c0;
            color: #000;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php?page=dashboard">Dashboard</a></li>
            <?php if (in_array($role_id, [1, 2, 3, 4])): ?>
                <li><a href="index.php?page=assets">Assets</a></li>
                <li><a href="index.php?page=notifications">Notifications</a></li>
            <?php endif; ?>
            <?php if ($role_id == 1): // Admin ?>
                <li><a href="index.php?page=role_management">Role Management</a></li>
                <li><a href="index.php?page=add_edit_asset">Add Asset</a></li>
                <li><a href="index.php?page=requests">Requests</a></li>
                <li><a href="index.php?page=reports">Reports</a></li>
                <li><a href="index.php?page=audit_logs">Audit Logs</a></li>
                <li><a href="index.php?page=feedback">Feedback</a></li>
            <?php endif; ?>
            <?php if (in_array($role_id, [2, 3])): // Researchers and Students ?>
                <li><a href="index.php?page=request_asset">Request Asset</a></li>
                <li><a href="index.php?page=submit_feedback">Submit Feedback</a></li>
            <?php endif; ?>
            <?php if ($role_id == 4): // Technicians ?>
                <li><a href="index.php?page=schedule_maintenance">Schedule Maintenance</a></li>
                <li><a href="index.php?page=maintenance">Maintenance</a></li>
                <li><a href="index.php?page=feedback">Feedback</a></li>
                <li><a href="index.php?page=submit_feedback">Submit Feedback</a></li>
            <?php endif; ?>
            <li><a href="../actions/logout_action.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
