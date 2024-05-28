<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; // Adjusted path to include header from the same directory ?>
    <title>Maintenance List</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600&display=swap');
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
        .actions a 
        {
            margin-right: 10px;
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .actions a.edit 
        {
            background-color: #FFC107;
        }
        .actions a.edit:hover 
        {
            background-color: #FFB300;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <h1>Maintenance List</h1>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/../config/database.php';

    // Check if user is logged in and is an admin or technician
    if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role_id'], [1, 4])) {
        header('Location: ../public/index.php?page=login');
        exit();
    }
    ?>
    <table>
        <tr>
            <th>Asset</th>
            <th>Technician</th>
            <th>Maintenance Date</th>
            <th>Type</th>
            <th>Details</th>
            <th>Next Maintenance</th>
            <th>Cost</th>
            <th>Parts Replaced</th>
            <th>Actions</th>
        </tr>
        <?php
        $stmt = $pdo->query('SELECT maintenance.*, asset.asset_name, user.username FROM maintenance JOIN asset ON maintenance.asset_id = asset.asset_id JOIN user ON maintenance.technician_id = user.user_id');
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['asset_name']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['maintenance_date']}</td>
                    <td>{$row['maintenance_type']}</td>
                    <td>{$row['details']}</td>
                    <td>{$row['next_maintenance_date']}</td>
                    <td>{$row['maintenance_cost']}</td>
                    <td>{$row['parts_replaced']}</td>
                    <td class='actions'>
                        <a class='edit' href='index.php?page=update_maintenance&id={$row['maintenance_id']}'>Edit</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
