<?php
require_once __DIR__ . '/../config/database.php';

// Check if the user is logged in and if they have the appropriate role
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role_id'], [1, 4])) { // Only admins (role_id = 1) and technicians (role_id = 4)
    header('Location: ../public/index.php?page=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback List</title>
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
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background: #000;
            color: #fff;
            padding: 20px;
        }
        h1 
        {
            font-size: 2.5em;
            color: #0f0;
            margin-bottom: 20px;
        }
        table 
        {
            width: 100%;
            max-width: 1000px;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td 
        {
            border: 1px solid #333;
        }
        th, td 
        {
            padding: 15px;
            text-align: left;
        }
        th 
        {
            background-color: #0f0;
            color: #000;
        }
        tr:nth-child(even) 
        {
            background-color: #222;
        }
        tr:nth-child(odd) 
        {
            background-color: #333;
        }
        tr:hover 
        {
            background-color: #444;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Feedback List</h1>
    <table>
        <tr>
            <th>Asset</th>
            <th>User</th>
            <th>Date</th>
            <th>Rating</th>
            <th>Comments</th>
        </tr>
        <?php
        $stmt = $pdo->query('SELECT feedback.*, asset.asset_name, user.username FROM feedback JOIN asset ON feedback.asset_id = asset.asset_id JOIN user ON feedback.user_id = user.user_id');
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['asset_name']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['feedback_date']}</td>
                    <td>{$row['rating']}</td>
                    <td>{$row['comments']}</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
