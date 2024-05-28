<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title>Notifications</title>
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
        a 
        {
            color: #0f0;
            text-decoration: none;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #222;
            border-radius: 8px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        a:hover 
        {
            background-color: #0c0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
    <h1>Notifications</h1>
    <?php
    require_once __DIR__ . '/../config/database.php';

    // Mark all unread notifications as read for the current user
    $stmt = $pdo->prepare('UPDATE notification SET status = "Read" WHERE user_id = ? AND status = "Unread"');
    $stmt->execute([$_SESSION['user_id']]);

    // Fetch notifications for the current user
    $stmt = $pdo->prepare('SELECT * FROM notification WHERE user_id = ? ORDER BY notification_date DESC');
    $stmt->execute([$_SESSION['user_id']]);
    ?>
    <table>
        <tr>
            <th>Message</th>
            <th>Date</th>
            <th>Status</th>
            <th>Priority</th>
        </tr>
        <?php
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['message']}</td>
                    <td>{$row['notification_date']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['priority']}</td>
                  </tr>";
        }
        ?>
    </table>
    <a href="index.php?page=dashboard">Back to Dashboard</a>
</body>
</html>
