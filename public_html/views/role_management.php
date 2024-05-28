<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title>Role Management</title>
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
        form 
        {
            display: flex;
            align-items: center;
        }
        select 
        {
            margin-right: 10px;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #333;
            background: #333;
            color: #fff;
        }
        button 
        {
            padding: 5px 10px;
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
    </style>
</head>
<body>
    <h1>Role Management</h1>
    <table>
        <tr>
            <th>Username</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        <?php
        require_once __DIR__ . '/../config/database.php';
        $stmt = $pdo->query('SELECT user.user_id, user.username, role.role_name FROM user JOIN role ON user.role_id = role.role_id');
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['username']}</td>
                    <td>{$row['role_name']}</td>
                    <td>
                        <form action='../actions/update_role_action.php' method='post'>
                            <input type='hidden' name='user_id' value='{$row['user_id']}'>
                            <select name='role_id'>
                                <option value='1'>Admin</option>
                                <option value='2'>Researcher</option>
                                <option value='3'>Student</option>
                                <option value='4'>Technician</option>
                            </select>
                            <button type='submit'>Update</button>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
