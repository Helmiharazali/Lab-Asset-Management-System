<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title>Asset List</title>
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
        a.add-asset 
        {
            color: #fff;
            background-color: #4CAF50;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 20px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        a.add-asset:hover 
        {
            background-color: #45a049;
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
        .actions a 
        {
            margin-right: 10px;
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            transition: background-color 0.3s, box-shadow 0.3s;
        }
        .actions a.view 
        {
            background-color: #2196F3;
        }
        .actions a.view:hover 
        {
            background-color: #1976D2;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
        .actions a.delete 
        {
            background-color: #f44336;
        }
        .actions a.delete:hover 
        {
            background-color: #e53935;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    <script>
        function confirmDelete(assetId) {
            if (confirm('Are you sure you want to delete this asset?')) {
                window.location.href = '../actions/delete_asset_action.php?id=' + assetId;
            }
        }
    </script>
</head>
<body>
    <h1>Asset List</h1>
    <a href="index.php?page=add_edit_asset" class="add-asset">Add New Asset</a>
    <table>
        <tr>
            <th>Asset Name</th>
            <th>Type</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        require_once __DIR__ . '/../config/database.php';
        $stmt = $pdo->query('SELECT asset.asset_id, asset.asset_name, assettype.type_name, asset.status FROM asset JOIN assettype ON asset.type_id = assettype.type_id');
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['asset_name']}</td>
                    <td>{$row['type_name']}</td>
                    <td>{$row['status']}</td>
                    <td class='actions'>
                        <a class='view' href='index.php?page=asset_details&id={$row['asset_id']}'>View</a>
                        <a class='edit' href='index.php?page=add_edit_asset&id={$row['asset_id']}'>Edit</a>";
            if ($role_id == 1 && $row['status'] != 'In Use') {
                echo "<a class='delete' href='javascript:void(0);' onclick='confirmDelete({$row['asset_id']});'>Delete</a>";
            }
            echo "</td></tr>";
        }
        ?>
    </table>
</body>
</html>
