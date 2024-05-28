<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title>Request List</title>
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
        h2 
        {
            font-size: 2em;
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
        .actions 
        {
            display: flex;
            gap: 10px;
        }
        .actions a 
        {
            display: inline-block;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .actions a.approve 
        {
            background-color: #4CAF50;
            color: #fff;
        }
        .actions a.approve:hover 
        {
            background-color: #45a049;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .actions a.reject 
        {
            background-color: #f44336;
            color: #fff;
        }
        .actions a.reject:hover 
        {
            background-color: #e53935;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .actions a.unlock 
        {
            background-color: #4CAF50;
            color: #fff;
        }
        .actions a.unlock:hover 
        {
            background-color: #45a049;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <h1>Request List</h1>
    
    <!-- Asset Requests -->
    <h2>Asset Requests</h2>
    <table>
        <tr>
            <th>Asset</th>
            <th>User</th>
            <th>Request Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        require_once __DIR__ . '/../config/database.php';
        $stmt = $pdo->query('SELECT request.request_id, asset.asset_name, user.username, request.request_date, request.approval_status FROM request JOIN asset ON request.asset_id = asset.asset_id JOIN user ON request.user_id = user.user_id');
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['asset_name']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['request_date']}</td>
                    <td>{$row['approval_status']}</td>
                    <td class='actions'>
                        <a class='approve' href='index.php?page=request_details&id={$row['request_id']}'>View</a>
                        <a class='approve' href='../actions/approve_request_action.php?id={$row['request_id']}'>Approve</a>
                        <a class='reject' href='../actions/reject_request_action.php?id={$row['request_id']}'>Reject</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
    
    <!-- Registration Requests -->
    <h2>Registration Requests</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Department</th>
            <th>Request Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        $stmt = $pdo->query('SELECT rr.*, r.role_name, d.department_name FROM registrationrequests rr JOIN role r ON rr.role_id = r.role_id JOIN department d ON rr.department_id = d.department_id WHERE rr.approval_status = "Pending"');
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['role_name']}</td>
                    <td>{$row['department_name']}</td>
                    <td>{$row['request_date']}</td>
                    <td>{$row['approval_status']}</td>
                    <td class='actions'>
                        <a class='approve' href='../actions/approve_registration_request_action.php?id={$row['request_id']}'>Approve</a>
                        <a class='reject' href='../actions/reject_registration_request_action.php?id={$row['request_id']}'>Reject</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Locked Accounts -->
    <h2>Locked Accounts</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        <?php
        $stmt = $pdo->query('SELECT user.user_id, user.username, user.email, role.role_name FROM user JOIN role ON user.role_id = role.role_id WHERE user.account_locked = 1');
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['role_name']}</td>
                    <td class='actions'>
                        <a class='unlock' href='../actions/unlock_user_action.php?id={$row['user_id']}'>Unlock</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
