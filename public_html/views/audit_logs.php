<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title>Audit Logs</title>
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
        .table-container 
        {
            width: 100%;
            max-width: 1000px;
            overflow-x: auto;
            margin-bottom: 20px;
        }
        form 
        {
            background-color: #222;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin-bottom: 20px;
        }
        label 
        {
            display: block;
            margin: 10px 0 5px;
            color: #0f0;
        }
        input, select 
        {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #333;
            border-radius: 5px;
            background: #333;
            color: #fff;
            font-size: 1em;
        }
        button 
        {
            padding: 10px;
            background-color: #0f0;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
            font-weight: 600;
        }
        button:hover 
        {
            background-color: #0c0;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        table 
        {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td 
        {
            border: 1px solid #333;
        }
        th, td 
        {
            padding: 10px;
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
        a 
        {
            color: #0f0;
            text-decoration: none;
            margin-top: 20px;
            transition: color 0.3s;
        }
        a:hover 
        {
            color: #fff;
        }
        @media (max-width: 600px) 
        {
            th, td 
            {
                padding: 5px;
            }
        }
    </style>
</head>
<body>
    <h1>Audit Logs</h1>
    <form action="index.php?page=audit_logs" method="post">
        <label for="user_id">User:</label>
        <select name="user_id" id="user_id">
            <option value="">All</option>
            <?php
            require_once __DIR__ . '/../config/database.php';
            $users = $pdo->query('SELECT user_id, username FROM user');
            while ($user = $users->fetch()) {
                echo "<option value='{$user['user_id']}'>{$user['username']}</option>";
            }
            ?>
        </select>

        <label for="entity_type">Entity Type:</label>
        <input type="text" name="entity_type" id="entity_type">

        <label for="action_type">Action Type:</label>
        <select name="action_type" id="action_type">
            <option value="">All</option>
            <option value="INSERT">INSERT</option>
            <option value="UPDATE">UPDATE</option>
            <option value="DELETE">DELETE</option>
        </select>
        
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date">
        
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date">
        
        <button type="submit">Filter</button>
    </form>
    <div class="table-container">
        <table>
            <tr>
                <th>User</th>
                <th>Action Type</th>
                <th>Entity Type</th>
                <th>Entity ID</th>
                <th>Date</th>
                <th>Details</th>
            </tr>
            <?php
            require_once __DIR__ . '/../config/database.php';
            
            $where_clauses = [];
            $params = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $user_id = $_POST['user_id'];
                $entity_type = $_POST['entity_type'];
                $action_type = $_POST['action_type'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];

                if ($user_id) {
                    $where_clauses[] = 'log.user_id = ?';
                    $params[] = $user_id;
                }
                if ($entity_type) {
                    $where_clauses[] = 'log.entity_type = ?';
                    $params[] = $entity_type;
                }
                if ($action_type) {
                    $where_clauses[] = 'log.action_type = ?';
                    $params[] = $action_type;
                }
                if ($start_date) {
                    $where_clauses[] = 'log.action_date >= ?';
                    $params[] = $start_date;
                }
                if ($end_date) {
                    $where_clauses[] = 'log.action_date <= ?';
                    $params[] = $end_date;
                }
            }

            $where_sql = '';
            if ($where_clauses) {
                $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
            }

            $stmt = $pdo->prepare('SELECT log.*, user.username FROM log JOIN user ON log.user_id = user.user_id ' . $where_sql);
            $stmt->execute($params);

            while ($row = $stmt->fetch()) {
                echo "<tr>
                        <td>{$row['username']}</td>
                        <td>{$row['action_type']}</td>
                        <td>{$row['entity_type']}</td>
                        <td>{$row['entity_id']}</td>
                        <td>{$row['action_date']}</td>
                        <td>{$row['details']}</td>
                      </tr>";
            }
            ?>
        </table>
    </div>
    <a href="index.php?page=dashboard">Back to Dashboard</a>
</body>
</html>
